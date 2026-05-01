<?php
require_once '../login.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['employe', 'admin'])) {
    echo json_encode(['success' => false]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id   = (int) $data['id'];

$champs_autorises = [
    'menu_nom', 'theme', 'regime', 'prix', 'nb_perso_min', 'nb_perso_max',
    'entree', 'plat', 'dessert', 'boisson', 'allergene', 'description'
];

$sets   = [];
$values = [];

foreach ($champs_autorises as $champ) {
    if (isset($data[$champ])) {
        $sets[]   = "$champ = ?";
        $values[] = trim($data[$champ]);
    }
}

if (empty($sets)) {
    echo json_encode(['success' => false]);
    exit;
}

$values[] = $id;
$stmt = $pdo->prepare("UPDATE menu SET " . implode(', ', $sets) . " WHERE Id_menu = ?");
$stmt->execute($values);

echo json_encode(['success' => true]);