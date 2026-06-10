<?php 

require_once '../login.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ' .  BASE_URL .'/connexion.php');
    exit;
};

//mise à jour infos
if(isset($_POST['update-account'])) {
    $stmt_update = $pdo -> prepare("UPDATE users SET 
        nom = ?,
        prenom = ?,
        email = ?,
        tel = ?,
        adresse = ?,
        ville = ?,
        complement_adresse = ?,
        code_postal = ? 
        WHERE id_user = ?");
    $stmt_update -> execute([
        trim($_POST['nom']),
        trim($_POST['prenom']),
        trim($_POST['email']),
        trim($_POST['tel']),
        trim($_POST['adresse']),
        trim($_POST['ville']),
        trim($_POST['complement-adresse']),
        trim($_POST['code-postal']),
        $_SESSION['user_id']]);

    // Rafraîchir les données de l'utilisateur après la mise à jour
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['prenom']= $_POST['prenom'];
    $_SESSION['email'] = $_POST['email'];

    header('Location: /success-page/maj-personal-info.php');
            exit();
    }