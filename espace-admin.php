<?php $activePage = 'espace admin'; 

$activeTab = $_GET['tab'] ?? 'dashboard-wrapper';

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
<!DOCTYPE html>
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1><em> ADMINISTRATEUR </em></h1></div>
        </div>

        <main class="main-espace">

            <div class="espace-wrapper">
                
                <div class="sidebar-espace">

                    <button type="button" class="btn-dashboard <?= $activeTab ==='dashboard-wrapper' ? 'active' : ''?>" data-target="dashboard-wrapper" aria-selected="Tableau de Bord">Tableau de Bord</button>
                    <button type="button" class="btn-employee <?= $activeTab ==='employee-wrapper' ? 'active' : ''?>" data-target="employee-wrapper" aria-selected="Employés">Employés</button>
                    <button type="button" class="btn-turnover <?= $activeTab ==='turnover-wrapper' ? 'active' : ''?>" data-target="turnover-wrapper" aria-selected="Chiffre d'affaires">Chiffre d'affaires</button>
                    <button type="button" class="btn-commande <?= $activeTab ==='commande-wrapper' ? 'active' : ''?>" data-target="commandes-wrapper" aria-selected="commandes">Les Commandes</button>
                    <button type="button" class="btn-menus <?= $activeTab ==='menus' ? 'active' : ''?>" data-target="menus-plat" aria-selected="Menus et plats">Menus & Plats</button>
                    <button type="button" class="btn-avis <?= $activeTab ==='avis' ? 'active' : ''?>" data-target="moderation-avis" aria-selected="Modération Avis">Modération Avis</button>
                    <button type="button" class="btn-horaires <?= $activeTab ==='horaires' ? 'active' : ''?>" data-target="horaires" aria-selected="Horaires">Horaires</button>
                </div>

                <section id="dashboard-wrapper" class="account-panel <?= $activeTab ==='dashboard-wrapper' ? 'active' : ''?>">
                        <?php include './espace/admin/dashboard.php' ?>
                </section>
                
                <section id="employee-wrapper" class="account-panel <?= $activeTab ==='employee-wrapper' ? 'active' : ''?>">
                        <?php include './espace/admin/employe.php' ?>
                </section>
                
                <section id="turnover-wrapper" class="account-panel <?= $activeTab ==='turnover-wrapper' ? 'active' : ''?>">
                        <?php include './espace/admin/turnover.php' ?>
                </section>

                <section id="commandes-wrapper" class="account-panel <?= $activeTab ==='commande-wrapper' ? 'active' : ''?>">
                    <?php include './espace/employee/commande.php' ?>
                </section>

                <section id="menus-plat" class="account-panel <?= $activeTab ==='menus-plat' ? 'active' : ''?>">
                        <?php include './espace/employee/menus-plat.php' ?>
                </section>

                <section id="moderation-avis" class="account-panel <?= $activeTab ==='moderation-avis' ? 'active' : ''?>">
                        <?php include './espace/employee/avis.php' ?>
                </section>
                
                <section id="horaires" class="account-panel <?= $activeTab ==='horaires' ? 'active' : ''?>">
                    <?php include './espace/employee/horaires.php' ?>
                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/espace-client.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-admin.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-employe.js"></script>
    </body>
</html>
