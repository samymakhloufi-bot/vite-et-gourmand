<?php
require_once __DIR__ . '/../login.php';
header('Content-Type: application/json');
/*----------------------------
    Vérif de la requête AJAX
-----------------------------*/
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès interdit']);
    exit;
}

/*---------------------------------------------
    Vérif consentement cookies côté serveur
-----------------------------------------------*/

if (!isset($_COOKIE['maps-consent']) || $_COOKIE['maps-consent'] !== 'true') {
    http_response_code(403);
    echo json_encode(['error' => 'Consentement non donné pour Google Maps']);
    exit;
}

/*----------------------------
    Calcul frais de livraison
-----------------------------*/
function calculerFraisLivraison($adresseComplete) {


    // Si Bordeaux → 0€
    if (stripos($adresseComplete, "Bordeaux") !== false) {
        return ['distance_km' => 0, 'frais_livraison' => 0];
    }

    // Appel à l'API Google Maps
    $origin = "Bordeaux, France";
    $destination = urlencode($adresseComplete);
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".urlencode($origin)."&destinations=".urlencode($adresseComplete)."&key=" . GOOGLE_MAPS_KEY;

    $response = file_get_contents($url);
    if ($response === false) {
        throw new Exception("Impossible de contacter l'API Google Maps");
    }

    $data = json_decode($response, true);
    if ($data['status'] !== 'OK' || empty($data['rows'][0]['elements'][0]['distance']['value'])) {
        throw new Exception("Adresse non reconnue par Google Maps");
    }

    $distanceMetres = $data['rows'][0]['elements'][0]['distance']['value'];
    $distanceKm = $distanceMetres / 1000;
    $fraisLivraison = 5 + ($distanceKm * 0.59);

    return [
        'distance_km' => $distanceKm,
        'frais_livraison' => round(5 + ($distanceKm * 0.59), 2)
    ];
}

/*----------------------------
    gestion de la requête AJAX
-----------------------------*/

try {
    $adresse = $_POST['adresse'] ?? '';
    error_log('adresse reçue: ' . print_r($_POST, true));
    if (empty($adresse)) {
        throw new Exception("Adresse manquante");
    }
    $result = calculerFraisLivraison($adresse);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>