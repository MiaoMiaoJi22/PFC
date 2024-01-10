<?php 

session_start();

include_once('../ConexionPHP.php');

if (isset($_POST["btn_cerrar"])){
	header('location: ../Producto.php');
}

if (isset($_POST["btn_AgregarProducto"])){

	if (!empty($_POST["nombre"]) && !empty(trim($_POST["precio"])) && !empty(trim($_POST["selec"]))) {

		$nom = $_POST['nombre'];
		$descrip = $_POST['descripcion'];
		$precio = $_POST['precio'];
		$descuento = $_POST['descuento'];
		$tipo = $_POST['selec'];
		$cantidad = $_POST['cantidad'];
		$fechaActual = date('Y-m-d');

		//Nombre imagen
		$Nombreimage = $_FILES['image']['name'];

		$rutaAb = $_SERVER["DOCUMENT_ROOT"] . "/Fotos/" . $tipo . "/" . $Nombreimage;

		move_uploaded_file($_FILES['image']['tmp_name'], $rutaAb);
		$ruta = "Fotos/" . $tipo . "/" . $Nombreimage;

		$AgregarProducto = "INSERT INTO productos (NOMBRE, DESCRIPCION, PRECIO, DESCUENTO, TIPO, CANTIDAD, FOTO, FECHA_MODIFICACION, CANTIDAD_VENDIDO) VALUES (:nombre, :descrip, :precio, :descuento, :tipo, :cantidad, :imagen, :fecha, 0)";

		$resultadoAgregar = $base->prepare($AgregarProducto);

		$resultadoAgregar->execute(array(
			":nombre" => $nom,
			":descrip" => $descrip, 
			":precio" => $precio,
			":descuento" => $descuento,
			":tipo" => $tipo,
			":cantidad" => $cantidad,
			":imagen" => $ruta,
			":fecha" => $fechaActual
		));

		if ($resultadoAgregar){

			$_SESSION['titulo']="Hecho!";
			$_SESSION['status']="Producto insertado correctamente";
			$_SESSION['status_code']="success";

			header('location: ../Producto.php');

		}else{

			$_SESSION['titulo']="Error";
			$_SESSION['status']="Los productos no insertaron";
			$_SESSION['status_code']="error";

			header('location: CrearProducto.php');
		}

	}else{

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos no pueden estar vacios";
		$_SESSION['status_code']="error";

		header('location: CrearProducto.php');

	}

}

if (isset($_POST["btn_ModificarProducto"])){

	$id_producto = $_POST['id_producto'];

	if (!empty($_POST["nombreMod"]) && !empty(trim($_POST["precioMod"])) && !empty(trim($_POST["selecMod"]))) {

		$nomMod = $_POST['nombreMod'];
		$descripMod = $_POST['descripcionMod'];
		$precioMod = $_POST['precioMod'];
		$descuentoMod = $_POST['descMod'];
		$tipoMod = $_POST['selecMod'];
		$cantidadMod = $_POST['cantidadMod'];
		$fechaActualMod = date('Y-m-d');

		//Nombre imagen
		$Nombreimage = $_FILES['imageMod']['name'];
		$rutaAb = $_SERVER["DOCUMENT_ROOT"] . "/Fotos/" . $tipoMod . "/" . $Nombreimage;

		move_uploaded_file($_FILES['imageMod']['tmp_name'], $rutaAb);

		$ruta = "Fotos/" . $tipoMod . "/" . $Nombreimage;

		if (empty($Nombreimage)) {
			$ModificarProducto = "UPDATE productos SET NOMBRE = :nombreMod, DESCRIPCION = :descripMod, PRECIO = :precioMod, DESCUENTO = :descMod, TIPO = :tipoMod, CANTIDAD = :cantidadMod, FECHA_MODIFICACION = :fechaMod WHERE ID = :id_pro";

			$resultadoModificar = $base->prepare($ModificarProducto);

			$resultadoModificar->execute(array(
				":nombreMod" => $nomMod,
				":descripMod" => $descripMod, 
				":precioMod" => $precioMod,
				":descMod" => $descuentoMod,
				":tipoMod" => $tipoMod,
				":cantidadMod" => $cantidadMod,
				":fechaMod" => $fechaActualMod,
				":id_pro" => $id_producto
			));

		} else {
			$ModificarProducto = "UPDATE productos SET NOMBRE = :nombreMod, DESCRIPCION = :descripMod, PRECIO = :precioMod, DESCUENTO = :descMod, TIPO = :tipoMod, CANTIDAD = :cantidadMod, FOTO = :imagenMod, FECHA_MODIFICACION = :fechaMod WHERE ID = :id_pro";

			$resultadoModificar = $base->prepare($ModificarProducto);

			$resultadoModificar->execute(array(
				":nombreMod" => $nomMod,
				":descripMod" => $descripMod, 
				":precioMod" => $precioMod,
				":descMod" => $descuentoMod,
				":tipoMod" => $tipoMod,
				":cantidadMod" => $cantidadMod,
				":imagenMod" => $ruta,
				":fechaMod" => $fechaActualMod,
				":id_pro" => $id_producto
			));
		}

		if ($resultadoModificar){

			$_SESSION['titulo']="Hecho!";
			$_SESSION['status']="Producto modificado correctamente";
			$_SESSION['status_code']="success";

			header('location: ../Producto.php');

		}else{

			$_SESSION['titulo']="Error";
			$_SESSION['status']="Los productos no moficado";
			$_SESSION['status_code']="error";

			header('location: ModificarProducto.php?ID=' . $id_producto);
		}

	}else if ($_FILES['imageMod']['type'] != "image/png"){

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Tipos de imagen no validos";
		$_SESSION['status_code']="error";

		header('location: ModificarProducto.php?ID=' . $id_producto);

	}else{

		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos no pueden estar vacios";
		$_SESSION['status_code']="error";

		header('location: ModificarProducto.php?ID=' . $id_producto);

	}

}


?>