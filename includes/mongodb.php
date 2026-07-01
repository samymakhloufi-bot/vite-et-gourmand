<?php

$envFile = file_exists(__DIR__ . '/../.env.docker')
    ? __DIR__ . '/../.env.docker'
    : __DIR__ . '/../.env';

$env = parse_ini_file($envFile);

function mongoRequest(string $action, array $body): array {
    global $env;

    $url = "https://data.mongodb-api.com/app/{$env['MONGO_APP_ID']}/endpoint/data/v1/action/{$action}";

    $payload = array_merge([
        'dataSource' => 'Cluster0',
        'database'   => $env['MONGO_DB'],
        'collection' => $env['MONGO_COLLECTION'],
    ], $body);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'api-key: ' . $env['MONGO_DATA_API_KEY']
        ],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    $response = curl_exec($ch);
    return json_decode($response, true) ?? [];
}