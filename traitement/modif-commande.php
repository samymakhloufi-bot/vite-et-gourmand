<?php 
header('Content-Type: application/json');
require_once '../login.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'non connecté']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id_commande = (int)$data['id_commande'];
$datetime = $data['date_livraison'] . ' ' . $data['heure_livraison'] . ':00';


//recalcul prix si quantite modif
$stmt_prix = $pdo -> prepare ("SELECT m.prix_menu, m.nb_perso_min, c.frais_livraison FROM menu m
    JOIN commande_detail cd ON m.Id_menu = cd.Id_menu 
    JOIN commande c ON cd.Id_commande = c.Id_commande
    WHERE cd.Id_commande = ?");
$stmt_prix -> execute ([$id_commande]);
$detail_menu = $stmt_prix ->fetch();

$quantite  = (int)$data['quantite'];
$nb_perso_min = (int)$detail_menu['nb_perso_min'];

if($quantite <$nb_perso_min){
    echo json_encode(['error' =>'Nombre de personne minimum non atteint pour ce menu.']);
    exit;
}

$menu_prix = (float)$detail_menu['prix_menu'];
$reduction = ($quantite >= $nb_perso_min + 5) ? 0.10 : 0;
$frais_livraison = (float)$detail_menu['frais_livraison'];
$nouveau_prix = ($menu_prix * $quantite) * (1 -$reduction);
$prix_total = $nouveau_prix + $frais_livraison;

//délai de commande 
$date_livraison = new DateTime($data['date_livraison']);
$today = new DateTime();
$diff = $today ->diff($date_livraison)->days;

$delai_min = $quantite < 10 ? 7 : ($quantite <= 50 ? 14 : 20);

if($diff <$delai_min){
    echo json_encode(['error' => 'Délai insuffisant : minimum '. $delai_min .' jours pour '. $quantite .' personnes']);
    exit;
    }

try {
    //verif si la cmd appartient bien à l'user
    $check = $pdo ->prepare ("SELECT Id_commande FROM commande WHERE Id_commande = ? AND Id_user = ? AND statut = 'en_attente' ");
    $check -> execute([$id_commande, $_SESSION['user_id']]);

    if(!$check-> fetch()){
        echo json_encode(['error' => 'Commande non modifiable']);
        exit;
    }

    $cmd = $pdo -> prepare ("UPDATE commande set 
                date_livraison = ?,
                adresse_livraison = ?,
                ville_livraison = ?,
                complement = ?
                WHERE Id_commande = ?");
    $cmd -> execute([$datetime, $data['adresse_livraison'], $data['ville_livraison'], $data['complement'], $id_commande]);

    $detail = $pdo -> prepare("UPDATE commande_detail set
                        quantite = ?,
                        prix = ?, 
                        prix_total = ?
                        WHERE ID_commande = ? ");
    $detail -> execute([$quantite, $nouveau_prix, $prix_total, $id_commande]);

    echo json_encode(['success'=> true]);
}catch(Exception $e){
    echo json_encode(['error' => $e -> getMessage()]);
}

