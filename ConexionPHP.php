<?php

$host="localhost";
$bdname="id21663037_bdproyectofindeciclo";
$username="id21663037_miao";
$password="jiMIAOjiCHENG_183";

try{
    $base = new PDO('mysql:host=localhost;dbname=' . $bdname, $username, $password);
    $base->exec("SET CHARACTER SET utf8");
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "Se ha producido un error, no puede conectar el base de datos llamado $bdname, el error es: $e";
}

// try {
//     $base = new PDO("sqlsrv:server = bdproyectofindeciclo.database.windows.net; Database = bdproyectofindeciclo", "administrador", "{jiMIAOjiCHENG183}");
//     $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $e) {
//     print("Error connecting to SQL Server.");
//     die(print_r($e));
// }

// try {
//     $base = new PDO("sqlsrv:server = LAPTOP-B5SQFNRE\SQLSPROYECTO; Database = proyectofindeciclo", "", "");
//     $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $e) {
//     print("Error connecting to SQL Server.");
//     die(print_r($e));
// }


?>