<?php 
header('Content-Type: application/json');
require_once '../login.php';
require_once __DIR__ . '/../classes/Repository/CommandeRepository.php';
require_once __DIR__ . '/../classes/Repository/StatsRepository.php';
require_once __DIR__ . '/../includes/mongodb.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'non connecté']);
    exit();
}

csrf_require();

$data = json_decode(file_get_contents('php://input'), true);
$id_commande = (int)$data['id_commande'];
$datetime = $data['date_livraison'] . ' ' . $data['heure_livraison'] . ':00';


//recalcul prix si quantite modif
$stmt_prix = $pdo -> prepare ("SELECT m.prix_menu, m.nb_perso_min, m.delai_commande_jours, c.frais_livraison 
    FROM menu m
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

// Délai défini directement dans le menu
$delaiCommande = (int)$detail_menu['delai_commande_jours'];

$dateLivraison = DateTimeImmutable::createFromFormat(
    '!Y-m-d',
    $data['date_livraison']
);

$dateMinimum = (new DateTimeImmutable('today'))
    ->modify("+{$delaiCommande} days");

if (!$dateLivraison || $dateLivraison < $dateMinimum) {
    echo json_encode([
        'error' => "La date doit respecter le délai de {$delaiCommande} jour(s) indiqué pour ce menu."
    ]);
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

    try {
        $commandeRepository = new CommandeRepository($pdo);
        $statsRepository = new StatsRepository(
            MongoConnection::getStatsCollection());
        $commandeStats = $commandeRepository->findStatsDataById($id_commande);

        if (!$commandeStats) {
            throw new RuntimeException("Commande SQL #{$id_commande} introuvable.");
        }

        $statsRepository->synchroniserCommande($commandeStats);
    } catch (Exception $e) {
        error_log('Synchronisation MongoDB du montant impossible : ' . $e->getMessage());
    }
    echo json_encode(['success'=> true]);
}catch(Exception $e){
    echo json_encode(['error' => $e -> getMessage()]);
}

