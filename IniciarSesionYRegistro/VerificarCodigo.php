<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Verificar codigo</title>
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

               <form action="code.php" method="POST">

                <div class="login">Verificar codigo</div>

                <div class="row">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="number" name="OTPVerificar" placeholder="Introducir codigo.">
                </div>

                <div class="row button">
                    <input type="submit" value="Enviar codigo" name="btn_enviarCodigo">
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
</html>