<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" type="text/css" href="css/LoginStyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>fontawesome/css/all.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>/Fotos/IconoWeb.png">
</head>

<body>

    <?php include_once('footer.php');?>

    <div class="port">

        <div class="cont">

            <div class="wrapper">

                <div style="text-align: center;">
                    <a href="../index.php" title="Inicio"><img src="../Fotos/logo.png"></a>
                </div>
                
                <form action="code.php" method="POST">

                    <div class="login">Iniciar sesión</div>

                    <div class="row">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="user" placeholder="Introducir nombre de usuario">
                    </div>

                    <div class="row">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="contrase" name="pass" placeholder="Introducir contraseña">
                        <i class="fa-solid fa-eye-slash showHodePW"></i>
                    </div>

                    <div class="olvidado">
                        <a href="EnviarCorreo.php">Has olvidado tu contraseña?</a>
                    </div>

                    <div class="row button">
                        <input type="submit" value="Iniciar sesion" name="btn_login">
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
<script type="text/javascript" src="js/Login.js"></script>
</html>