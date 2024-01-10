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
                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Perfil de usuario</button>
                    <?php if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 && strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0)) { ?>
                        <button class="nav-link" id="nav-direccion-tab" data-bs-toggle="tab" data-bs-target="#nav-direccion" type="button" role="tab" aria-controls="nav-direccion" aria-selected="false">Direcciones de envios y facturas</button>
                    <?php } ?>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <?php 
                    //Mostrar usuarios
                    $MostrarUsuario = $base->prepare("SELECT * FROM usuario_pass WHERE ID = :usuario");
                    $MostrarUsuario->execute(array(":usuario" => $_SESSION['id_usuario']));
                    $ResultadoUsuario = $MostrarUsuario->fetch();

                    ?>
                    <form action="code.php" method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <?php $ExistImagen = $ResultadoUsuario['FOTO'];

                            if (!file_exists($ExistImagen)){
                                $ExistImagen = "Fotos/Usuarios/UsuarioNoFotos.png";
                            }?>

                            <div class="col-md-5 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-2">
                                    <img class="rounded-circle mt-5" width="200px" height="200px" src="<?php echo $ExistImagen ?>">
                                    <span class="font-weight-bold h1 mt-2"><?php echo $ResultadoUsuario['USUARIOS'];?></span>
                                    <span class="text-black-50 h5"><?php echo $ResultadoUsuario['E_MAIL'];?></span>
                                    <span> </span>
                                </div>

                                <div class="mt-3 text-center">
                                    <button class="btn btn-primary profile-button" type="submit" name="btn_GuardarPerfil">Guardar Perfil</button>
                                </div>

                            </div>

                            <div class="col-md-5 border-right">
                                <div class="p-3 py-2">
                                    <div class="row my-2">

                                        <div class="col-md-6 mb-3">
                                            <label class="labels h5">Código usuario</label>
                                            <input type="text" class="form-control" value="<?php echo $ResultadoUsuario['ID'];?>" disabled>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="labels h5">Nombre usuario</label>
                                            <input type="text" class="form-control" value="<?php echo $ResultadoUsuario['USUARIOS'];?>" disabled>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="labels h5">Rol usuario</label>
                                            <input type="text" class="form-control" value="<?php echo $ResultadoUsuario['ROL'];?>" disabled>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="labels h5">Nombre completo (*)</label>
                                            <input type="text" name="nombre_usuario" class="form-control" value="<?php echo $ResultadoUsuario['NOMBRECOMPLETO'];?>">
                                            <small>Ej. Nombre Apellido1 Apellido2</small>
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label class="labels h5">Telefono fijo (*)</label>
                                            <input type="text" name="telefono_usuario" class="form-control" placeholder="Rellena teléfono" value="<?php echo $ResultadoUsuario['TELEFONO'];?>">
                                        </div>

                                        <div class="col-md-7 mb-3">
                                            <label class="labels h5">Correo electronico (*)</label>
                                            <input type="text" name="correo_usuario" class="form-control" value="<?php echo $ResultadoUsuario['E_MAIL'];?>">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="labels h5">Averia</label>
                                            <input type="file" name="image_usuario" class="form-control" accept="image/png">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 && strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0)) { ?>
                    <div class="tab-pane fade" id="nav-direccion" role="tabpanel" aria-labelledby="nav-direccion-tab">

                        <h2 class="my-3">Direcciones de envio</h2>

                        <?php  
                        //Mostrar direccion de envio
                        $MostrarDireccionEnvio = $base->prepare("SELECT * FROM direccion_cliente WHERE ID_USUARIO = :usuario AND TIPO_DIRECCION = :tipo_direccion ORDER BY PREDETERMINADA DESC");
                        $MostrarDireccionEnvio->execute(array(
                            ":usuario" => $_SESSION['id_usuario'],
                            ":tipo_direccion" => "envio"
                        ));

                        $ResultadoMostrarDireccionEnvio = $MostrarDireccionEnvio->fetchAll();
                        $CantidadDireccionEnvio = $MostrarDireccionEnvio->rowCount();

                        if ($CantidadDireccionEnvio >= 0) { 
                            foreach ($ResultadoMostrarDireccionEnvio as $direccionEnvio) { ?>
                                <div class="CjDireccionEnvio my-2 pl-3 w-75">
                                    <?php if ($direccionEnvio['PREDETERMINADA'] == 1) { ?>
                                        <h6 class="border text-center p-1 mb-3 bg-info bg-gradient w-100 rounded-pill">Predeterminado</h6>
                                    <?php }

                                    echo $direccionEnvio['DIRECCION_NUMERO'] . ", " . $direccionEnvio['CODIGO_POSTAL'] . ", " . $direccionEnvio['POBLACION'] . ", " . $direccionEnvio['PROVINCIA']; ?>

                                    <div class="w-25 float-end text-end" style="margin-top: -5px;">
                                        <a class="btn btn-warning p-1 text-black" href="Direcciones/ModificarDirecciones.php?tipo_direcciones=envio&id=<?php echo $direccionEnvio['ID']?>">Editar</a>
                                        <button type="button" onclick="alert_eliminar(<?php echo $direccionEnvio['ID']; ?>)" class="btn btn-danger p-1 text-black">Eliminar</button>
                                    </div>
                                </div>

                            <?php } 

                            if ($CantidadDireccionEnvio > 0 && $CantidadDireccionEnvio < 3) { ?>
                                <a class="btn btn-primary mt-4 mb-2" href="Direcciones/CrearDirecciones.php?tipo_direcciones=envio"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir otra direccion</a>
                            <?php } else if ($CantidadDireccionEnvio == 0) { ?>

                                <a class="btn btn-primary mt-3" href="Direcciones/CrearDirecciones.php?tipo_direcciones=envio"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir una direccion</a>

                            <?php } ?>

                        <?php } ?>

                        <h2 class="my-3">Direcciones de factura</h2>

                        <?php 
                            //Mostrar direccion de facturas
                        $MostrarDireccionFactura = $base->prepare("SELECT * FROM direccion_cliente WHERE ID_USUARIO = :usuario AND TIPO_DIRECCION = :tipo_direccion ORDER BY PREDETERMINADA DESC");
                        $MostrarDireccionFactura->execute(array(
                            ":usuario" => $_SESSION['id_usuario'],
                            ":tipo_direccion" => "factura"
                        ));
                        $ResultadoDireccionFactura = $MostrarDireccionFactura->fetchAll();
                        $CantidadDireccionFactura = $MostrarDireccionFactura->rowCount();

                        if ($CantidadDireccionFactura >= 0) { 
                            foreach ($ResultadoDireccionFactura as $direccionFactura) { ?>
                                <div class="CjDireccionEnvio my-2 pl-3 w-75">
                                    <?php if ($direccionFactura['PREDETERMINADA'] == 1) { ?>
                                        <h6 class="border text-center p-1 mb-3 bg-info bg-gradient w-100 rounded-pill">Predeterminado</h6>
                                    <?php }

                                    echo $direccionFactura['DIRECCION_NUMERO'] . ", " . $direccionFactura['CODIGO_POSTAL'] . ", " . $direccionFactura['POBLACION'] . ", " . $direccionFactura['PROVINCIA']; ?>

                                    <div class="w-25 float-end text-end" style="margin-top: -5px;">
                                        <a class="btn btn-warning p-1 text-black" href="Direcciones/ModificarDirecciones.php?tipo_direcciones=factura&id=<?php echo $direccionFactura['ID']?>">Editar</a>
                                        <button type="button" onclick="alert_eliminar(<?php echo $direccionFactura['ID']; ?>)" class="btn btn-danger p-1 text-black">Eliminar</button>
                                    </div>
                                </div>


                            <?php } 

                            if ($CantidadDireccionFactura > 0 && $CantidadDireccionFactura < 3) { ?>
                                <a class="btn btn-primary mt-3 mb-1" href="Direcciones/CrearDirecciones.php?tipo_direcciones=factura"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir otra direccion</a>
                            <?php } else if ($CantidadDireccionFactura == 0) { ?>

                                <a class="btn btn-primary mt-3 mb-1" href="Direcciones/CrearDirecciones.php?tipo_direcciones=factura"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir una direccion</a>

                            <?php }
                        } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php require("Abajo.php"); ?>
    <?php } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes permiso, iniciar sesion para mostrar el perfil de usuario</h4>
    <?php } ?>

    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>