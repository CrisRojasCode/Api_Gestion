<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$db = (new Database())->getConnection();
$evento = new Eventos($db);

$result = $evento->getAll();
$eventos = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $row['imagen'] = 'http://localhost/tu-proyecto/uploads/' . $row['imagen'];
    $eventos[] = $row;
}

echo json_encode($eventos);
