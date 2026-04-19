<?php $activePage = 'espace employé'; 

require_once './login.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['employe', 'admin'])) {
    header('Location: /VG/index.php');
    exit();
}

$section = $_GET['section'] ?? 'commandes';


if($section ==='commandes') {
        $stmt = $pdo -> query("SELECT c.id_commande, u.nom, m.menu_name, c.date_commande, c.status FROM commande c JOIN users u ON c.user_id = u.id JOIN menu m ON c.menu_id = m.id ORDER BY date_commande DESC");
        $commandes = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    } elseif($section === 'menus-plat') {
        $stmt = $pdo -> query("SELECT * FROM menu ORDER BY nom DESC");
        $menus = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    } else if($section === 'moderation-avis') {
        $stmt = $pdo->query("SELECT a.*, u.nom, u.prenom FROM avis a JOIN users u ON a.id_user = u.id_user WHERE a.statut = 'en_attente' ORDER BY a.created_at DESC");
        $avis = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include '/VG/includes/head.php';?>
    
    <body>
        <?php include '/VG/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Mon espace <em> employé </em></h2></div>
        </div>

        <main class="main-espace-client">
            <div class="espace-client-wrapper">
                <div class="sidebar-espace-client">
                    <button type="button" class="btn-commande" data-target="commandes">Commandes</button>
                    <button type="button" class="btn-infos" data-target="menus-plat">Menus & Plats</button>
                    <button type="button" class="btn-avis" data-target="moderation-avis">Modération Avis</button>
                </div>


                <section id="orders-wrapper" class="account-panel" >
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th scope="col">ID Commande</th>
                                <th scope="col">Client</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($commandes)): ?>
                                <tr>
                                    <td colspan="6">Aucune commande trouvée.</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach($commandes as $commande): ?>
                                <tr>
                                    <th scope="row">#<?= htmlspecialchars($commande['id_commande']) ?></th>
                                    <td><?= htmlspecialchars($commande['nom']) ?></td>
                                    <td><?= htmlspecialchars($commande['menu_name']) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($commande['date_commande']))) ?></td>
                                    <td>
                                        <select name="action" onchange="updateStatut(this, <?= htmlspecialchars($commande['id_commande']) ?>)" id="select-action" required>
                                            <option value="waiting" <?= $commande['status'] === 'waiting' ? 'selected' : ''; ?>>EN ATTENTE</option>
                                            <option value="preparation" <?= $commande['status'] === 'preparation' ? 'selected' : ''; ?>>EN PRÉPARATION</option>
                                            <option value="delivery" <?= $commande['status'] === 'delivery' ? 'selected' : ''; ?>>EN LIVRAISON</option>
                                            <option value="accepted" <?= $commande['status'] === 'accepted' ? 'selected' : ''; ?>>ACCEPTÉ</option>
                                            <option value="done" <?= $commande['status'] === 'done' ? 'selected' : ''; ?>>TERMINÉE</option>
                                            <option value="cancelled" <?= $commande['status'] === 'cancelled' ? 'selected' : ''; ?>>ANNULÉ</option>
                                            <option value="return-material" <?= $commande['status'] === 'return-material' ? 'selected' : ''; ?>>RETOUR DE MATERIEL</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                        <?php endif; ?>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td> <select name="action" id="select-action" required>
                                    <option value="waiting">EN ATTENTE</option>
                                    <option value="preparation">EN PRÉPARATION</option>
                                    <option value="delivery">EN LIVRAISON</option>
                                    <option value="accepted">ACCEPTÉ</option>
                                    <option value="done">TERMINÉE</option>
                                    <option value="cancelled">ANNULÉ</option>
                                    <option value="return-material">RETOUR DE MATERIEL</option>
                                </select></td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                
                
                <section id="menus-plat-wrapper" class="account-panel" style="display:none;">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Prix</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($menus)): ?>
                                <tr>
                                    <td colspan="3">Aucun menu trouvé.</td>
                                </tr>
                            <?php else: ?>

                                <?php foreach($menus as $menu): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($menu['menu_name']) ?></td>
                                        <td><?= htmlspecialchars($menu['prix']) ?>€</td>
                                        <td><?= htmlspecialchars($menu['description']) ?></td>
                                    </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>

                <section id="">

                </section>
        </main>

        <?php include '/VG/includes/footer.php' ;?>
        <script src="/VG/js/espaceclient.js"></script>
    </body>
</html>