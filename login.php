<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$envFile = file_exists(__DIR__ . '/.env.docker') 
    ? __DIR__ . '/.env.docker'
    : __DIR__ . '/.env';



$envDocker =  __DIR__ .'/.env.docker';
$envNormal = __DIR__ .'/.env';

if(file_exists($envDocker)){
    $testEnv = parse_ini_file($envDocker);
    $envFile = ($testEnv['DB_HOST']=== 'db') ? $envDocker : $envNormal;
} else {
    $envFile = $envDocker;
}

$env = parse_ini_file($envFile);

define('BASE_URL', $env['BASE_URL']);
define('GOOGLE_MAPS_KEY', $env['GOOGLE_MAPS_KEY']);
define('MAIL_PASS', $env['MAIL_PASS']);

require_once __DIR__ . '/includes/database.php';
$pdo = Database::getInstance();

if (!isset($_SESSION['user_id'])) {
    $token = $_COOKIE['remember_token'] ?? null;
    if ($token) {
        require_once __DIR__ . '/classes/Repository/UserRepository.php';
        $userRepository = new UserRepository($pdo);
        $user = $userRepository->findByRememberToken($token);
        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role']    = $user->getRole();
        }
    }
}

