<?php $activePage = 'espace employe'; 

require_once './login.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['admin', 'employe'])) {
    header('Location: /VG/index.php');
    exit();
}

$section = $_GET['section'] ?? 'commandes';


if($section ==='commandes') {
        $stmt = $pdo -> query("SELECT c.Id_commande, u.nom, m.menu_nom, c.date_commande, c.statut
        FROM commande c 
        JOIN users u ON c.Id_user = u.Id_user 
        JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
        JOIN menu m ON cd.Id_menu = m.Id_menu 
        ORDER BY date_commande DESC");
        $commandes = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    } elseif($section === 'menus-plat') {
        $stmt = $pdo -> query("SELECT * FROM menu ORDER BY menu_nom DESC");
        $menus = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    } else if($section === 'moderation-avis') {
        $stmt = $pdo->query("SELECT a.*, u.nom, u.prenom 
        FROM avis a 
        JOIN users u ON a.Id_user = u.Id_user 
        WHERE a.statut = 'en_attente' 
        ORDER BY a.created_at DESC");
        $avis = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

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

        <main class="main-espace-client">
            <div class="espace-client-wrapper">
                <div class="sidebar-espace-client">
                    <a href="?section=commandes" class="btn-commande">Commandes</a>
                    <a href="?section=menus-plat" class="btn-infos">Menus & Plats</a>
                    <a href="?section=moderation-avis" class="btn-avis">Modération Avis</a>
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
                                    <th scope="row">#<?= htmlspecialchars($commande['Id_commande']) ?></th>
                                    <td><?= htmlspecialchars($commande['nom']) ?></td>
                                    <td><?= htmlspecialchars($commande['menu_nom']) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($commande['date_commande']))) ?></td>
                                    <td>
                                        <select name="action" onchange="updateStatut(this, <?= htmlspecialchars($commande['id_commande']) ?>)" id="select-action" required>
                                            <option value="waiting" <?= $commande['statut'] === 'waiting' ? 'selected' : ''; ?>>EN ATTENTE</option>
                                            <option value="preparation" <?= $commande['statut'] === 'preparation' ? 'selected' : ''; ?>>EN PRÉPARATION</option>
                                            <option value="delivery" <?= $commande['statut'] === 'delivery' ? 'selected' : ''; ?>>EN LIVRAISON</option>
                                            <option value="accepted" <?= $commande['statut'] === 'accepted' ? 'selected' : ''; ?>>ACCEPTÉ</option>
                                            <option value="done" <?= $commande['statut'] === 'done' ? 'selected' : ''; ?>>TERMINÉE</option>
                                            <option value="cancelled" <?= $commande['statut'] === 'cancelled' ? 'selected' : ''; ?>>ANNULÉ</option>
                                            <option value="return-material" <?= $commande['statut'] === 'return-material' ? 'selected' : ''; ?>>RETOUR DE MATERIEL</option>
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
                                <th>Thème</th>
                                <th>Régime</th>
                                <th>Prix/pers</th>
                                <th>Entrée</th>
                                <th>Plat</th>
                                <th>Dessert</th>
                                <th>Boisson</th>
                                <th>Allergènes</th>
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
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu']?>" data-fields="menu_nom" class="editable"><?= htmlspecialchars($menu['menu_nom']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="theme" class="editable"><?= htmlspecialchars($menu['theme']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="regime" class="editable"><?= htmlspecialchars($menu['regime']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="prix" class="editable"><?= htmlspecialchars($menu['prix']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="entree" class="editable"><?= htmlspecialchars($menu['entree']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="plat" class="editable"><?= htmlspecialchars($menu['plat']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="dessert" class="editable"><?= htmlspecialchars($menu['dessert']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="boisson" class="editable"><?= htmlspecialchars($menu['boisson']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="allergene" class="editable"><?= htmlspecialchars($menu['allergene']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="description" class="editable"><?= htmlspecialchars($menu['description']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="entree_description" class="editable"><?= htmlspecialchars($menu['entree_description']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="plat_description" class="editable"><?= htmlspecialchars($menu['plat_description']) ?></td>
                                        <td contenteditable="true" data-id="<?= $menu['Id_menu'] ?>" data-field="dessert_description" class="editable"><?= htmlspecialchars($menu['dessert_description']) ?></td>
                                        <td> <img src="/VG/Images/<?= htmlspecialchars($menu['img_desktop']) ?>" alt="<?= htmlspecialchars($menu['menu_nom']) ?>" style="width:60px; height:40px;object-fit:cover;border-radius:4px;">
                                        <form action="/VG/traitement/upload-img-menu.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="menu_id" value="<?= $menu['Id_menu'] ?>">
                                            <input type="file" name="img_menu" accept=".png" style="display:none" id="upload-<?= $menu['Id_menu'] ?>">
                                            <label for="upload-<?= $menu['Id_menu'] ?>" class="btn-sm" style="cursor:pointer;">Changer</label>
                                            <button type="submit">Uploader</button>
                                        </form>
                                    </td>

                                    </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <?php endif; ?>
                <section id="">

                </section>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>
        <script src="/VG/js/espaceclient.js"></script>
    </body>
</html>