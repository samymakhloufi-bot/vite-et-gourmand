<?php $activePage = 'espace employe'; 

require_once './login.php';
require_once './classes/Repository/CommandeRepository.php';
require_once './classes/Repository/MenuRepository.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['employe'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

$commandeRepository = new CommandeRepository($pdo);
$menuRepository     = new MenuRepository($pdo);

// Commandes
$commandes = $commandeRepository->findAllWithDetails();

// Menus
$menus = $menuRepository->findAllAsArray(false);

// Avis
$stmt = $pdo->query("SELECT a.*, u.nom, u.prenom 
    FROM avis a 
    JOIN users u ON a.Id_user = u.Id_user 
    WHERE a.statut_avis 
    ORDER BY a.created_at DESC");
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Mon espace <em> employé </em></h1></div>
        </div>

        <main>

            <div class="espace-wrapper">

                <div class="sidebar-espace">
                    <button type="button" class="btn-commande" data-target="commandes-wrapper" aria-selected="commandes">Les Commandes</button>
                    <button type="button" class="btn-menus" data-target="menus-plat" aria-selected="Menus et plats">Menus & Plats</button>
                    <button type="button" class="btn-avis" data-target="moderation-avis" aria-selected="Modération Avis">Modération Avis</button>
                    <button type="button" class="btn-horaires" data-target="horaires" aria-selected="Horaires">Horaires</button>
                </div>


                <section id="commandes-wrapper" class="account-panel active">
                    <?php include './espace/employee/commande.php' ?>
                </section>

                <section id="menus-plat" class="account-panel">
                        <?php include './espace/employee/menus-plat.php' ?>
                </section>

                <section id="moderation-avis" class="account-panel">
                        <?php include './espace/employee/avis.php' ?>
                </section>
                
                <section id="horaires" class="account-panel">
                    <?php include './espace/employee/horaires.php' ?>
                </section>
            </div>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>
        <script src="<?= BASE_URL ?>/js/espace-client.js"></script>
        <script src="<?= BASE_URL ?>/js/espace-employe.js"></script>
    </body>
</html>