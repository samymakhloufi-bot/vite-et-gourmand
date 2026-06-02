<?php
require_once __DIR__.'/includes/config.php';

header('Content-Type: application/json');

try{
    $adress = $_POST['adress'] ?? '';
    if(empty($adress)){
        throw new Exception('Adresse manquante');
    }

    //Si adresse Bordeaux , frais = 0€
    if(stripos($adress, 'Bordeaux') !== false){
        echo json_encode(['distance_km' => 0, 'frais_livraison' => 0]);
        exit;
    }

    //Appel API Google maps pour calculer la distance
    $apiKey = GOOGLE_MAPS_API_KEY;
    $origin = 'Bordeaux, France';
    $destination = urlencode($adress);
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$origin&destinations=$destination&key=$apiKey";

    $response = file_get_contents($url);
    if($response === false){
        throw new Exception('Erreur lors de l\'appel à l\'API Google Maps');
    }

    $distanceMetres = $data['rows'][0]['elements'][0]['distance']['value'] ?? 0;
    $distanceKM = $distanceMetres / 1000;
    $fraisLivraison = 5 + ($distanceKM * 0.59);

    echo json_encode(['distance_km' => round($distanceKM, 2), 'frais_livraison' => round($fraisLivraison, 2)]);
} catch(Exception $e){
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>