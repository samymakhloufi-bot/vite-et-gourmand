<?php $activePage = 'espace client'; 

require_once './login.php';


if(!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}
//Voir Commande
$stmts = $pdo -> prepare("SELECT * FROM users WHERE id_user = ?");
$stmts -> execute([$_SESSION['user_id']]);
$user = $stmts -> fetch(PDO::FETCH_ASSOC);

$stmt_commandes = $pdo -> prepare("SELECT c.Id_commande, m.menu_nom, c.date_livraison, cd.prix, c.statut, c.adresse_livraison, c.ville_livraison, cd.quantite, c.frais_livraison,
                                            cd.prix_total, c.frais_livraison, cd.reduction, c.mode_paiement, c.complement
                            FROM commande c 
                            JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
                            JOIN menu m ON cd.Id_menu = m.Id_menu
                            WHERE c.Id_user = ? ORDER BY date_commande DESC");
$stmt_commandes -> execute([$_SESSION['user_id']]);
$commandes = $stmt_commandes -> fetchAll(PDO::FETCH_ASSOC);


    
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
