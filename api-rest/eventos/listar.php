<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/eventosClass.php';

$db = (new Database())->getConnection();
$eventos = new Eventos($db);

$result = $eventos->getAll();
$data = $result->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
?>