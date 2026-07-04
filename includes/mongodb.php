<?php
require_once __DIR__ . '/../vendor/autoload.php';

$envFile = file_exists(__DIR__ . '/../.env.docker')
    ? __DIR__ . '/../.env.docker'
    : __DIR__ . '/../.env';

$env = parse_ini_file($envFile);


try {
    $client = new MongoDB\Client($env['MONGO_URI'] ?? 'mongodb://root:root@mongo:27017');
    $db = $client->selectDatabase($env['MONGO_DB'] ?? 'vite_gourmand');
    $collection = $db->selectCollection($env['MONGO_COLLECTION'] ?? 'commandes_stats');
} catch (Exception $e) {
    error_log("MongoDB Connection Error: " . $e->getMessage());
    die("❌ Impossible de se connecter à MongoDB : " . $e->getMessage());
}

function getMongoCollection() {
    global $collection;
    return $collection;
}