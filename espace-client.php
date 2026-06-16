<?php $activePage = 'espace client'; 

require_once './login.php';
    require_once './classes/Repository/CommandeRepository.php';
    require_once './classes/Repository/UserRepository.php';


if(!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}
$userRepository = new UserRepository($pdo);
$commandeRepository = new CommandeRepository($pdo);

$user = $userRepository->findById((int) $_SESSION['user_id']);
$commandes = $commandeRepository->findByUserWithDetails((int) $_SESSION['user_id']);

    
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
            <h2>Mon espace <em> & commandes </em></h2></div>
        </div>

        
        <main class="main-espace">
            <div class="espace-wrapper">
                <div class="sidebar-espace">
                    <button type="button" class="btn-mes-commande" data-target="my-orders-wrapper" aria-selected="Mes Commandes">Mes Commandes</button>
                    <button type="button" class="btn-infos" data-target="sub-form" aria-selected="Mes Informations" >Mes Informations</button>
                    <button type="button" class="btn-avis-form" data-target="avis-form" aria-selected="Donner mon avis">Donner mon avis</button>
                </div>

        <section id="my-orders-wrapper" class="account-panel" >
            <?php include './espace/client/mes-commandes.php' ?>
        </section>

        <section id="sub-form" class="account-panel">
                <?php include './espace/client/mes-infos.php' ?>
        </section>
        
        <section id="avis-form" class="account-panel">
            <?php include './espace/client/mon-avis.php' ?>
        </section>

            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/espace-client.js"></script>
    </body>
</html>
