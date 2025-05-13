<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once "../../includes/DatabaseClass.php";
include_once "../../includes/galeriaClass.php";

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

// Recibir datos del formulario
$id = $_POST['id'] ?? null;
$titulo = $_POST['titulo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$archivo = $_POST['archivoActual'] ?? ''; // valor por defecto: el actual

if (!$id) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
    exit;
}

// Verificar si se subió un nuevo archivo
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES['archivo']['name']);
    $ruta = "../../uploads/" . $nombreArchivo;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
        $archivo = $nombreArchivo;
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al subir archivo"]);
        exit;
    }
}

$success = $galeria->update($id, $titulo, $categoria, $archivo, $descripcion);

if ($success) {
    echo json_encode(["success" => true, "message" => "Elemento actualizado correctamente"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "No se pudo actualizar"]);
}
