<?php $activePage = 'espace admin'; 


require_once './login.php';

$activeTab = $_GET['tab'] ?? 'dashboard-wrapper';

if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin'])) {
    header('Location: ./index.php');
    exit();
}

require_once './classes/Repository/CommandeRepository.php';
require_once './classes/Repository/UserRepository.php';
require_once './classes/Repository/MenuRepository.php';
require_once './classes/Repository/AvisRepository.php';



$commandes = [];
$menus =[];
$avis =[];
$horaires = [];


$commandeRepository = new CommandeRepository($pdo);
$menuRepository     = new MenuRepository($pdo);
$avisRepository     = new AvisRepository($pdo);


// Commandes
$commandes = $commandeRepository->findAllWithDetails();

// Menus
$menus = $menuRepository->findAllAsArray(false);

// Avis
$avis = $avisRepository->findAllAvis();

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
        <script src="<?= BASE_URL ?>/js/espace-client.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-admin.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-employe.js"></script>
    </body>
</html>
