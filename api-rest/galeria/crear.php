<?php
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->titulo) || !isset($data->categoria) || !isset($data->archivo)) {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

$success = $galeria->create($data->titulo, $data->categoria, $data->archivo);

echo json_encode(["success" => $success]);
?>