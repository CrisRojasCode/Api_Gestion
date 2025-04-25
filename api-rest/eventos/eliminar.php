<?php
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "ID requerido"]);
    exit;
}

$db = (new Database())->getConnection();
$eventos = new Eventos($db);

$success = $eventos->delete($data->id);

echo json_encode(["success" => $success]);
?>