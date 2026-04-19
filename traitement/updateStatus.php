<?php 
require_once '../login.php';

if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['employe', 'admin'])) {
    header('Location: ../index.php');
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id_commande = (int) $data['id_commande'];
$statut = $data['statut'];

$statuts_valides = ['waiting', 'accepted', 'done', 'cancelled', 'return-material', 'preparation', 'delivery'];

if (!in_array($statut, $statuts_valides)) {
    echo json_encode(['success' => false]);
    exit();
}

$stmt = $pdo->prepare("UPDATE commande SET status = :status WHERE id_commande = :id_commande");
$stmt->execute ([$statut, $id_commande]);