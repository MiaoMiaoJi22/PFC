<!DOCTYPE html>
<html>

<head>
    <title>Facturas</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="../Fotos/IconoWeb.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        <?php 
        require("../bootstrap-5.1.3-dist/css/bootstrap.min.css");
        require("../bootstrap-5.1.3-dist/css/bootstrap-grid.min.css");
        require("../bootstrap-5.1.3-dist/css/bootstrap-reboot.min.css");
        require("../bootstrap-5.1.3-dist/css/bootstrap-utilities.min.css");
        ?>
    </style>
</head>

<body class="pt-2">

    <?php 

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
    $SelectDireccion->execute(array(":idD" => $rowFactura['ID_DIRECCION_ENVIO']));
    $rowDireccion = $SelectDireccion->fetch();

    ?>

    <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents("../Fotos/logo.png")) ;?>" class="mt-2" style="margin-left: -30px;" />

    <div class="w-100 p-4">

        <table class="w-100">
            <thead>
                <tr>
                    <th class="float-start"><h5><strong>Alimentación y Bazar</strong></h5></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>28025&nbsp;&nbsp;&nbsp;Madrid</td>
                </tr>
                <tr>
                    <td>Madrid&nbsp;&nbsp;&nbsp;España</td>
                </tr>
                <tr>
                    <td>NIE: &nbsp;&nbsp;&nbsp;X6082365S</td>
                </tr>
            </tbody>
        </table>

        <h1 class="text-center" style="margin-top: 20px; margin-bottom: 20px; font-size: 40px;">Factura</h1>
        <h5 class="float-start">Número de factura:&nbsp;<strong><?php echo $rowFactura['ID_TRANSACCION']; ?></strong></h5>
        <h5 class="float-end"><strong><?php echo $rowFactura['FECHA']; ?></strong></h5></th>

        <div class="mt-5 p-2 border border-dark border-4">
            <table class="w-100">
                <thead>
                    <tr>
                        <th><h5><strong><?php echo $rowUsuario['NOMBRECOMPLETO']; ?></strong></h5></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo ($rowDireccion['DIRECCION_NUMERO'] !== '') ? $rowDireccion['DIRECCION_NUMERO'] :  ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ($rowDireccion['CODIGO_POSTAL'] !== '') ? $rowDireccion['CODIGO_POSTAL'] :  ''; ?>&nbsp;&nbsp;&nbsp;<?php echo ($rowDireccion['POBLACION'] !== '') ? $rowDireccion['POBLACION'] :  ''; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ($rowDireccion['PROVINCIA'] !== '') ? $rowDireccion['PROVINCIA'] :  ''; ?>&nbsp;&nbsp;&nbsp;España</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="table mt-3 table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Concepto</th>
                    <th scope="col" class="text-center">Unidad</th>
                    <th scope="col" class="text-end">Precio/Unidad</th>
                    <th scope="col" class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rowProducto as $row) { ?>
                    <tr>
                        <td class="align-middle"><?php echo $row['NOMBRE']; ?></td>
                        <td class="align-middle text-center"><?php echo $row['CANTIDAD']; ?></td>
                        <td class="align-middle text-end"><?php echo number_format($row['PRECIO'], 2, '.', ',') . MONEDA; ?></td>
                        <td class="align-middle text-end"><?php echo number_format($row['CANTIDAD'] * $row['PRECIO'], 2, '.', ',') . MONEDA; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table class="table mt-5 table-striped table-hover text-end float-end w-25">
            <thead>
                <tr>
                    <th scope="col"><h2>Total</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-middle"><h2><?php echo number_format($rowFactura['TOTAL_COMPRA'], 2, '.', ',') . MONEDA; ?></h2></td>
                </tr>
            </tbody>
        </table>
        
    </div>

</body>
</html>