<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Producto</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="CRUD_Productos/js/Eliminar.js"></script>
</head>

<body>

    <?php include_once("menu.php"); 
    include_once("footer.php");
    ?>

    <?php

    $where = "";
    $pro = "";
    $order ="";

    if (isset($_GET['Tipo_Producto'])) {
        $pro = $_GET['Tipo_Producto'];
        $where = "WHERE TIPO='" . $pro . "'";
    }else {
        $pro = "Productos";
        $where = "WHERE TIPO <> '" . $pro . "'";
    }

    $where2 = "";

    if (isset($_POST['btn_enviarBusqueda'])){
        $busqueda = $_POST['cajabusqueda'];
        if (isset($_POST['cajabusqueda'])){
            $where2 = "AND NOMBRE LIKE '%" . $busqueda . "%'";
        }
    }

    if (isset($_POST['btn_Pbajo'])) {
        $order = "ORDER BY PRECIO_DECUENTO ASC";
    }

    if (isset($_POST['btn_PAlto'])) {
        $order = "ORDER BY PRECIO_DECUENTO DESC";
    }

    if (isset($_POST['btn_Pmasventa'])){
        $order = "ORDER BY CANTIDAD_VENDIDO DESC";
    }

    $MostrarProducto = "SELECT ID, NOMBRE, DESCRIPCION, PRECIO, DESCUENTO, TIPO, CANTIDAD, FOTO, FECHA_MODIFICACION, (PRECIO - ((PRECIO * DESCUENTO) / 100)) AS PRECIO_DECUENTO FROM productos $where $where2 $order";
    $MostrarProductoResul = $base->prepare($MostrarProducto);
    $MostrarProductoResul->execute();

    $contamosrProducto = $MostrarProductoResul->rowCount();

    if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0)) { ?>

        <div class="Productos">
            <h1>Lista de productos</h1>

            <div class="mb-5">

                <a class="btn btn-success mt-3 mb-4 mx-0" href="CRUD_Productos/CrearProducto.php"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Nuevo producto</a>

                <table id="TableProductos" class="display">

                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categorias</th>
                            <th>Cantidad</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $filasProducto = $MostrarProductoResul->fetchAll();

                        foreach ($filasProducto as $filas) {

                            $ExistImagen = $filas['FOTO'];

                            if (!file_exists($ExistImagen)){
                                $ExistImagen = "Fotos/NoFoto.png";
                            }

                            ?>

                            <tr>
                                <td><img width="100px" height="100px" src="<?php echo $ExistImagen; ?>"></td>
                                <td class="align-middle"><?php echo $filas['NOMBRE']; ?></td>
                                <td class="align-middle"><?php echo number_format($filas['PRECIO'], 2, ".", ",") . MONEDA; ?></td>
                                <td class="align-middle"><?php echo $filas['TIPO']; ?></td>
                                <td class="align-middle"><?php echo $filas['CANTIDAD']; ?></td>
                                <td class="align-middle"><a href="CRUD_Productos/ModificarProducto.php?ID=<?php echo $filas['ID']; ?>" class="btn btn-xl btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td class="align-middle"><a onclick="alert_eliminar(<?php echo $filas['ID']; ?>)" class="btn btn-xl btn-danger"><i class="fa-solid fa-trash-can"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 || (strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0)) || !isset($_SESSION['id_usuario'])) {  ?>

        <div class="PartDer">
            <div class='my-4 text-center'>
                <form action="Producto.php" method="POST">
                    <input type='search' name='cajabusqueda' class='buscador' placeholder='Busca tu producto que quieres...' id="buscar">
                    <button class="btn btn-outline-warning" type="submit" name="btn_enviarBusqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div> 

            <div class="menu">
                <ul>
                    <a href="Producto.php"><li>Todos</li></a>
                    <a href="Producto.php?Tipo_Producto=Alimentacion"><li>Alimentación</li></a>
                    <a href="Producto.php?Tipo_Producto=Bebida"><li>Bebida</li></a>
                    <a href="Producto.php?Tipo_Producto=Papeleria"><li>Papeleria</li></a>
                    <a href="Producto.php?Tipo_Producto=Limpieza"><li>Limpieza</li></a>
                    <a href="Producto.php?Tipo_Producto=Herramientas"><li>Herramientas</li></a>
                    <a href="Producto.php?Tipo_Producto=Cosmetico"><li>Cosmético</li></a>
                    <a href="Producto.php?Tipo_Producto=Juego"><li>Juego</li></a>
                </ul>
            </div>

            <div class="derecaja">
                <h1><?php echo $pro; ?></h1>

                <div class="botonesFiltral">

                    <form action="Producto.php" method="POST">
                        <button class="btn btn-outline-primary" type="submit" name="btn_Pbajo">Precio más bajo</button>
                        <button class="btn btn-outline-primary ms-5" type="submit" name="btn_PAlto">Precio más alto</button>
                        <button class="btn btn-outline-primary mx-5" type="submit" name="btn_Pmasventa">Producto más vendido</button>
                        <div style="float:right;align-items: center; font-size: 22px"><?php echo $contamosrProducto; ?> Productos</div>
                    </form>

                </div>
                

                <main>

                    <div class="container">

                        <div class="row">

                            <?php 

                            $filasProducto = $MostrarProductoResul->fetchAll();

                            foreach ($filasProducto as $filas){
                                $ExistImagen = $filas['FOTO'];
                                $descuentobtn = $filas['DESCUENTO'];

                                if (!file_exists($ExistImagen)){
                                    $ExistImagen = "Fotos/NoFoto.png";
                                }

                                $precio_desc = $filas['PRECIO'] - (($filas['PRECIO'] * $descuentobtn) / 100);

                                ?>

                                <div class="col-md-4">
                                    <div class="card mb-4 box-shadow">
                                        <?php if ($descuentobtn > 0){ ?>
                                            <div class="btn-danger ofertas">Oferta</div>
                                        <?php }?>
                                        <img width="100%" height="300px" src="<?php echo $ExistImagen; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $filas['NOMBRE']; ?></h5>
                                            <p class="card-text"><?php echo number_format($precio_desc, 2, ".", ",") . MONEDA; ?></p>

                                            <div class="d-flex justify-content-between align-items-center">

                                                <div class="btn-group">
                                                    <a href="detalles.php?ID=<?php echo $filas['ID']; ?>&token=<?php echo hash_hmac('sha256', $filas['ID'], KEY_TOKEN)?>" class="btn btn-primary">Detalles</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php require("Abajo.php"); ?>
    <?php } ?>

    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#TableProductos').DataTable( {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>

</body>
</html>