<?php 

include_once('ConexionPHP.php');
require 'token.php';

session_start();

//CarroCompra.php
if (isset($_POST['btn_carrito'])){

	$idp = $_POST['idp'];
	$tokenp = $_POST['tokenp'];

	if ($_POST['cantidadproduc'] > 0 || !empty($_POST['cantidadproduc'])){

		/*Id_producto para guardar en carrito*/
		$id_producto = $_POST['id_producto'];
		$id_producto = filter_var($id_producto, FILTER_SANITIZE_STRING);

		$id_usuario = $_SESSION['id_usuario'];//$_POST['usuario'];
		$precioUnidad = $_POST['precio']; //Precio descuento ya echo

		/*Cantidad de producto*/
		$cant = $_POST['cantidadproduc'];
		$cant = filter_var($cant, FILTER_SANITIZE_STRING);

		$fecha = date('Y-m-d H:i:s');

		$Existe = "SELECT * FROM carro_compra WHERE ID_PRODUCTO = :id_product AND ID_USUARIO = :usua LIMIT 1";
		$Existeno = $base->prepare($Existe);
		$Existeno->execute(array(":id_product" => $id_producto,
			":usua" => $id_usuario));

		if ($Existeno->rowCount() == 1){

			$registro = $Existeno->fetch();
			$CantAntiguo = $registro['CANTIDAD'];
			$NuevoCantidad = $CantAntiguo + $cant;

			$CambiarCantidad = $base->prepare("UPDATE carro_compra SET CANTIDAD = :canti, FECHA_SUBIDO = :fecha WHERE ID_PRODUCTO = :id_product AND ID_USUARIO = :usua");
			$CambiarCantidad->execute(array(
				":canti" => $NuevoCantidad,
				":fecha" => $fecha,
				":id_product" => $id_producto,
				":usua" => $id_usuario, 
			));

		}else{

			$cadena = "INSERT INTO carro_compra (ID_PRODUCTO, PRECIO, CANTIDAD, ID_USUARIO, FECHA_SUBIDO) VALUES (:id_product, :prec, :cant, :nomusua, :fecha)";

			$AgregarCarro = $base->prepare($cadena);

			$AgregarCarro->execute(array(
				":id_product" => $id_producto,
				":prec" => $precioUnidad, 
				":cant" => $cant,
				":nomusua" => $id_usuario,
				":fecha" => $fecha,
			));
		}

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="Producto añadido en el carro";
		$_SESSION['status_code']="success";

		header('location: Producto.php');
	}else{
		$_SESSION['titulo']="Error";
		$_SESSION['status']="Debes poner cantidad de producto";
		$_SESSION['status_code']="error";

		header('location: detalles.php?ID=' . $idp . '&token=' . $tokenp);
	}

}

if (isset($_POST['btn_editarCarro'])){
	$id = $_POST['idCarro'];
	$id = filter_var($id, FILTER_SANITIZE_STRING);
	$cantidades = $_POST['cantidadproduc'];
	$cantidades = filter_var($cantidades, FILTER_SANITIZE_STRING);

	$incre = "UPDATE carro_compra SET CANTIDAD = :cant WHERE ID = :idCarro";
	$incrementarCant = $base->prepare($incre);
	$incrementarCant->execute(array(
		":cant" => $cantidades,
		":idCarro" => $id
	));

	header('location:CarroCompra.php');
}

if (isset($_POST['btn_eliminarCarro'])){
	$id = $_POST['idCarro'];
	$id = filter_var($id, FILTER_SANITIZE_STRING);
	
	$Verificar_delete_item = $base->prepare("SELECT * FROM carro_compra WHERE ID = :idCarro");
	$Verificar_delete_item->execute(array(":idCarro" => $id));

	if ($Verificar_delete_item->rowCount() > 0){
		$delete_item = $base->prepare("DELETE FROM carro_compra WHERE ID = :idC");
		$delete_item->execute(array(":idC" => $id));

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="El producto eliminado correctamente en el carro";
		$_SESSION['status_code']="success";
	}else{
		$_SESSION['titulo']="Error";
		$_SESSION['status']="El producto ya se ha eliminado en el carro";
		$_SESSION['status_code']="error";
	}

	header('location:CarroCompra.php');
}

