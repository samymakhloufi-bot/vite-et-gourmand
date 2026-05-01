<?php 



require_once '../login.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['employe', 'admin'])) {
    echo json_encode(['success' => false]);
    exit;
}

$data        = json_decode(file_get_contents('php://input'), true);
$id_commande = (int) $data['id_commande'];
$statut      = $data['statut'];

$statuts_autorises = [
    'en_attente', 'accepte', 'en_preparation', 'en_cours_de_livraison',
    'livre', 'en_attente_retour_materiel', 'terminee', 'annulee'
];

if (!in_array($statut, $statuts_autorises)) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $pdo->prepare("UPDATE commande SET statut = ? WHERE Id_commande = ?");
$stmt->execute([$statut, $id_commande]);

echo json_encode(['success' => true]);