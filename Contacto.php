<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Pagina contacto</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php 
    include_once("footer.php");
    include_once("ConexionPHP.php");
    include_once("menu.php"); ?>

    <div class="CajaContacta">
        <h1 class="mx-2"><b>Contacta</b> con nosotros</h1>

        <form action="code.php" method="POST">

            <div class="container">
                <div class="row my-3">

                    <?php if (isset($_SESSION['id_usuario'])) { 

                        $usuario = $_SESSION['id_usuario'];

                        $MostrarUsuario = $base->prepare("SELECT * FROM usuario_pass WHERE ID = :usuario");
                        $MostrarUsuario->execute(array(':usuario' => $usuario));

                        $usua = $MostrarUsuario->fetch();
                        
                        ?>

                        <div class="col-md-6">
                            <label for="Nombre">Nombre *</label>
                            <input type="text" id="Nombre" name="nombre" value="<?php echo $usua['NOMBRECOMPLETO']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo electronico *</label>
                            <input type="text" id="correo" name="correos" value="<?php echo $usua['E_MAIL']; ?>">
                        </div>

                    <?php } else { ?>

                        <div class="col-md-6">
                            <label for="Nombre">Nombre *</label>
                            <input type="text" id="Nombre" name="nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="correo">Correo electronico *</label>
                            <input type="text" id="correo" name="correos">
                        </div>

                    <?php } ?>

                    <div class="col-md-12">
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto">
                    </div>
                    <div class="col-md-12">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" rows="12" cols="69" name="mensaje"></textarea>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" name="btn_enviarcontacto" class="btn btn-primary px-5" value="Enviar Mensaje">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="Sitio">
        <h1 class="mb-4"><b>Tienda</b></h1>
        <div class="row">
            <div class="col-md-1">
                <i class="fa-solid fa-location-dot"></i> <!--NO LO SE PORQUE SON DIFERENTES TAMAÑOS LOS CIRCULOS, PORQUE LOS TAMAÑOS ME LO HA PUESTO IGUALES LOS ICONOS-->
            </div>
            <div class="col-md-8 mx-3">
                <h5>Direccion</h5>
                <p>Calle piedrahita 27, 28025 Madrid. España</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="col-md-8 mx-3">
                <h5>Teléfono</h5>
                <p>+34 622 682 527</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <i class="fa-solid fa-envelope"></i> 
            </div>
            <div class="col-md-8 mx-3">
                <h5>Email</h5>
                <p>vicentealimentacion1969@gmail.com</p>
            </div>
        </div>
    </div>

    <div class="Sitio">
        <h1 class="mb-4"><b>Horario</b> abierto</h1>
        <div class="row">
            <div class="col-md-1">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="col-md-8 mx-3">
                <h5>Lunes a Domingo</h5>
                <p>De 09:00 a 00:30 horas</p>
            </div>
        </div>
    </div>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1807.2511299418618!2d-3.7425196795022178!3d40.37733898561656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42278722b9d761%3A0x67ff54cbe21a69b8!2sC.%20Piedrahita%2C%2027%2C%2028025%20Madrid!5e0!3m2!1szh-CN!2ses!4v1685917215258!5m2!1szh-CN!2ses" width="1200" height="450" style="border:0;margin: 20px 60px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    <?php require("Abajo.php"); ?>
    
</body>
</html>

