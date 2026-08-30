<?php
require_once '../login.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['employe', 'admin'])) {
    header('location: '. BASE_URL .'/index.php');
    exit;
}

csrf_require(false, BASE_URL . '/espace-employe.php?section=menus-plat');

if (isset($_FILES['img_menu']) && $_FILES['img_menu']['error'] === 0) {
    $menu_id   = (int) $_POST['menu_id'];
    $extension = strtolower(pathinfo($_FILES['img_menu']['name'], PATHINFO_EXTENSION));

    // Vérification que c'est bien un PNG
    if ($extension !== 'png') {
        header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&error=format');
        exit;
    }

    // Vérification du type MIME réel du contenu (indépendant du nom de fichier)
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($_FILES['img_menu']['tmp_name']);
    if ($mimeType !== 'image/png') {
        header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&error=format');
        exit;
    }

    // Vérification que le fichier est bien une image décodable (rejette un PNG corrompu ou un polyglotte)
    if (@getimagesize($_FILES['img_menu']['tmp_name']) === false) {
        header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&error=format');
        exit;
    }


    // Vérification taille max 2MB
    if ($_FILES['img_menu']['size'] > 2 * 1024 * 1024) {
        header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&error=taille');
        exit;
    }

    // Nom de fichier unique
    $nom_original = pathinfo($_FILES['img_menu']['name'], PATHINFO_FILENAME);
    $nom_sanitize = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nom_original);
    $nom_fichier  = $nom_sanitize . '_' . time() . '.png';
    $destination = __DIR__ . '/../Images/' . $nom_fichier;

    if (move_uploaded_file($_FILES['img_menu']['tmp_name'], $destination)) {
        // Mettre à jour img_menu en BDD
        $stmt = $pdo->prepare("UPDATE menu SET img_menu = ? WHERE Id_menu = ?");
        $stmt->execute([$nom_fichier, $menu_id]);

        header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&success=1');
        exit;
    }
}

header('location: '. BASE_URL .'/espace-employe.php?section=menus-plat&error=upload');
exit;