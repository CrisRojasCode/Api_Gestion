<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$db = (new Database())->getConnection();
$evento = new Eventos($db);

$id = $_POST['id'] ?? null;
$imagen = $_POST['imagen'] ?? null;

if (!$id || !$imagen) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$ruta = '../../uploads/' . $imagen;
if (file_exists($ruta)) {
    unlink($ruta);
}

$success = $evento->delete($id);
echo json_encode(["success" => $success]);
