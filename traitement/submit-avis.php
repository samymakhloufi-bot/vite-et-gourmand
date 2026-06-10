<?php 
header('Content-Type: application/json');
require_once '../login.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Non connecté']);
    exit();
}

if(isset($_POST['contenu'])){

    $contenu = trim($_POST['contenu']);
    $note = (int)$_POST['note'];

    if(empty($contenu) || $note <1 || $note > 5){
        echo json_encode(['error' => 'Veuillez remplir le commentaire et choisir une note.']);
        exit;
    }
    
    try {
        $stmt = $pdo -> prepare("INSERT INTO avis (Id_user, contenu, note, created_at, statut_avis) 
                            VALUES (?, ?, ?, NOW(), 'en_attente')");
        $stmt -> execute([$_SESSION['user_id'], $contenu, $note]);
    
        echo json_encode(['success'=>true]);
        exit();
    }catch(Exception $e){
        echo json_encode(['error' => $e->getMessage()]);
        exit();
        }
}