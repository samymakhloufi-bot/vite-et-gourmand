<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../login.php';

if (
    !isset($_SESSION['role']) ||
    !in_array($_SESSION['role'], ['employe', 'admin'], true)
) {
    http_response_code(403);

    echo json_encode([
        'success' => false,
        'error' => 'Accès interdit.'
    ]);

    exit;
}

csrf_require();

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data) || empty($data['id'])) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'Données invalides.'
    ]);

    exit;
}

$id = (int) $data['id'];

$champs_autorises = [
    'menu_nom',
    'theme',
    'regime',
    'prix',
    'nb_perso_min',
    'nb_perso_max',
    'quantite_restante',
    'entree',
    'plat',
    'dessert',
    'boisson',
    'allergene',
    'description'
];

$sets = [];
$values = [];

foreach ($champs_autorises as $champ) {
    if (array_key_exists($champ, $data)) {
        $value = is_string($data[$champ])
            ? trim($data[$champ])
            : $data[$champ];

        if ($champ === 'quantite_restante') {
            if (
                filter_var($value, FILTER_VALIDATE_INT) === false ||
                (int) $value < 0
            ) {
                http_response_code(422);

                echo json_encode([
                    'success' => false,
                    'error' => 'Le stock doit être un entier positif ou nul.'
                ]);

                exit;
            }

            $value = (int) $value;
        }

        // Le champ HTML "prix" correspond à "prix_menu" dans MySQL
        $colonne = $champ === 'prix'
            ? 'prix_menu'
            : $champ;

        $sets[] = "$colonne = ?";
        $values[] = $value;
    }
}

if (empty($sets)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'Aucune modification reçue.'
    ]);

    exit;
}

$values[] = $id;

$stmt = $pdo->prepare(
    'UPDATE menu SET ' .
    implode(', ', $sets) .
    ' WHERE Id_menu = ?'
);

$stmt->execute($values);

echo json_encode([
    'success' => true,
    'updated' => $stmt->rowCount()
]);