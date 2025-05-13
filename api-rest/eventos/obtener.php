<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    include_once "../../includes/DatabaseClass.php";
    include_once "../../includes/eventosClass.php";

    if (!isset($_GET['id'])) {
        throw new Exception("ID no proporcionado");
    }

    $id = $_GET['id'];

    $db = (new Database())->getConnection();
    $eventoClass = new Eventos($db);

    $evento = $eventoClass->obtenerEventoPorId($id);

    if ($evento) {
        echo json_encode($evento);
    } else {
        echo json_encode(["success" => false, "message" => "Evento no encontrado"]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