//Contacto.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; 

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['btn_enviarcontacto'])){
	if (!empty($_POST['nombre']) && !empty($_POST['correos']) && !empty($_POST['mensaje'])){

		//session_unset($_SESSION['email']);

		$sends = $_POST['correos'];
		$nombre = $_POST['nombre'];
		$mensajes = $_POST['mensaje'];

		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'vicentealimentacion1969@gmail.com';
		$mail->Password = 'ccvvcjddchlrrgqq';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom($sends, $nombre);
		$mail->addAddress('vicentealimentacion1969@gmail.com');
		$mail->addReplyTo($sends, $nombre);
		$mail->isHTML(true);
		$mail->Subject = "Enviado por correo " . $sends;
		$mail->Body = "<p>Nombre y apellido: <b>" . $nombre . "</b></p>
		<p>Email: <b>" . $sends . "</b></p>
		<p>Asunto: <b>" . $_POST['asunto'] . "</b></p>
		<p>Mensaje: " . $mensajes . "</p>";

		if ($mail->send()){

			$_SESSION['titulo']="Hecho!";
			$_SESSION['status']="Correo enviado correctamente";
			$_SESSION['status_code']="success";

			header('location: Contacto.php');
		}else{

			$_SESSION['titulo']="Error";
			$_SESSION['status']="Fallo de enviar correo";
			$_SESSION['status_code']="error";

			header('location: Contacto.php');
		}
		
	}else{

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos obligatorios(*) no puede estar vacios";
		$_SESSION['status_code']="error";

		header('location: Contacto.php');
	}
}

