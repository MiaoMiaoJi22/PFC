<?php 
include("ConexionPHP.php"); 
require 'token.php';

$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

if (isset($_SESSION['id_usuario'])){

   $user = $_SESSION["Rol_usuario"];

   $TiempoEx = ($user === "Administrador") ? 3600: 1800;

   if ((time() - $_SESSION['time']) > $TiempoEx){
       session_destroy();
       header("location: IniciarSesionYRegistro/ExpirarSesion.php");
   }
}

?>

<div class="body">
    <nav class="navbars">
        <a href="<?php echo $enlacePrincipal; ?>index.php"><img src="<?php echo $enlacePrincipal; ?>Fotos/logo.png"/></a>

        <?php 
        if (!isset($_SESSION['id_usuario']) || (isset($_SESSION['id_usuario']) && strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 && (strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0))) { ?>

            <ul class="navbars-list">
                <li><a href="<?php echo $enlacePrincipal; ?>index.php">Inicio</a></li>
                <li><a href="<?php echo $enlacePrincipal; ?>Producto.php">Productos</a></li>
                <li><a href="<?php echo $enlacePrincipal; ?>Acerca.php">Acerca de</a></li>
                <li><a href="<?php echo $enlacePrincipal; ?>Contacto.php">Contacto</a></li>
            </ul>

        <?php } else if (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0) { ?>

            <ul class="navbars-list">
                <li><a href="<?php echo $enlacePrincipal; ?>Producto.php">Productos</a></li>
                <li><a href="<?php echo $enlacePrincipal; ?>Cliente.php?Pagina=1">Usuarios</a></li>
                <li><a href="<?php echo $enlacePrincipal; ?>Carrusel.php">Carrusel</a></li>
            </ul>

        <?php }

        if (!isset($_SESSION['id_usuario'])) { ?>

            <div class="Iniciarsesion">
                <a href="<?php echo $enlacePrincipal; ?>IniciarSesionYRegistro/IniciarSesion.php" title="Iniciar sesión"><i class="fa-solid fa-user"></i>Iniciar sesión</a>
            </div>

        <?php } else if (isset($_SESSION['id_usuario'])) {
            $ExistImagen = $_SESSION["foto_usuario"];
            
            if (!file_exists($ExistImagen)){
                $ExistImagen = "Fotos/Usuarios/UsuarioNoFotos.png";
            }

            ?>

            <div class="profile-dropdown">
                <div class="profile-dropdown-btn" onclick="toggle()">
                    <div class="profile-img">
                        <img src="<?php echo $enlacePrincipal . $ExistImagen; ?>">
                    </div>
                    <span><?php echo $_SESSION['usuarios']; ?></span>
                    <i class="fa-solid fa-angle-down"></i>
                </div>

                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item">
                        <a href="<?php echo $enlacePrincipal; ?>Usuarios.php">
                            <i class="fa-solid fa-user"></i>
                            Mi perfil
                        </a>
                    </li>
                    <li class="profile-dropdown-list-item">
                        <a href="<?php echo $enlacePrincipal; ?>FacturaUsuario.php?Pagina=1">
                            <i class="fa-solid fa-file-invoice"></i>
                            Facturas
                        </a>
                    </li>
                    <hr />
                    <li class="profile-dropdown-list-item">
                        <a href="<?php echo $enlacePrincipal; ?>IniciarSesionYRegistro/ExpirarSesion.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Cerrar sesión
                        </a>
                    </li>
                </ul>

                <ul class="navbars-list-2">
                    <?php

                    if (isset($_SESSION["Rol_usuario"]) && strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 && strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0) { 

                        $ContarProductoCliente = $base->prepare("SELECT * FROM carro_compra WHERE ID_USUARIO = :nom_usuario");
                        $ContarProductoCliente->execute(array(":nom_usuario" => $_SESSION['id_usuario']));
                        $Total_ProductoCliente = $ContarProductoCliente->rowCount();

                        ?>
                        <li><a href="<?php echo $enlacePrincipal; ?>CarroCompra.php"><i class="fa-solid fa-cart-shopping"></i> <span class="badge bg-secondary"><?php echo $Total_ProductoCliente; ?></span></a></li>

                    <?php } else if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0)) {

                        $ContarProducto = $base->prepare("SELECT * FROM factura");
                        $ContarProducto->execute();
                        $Total_Producto = $ContarProducto->rowCount();

                        ?> 
                        <li><a href="<?php echo $enlacePrincipal; ?>FacturaUsuario.php?Pagina=1"><i class="fa-solid fa-file-invoice-dollar"></i> <span class="badge bg-secondary"><?php echo $Total_Producto; ?></span></a></li>

                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </nav>
</div>

<script src="<?php echo $enlacePrincipal; ?>js/menu.js"></script>