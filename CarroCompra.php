<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Carrito de compra</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
</head>

<body>

    <?php 
    include_once("menu.php"); 
    include_once('footer.php');

    if (isset($_SESSION['id_usuario'])) {

        $user = $_SESSION['id_usuario'];
        $total = 0;
        $totalConfirmacion = 0;

        $MostrarCarro = $base->prepare("SELECT * FROM carro_compra WHERE ID_USUARIO = :usua ORDER BY FECHA_SUBIDO");
        $MostrarCarro->execute(array(":usua" => $user));

        if (strcasecmp($user, "Admin") != 0) { ?>

            <div class="container">

                <?php if ($MostrarCarro->rowCount() > 0) {

                    while($filasCarro = $MostrarCarro->fetch(PDO::FETCH_ASSOC)) {

                        $MostrarProductos = $base->prepare("SELECT * FROM productos WHERE ID = :id");
                        $MostrarProductos->execute(array(":id" => $filasCarro['ID_PRODUCTO']));

                        if ($MostrarProductos->rowCount() > 0) {

                            $filasProducto = $MostrarProductos->fetch(PDO::FETCH_ASSOC); ?> 

                            <form action="code.php" method="POST">
                                <main>
                                    <div class="row cj my-5">
                                        <div class="col-md-2 p-3">
                                            <input type="hidden" name="idCarro" value="<?php echo $filasCarro['ID']; ?>">
                                            <img width="150px" height="150px" src="<?php echo $filasProducto['FOTO']; ?>"> 
                                        </div>

                                        <div class="col-md-4 p-4">
                                            <h4><?php echo $filasProducto['NOMBRE']; ?></h4>

                                            <h5 class="">Precio/Unidad:&nbsp;&nbsp;&nbsp;<?php echo number_format($filasCarro['PRECIO'],2, '.', ',') . MONEDA; ?></h5>

                                            <h4 class="text-danger"><?php
                                            $subtotal = ($filasCarro['PRECIO'] * $filasCarro['CANTIDAD']);
                                            $total += $subtotal;
                                            echo "Subtotal: " . number_format($subtotal,2, '.', ',') . MONEDA; ?></h4>

                                        </div>

                                        <div class="col-md-4 p-5 text-center">
                                            <!-- <input type="submit" value="-" class="decrementar" name="btn_decrementar"> -->
                                            <h5>Cantidad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>

                                            <input type="text" name="cantidadproduc" value="<?php echo $filasCarro['CANTIDAD']; ?>" step="1" class="cantidad mb-1">
                                            <!-- <input type="submit" value="+" class="incrementar" name="btn_incrementar"> -->
                                            <button type="submit" class="btn btn-warning mx-2" name="btn_editarCarro"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </div>

                                        <div class="col-md-2 p-4 text-center my-auto">
                                            <button type="submit" name="btn_eliminarCarro" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
                                        </div>

                                    </div>
                                </main>
                            </form>

                            <!-- Modal -->
                            <div class="modal fade" id="RealizarPago" tabindex="-1" aria-labelledby="RealizarPagoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <form action="code.php" method="POST">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="RealizarPagoLabel">Confirmación de pago</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <main>
                                                    <table class="table table-sm table-striped table-hover text-center">

                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Foto</th>
                                                                <th>Nombre</th>
                                                                <th>Cantidad</th>
                                                                <th>Precio/Unidad</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                            <input type="hidden" name="idCarro" value="<?php echo $filasCarro['ID']; ?>">

                                                            <?php if ($MostrarProductos->rowCount() > 0) { ?>

                                                                <tr>
                                                                    <?php 

                                                                    $ExistImagen = $filasProducto['FOTO'];

                                                                    if (!file_exists($ExistImagen)){
                                                                        $ExistImagen = $_SERVER["DOCUMENT_ROOT"] . "/Fotos/NoFoto.png";
                                                                    }

                                                                    ?>

                                                                    <td>
                                                                        <img width="100px" height="100px" src="<?php echo $ExistImagen; ?>">
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?php echo $filasProducto['NOMBRE']; ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?php echo $filasCarro['CANTIDAD']; ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?php echo number_format($filasCarro['PRECIO'], 2, ".", ",") . MONEDA; ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?php
                                                                        $subtotalConfirmacion = ($filasCarro['PRECIO'] * $filasCarro['CANTIDAD']);
                                                                        $totalConfirmacion += $subtotalConfirmacion;
                                                                        echo number_format($totalConfirmacion,2, '.', ',') . MONEDA; ?>
                                                                    </td>
                                                                </tr>

                                                                <?php    
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php if ($totalConfirmacion > 0){ ?>
                                                    <input type="hidden" name="TotalCompra" value="<?php echo $totalConfirmacion;?>">
                                                    <h1 style="text-align: right;">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalConfirmacion,2, '.', ',') . MONEDA; ?></h1>
                                                <?php } ?>
                                            </main>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="btn_RealizarPago">Comprar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php }
                } else{ ?>
                    <p class='text-center pt-5'><b>Lista vacia</b></p>
                <?php  }

            }
            
            if ($total > 0){ ?>
                <h1 style="text-align: right;">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($total,2, '.', ',') . MONEDA; ?></h1>
            <?php }

            if ($MostrarCarro->rowCount() > 0) { ?>

                <div class="row my-5">
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#RealizarPago">Realizar pago</button>
                    </div>
                </div>

            <?php } ?>

        </div>

        <?php require("Abajo.php"); ?>

        <?php 
    } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes persmiso, iniciar sesion para mostrar carro de compra</h4>
    <?php } ?> 

    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>