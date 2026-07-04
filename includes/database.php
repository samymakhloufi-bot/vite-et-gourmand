<?php

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $envDocker = __DIR__ . '/../.env.docker';
            $envNormal = __DIR__ . '/../.env';
            if (file_exists($envDocker)) {
                $testEnv = parse_ini_file($envDocker);
                $envFile = ($testEnv['DB_HOST'] === 'db') ? $envDocker : $envNormal;
            } else {
                $envFile = $envNormal;
            }

            $env = parse_ini_file($envFile);
            try {
                self::$instance = new PDO(
                    "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4",
                    $env['DB_USERNAME'],
                    $env['DB_PASSWORD']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}