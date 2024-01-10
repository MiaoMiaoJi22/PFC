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
    include_once("ConexionPHP.php");
    include_once("menu.php"); ?>

    <div class="Acerca">
        <h1>Acerca de nosotros</h1>

        <img src="Fotos/Ubicacion.png">

        <div class="contenido">

            <p>Nuestro tienda ha empezado en 15 años antes, es decir en el año 2008, en este año, me ha ido al España con mis familias, mi mujer, mi hijo y mi hija, buscando una tienda para abrirla en tipo de alimentación y bazar.</p>

            <p>En el febrero del año 2005 me ha venido primera vez en España, para ganar dinero, me ha ido a trabajar sobre parte de obras, un trabajador de cementos, después de dos años me ha dejado de trabajar y me volvido a china a descansar, porque mi cuerpo está enfermo.</p>

            <p>Llega al 2008, vuelvo a venir a España con mís familias veniendo aqui a abrir una tienda de Alimentacioón y Bazar.</p>

            <p>En principio era un tienda pequeña, mientras se ha cerrado el locutorio que esta a lado de nuestro tienda, me ha alquilado también este locutorio para que el tienda sea un poco más grande (Son mismo dueño los dos tiendas).</p>

            <p>Se ha cambiado la entrada de la puerta, en principio era un puerta y una ventana para mostrar los productos, después de alquilar el locutorio, se ha cambiado entrada de puerta por la entrada de locutorio.</p>

        </div>
    </div>

    <?php require("Abajo.php"); ?>
    
</body>
</html>

