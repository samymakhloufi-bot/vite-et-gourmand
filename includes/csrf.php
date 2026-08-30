<?php 

function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_verify($token) :bool {
    return isset($_SESSION['csrf_token']) 
    && is_string($token) 
    && hash_equals($_SESSION['csrf_token'], $token) 
    && $token !== '';
}

function csrf_verify_request(): bool {
    $token = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? NULL);
    return csrf_verify($token);
}

function csrf_require(bool $json = true, string $redirect = null): void{
    if (csrf_verify_request()) {
        return;
    }
        
    if ($json) {
        header('Content-Type: application/json');            
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Jeton CSRF invalide ou expiré']);
        exit;
    } 
    header('Location: ' . ($redirect ?? (BASE_URL . '/index.php')) . '?error=csrf');
    exit;
}