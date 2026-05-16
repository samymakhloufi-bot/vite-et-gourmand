<?php $activePage = 'espace employe'; 

require_once './login.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['admin', 'employe'])) {
    header('Location: /VG/index.php');
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
        WHERE a.statut = 'en_attente' 
        ORDER BY a.created_at DESC");
        $avis = $stmt -> fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Mon espace <em> employé </em></h2></div>
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

                    <?php // Message image à jour
                    if (isset($_GET['success'])): ?>
                        <p class="message-succes">Image mise à jour avec succès.</p>
                    <?php elseif (isset($_GET['error'])): ?>
                        <p class="message-erreur">Erreur lors de l'upload.</p>
                    <?php endif; ?>
                    

                <section id="menus-plat" class="account-panel">
                        <?php include './espace/employee/menus-plat.php' ?>
                </section>

                <section id="moderation-avis" class="account-panel">
                        <?php include './espace/employee/avis.php' ?>
                </section>
                
                <section id="horaires" class="account-panel">
                    <?php include './espace/employee/horaires.php' ?>
                </section>

        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>
        <script src="/VG/js/espaceclient.js"></script>
        <script src="/VG/js/espaceAdmin.js"></script>
    </body>
</html>