//Perfil de usuarios
if (isset($_POST['btn_GuardarPerfil'])) {
	if (!empty($_POST['nombre_usuario']) && !empty($_POST['telefono_usuario']) && !empty($_POST['correo_usuario'])) {

		$id_cliente = $_SESSION['id_usuario'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$telefono_usuario = $_POST['telefono_usuario'];
		$correo_usuario = $_POST['correo_usuario'];

		$nombre_imagen = $_FILES['image_usuario']['name'];

		if (empty($nombre_imagen)) {

			$ModificarPerfil = "UPDATE usuario_pass SET NOMBRECOMPLETO = :nombre_completo, TELEFONO = :telefono, E_MAIL = :correo WHERE ID = :id_usuario";

			$resultadoModificar = $base->prepare($ModificarPerfil);

			$resultadoModificar->execute(array(
				":nombre_completo" => $nombre_usuario,
				":telefono" => $telefono_usuario, 
				":correo" => $correo_usuario,
				":id_usuario" => $id_cliente
			));

		} else {

			$extension_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			//$extension_imagen = $_FILES['image_usuario']['type'];
			$rutaAb = $_SERVER["DOCUMENT_ROOT"] . "/Fotos/Usuarios/Usuario" . $id_cliente . "." . $extension_imagen;
			move_uploaded_file($_FILES['image_usuario']['tmp_name'], $rutaAb);
			$ruta = "Fotos/Usuarios/Usuario" . $id_cliente . "." . $extension_imagen;

			$ModificarPerfil = "UPDATE usuario_pass SET NOMBRECOMPLETO = :nombre_completo, TELEFONO = :telefono, E_MAIL = :correo, FOTO = :foto WHERE ID = :id_usuario";

			$resultadoModificar = $base->prepare($ModificarPerfil);

			$resultadoModificar->execute(array(
				":nombre_completo" => $nombre_usuario,
				":telefono" => $telefono_usuario, 
				":correo" => $correo_usuario,
				":foto" => $ruta,
				":id_usuario" => $id_cliente
			));
		}

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="Perfil modificado correctamente";
		$_SESSION['status_code']="success";

		header('location: Usuarios.php');

	} else {

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos obligatorios(*) no puede estar vacios";
		$_SESSION['status_code']="error";

		header('location: Usuarios.php');
	} 
}

// CRUD Usaurios en modo administrador----------------------------------------------------------------------------------------------
if (isset($_POST["btn_GuardarUsuario"])){

	if (!empty($_POST["NombreCompleto"]) && !empty(trim($_POST["Usuario"])) && !empty(trim($_POST["confirmpassword"])) && !empty(trim($_POST["Correo"])) && !empty(trim($_POST["Telefono"])) && !empty($_POST["rol"])) {

		$usuario = ucfirst(addslashes(trim($_POST["Usuario"])));
		$contra = $_POST["confirmpassword"];
		$email = strtolower($_POST["Correo"]);
		$Tele = $_POST["Telefono"];
		$Nombre = $_POST["NombreCompleto"];
		$Rol = $_POST["rol"];
		$cifrarContra = password_hash($contra, PASSWORD_DEFAULT);

		$Activo = isset($_POST["Activo"]) ? true : false;

        //Confirmar correo
		$ConfirmarCorreo = "SELECT * FROM usuario_pass WHERE E_MAIL = :correo";
		$ResConfirmarCorreo = $base->prepare($ConfirmarCorreo);
		$ResConfirmarCorreo->execute(array(":correo" => $email));

		if ($ResConfirmarCorreo->rowCount() == 0) {

            //Confirmar nombre de usuario
			$ConfirmarUsuario = "SELECT * FROM usuario_pass WHERE USUARIOS = :usuario";
			$ResConfirmarUsuario = $base->prepare($ConfirmarUsuario);
			$ResConfirmarUsuario->execute(array(":usuario" => $usuario));

			if ($ResConfirmarUsuario->rowCount() == 0) {

				$cadena = "INSERT INTO usuario_pass (NOMBRECOMPLETO, USUARIOS, CONTRASENA, TELEFONO, E_MAIL, ROL, FOTO, ACTIVO) VALUES (:nombrecompleto, :usua, :contra, :tele, :email, :cliente, :foto, :activo)";
				$resultado = $base->prepare($cadena);

				$resultado->execute(array(
					":nombrecompleto" => $Nombre,
					":usua" => $usuario, 
					":contra" => $cifrarContra,
					":tele" => $Tele,
					":email" => $email,
					":cliente" => $Rol,
					":foto" => "Fotos/Usuarios/UsuarioNoFotos.png",
					":activo" => $Activo
				));

				$_SESSION['titulo']="Hecho!";
				$_SESSION['status']="Usuario creado correctamente";
				$_SESSION['status_code']="success";

				header('location: Cliente.php');
			}else{

				$_SESSION['titulo']="Error";
				$_SESSION['status']="Nombre de usuario ya existe";
				$_SESSION['status_code']="error";

				header('location: Cliente.php');
			}

		}else{

			$_SESSION['titulo']="Error";
			$_SESSION['status']="Con este correo ya existe un usuario";
			$_SESSION['status_code']="error";

			header('location: Cliente.php');
		}

	} else {

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos no pueden estar vacios";
		$_SESSION['status_code']="error";

		header('location: Cliente.php');
	}

}

// if (isset($_POST["btn_ModificarUsuario"])){
// 	$id_modificar = $_POST['idModificar'];

// 	$contra = $_POST["passwordMod"];
// 	$email = strtolower($_POST["CorreoMod"]);
// 	$Tele = $_POST["TelefonoMod"];
// 	$Nombre = $_POST["NombreCompletoMod"];
// 	$Rol = $_POST["rolMod"];
// 	$cifrarContra = password_hash($contra, PASSWORD_DEFAULT);

// 	$Activos = isset($_POST["ActivoMod"]) ? "1" : "0";

// 	//Confirmar correo
// 	$ConfirmarCorreo = "SELECT * FROM usuario_pass WHERE E_MAIL = :correos";
// 	$ResConfirmarCorreo = $base->prepare($ConfirmarCorreo);
// 	$ResConfirmarCorreo->execute(array(":correos" => $email));

// 	if ($ResConfirmarCorreo->rowCount() == 0) {

// 		if (!empty(trim($_POST["passwordMod"]))) {
// 			$cadena = $base->prepare("UPDATE usuario_pass SET NOMBRECOMPLETO = :nombrecompleto, CONTRASENA = :pass, TELEFONO = :tele, E_MAIL = :correo, ROL = :rol, ACTIVO = :activo WHERE ID = :id_mod");

// 			$cadena->execute(array(
// 				":nombrecompleto" => $Nombre,
// 				":pass" => $cifrarContra,
// 				":tele" => $Tele,
// 				":correo" => $email,
// 				":rol" => $Rol,
// 				":activo" => $Activos,
// 				":id_mod" => $id_modificar
// 			));

// 		} else {
// 			$cadena =  $base->prepare("UPDATE usuario_pass SET NOMBRECOMPLETO = :nombrecompleto2, TELEFONO = :tele2, E_MAIL = :correo2, ROL = :rol2, ACTIVO = :activo2 WHERE ID = :id_mod2");

// 			$cadena->execute(array(
// 				":nombrecompleto2" => $Nombre,
// 				":tele2" => $Tele,
// 				":correo2" => $email,
// 				":rol2" => $Rol,
// 				":activo2" => $Activos,
// 				":id_mod2" => $id_modificar
// 			));

// 		}
// 	}else{

// 		$_SESSION['titulo']="Error";
// 		$_SESSION['status']="Con este correo ya existe un usuario";
// 		$_SESSION['status_code']="error";

// 		header('location: Cliente.php');
// 	}

// 	$_SESSION['titulo']="Hecho!";
// 	$_SESSION['status']="Usuario modificado correctamente";
// 	$_SESSION['status_code']="success";

// 	header('location: Cliente.php');
// }

if (isset($_POST["btn_EliminarUsuario"])){
	$id_eliminars = $_POST['idEliminar'];

	$cadena =  $base->prepare("DELETE FROM usuario_pass WHERE ID = :id_eli");

	$cadena->execute(array(
		":id_eli" => $id_eliminars
	));

	$_SESSION['titulo']="Hecho!";
	$_SESSION['status']="Usuario eliminado correctamente";
	$_SESSION['status_code']="success";

	header('location: Cliente.php');
}

// CRUD Carrusel -------------------------------------------------------------------------------------------------------------------
if (isset($_POST['btn_AgregarCarrusel'])) {

	if ((isset($_POST['Productos']) != 0 && !empty($_POST['descripcion']))) {

		$id_producto = $_POST['Productos'];
		$descripcion = $_POST['descripcion'];

		$InsertarCarrusel = $base->prepare("INSERT INTO tbl_carrusel (ID_PRODUCTO, DESCRIPCION) VALUES (:id_pro, :descrip)");

		$InsertarCarrusel->execute(array(
			":id_pro" => $id_producto,
			":descrip" => $descripcion
		));

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="Carrusel añadido correctamente";
		$_SESSION['status_code']="success";

		header('location: Carrusel.php');

	} else {
		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos obligatorios(*) no puede estar vacios";
		$_SESSION['status_code']="error";

		header('location: Carrusel.php');
	}
}

if (isset($_POST["btn_EliminarCarrusel"])){
	$id_eliminarCarrusel = $_POST['idEliminarCarrusel'];

	$cadena =  $base->prepare("DELETE FROM tbl_carrusel WHERE ID = :id_eli");

	$cadena->execute(array(
		":id_eli" => $id_eliminarCarrusel
	));

	$_SESSION['titulo']="Hecho!";
	$_SESSION['status']="Carrusel eliminado correctamente";
	$_SESSION['status_code']="success";

	header('location: Carrusel.php');
}


//Comprar 
if (isset($_POST['btn_RealizarPago'])){
	
	$total = $_POST['TotalCompra'];
	$status = 'COMPLETED';
	$fecha_nueva = date("Y-m-d H:i:s");
	$email = $_SESSION['Correos'];
	$id_transaccion = uniqid();

	$SelectDireccionesEnvio = $base->prepare("SELECT ID FROM direccion_cliente WHERE ID_USUARIO = :id_usuario AND PREDETERMINADA = 1 AND TIPO_DIRECCION = 'envio'");
	$SelectDireccionesEnvio->execute(array(":id_usuario" => $_SESSION['id_usuario']));
	$IdDireccionEnvio = $SelectDireccionesEnvio->fetch();
	$IdEnvio = $IdDireccionEnvio['ID'];

	$SelectDireccionesFactura = $base->prepare("SELECT ID FROM direccion_cliente WHERE ID_USUARIO = :id_usuarios AND PREDETERMINADA = 1 AND TIPO_DIRECCION = 'factura'");
	$SelectDireccionesFactura->execute(array(":id_usuarios" => $_SESSION['id_usuario']));
	$IdDireccionFactura = $SelectDireccionesFactura->fetch();
	$IdFactura = $IdDireccionFactura['ID'];

	$sql = $base->prepare("INSERT INTO factura (ID_TRANSACCION, FECHA, STATUSES, CORREO, ID_DIRECCION_ENVIO, ID_DIRECCION_FACTURA, TOTAL_COMPRA, ID_USUARIO) VALUES (:id_transaccion, :fecha, :status, :correo, :id_direccion_envio, :id_direccion_factura, :total_compra, :id_usuariosFac)");

	$sql->execute(array(
		":id_transaccion" => $id_transaccion,
		":fecha" => $fecha_nueva,
		":status" => $status,
		":correo" => $email,
		":id_direccion_envio" => $IdEnvio,
		":id_direccion_factura" => $IdFactura,
		":total_compra" => $total,
		":id_usuariosFac" => $_SESSION['id_usuario']
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

	header("location: Pago.php");
}

?>