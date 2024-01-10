<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Crear direcciones</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <?php
    include("../ConexionPHP.php"); 
    require '../token.php';
    include_once("../footer.php");

    //Mostrar provincias

    $MostrarProvincia = $base->prepare("SELECT * FROM tblprovincia");
    $MostrarProvincia->execute();
    $ResultadoProvincia = $MostrarProvincia->fetchAll();

    if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") != 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") != 0)) {

        $tipo_direcciones = $_GET['tipo_direcciones'];
        ?>

        <div class="container rounded bg-white mb-5 shadow-lg bg-white rounded pb-5 my-5">
            <form action="code.php" method="POST">

                <div class="row p-2">
                    <input type="hidden" name="tipo_direccion" value="<?php echo $tipo_direcciones;?>">
                    <h1>Añadir direccion de <?php echo $tipo_direcciones;?></h1>

                    <h4 style="color:red; ">(*) Obligatorio</h4>

                    <div class="mb-3">
                        <label for="direcciones" class="form-label">Direcciones y número (*):</label>
                        <input type="text" class="form-control" name="direcciones" id="direcciones">
                        <small>Ej. Calle aliseda 2, Piso 3, Puerta C</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Codigo postal (*):</label>
                        <input type="text" class="form-control" name="codigo_postal">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Población (*):</label>
                        <input type="text" class="form-control" name="poblacion">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Provincia (*):</label><br />
                        <select name="selecProvincia" class="form-select">
                            <option value="0">Seleccionar</option>
                            <?php foreach ($ResultadoProvincia as $Provincia) { ?>
                                <option value="<?php echo $Provincia['ID']; ?>"><?php echo $Provincia['PROVINCIA'] ;?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" class="mt-3" name="pretederminado">
                        <label class="form-label">Establecer cómo predeterminada (para futuras compras)</label>
                    </div>

                    <div class="centr">
                        <input type="submit" class="btn btn-danger mx-2" style="width:49%;" name="btn_cerrar" value="Cancelar">
                        <input type="submit" class="btn btn-primary" style="width:49%;" name="btn_GuardarDireccion" value="Guardar">
                    </div>
                </div>
            </form>
        </div>

    <?php } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes permiso, iniciar sesion para insertar direcciones</h4>
    <?php } ?>

    <script src="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>