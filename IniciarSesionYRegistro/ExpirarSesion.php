<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>
<!DOCTYPE html>
<html>

<head>
	<title>Sesión expirado</title>
	<link rel="stylesheet" type="text/css" href="css/CerrarStyle.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
	<link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>/Fotos/IconoWeb.png">
</head>

<body style="background: #e8ffcc;">

	<div class="Cerrar">
		<div class="container">
			<main>
				<div class="row m-auto">

					<div class="col-md-2 p-5 mx-4">
						<img src="../Fotos/ExpirarSesion.png" class="derecha">
					</div>

					<div class="col-md-9 p-5">
						<h1>Su sesión ha expirado por inactividad, vuelva a iniciar sesión para continuar.</h1>
						<a href="IniciarSesion.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket" style="margin-right: 7px;"></i>Volver a iniciar sesión</a>
						</form>
					</div>
					
				</div>
			</main>
		</div>
	</div>
</body>
</html>