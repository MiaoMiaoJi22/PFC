<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Pagina principal</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php include_once("menu.php");
    include_once('footer.php');

    $SelectCarrusel = $base->prepare("SELECT * FROM tbl_carrusel");
    $SelectCarrusel->execute();
    $rowCarrusel = $SelectCarrusel->fetchAll();
    $CantCarrusel = count($rowCarrusel);
    ?>

    <div class="CajaCarousel">

        <div id="carouselExample" class="carousel slide" data-ride="carousel">

            <div class="carousel-indicators">
                <?php for ($i = 0; $i < $CantCarrusel; $i++) { 
                    if ($i == 0) { ?>
                        <button type="button" data-bs-target="#carousel<?php echo $i; ?>" data-bs-slide-to="<?php echo $i; ?>" class="active" aria-current="true" aria-label="Slide<?php echo $i; ?>"></button>
                    <?php } else { ?>
                        <button type="button" data-bs-target="#carousel<?php echo $i; ?>" data-bs-slide-to="<?php echo $i; ?>" class="" aria-current="true" aria-label="Slide<?php echo $i; ?>"></button>
                    <?php } 
                }?>
            </div>

            <div class="carousel-inner">
                <?php for ($i = 0; $i < $CantCarrusel; $i++) { 

                    $SelectProducto = $base->prepare("SELECT * FROM productos WHERE ID = :idp");
                    $SelectProducto->execute(array(":idp" => $rowCarrusel[$i]['ID_PRODUCTO']));

                    $row_filas = $SelectProducto->fetch();

                    if ($i == 0) { ?>
                        <div class="carousel-item active c-item" data-bs-interval="2000">
                            <img class="c-img" src="<?php echo $row_filas['FOTO']; ?>">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Oferta de <?php echo $row_filas['NOMBRE']; ?></h5>
                                <p><?php echo $rowCarrusel[$i]['DESCRIPCION']; ?></p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="carousel-item c-item" data-bs-interval="2000">
                            <img class="c-img" src="<?php echo $row_filas['FOTO']; ?>">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Oferta de <?php echo $row_filas['NOMBRE']; ?></h5>
                                <p><?php echo $rowCarrusel[$i]['DESCRIPCION']; ?></p>
                            </div>
                        </div>
                    <?php } 
                }?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>

    </div>

    <div class="ParteIndicer">
        <?php 
        $SelectCarrusel->closeCursor(); // Cerrar el cursor y liberar recursos
        unset($SelectCarrusel);
        $MostrarProductoDescuento = $base->prepare("SELECT * FROM productos WHERE DESCUENTO > 0.00");
        $MostrarProductoDescuento->execute();

        $cantidad_filas = $MostrarProductoDescuento->rowCount();
        $desc_filas = $MostrarProductoDescuento->fetchAll();?>

        <h1>Productos que llevan ofertas</h1>

        <?php if ($cantidad_filas > 0) { ?>

            <div class="owl-carousel owl-theme">

                <?php 

                foreach ($desc_filas as $filas) { 
                    $precio = $filas['PRECIO'];
                    $descuento = $filas['DESCUENTO'];

                    $ExistImagen = $filas['FOTO'];

                    if (!file_exists($ExistImagen)){
                        $ExistImagen = $_SERVER["DOCUMENT_ROOT"] . "/Fotos/NoFoto.png";
                    }

                    ?>
                    <div class="item">
                        <div class="card">
                            <div class="img-wrapper">
                                <?php if ($descuento > 0){ ?>
                                    <div class="btn-danger ofertas">Oferta</div>
                                <?php }?>
                                <img src="<?php echo $ExistImagen; ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $filas['NOMBRE']; ?></h5>
                                <p><del><?php echo number_format($filas['PRECIO'], 2, '.', ',') . MONEDA; 
                                $precio_desc = $precio - (($precio * $descuento) / 100);?></del></p>
                                <h3>
                                    <?php echo number_format($precio_desc, 2, '.', ',') . MONEDA; ?>
                                    <small class="text-success"><?php echo $descuento ?>% descuento</small>
                                </h3>
                                <a href="detalles.php?ID=<?php echo $filas['ID']; ?>&token=<?php echo hash_hmac('sha256', $filas['ID'], KEY_TOKEN)?>" class="btn btn-primary">Detalles</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <?php require("Abajo.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            autoplay: true,
            stagePadding: 50,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        })
    </script>

</body>
</html>