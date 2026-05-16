<?php 
require_once '../login.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['employe', 'admin'])) {
    echo json_encode(['success' => false]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = (int) $data['id'];
$actif = (int) $data['actif'];

$stmt = $pdo -> prepare('UPDATE menu SET actif = ? WHERE Id_menu = ?');
$stmt -> execute([$actif, $id]);

echo json_encode(['success'=> true]);