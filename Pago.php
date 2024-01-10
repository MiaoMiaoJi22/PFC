<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Pagado</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <?php 
    include_once("menu.php"); 

    if (isset($_SESSION['id_usuario'])) {

        $user = $_SESSION['id_usuario'];
        $total = 0;

        $MostrarCarro = $base->prepare("SELECT * FROM carro_compra WHERE ID_USUARIO = :usua ORDER BY FECHA_SUBIDO");
        $MostrarCarro->execute(array(":usua" => $user));

        if (strcasecmp($user, "Administrador") != 0) { 
            if ($MostrarCarro->rowCount() == 0) {
                ?>
                <div class="text-center">
                    <h2 class="text-success">Has comprado perfectamente los productos</h2>
                    <a class="btn btn-warning mt-4" href="Producto.php">Volver a la página de productos</a>
                </div>

            <?php }
        } 

    } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes permiso, iniciar sesion para mostrar esta ventana</h4>
    <?php } ?> 

    <?php require("Abajo.php"); ?>
    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>