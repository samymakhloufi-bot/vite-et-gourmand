<?php 
require_once '../login.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}

$contenu = trim($_POST['contenu']);
if(!empty($contenu)){
    $stmt = $pdo -> prepare("INSERT INTO avis (Id_user, contenu, statut) VALUES (?, ?, 'en_attente')");
    $stmt -> execute([$_SESSION['user_id'], $contenu]);
    header('Location: ../espaceClient.php?avis=ok');
} else{
    header('Location: ../espaceClient.php?avis=error');
}

exit();