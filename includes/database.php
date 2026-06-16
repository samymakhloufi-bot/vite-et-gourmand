<?php

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $env = parse_ini_file(__DIR__ . '/../.env');
            try {
                self::$instance = new PDO(
                    "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8",
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