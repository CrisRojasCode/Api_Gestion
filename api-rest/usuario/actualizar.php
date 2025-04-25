<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/usuariosClass.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->usuario) || !isset($data->clave)) {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

$success = $usuario->update($data->id, $data->usuario, $data->clave);

echo json_encode(["success" => $success]);
?>