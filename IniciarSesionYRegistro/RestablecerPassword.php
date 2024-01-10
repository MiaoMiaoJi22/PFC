<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" type="text/css" href="css/LoginStyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>fontawesome/css/all.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>/Fotos/IconoWeb.png">
</head>

<body>

    <?php include_once('footer.php'); ?>

    <div class="port">
        <a href="../index.php" title="Inicio"><img src="../Fotos/logo.png"></a>

        <div class="cont">
            <div class="wrapper">

               <a href="IniciarSesion.php" title="Iniciar sesion" class="EntrarInicio">Iniciar sesión</a>

               <form action="code.php" method="POST" id="formulario">

                <div class="login">Restablecer contraseña</div>

                <div class="input-box" id="grupo__pass">

                    <div class="row">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" class="contrase" placeholder="Introducir contraseña" id="pass">
                        <i class="fa-solid fa-eye-slash showHodePW"></i>
                    </div>

                    <p class="formulario__input-error">La contraseña tiene que ser de 4 a 50 dígitos</p>

                </div>

                <div class="input-box" id="grupo__confirmpass">

                    <div class="row">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="contrase" id="pass2" name="confirmpassword" placeholder="Volver a introducir contraseña">
                        <i class="fa-solid fa-eye-slash showHodePW"></i>
                    </div>

                    <p class="formulario__input-error">Ambas contraseñas deben ser iguales</p>

                </div>

                <div class="row button">
                    <input type="submit" value="Restablecer" name="btn_restablece">
                </div>

                <div class="signup-link">
                    No tienes cuenta? 
                    <a href="RegistrarUsuario.php">Registrarla</a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="js/Formulario.js"></script>
<script type="text/javascript" src="js/Login.js"></script>
</html>