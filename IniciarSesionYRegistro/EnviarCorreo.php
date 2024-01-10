<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Recuperar contraseña</title>
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

                    <div class="login">Enviar correo</div>

                    <div class="input-box" id="grupo__mail">

                        <div class="row">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="mail" placeholder="Introducir correo electronico">
                        </div>

                        <p class="formulario__input-error">El correo solo puede contener letras, números, puntos, guiones y guión bajo.</p>

                    </div>

                    <div class="row button">
                        <input type="submit" value="Enviar" name="btn_enviarCorreo">
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
</html>