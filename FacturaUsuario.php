<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Mi perfil</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="Direcciones/js/EliminarDireccion.js"></script>
</head>

<body>

    <?php include_once("menu.php"); 
    include_once("footer.php");

    if (isset($_SESSION["id_usuario"])) { ?>

        <div class="container rounded bg-white mb-5 shadow-lg bg-white rounded pb-5">

            <nav>
                <div class="nav nav-tabs w-100" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-factura-tab" data-bs-toggle="tab" data-bs-target="#nav-factura" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <?php if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0) { ?>
                            Facturas de clientes
                        <?php } else { ?>
                            Facturas de pedido
                        <?php } ?>
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active" id="nav-factura" role="tabpanel" aria-labelledby="nav-factura-tab">
                    <?php 
                    $where = "";
                    $where2 = "";

                    if (isset($_POST['btn_BuscarFecha'])){

                        if (isset($_POST['FechaDesde'])){
                            $fechad = $_POST['FechaDesde'];
                            $where = " (FECHA BETWEEN '" . $fechad . "'";
                        }

                        if (isset($_POST['FechaHasta'])) {
                            $fechah = $_POST['FechaHasta'];
                            $where2 = " AND '" . $fechah . "') AND";
                        }
                    }

                    if(isset($_GET['Pagina'])){
                        $Pagina = $_GET['Pagina'];
                    } else {
                        $Pagina = 1;
                    }

                    $RegistrosPorPagina = 10;
                    $Empieza = ($Pagina - 1) * $RegistrosPorPagina;

                    if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0) {

                        $SelectFactura = $base->prepare("SELECT * FROM factura WHERE" . $where . $where2 . " ID_USUARIO <> 0 ORDER BY FECHA DESC, ID DESC LIMIT $RegistrosPorPagina OFFSET $Empieza");

                        $SelectFactura->execute();

                    } else {
                        $SelectFactura = $base->prepare("SELECT * FROM factura WHERE" . $where . $where2 . " ID_USUARIO = :idusuario ORDER BY FECHA DESC, ID DESC LIMIT $RegistrosPorPagina OFFSET $Empieza");

                        $SelectFactura->execute(array(
                            ":idusuario" => $_SESSION['id_usuario']
                        ));
                    }

                    $CantidadF = $SelectFactura->rowCount();
                    $MostrarFactura = $SelectFactura->fetchAll();
                    ?>
                    <h2 class="my-3">Facturas</h2>

                    <form action="FacturaUsuario.php" method="POST">
                        <div class="row p-1">
                            <div class="col-md-5 mb-3">
                                <label for="Desde" class="form-label">Desde</label>
                                <input type="date" name="FechaDesde" id="Desde" class="form-control" value="<?php echo $fechad;?>">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="Hasta" class="form-label">Hasta</label>
                                <input type="date" name="FechaHasta" id="Hasta" class="form-control" value="<?php echo $fechah;?>">
                            </div>
                            <div class="col-md-2 mt-4">
                                <input type="submit" name="btn_BuscarFecha" class="btn btn-primary mt-2" value="Buscar">
                            </div>
                        </div>
                    </form>

                    <table class="table table-sm table-striped table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nº Factura</th>
                                <th>Codigo de Factura</th>
                                <?php if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0) { ?>
                                    <th>Cliente</th>
                                <?php } ?>
                                <th>Fecha facturación</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            if ($CantidadF > 0) {
                                foreach ($MostrarFactura as $row) { 
                                    $SelectUsuario = $base->prepare("SELECT * FROM usuario_pass WHERE ID = :id_usuarioss");
                                    $SelectUsuario->execute(array(":id_usuarioss" => $row['ID_USUARIO']));
                                    $rowUsuarios = $SelectUsuario->fetch();
                                    ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $row['ID'] ;?></td>
                                        <td class="align-middle"><?php echo $row['ID_TRANSACCION'] ;?></td>
                                        <?php if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0) { ?>
                                            <td class="align-middle"><?php echo $rowUsuarios['USUARIOS']; ?></td>
                                        <?php }?>
                                        <td class="align-middle"><?php echo $row['FECHA'] ;?></td>
                                        <td class="align-middle"><?php echo number_format($row['TOTAL_COMPRA'], 2, '.', ',') . MONEDA;?></td>
                                        <td class="align-middle"><?php echo $row['STATUSES'] ;?></td>
                                        <td class="align-middle"><a class="btn btn-warning" target="_blank" href="Facturas/Factura.php?idFactura=<?php echo $row['ID'] ;?>"><i class="fa-solid fa-file-pdf"></i></a></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td class="align-middle">Lista de factura vacia</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="container-fluid col-12">
                        <ul class="pagination pg-dark justify-content-center pb-2 mb-0" style="float:none;">
                            <?php 

                            if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0) {

                                $SelectPagina = $base->prepare("SELECT * FROM factura WHERE" . $where . $where2 . " ID_USUARIO <> 0 ORDER BY FECHA DESC");

                                $SelectPagina->execute();

                            } else {
                                $SelectPagina = $base->prepare("SELECT * FROM factura WHERE" . $where . $where2 . " ID_USUARIO = :idusuario ORDER BY FECHA DESC");

                                $SelectPagina->execute(array(
                                    ":idusuario" => $_SESSION['id_usuario']
                                ));
                            }

                            $CantidadPagina = $SelectPagina->rowCount();
                            $Paginas = ceil($CantidadPagina / $RegistrosPorPagina);
                            $Ultima = round($CantidadPagina / $RegistrosPorPagina);

                            if ($Ultima == $Pagina + 1) {
                                $Ultima = "";
                            }

                            if ($Pagina > 1) { ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=1" class="page-link"><i class="fa-solid fa-angles-left"></i></a></li>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina - 1); ?>" class="page-link"><i class="fa-solid fa-angle-left"></i></a></li>
                            <?php }
                            if ($Pagina > 2) { ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina-2); ?>" class="page-link"><?php echo ($Pagina-2);?></a></li>
                            <?php }

                            if ($Pagina > 1) { ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina-1); ?>" class="page-link"><?php echo ($Pagina-1);?></a></li>
                            <?php } ?>

                            <li class="page-item active"><a href="FacturaUsuario.php?Pagina=<?php echo $Pagina; ?>" class="page-link"><?php echo $Pagina;?></a></li>

                            <?php if (($Pagina + 1) <= $Paginas && $Paginas > 1) { 
                                ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina+1); ?>" class="page-link"><?php echo ($Pagina+1);?></a></li>
                            <?php } 

                            if (($Pagina + 2) <= $Paginas && $Paginas > 1) { 
                                ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina+2); ?>" class="page-link"><?php echo ($Pagina+2);?></a></li>
                                <?php 
                            }
                            if ($Pagina < $Paginas && $Paginas > 1) { ?>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo ($Pagina + 1); ?>" class="page-link"><i class="fa-solid fa-angle-right"></i></a></li>
                                <li class="page-item"><a href="FacturaUsuario.php?Pagina=<?php echo $Ultima; ?>" class="page-link"><i class="fa-solid fa-angles-right"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php require("Abajo.php"); ?>
    <?php } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes permiso, iniciar sesion para mostrar las facturas</h4>
    <?php } ?>

    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>