<?php 
if(session_status() === PHP_SESSION_NONE);{
    session_start();
}

$env = parse_ini_file( __DIR__ . '/.env');
define('BASE_URL', $env['BASE_URL']);
define('GOOGLE_MAPS_KEY', $env['GOOGLE_MAPS_KEY']);

try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8",
        $env['DB_USERNAME'],
        $env['DB_PASSWORD']
    );
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion :" . $e->getMessage());
}


if(!isset($_SESSION['user_id'])) {
    $token = $_COOKIE['remember_token'] ?? null;

    $stmt = $pdo -> prepare('SELECT id_user, role FROM users Where remember_token = ?');
    $stmt -> execute([$token]);
    $user = $stmt -> fetch();

    if($user){
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];
        }
}


