<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    include_once "../../includes/DatabaseClass.php";
    include_once "../../includes/galeriaClass.php";

    if (!isset($_GET['id'])) {
        throw new Exception("ID no proporcionado");
    }

    $id = $_GET['id'];

    $db = (new Database())->getConnection();
    $galeria = new Galeria($db);

    $item = $galeria->obtenerPorId($id);

    if ($item) {
        echo json_encode($item);
    } else {
        echo json_encode(["success" => false, "message" => "Elemento no encontrado"]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
