<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

// Recibir datos del formulario
$titulo = $_POST['titulo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$archivo = '';

if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES['archivo']['name']);
    $rutaDestino = '../../uploads/' . $nombreArchivo;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {
        $archivo = $nombreArchivo;
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al subir la imagen"]);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No se envió ninguna imagen"]);
    exit;
}

$success = $galeria->create($titulo, $categoria, $archivo);
echo json_encode(["success" => $success]);
