<?php
include_once '../../includes/DatabaseClass.php';
include_once '../../includes/usuariosClass.php';

$db = (new Database())->getConnection();
$usuario = new Usuario($db);

$result = $usuario->getAll();
$data = $result->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
?>