<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

function guardarImagen($file) {
    if (!isset($file['imagen']) || $file['imagen']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $directorio = __DIR__ . '/../../gallery/';
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
if (!isset($_POST['titulo']) || !isset($_POST['categoria'])) {
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
$galeria = new Galeria($db);

$success = $galeria->create(
    $_POST['titulo'],
    $_POST['categoria'],
    $imagenEnlace
);

echo json_encode(["success" => $success]);
?>
