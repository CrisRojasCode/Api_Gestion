<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

function guardarImagen($file) {
    if (!isset($file['imagen']) || $file['imagen']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $directorio = _DIR_ . '/../../gallery/';
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = uniqid() . '_' . basename($file['imagen']['name']);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($file['imagen']['tmp_name'], $rutaDestino)) {
        return 'https://gray-gnat-361867.hostingersite.com/gallery/' . $nombreArchivo;
    }

    return null;
}

// Leer los datos desde $_POST
if (!isset($_POST['titulo']) || !isset($_POST['descripcion']) || !isset($_POST['fecha']) ||
    !isset($_POST['hora_inicio']) || !isset($_POST['hora_fin']) || !isset($_POST['lugar']) ||
    !isset($_POST['categoria']) || !isset($_POST['participantes'])) {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

// Guardar la imagen y obtener el enlace
$imagenEnlace = guardarImagen($_FILES);
if ($imagenEnlace === null) {
    http_response_code(400);
    echo json_encode(["message" => "Error al subir la imagen"]);
    exit;
}

$db = (new Database())->getConnection();
$eventos = new Eventos($db);

$success = $eventos->create(
    $_POST['titulo'],
    $_POST['descripcion'],
    $_POST['fecha'],
    $_POST['hora_inicio'],
    $_POST['hora_fin'],
    $_POST['lugar'],
    $_POST['categoria'],
    $_POST['participantes'],
    $imagenEnlace
);

echo json_encode(["success" => $success]);
?>