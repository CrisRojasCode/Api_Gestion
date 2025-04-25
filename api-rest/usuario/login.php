<?php
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/usuariosClass.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->usuario) || !isset($data->clave)) {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

$response = $usuario->login($data->usuario, $data->clave);

echo json_encode($response);
?>