<?php
$protocol = 'https://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$enlacePrincipal = $protocol . $host . "/";
?>


<script src="<?php echo $enlacePrincipal; ?>js/SweetAlert.js"></script>

<?php 

if (isset($_SESSION['status'])){

	?>

	<script>

		Swal.fire(
			'<?php echo $_SESSION['titulo']; ?>',
			'<?php echo $_SESSION['status']; ?>',
			'<?php echo $_SESSION['status_code']; ?>'
			)

		</script>

		<?php

		unset($_SESSION['titulo']);
		unset($_SESSION['status']);
		unset($_SESSION['status_code']);
	}

?>