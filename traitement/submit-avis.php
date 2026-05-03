<?php 
require_once './login.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}

$contenu = trim($_POST['contenu']);
if(!empty($contenu)){
    $stmt = $pdo -> prepare("INSERT INTO avis (Id_user, contenu, statut, created_at) VALUES (?, ?, 'en_attente', NOW())");
    $stmt -> execute([$_SESSION['user_id'], $contenu]);
    header('Location : ../EspaceClient.php?avis=ok');
} else{
    header('Location : ../EspaceClient.php?avis=error');
}

exit();