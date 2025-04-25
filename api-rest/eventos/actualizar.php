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

// Verificar que el ID esté presente
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["message" => "ID requerido"]);
    exit;
}

// Si se sube nueva imagen, la guardamos
$imagenEnlace = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagenEnlace = guardarImagen($_FILES);
}

// Si no suben nueva imagen, quizá quieres mantener la que ya tenía
if (!$imagenEnlace && isset($_POST['imagen_actual'])) {
    $imagenEnlace = $_POST['imagen_actual']; // Imagen anterior enviada por el formulario
}

$db = (new Database())->getConnection();
$eventos = new Eventos($db);

$success = $eventos->update(
    $_POST['id'],
    $_POST['titulo'] ?? null,
    $_POST['descripcion'] ?? null,
    $_POST['fecha'] ?? null,
    $_POST['hora_inicio'] ?? null,
    $_POST['hora_fin'] ?? null,
    $_POST['lugar'] ?? null,
    $_POST['categoria'] ?? null,
    $_POST['participantes'] ?? null,
    $imagenEnlace
);

echo json_encode(["success" => $success]);
?>
