<?php $activePage = 'espace client'; 

require_once './login.php';
if(!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}

$stmts = $pdo -> prepare("SELECT * FROM users WHERE id_user = ?");
$stmts -> execute([$_SESSION['user_id']]);
$user = $stmts -> fetch(PDO::FETCH_ASSOC);

$stmt_commandes = $pdo -> prepare("SELECT c.Id_commande, m.menu_nom, c.date_livraison, cd.prix, c.statut 
                            FROM commande c 
                            JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
                            JOIN menu m ON cd.Id_menu = m.Id_menu
                            WHERE c.Id_user = ? ORDER BY date_commande DESC");
$stmt_commandes -> execute([$_SESSION['user_id']]);
$commandes = $stmt_commandes -> fetchAll(PDO::FETCH_ASSOC);

$message = '';
if(isset($_POST['update-account'])) {
    $stmt_update = $pdo -> prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, tel = ?, adresse = ?, ville = ?, complement_adresse = ?, code_postal = ? 
                            WHERE id_user = ?");
    $stmt_update -> execute([trim($_POST['nom']), trim($_POST['prenom']), trim($_POST['email']), trim($_POST['tel']), trim($_POST['adresse']), trim($_POST['ville']), trim($_POST['complement-adresse']), trim($_POST['code-postal']), $_SESSION['user_id']]);

    // Rafraîchir les données de l'utilisateur après la mise à jour
    $message = 'Vos informations ont été mises à jour avec succès.';    
    $stmts -> execute([$_SESSION['user_id']]);
        $user = $stmts -> fetch(PDO::FETCH_ASSOC);
    }
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
                </div>


                <section id="my-orders-wrapper" class="account-panel" >
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th scope="col">Commande</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Date de Livraison</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($commandes)): ?>
                                <tr>
                                    <td colspan="6" class="no-orders">Vous n'avez pas encore passé de commande.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($commandes as $commande): ?>
                            <tr>
                                <th scope="row">#<?= $commande['Id_commande'] ?></th>
                                <td><?= htmlspecialchars($commande['menu_nom']) ?></td>
                                <td><?= date('d/m/Y', strtotime(htmlspecialchars($commande['date_livraison']))) ?>€</td>
                                <td><?= htmlspecialchars($commande['prix']) ?></td>
                                <td><span class="order-statut order-statut--waiting">EN ATTENTE</span></td>
                                    <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-statut order-statut--waiting">EN ATTENTE</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-statut order-statut--accepted">ACCEPTÉ</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-statut order-statut--done">TERMINÉE</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-statut order-statut--cancelled">ANNULÉ</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </section>

                <section id="sub-form" class="account-panel">

                    <form action="" method="post" id="form-update-account">
                        <fieldset>
                            <h3>Vos Coordonnées</h3>

                            <div class="personal-info">
                                <label for="nom">NOM</label>
                                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?? '' ?>" placeholder="Votre nom de famille" >
                                
                                <label for="prenom">PRÉNOM</label>
                                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?? '' ?>" placeholder="Votre prénom" >
                                
                                <label for="email">E-MAIL</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?? '' ?>" placeholder="Votre e-mail" >
                                

                                <label for="tel">TÉLÉPHONE</label>
                                <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user['tel']) ??  '' ?>" placeholder="Votre numéro de téléphone" >

                                <label for="adresse">ADRESSE</label>
                                <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?? '' ?>" placeholder="Votre adresse" >

                                <label for="ville">VILLE</label>
                                <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($user['ville']) ??   '' ?>" placeholder="Votre ville de domiciliation" >

                                <label for="complement-adresse">COMPLÉMENT D'ADRESSE</label>
                                <input type="text" id="complement-adresse" name="complement-adresse" value="<?= htmlspecialchars($user['complement_adresse']) ?? '' ?>" placeholder="Complément d'adresse" >

                                <label for="code-postal">CODE POSTAL</label>
                                <input type="text" id="code-postal" name="code-postal" value="<?= htmlspecialchars($user['code_postal']) ?? '' ?>" placeholder="code postal" >


                            </div>
                            <button type="button" class="btn-edit">Modifier</button>
                            <button type="submit" class="btn-submit" name="update-account">Mettre à jour</button>
                        </fieldset>
                    </form>
                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/espaceclient.js"></script>
    </body>
</html>
