<html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php

include_once("../ConexionPHP.php");

if (isset($_POST['id'])) {
	$id_eliminar = $_POST['id'];
	$sentencia = "DELETE FROM PRODUCTOS WHERE ID = :id";

	$delete_sentencia = $base->prepare($sentencia);
	$delete_sentencia->execute(array(":id" => $id_eliminar)); 
}

?>

</html>