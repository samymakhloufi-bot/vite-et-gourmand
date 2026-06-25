<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

$env = parse_ini_file(__DIR__ .'/../.env.docker');

$apiVersion = new ServerApi(ServerApi::V1);
$mongoClient = new Client(
    $env['MONGO_URI'],
    [],
    ['serverApi' => $apiVersion]
);

$mongoDB = $mongoClient -> selectDatabase($env['MONGO_DB']);
