<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/galeriaClass.php';

$db = (new Database())->getConnection();
$galeria = new Galeria($db);

$result = $galeria->getAll();
$data = $result->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
?>