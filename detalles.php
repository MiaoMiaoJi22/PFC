<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/menustyle.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
	<link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
</head>

<body>

	<?php include_once("menu.php");
	include_once('footer.php');

	$id = isset($_GET['ID']) ? $_GET['ID'] : '';
	$token = isset($_GET['token']) ? $_GET['token'] : '';

	if ($id == '' || $token == ''){
		$_SESSION['titulo']="Error";
		$_SESSION['status']="Error al procesar la petición";
		$_SESSION['status_code']="error";

		exit;
	}else{

		$token_tmp = hash_hmac('sha256', $id, KEY_TOKEN);

		if ($token == $token_tmp){

			$MostrarDetalleID = "SELECT count(ID) FROM productos WHERE ID = :id";
			$MostrarDetalleResulID = $base->prepare($MostrarDetalleID);
			$MostrarDetalleResulID->execute(array(':id' => $id));

			if ($MostrarDetalleResulID->rowCount() > 0){

				$MostrarDetalle = "SELECT * FROM productos WHERE ID = :id";

				$MostrarDetalleResul = $base->prepare($MostrarDetalle);
				$MostrarDetalleResul->bindParam(":id", $id);
				$MostrarDetalleResul->execute();

				$filasP = $MostrarDetalleResul->fetch();

				$id_producto = $filasP['ID'];
				$nombre = $filasP['NOMBRE'];
				$descripcion = $filasP['DESCRIPCION'];
				$precio = $filasP['PRECIO'];
				$descuento = $filasP['DESCUENTO'];
				$tipos = $filasP['TIPO'];
				$foto = $filasP['FOTO'];
				$cantidad = $filasP['CANTIDAD'];
				$cantidadP = ($cantidad == 0) ? 'disabled' : '';

				$precio_desc = $precio - (($precio * $descuento) / 100);

				if (!file_exists($foto)){
					$foto = 'Fotos/NoFoto.png';
				}

			}

		}else{
			$_SESSION['titulo']="Error";
			$_SESSION['status']="Error al procesar la petición";
			$_SESSION['status_code']="error";

			exit;
		}
	}

	if (isset($_SESSION['id_usuario'])) {
		?>

		<main>
			<form action="code.php" method="POST">
				<div class="container">
					<div class="row my-5">
						<div class="col-md-6 order-md-1">
							<img width="350px" height="330px" src="<?php echo $foto; ?>">
						</div>

						<div class="col-md-6 order-md-2">

							<h1><?php echo $nombre ?></h1>

							<?php if ($descuento > 0) { ?>

								<p><del><?php echo number_format($precio, 2, '.', ',') . MONEDA; ?></del></p>

								<h3>
									<?php echo number_format($precio_desc, 2, '.', ',') . MONEDA; ?>
									<small class="text-success"><?php echo $descuento ?>% descuento</small>
								</h3>

							<?php } else{ ?>

								<h3><?php echo number_format($precio, 2, '.', ',') . MONEDA; ?></h3>

							<?php } ?>

							<?php if ($cantidad == 0) { ?>
								<h3 class="text-danger">Producto agotado</h3>
							<?php }?>

							<p class="lead">
								<h6><?php echo $descripcion; ?></h6>
							</p>

							<input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
							<input type="hidden" name="precio" value="<?php echo $precio_desc; ?>">
							<input type="hidden" name="idp" value="<?php echo $id; ?>">
							<input type="hidden" name="tokenp" value="<?php echo $token; ?>">

							Cantidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="fa-solid fa-minus decrementar"></i>
							<input type="number" name="cantidadproduc" value="1" step="1" class="cantidad mt-3 mb-1">
							<i class="fa-solid fa-plus incrementar"></i>

							<div class="d-grid gap-3 col-10 my-5">
								<input class="btn btn-outline-primary" type="submit" name="btn_carrito" <?php echo $cantidadP;?> value="Añadir carrito">
							</div>
						</div>
					</div>
				</div>
			</form>
		</main>

	<?php } else { ?>

		<main>

			<div class="container">

				<div class="row my-5">

					<div class="col-md-6 order-md-1">
						<img width="350px" height="330px" src="<?php echo $foto; ?>">
					</div>

					<div class="col-md-6 order-md-2">

						<h1><?php echo $nombre ?></h1>

						<?php if ($descuento > 0) { ?>

							<p><del><?php echo number_format($precio, 2, '.', ',') . MONEDA; ?></del></p>

							<h3>
								<?php echo number_format($precio_desc, 2, '.', ',') . MONEDA; ?>
								<small class="text-success"><?php echo $descuento ?>% descuento</small>
							</h3>

						<?php } else{ ?>

							<h3><?php echo number_format($precio, 2, '.', ',') . MONEDA; ?></h3>

						<?php } ?>

						<p class="lead">
							<h6><?php echo $descripcion; ?></h6>
						</p>

					</div>
				</div>
			</div>
		</main>

	<?php } ?>

	<?php require("Abajo.php"); ?>

	<script src="js/Inputs.js"></script>
	
</body>
</html>