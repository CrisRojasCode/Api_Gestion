<?php
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->titulo) || !isset($data->descripcion) || !isset($data->fecha) ||
    !isset($data->hora_inicio) || !isset($data->hora_fin) || !isset($data->lugar) ||
    !isset($data->categoria) || !isset($data->participantes) || !isset($data->imagen)) {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

$db = (new Database())->getConnection();
$eventos = new Eventos($db);

$success = $eventos->create(
    $data->titulo,
    $data->descripcion,
    $data->fecha,
    $data->hora_inicio,
    $data->hora_fin,
    $data->lugar,
    $data->categoria,
    $data->participantes,
    $data->imagen
);

echo json_encode(["success" => $success]);
?>