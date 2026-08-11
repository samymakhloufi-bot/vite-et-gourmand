<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Collection;

final class MongoConnection
{
    private static ?Client $client = null;

    private static ?array $env = null;

    private function __construct()
    {
    }

    public static function getStatsCollection(): Collection
    {
        $env = self::getEnv();
        $uri = trim((string) ($env['MONGO_URI'] ?? ''));
        $databaseName = trim((string) ($env['MONGO_DB'] ?? 'vite_gourmand'));
        $collectionName = trim((string) ($env['MONGO_COLLECTION'] ?? 'commandes_stats'));

        if ($uri === '' || $uri === 'your_mongo_uri') {
            throw new RuntimeException('La variable MONGO_URI n\'est pas configurée.');
        }

        if (!extension_loaded('mongodb')) {
            throw new RuntimeException('L\'extension PHP mongodb n\'est pas installée.');
        }

        if (!class_exists(Client::class)) {
            throw new RuntimeException('La bibliothèque mongodb/mongodb n\'est pas installée.');
        }

        self::$client ??= new Client($uri);

        return self::$client
            ->selectDatabase($databaseName)
            ->selectCollection($collectionName);
    }

    private static function getEnv(): array
    {
        if (self::$env !== null) {
            return self::$env;
        }

        $envDocker = __DIR__ . '/../.env.docker';
        $envNormal = __DIR__ . '/../.env';
        $envFile = $envNormal;

        if (file_exists($envDocker)) {
            $dockerEnv = parse_ini_file($envDocker) ?: [];
            $envFile = ($dockerEnv['DB_HOST'] ?? null) === 'db' ? $envDocker : $envNormal;
        }

        if (!file_exists($envFile)) {
            throw new RuntimeException('Fichier de configuration .env introuvable.');
        }

        self::$env = parse_ini_file($envFile) ?: [];

        return self::$env;
    }
}
