<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Registrar cuenta</title>
    <link rel="stylesheet" type="text/css" href="css/RegistrarStyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>fontawesome/css/all.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>/Fotos/IconoWeb.png">
</head>

<body>

    <?php include_once('footer.php'); ?>

    <div class="container">
        <div class="title">Registrar cuenta</div>

        <form action="code.php" method="post" id="formulario">
            <div class="user-details">

                <div class="input-box" id="grupo__nombre">
                    <span class="details">Nombre completo</span>
                    <input type="text" name="fullname" placeholder="John Doe" class="formulario__input">

                    <p class="formulario__input-error">El nombre completo debe tener por mínimo 4 dígitos</p>
                </div>

                <div class="input-box" id="grupo__usuario">
                    <span class="details">Usuario</span>
                    <input type="text" name="user" placeholder="Introduce nombre de usuario" class="formulario__input">

                    <p class="formulario__input-error">El usuario tiene que ser de 4 a 20 dígitos y solo puede contener numeros, letras y guión bajo.</p>
                </div>

                <div class="input-box" id="grupo__mail">
                    <span class="details">Email</span>
                    <input type="email" name="mail" placeholder="example@gmail.com" class="formulario__input">

                    <p class="formulario__input-error">El correo solo puede contener letras, números, puntos, guiones y guión bajo.</p>
                </div>

                <div class="input-box" id="grupo__tel">
                    <span class="details">Telefono</span>
                    <input type="tel" name="phone" placeholder="123456789" class="formulario__input">

                    <p class="formulario__input-error">El teléfono solo puede contener números y el máximo son 14 dígitos</p>
                </div>

                <div class="input-box" id="grupo__pass">
                    <span class="details">Contraseña</span>
                    <input type="password" name="password" placeholder="Introduce contraseña" id='pass' class="formulario__input">

                    <p class="formulario__input-error">La contraseña tiene que ser de 4 a 50 dígitos</p>
                </div>

                <div class="input-box" id="grupo__confirmpass">
                    <span class="details">Confirmar Contraseña</span>
                    <input type="password" name="confirmpassword" placeholder="Introduce contraseña" id='pass2' class="formulario__input">

                    <p class="formulario__input-error">Ambas contraseñas deben ser iguales</p>
                </div>

            </div>

            <div class="formulario__mensaje">
                <p><i class="fa-solid fa-triangle-exclamation"></i> <b>Error:</b> Por favor rellena el formulario correctamente</p>
            </div>

            <div class="button">
                <input type="submit" value="Registrar" name="btn_registrar">
            </div>

            <h4>Ya tienes cuenta? <a href="IniciarSesion.php">Iniciar sesión</a></h4>

        </form>

    </div>


    <script type="text/javascript" src="js/Formulario.js"></script>

</body>
</html>