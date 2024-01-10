<?php 

session_start();

include_once('../ConexionPHP.php');

if (isset($_POST['tipoproducto'])) {
	$tipo_producto = $_POST['tipoproducto'];
} else {
	$tipo_producto = "";
}

$Sql = $base->prepare("SELECT * FROM productos WHERE TIPO = :tipo");

$Sql->execute(array(":tipo" => $tipo_producto));

$row = $Sql->fetchAll();

$cadena = "<select name='Productos' id='Productos' class='form-select'>";

foreach ($row as $rows) {
	$cadena = $cadena . "<option value=" . $rows['ID'] . ">" . utf8_encode($rows['NOMBRE']) . "</option>";
}

echo $cadena . "</select>";

?>