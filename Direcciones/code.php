<?php 

session_start();

include_once('../ConexionPHP.php');

//Cancelar
if (isset($_POST['btn_cerrar'])) {
	header('location: ../Usuarios.php');
}

//Direcciones de envio y facturas
if (isset($_POST['btn_GuardarDireccion'])) {

	if ((!empty($_POST['direcciones']) && !empty($_POST['codigo_postal']) && !empty($_POST['poblacion']))) {

		$id_usuario = $_SESSION['id_usuario'];

		$direccion = $_POST['direcciones'];
		$codigo_postal = $_POST['codigo_postal'];
		$poblacion_Envio = $_POST['poblacion'];
		$Provincia = $_POST['selecProvincia'];
		$tipo_direccion = $_POST['tipo_direccion'];

		$MostrarProvincia = $base->prepare("SELECT * FROM tblprovincia WHERE ID = :id_provincia");
		$MostrarProvincia->execute(array(":id_provincia" => $Provincia));
		$ResultadoProvincia = $MostrarProvincia->fetch();

		$InsertarDireccion = $base->prepare("INSERT INTO direccion_cliente (DIRECCION_NUMERO, CODIGO_POSTAL, POBLACION, PROVINCIA, PREDETERMINADA, TIPO_DIRECCION, ID_USUARIO) VALUES (:direccion_numero, :codigo_postal, :poblacion, :provincia, :predeterminada, :tipo_direccion, :id_usuario)");

		if (isset($_POST['pretederminado'])) {
			$ConsultarSiExisteDireccionPredeterminado = $base->prepare("SELECT * FROM direccion_cliente WHERE PREDETERMINADA = 1 AND TIPO_DIRECCION = :tipo_direccion AND ID_USUARIO = :id_usuario");
			$ConsultarSiExisteDireccionPredeterminado->execute(array(
				":tipo_direccion" => $tipo_direccion,
				":id_usuario" => $id_usuario
			));
			$ResultadoConsultar = $ConsultarSiExisteDireccionPredeterminado->rowCount();

			if ($ResultadoConsultar >= 1) {
				$CambiarPredeterminado = $base->prepare("UPDATE direccion_cliente SET PREDETERMINADA = 0 WHERE TIPO_DIRECCION = :tipo_direcciones AND ID_USUARIO = :id_usuarios");
				$CambiarPredeterminado->execute(array(
					":tipo_direcciones" => $tipo_direccion,
					":id_usuarios" => $id_usuario
				));				
			}

			$Predeterminado = 1;			
		}else {
			$Predeterminado = 0;
		}

		$InsertarDireccion->execute(array(
			":direccion_numero" => $direccion,
			":codigo_postal" => $codigo_postal,
			":poblacion" => $poblacion_Envio,
			":provincia" => $ResultadoProvincia['PROVINCIA'],
			":predeterminada" => $Predeterminado,
			":tipo_direccion" => $tipo_direccion,
			":id_usuario" => $id_usuario
		));

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="Direccion añadido correctamente";
		$_SESSION['status_code']="success";

		header('location: ../Usuarios.php');

	} else {
		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos obligatorios(*) no puede estar vacios";
		$_SESSION['status_code']="error";

		header('location: ../Usuarios.php');
	}
}

//Modificar Direcciones de envio y facturas
if (isset($_POST['btn_ModificarDireccion'])) {

	if ((!empty($_POST['direccionesMod']) && !empty($_POST['codigo_postalMod']) && !empty($_POST['poblacionMod']))) {

		$id_usuarios = $_SESSION['id_usuario'];

		$id = $_POST['id_direccionMod'];
		$direccion = $_POST['direccionesMod'];
		$codigo_postal = $_POST['codigo_postalMod'];
		$poblacion_Envio = $_POST['poblacionMod'];
		$Provincia = $_POST['selecProvinciaMod'];
		$tipo_direccion = $_POST['tipo_direccionMod'];
		$MostrarProvincia = $base->prepare("SELECT * FROM tblprovincia WHERE ID = :id_provincia");
		$MostrarProvincia->execute(array(":id_provincia" => $Provincia));
		$ResultadoProvincia = $MostrarProvincia->fetch();

		$ModificarDireccion = $base->prepare("UPDATE direccion_cliente SET DIRECCION_NUMERO = :direccion_numero, CODIGO_POSTAL = :codigo_postal, POBLACION = :poblacion, PROVINCIA = :provincia, PREDETERMINADA = :predeterminada WHERE ID = :id AND ID_USUARIO = :id_usuario");

		if (isset($_POST['pretederminadoMod'])) {

			$ConsultarSiExisteDireccionPredeterminado = $base->prepare("SELECT * FROM direccion_cliente WHERE PREDETERMINADA = 1 AND TIPO_DIRECCION = :tipo_direccion AND ID_USUARIO = :id_usuario");
			$ConsultarSiExisteDireccionPredeterminado->execute(array(
				":tipo_direccion" => $tipo_direccion,
				":id_usuario" => $id_usuarios
			));
			$ResultadoConsultar = $ConsultarSiExisteDireccionPredeterminado->rowCount();

			if ($ResultadoConsultar >= 1) {
				$CambiarPredeterminado = $base->prepare("UPDATE direccion_cliente SET PREDETERMINADA = 0 WHERE TIPO_DIRECCION = :tipo_direccion AND ID_USUARIO = :id_usuarios");
				$CambiarPredeterminado->execute(array(
					":tipo_direccion" => $tipo_direccion,
					":id_usuarios" => $id_usuarios
				));			
			}	

			$Predeterminado = 1;			
		}else {
			$ConsultarEnSiMismo = $base->prepare("SELECT * FROM direccion_cliente WHERE PREDETERMINADA = 1 AND TIPO_DIRECCION = :tipo_direccion AND ID_USUARIO = :id_usuario AND ID = :id");
			$ConsultarEnSiMismo->execute(array(
				":tipo_direccion" => $tipo_direccion,
				":id_usuario" => $id_usuarios,
				":id" => $id
			));
			$ResultadoConsultarEnSi = $ConsultarEnSiMismo->rowCount();
			if ($ResultadoConsultarEnSi >= 1) {
				$Predeterminado = 1;
			}else {
				$Predeterminado = 0;
			}
		}

		$ModificarDireccion->execute(array(
			":direccion_numero" => $direccion,
			":codigo_postal" => $codigo_postal,
			":poblacion" => $poblacion_Envio,
			":provincia" => $ResultadoProvincia['PROVINCIA'],
			":predeterminada" => $Predeterminado,
			":id" => $id,
			":id_usuario" => $id_usuarios
		));

		$_SESSION['titulo']="Hecho!";
		$_SESSION['status']="Direccion modificado correctamente";
		$_SESSION['status_code']="success";

		header('location: ../Usuarios.php');

	} else {
		$_SESSION['titulo']="Error";
		$_SESSION['status']="Los campos obligatorios(*) no puede estar vacios";
		$_SESSION['status_code']="error";

		header('location: ../Usuarios.php');
	}
}


?>