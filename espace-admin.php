<?php $activePage = 'espace admin'; 

$activeTab = $_GET['tab'] ?? 'dashboard';

require_once './login.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin'])) {
    header('Location: ./index.php');
    exit();
}

$commandes = [];
$menus =[];
$avis =[];
$horaires = [];


// Récupérer les données nécessaires pour chaque section

        //Commande 
        $stmt = $pdo -> query("SELECT c.Id_commande, u.nom, m.menu_nom, c.date_commande, c.statut, c.mode_paiement, c.adresse_livraison, cd.prix, cd.quantite, c.date_livraison
        FROM commande c 
        JOIN users u ON c.Id_user = u.Id_user 
        JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
        JOIN menu m ON cd.Id_menu = m.Id_menu 
        ORDER BY date_commande DESC");
        $commandes = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //Menu 
        $stmt = $pdo -> query("SELECT * FROM menu ORDER BY menu_nom DESC");
        $menus = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //Avis
        $stmt = $pdo->query("SELECT a.*, u.nom, u.prenom 
        FROM avis a 
        JOIN users u ON a.Id_user = u.Id_user 
        ORDER BY a.created_at DESC");
        $avis = $stmt -> fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2><em> ADMINISTRATEUR </em></h2></div>
        </div>

        <main class="main-espace">

            <div class="espace-wrapper">
                
                <div class="sidebar-espace">

                    <button type="button" class="btn-dashboard <?= $activeTab ==='dashboard' ? 'active' : ''?>" data-target="dashboard-wrapper" aria-selected="Tableau de Bord">Tableau de Bord</button>
                    <button type="button" class="btn-employee <?= $activeTab ==='employe' ? 'active' : ''?>" data-target="employee-wrapper" aria-selected="Employés">Employés</button>
                    <button type="button" class="btn-turnover <?= $activeTab ==='turnover' ? 'active' : ''?>" data-target="turnover-wrapper" aria-selected="Chiffre d'affaires">Chiffre d'affaires</button>
                </div>

                <section id="dashboard-wrapper" class="account-panel <?= $activeTab ==='dashboard' ? 'active' : ''?>">
                        <?php include './espace/admin/dashboard.php' ?>
                </section>
                
                <section id="employee-wrapper" class="account-panel <?= $activeTab ==='employe' ? 'active' : ''?>">
                        <?php include './espace/admin/employe.php' ?>
                </section>
                
                <section id="turnover-wrapper" class="account-panel <?= $activeTab ==='turnover' ? 'active' : ''?>">
                        <?php include './espace/admin/turnover.php' ?>
                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/espace-client.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-admin.js"></script>
    </body>
</html>
