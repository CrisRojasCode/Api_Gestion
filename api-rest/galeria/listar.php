<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

$result = $galeria->getAll();

$datos = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $row['archivo'] = 'http://localhost/tu-proyecto/uploads/' . $row['archivo'];
    $datos[] = $row;
}

echo json_encode($datos);
