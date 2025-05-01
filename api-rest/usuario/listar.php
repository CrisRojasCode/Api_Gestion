<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once '../../includes/DatabaseClass.php';
include_once '../../includes/usuariosClass.php';

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

$result = $usuario->getAll();

$usuarios = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
