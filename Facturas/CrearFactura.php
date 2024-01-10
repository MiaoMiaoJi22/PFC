<?php 

include_once('../ConexionPHP.php');
session_start();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

echo "<pre>";
print_r($datos);
echo "</pre>";

if (is_array($datos)){

	$id_transaccion = $datos['detalles']['id'];
	$total = $datos['detalles']['purchase_units'][0]['amount']['value'];
	$status = $datos['detalles']['status'];
	$fecha_nueva = date("Y-m-d H:i:s");
	$email = $datos['detalles']['payer']['email_address'];

	$id_cliente = $datos['detalles']['payer']['payer_id'];

	$SelectDireccionesEnvio = $base->prepare("SELECT * FROM direccion_cliente WHERE ID_USUARIO = :id_usuario AND PREDETERMINADA = 1 AND TIPO_DIRECCION = 'envio'");
	$SelectDireccionesEnvio->execute(array(":id_usuario" => $_SESSION['id_usuario']));
	$IdDireccionEnvio = $SelectDireccionesEnvio->fetch();

	$SelectDireccionesFactura = $base->prepare("SELECT * FROM direccion_cliente WHERE ID_USUARIO = :id_usuarios AND PREDETERMINADA = 1 AND TIPO_DIRECCION = 'factura'");
	$SelectDireccionesFactura->execute(array(":id_usuarios" => $_SESSION['id_usuario']));
	$IdDireccionFactura = $SelectDireccionesFactura->fetch();

	$sql = $base->prepare("INSERT INTO factura (ID_TRANSACCION, FECHA, STATUSES, CORREO, ID_CLIENTE, ID_DIRECCION_ENVIO, ID_DIRECCION_FACTURA, TOTAL_COMPRA) VALUES (:id_transaccion, :fecha, :status, :correo, :id_cliente, :id_direccion_envio, :id_direccion_factura, :total_compra)");

	$sql->execute(array(
		":id_transaccion" => $id_transaccion,
		":fecha" => $fecha_nueva,
		":status" => $status,
		":correo" => $email,
		":id_cliente" => $id_cliente,
		":id_direccion_envio" => $IdDireccionEnvio,
		":id_direccion_factura" => $IdDireccionFactura,
		":total_compra" => $total
	));

	$id = $base->lastInsertId();

	if ($id > 0){

		$user = $_SESSION['id_usuario'];
		$total = 0;

		$MostrarCarro = $base->prepare("SELECT * FROM carro_compra WHERE ID_USUARIO = :usua ORDER BY FECHA_SUBIDO");
		$MostrarCarro->execute(array(":usua" => $user));

		while($filasCarro = $MostrarCarro->fetch()) {
			$MostrarProductos = $base->prepare("SELECT * FROM productos WHERE ID = :id");
			$MostrarProductos->execute(array(":id" => $filasCarro['ID_PRODUCTO']));

			$filasProducto = $MostrarProductos->fetch();

			$precio = $filasProducto['PRECIO'];
			$descuento = $filasProducto['DESCUENTO'];
			$precio_desc = $precio - (($precio * $descuento) / 100);

			$sql_insert = $base->prepare("INSERT INTO detalle_factura(ID_FACTURA, ID_PRODUCTO, NOMBRE, PRECIO, CANTIDAD, ID_USUARIO) VALUES (:id_factura, :id_producto, :nom, :precio, :cantidad, :id_usua)");
			$sql_insert->execute(array(
				":id_factura" => $id,
				":id_producto" => $filasProducto['ID'],
				":nom" => $filasProducto['NOMBRE'],
				":precio" => $precio_desc,
				":cantidad" => $filasCarro['CANTIDAD'],
				":id_usua" => $_SESSION["id_usuario"]
			));

			$cantidad = $filasProducto['CANTIDAD_VENDIDO'];
			$cantidadVendido = $cantidad + $filasCarro['CANTIDAD'];
			$stock = $filasProducto['CANTIDAD'] - $filasCarro['CANTIDAD'];
			$SumarCantidadVendido = $base->prepare("UPDATE productos SET CANTIDAD_VENDIDO = :cantidadV, CANTIDAD = :cantidadS WHERE ID = :id_pro");
			$SumarCantidadVendido->execute(array(
				":cantidadV" => $cantidadVendido,
				":cantidadS" => $stock,
				":id_pro" => $filasCarro['ID_PRODUCTO']
			));

		}
	}

	$sql_eliminar = $base->prepare("DELETE FROM carro_compra WHERE ID_USUARIO = :usua");
	$sql_eliminar->execute(array(":usua" => $_SESSION['id_usuario']));

}

?>