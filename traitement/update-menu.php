<?php 
require_once '../login.php';

if(!isset($_SESSION['role']) || !in_array($_SESSION['role'] , ['employe', 'admin'])) {
    header('Location: ../index.php');
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id = (int) $data['id'];
$field = $data['field'];
$value = trim($data['value']);

$champ_autorises = ['menu_nom', 'theme', 'regime', 'prix', 'entree', 'plat', 'dessert', 'boisson', 'allergene', 'description', 'entree_description', 'plat_description', 'dessert_description'];
if (!in_array($data['field'], $champ_autorises)) {
    echo json_encode(['success' => false, 'message' => 'Champ non autorisé']);
    exit();
}

$field = $data['field'];
$stmt = $pdo->prepare("UPDATE menu SET $field = ? WHERE Id_menu = ?");
$result = $stmt->execute([$value, $id]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Menu mis à jour avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du menu']);
};
