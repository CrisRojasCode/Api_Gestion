<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

// Recibir el ID y nombre del archivo (para eliminar físicamente)
$id = $_POST['id'] ?? null;
$archivo = $_POST['archivo'] ?? null;

if (!$id || !$archivo) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$ruta = '../../uploads/' . $archivo;
if (file_exists($ruta)) {
    unlink($ruta); // Elimina la imagen física
}

$success = $galeria->delete($id);
echo json_encode(["success" => $success]);
