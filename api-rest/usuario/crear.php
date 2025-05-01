<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/usuariosClass.php';

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

// Recibir JSON plano
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->usuario) || !isset($data->clave)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$success = $usuario->create($data->usuario, $data->clave);

echo json_encode(["success" => $success]);
