<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$db = (new Database())->getConnection();
$evento = new Eventos($db);

$id = $_POST['id'] ?? null;
$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$hora_inicio = $_POST['hora_inicio'] ?? '';
$hora_fin = $_POST['hora_fin'] ?? '';
$lugar = $_POST['lugar'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$participantes = $_POST['participantes'] ?? '';
$imagen = $_POST['imagenActual'] ?? '';

if (!$id) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
    exit;
}

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $nombreImagen = uniqid() . "_" . basename($_FILES['imagen']['name']);
    $ruta = '../../uploads/' . $nombreImagen;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        $imagen = $nombreImagen;
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al subir imagen"]);
        exit;
    }
}

$success = $evento->update($id, $titulo, $descripcion, $fecha, $hora_inicio, $hora_fin, $lugar, $categoria, $participantes, $imagen);
echo json_encode(["success" => $success]);
