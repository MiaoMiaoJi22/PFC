<?php

session_start();

require_once ('../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

include("../ConexionPHP.php"); 
require('../token.php');

if (isset($_GET['idFactura'])) {
    $idFactura = $_GET['idFactura'];
}else {
    $idFactura = "";
}

$SelectFactura = $base->prepare("SELECT * FROM factura WHERE ID = :idfactura");
$SelectFactura->execute(array(":idfactura" => $idFactura));
$rowFactura = $SelectFactura->fetch();

$SelectUsuario = $base->prepare("SELECT * FROM usuario_pass WHERE ID = :id_usua");
$SelectUsuario->execute(array(":id_usua" => $rowFactura['ID_USUARIO']));
$rowUsuario = $SelectUsuario->fetch();

$SelectProducto = $base->prepare("SELECT * FROM detalle_factura WHERE ID_FACTURA = :idF ORDER BY NOMBRE ASC");
$SelectProducto->execute(array(":idF" => $rowFactura['ID']));
$rowProducto = $SelectProducto->fetchAll();

$SelectDireccion = $base->prepare("SELECT * FROM direccion_cliente WHERE ID = :idD");
$SelectDireccion->execute(array(
    ":idD" => $rowFactura['ID_DIRECCION_ENVIO'] 
));
$rowDireccion = $SelectDireccion->fetch();

$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
//$dompdf = new Dompdf();
ob_start();
require('Factura.php');
$html = ob_get_contents();
ob_get_clean();

$dompdf->load_html($html);
$dompdf->setPaper('A4', 'Portrait');
$dompdf->render();
$dompdf->stream('Factura.pdf', ['Attachment'=> false]);

?>