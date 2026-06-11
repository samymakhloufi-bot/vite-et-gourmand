<?php 
require_once '../login.php';

if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['admin', 'empoloye'])) {
    header('Location: ../index.php');
    exit();
}

$data = json_decode(file_get_contents('php://input'),true);
$id = (int) $data['Id_avis'];
$action = $data['action'];

if(!in_array($action, ['valide', 'refuse'])){
    echo json_encode(['success' => false]);
    exit();
}

$stmt = $pdo ->prepare('UPDATE avis SET statut_avis = ? WHERE Id_avis = ?');
$stmt -> execute([$action, $id]);

echo json_encode(['success'=> true]);

