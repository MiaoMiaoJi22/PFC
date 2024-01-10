<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modificar direcciones</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>Fotos/IconoWeb.png">
    <link rel="stylesheet" type="text/css" href="css/crudStyle.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <?php include("../ConexionPHP.php"); 
    require '../token.php';
    include_once('../footer.php');

    //Mostrar provincias
    $MostrarProvincia = $base->prepare("SELECT * FROM tblprovincia");
    $MostrarProvincia->execute();
    $ResultadoProvincia = $MostrarProvincia->fetchAll();

    if (isset($_SESSION["Rol_usuario"])) {
        $tipo_direcciones = $_GET['tipo_direcciones'];
        $id_direccion = $_GET['id'];

        $MostrarDireccion = $base->prepare("SELECT * FROM direccion_cliente WHERE ID_USUARIO = :usuario AND TIPO_DIRECCION = :tipo_direccion AND ID = :id");
        $MostrarDireccion->execute(array(
            ":usuario" => $_SESSION['id_usuario'],
            ":tipo_direccion" => $tipo_direcciones,
            ":id" => $id_direccion
        ));
        $resultado = $MostrarDireccion->fetch();
        ?>

        <div class="container rounded bg-white mb-5 shadow-lg bg-white rounded pb-5 my-5">

            <form action="code.php" method="POST">
                <div class="row p-2">
                    <input type="hidden" name="id_direccionMod" value="<?php echo $resultado['ID']; ?>">
                    <input type="hidden" name="tipo_direccionMod" value="<?php echo $tipo_direcciones; ?>">

                    <h1 class="modal-title">Modificar direccion de <?php echo $tipo_direcciones;?></h1>
                    <h4 style="color:red; ">(*) Obligatorio</h4>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Direcciones y número (*):</label>
                            <input type="text" class="form-control" name="direccionesMod" value="<?php echo $resultado['DIRECCION_NUMERO']; ?>">
                            <small>Ej. Calle aliseda 2, Piso 3, Puerta C</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Codigo postal (*):</label>
                            <input type="text" class="form-control" name="codigo_postalMod" value="<?php echo $resultado['CODIGO_POSTAL']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Población (*):</label>
                            <input type="text" class="form-control" name="poblacionMod" value="<?php echo $resultado['POBLACION']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Provincia (*):</label><br />
                            <select name="selecProvinciaMod" class="form-select">
                                <option value="0">Seleccionar</option>
                                <?php foreach ($ResultadoProvincia as $Provincia) { 
                                    if ($Provincia['PROVINCIA'] == $resultado['PROVINCIA']) { ?>
                                        <option value="<?php echo $Provincia['ID']; ?>" selected><?php echo $Provincia['PROVINCIA'] ;?></option>
                                    <?php }
                                    ?>
                                    <option value="<?php echo $Provincia['ID']; ?>"><?php echo $Provincia['PROVINCIA'] ;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if ($resultado['PREDETERMINADA'] == 0) { ?>
                            <div class="mb-3">
                                <input type="checkbox" class="mt-3" name="pretederminadoMod">
                                <label class="form-label">Establecer cómo predeterminada (para futuras compras)</label>
                            </div>
                        <?php } ?>
                    </div>

                    <input type="submit" class="btn btn-danger mx-3" style="width:48%;" name="btn_cerrar" value="Cancelar">
                    <input type="submit" class="btn btn-primary" style="width:48%;" name="btn_ModificarDireccion" value="Modificar">
                </div>
            </form>
        </div>

    <?php } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">No tienes permiso, iniciar sesion para modificar direcciones</h4>
    <?php } ?>

    <script src="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>