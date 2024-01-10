<?php session_start(); 
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Agregar productos</title>
	<link rel="icon" type="image/png" href="<?php echo $enlacePrincipal; ?>Fotos/IconoWeb.png">
	<link rel="stylesheet" type="text/css" href="css/crudStyle.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $enlacePrincipal; ?>css/menustyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<script src="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="<?php echo $enlacePrincipal; ?>bootstrap-5.1.3-dist/css/bootstrap.min.css" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" /></script>
</head>

<body>

	<?php
	include_once("../footer.php");

	if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0)) {
		?>

		<div class="Caja">

			<h1>Agregar producto</h1>

			<h4 style="color: red;">Campo obligatorio (*)</h4>

			<form action="code.php" method="POST" enctype="multipart/form-data">

				<div class="mb-3">
					<label for="nombre" class="form-label">(*) Nombre:</label>
					<input type="text" name="nombre" id="nombre" class="form-control" >
				</div>

				<div class="mb-3">
					<label for="descrip" class="form-label">Descripción:</label>

					<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalLong" class="btn btn-outline-primary" id="der"><i class="fa-solid fa-info"></i></button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Informaciones de etiquetas</h5>
									<button type="button" class="btn btn-close" data-bs-dismiss="modal">
									</button>
								</div>
								<div class="modal-body" style="overflow-y: scroll; max-height: 300px; margin: 20px;">
									<ol>
										<li><h6>Para hacer un salto de linea, creamos con etiqueta < br ></h6></li>
										<li><h6>Para hacer una lista, creamos con etiqueta < ol > si quieres con lista númerico o < ul > si quieres los listas con puntos, dentro de estos etiqueta ponemos un etiqueta < li >, los textos siguiente son ejemplos: </h6></li>
										<ul>
											<li>Hola</li>
											<li>Buenos</li>
											<li>Dias</li>
										</ul>
										<li><h6>Para hacer palabras en negrita, creamos con etiqueta < b ></h6></li>
										<li><h6>Para hacer una tablas en forma de boostrap, debe tener siguientes caracteristicas: </h6></li>
										<ol type="i">
											<li>En primera paso hay que poner un etiqueta < table ></li>
											<li>En segunda paso hay que poner un etiqueta < thead > en caso si quieres poner un titulo para cada campos.</li>
											<li>En tercera paso hay que poner un etiqueta < tbody > para crear contenido de las filas y columnas.</li>
											<li>Dentro de etiqueta < thead > o < tbody > puede tener los siguientes etiquetas: </li>
											<ol type="a">
												<li>< tr > : son etiquetas para crear filas.</li>
												<li>< th > : son etiquetas mayoria para etiqueta < thead >, para crear columnas, y cuando muestra, se sale negrita.</li>
												<li>< td > : por ultimo, esta etiqueta es parecido que etiqueta < th >, pero sin negritas con las letras.</li>
											</ol>
										</ol>
									</ol>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>

					<textarea name="descripcion" id="descrip" class="form-control" rows="3" ></textarea>
				</div>

				<div class="mb-3">
					<label for="precio" class="form-label">(*) Precio:</label>
					<input type="text" step="any" name="precio" id="precio" class="form-control" >
				</div>

				<div class="mb-3">
					<label for="descuento" class="form-label">Descuento:</label>
					<input type="text" step="any" name="descuento" id="descuento" class="form-control" value="0">
				</div>

				<div class="mb-3">
					<label for="tipo" class="form-label">(*) Categorias:</label>
					<select name="selec" id="tipo" class="form-select" >

						<option value="">SELECCIONAR...</option>
						<option value="Alimentacion">ALIMENTACION</option>
						<option value="Bebida">BEBIDA</option>
						<option value="Papeleria">PAPELERIA</option>
						<option value="Limpieza">LIMPIEZA</option>
						<option value="Herramientas">HERRAMIENTAS</option>
						<option value="Cosmetico">COSMÉTICO</option>
						<option value="Juego">JUEGO</option>

					</select>
				</div>

				<div class="mb-3">
					<label for="cant" class="form-label">(*) Cantidad de producto:</label>
					<input type="number" name="cantidad" id="cant" class="form-control" >
				</div>

				<div class="mb-3">
					<label for="image" class="form-label">Imagen:</label>
					<input type="file" name="image" id="image" class="form-control" accept="image/png">
				</div>

				<div class="centr">
					<input type="submit" class="btn btn-danger" name="btn_cerrar" value="Cerrar">
					<input type="submit" class="btn btn-primary" name="btn_AgregarProducto" value="Guardar">
				</div>

			</form>

		</div>
	<?php } else { ?>
		<h4 class="text-center p-3 m-5 bg-danger bg-gradient">Acceso denegado</h4>
	<?php } ?>
</body>
</html>