<?php
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>

<div class="footer">
	<a href="<?php echo $enlacePrincipal; ?>Politicas/Politica.php">Política de privacidad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $enlacePrincipal; ?>Politicas/Cookie.php">Cookie</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $enlacePrincipal; ?>Politicas/AvisoLegal.php">Aviso legal</a><br>
	@2023 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alimentación y Bazar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calle piedrahita 27
</div>

<div class="fixed-bottom rgpdbh align-middle p-2" align="center" style="background: tomato;">
	<table class="w-100">
		<tbody>
			<tr>
				<td class="align-middle text-center">
					Utilizamos cookies para proporcionar y mejorar nuestro servicios. Al navegar por nuestro sitio, usted acepta las cookies.
					<a href="Cookies.php">Politica de Cookies</a>
				</td>
				<td class="align-middle">
					<button type="button" class="close btn btn-danger float-end" style="font-size: 30;" aria-bs-label="Close" onclick="hbRgpd()">
						<span aria-bs-hidden="true" class="align-middle">X</span>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<script src="<?php echo $enlacePrincipal; ?>js/Cookie.js"></script>