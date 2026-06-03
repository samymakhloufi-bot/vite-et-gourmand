<?php
require_once __DIR__ . '/../login.php';
$activePage = 'menus';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM menu WHERE link = ? AND actif = 1 ");
$stmt->execute([$id]);
$menu_actif = $stmt->fetch();

if (!$menu_actif) {
    header('Location: <?= BASE_URL ?>/Nosmenus.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/../includes/head.php'; ?>
    <script src="<?= BASE_URL ?>/js/commande.js"></script>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <article class="menu-detail">
        <div class="menu-detail-header">
            <picture>
                <source media="(min-width:750px)" srcset="../Images/<?= $menu_actif['img_desktop'] ?>">
                <img src="../Images/<?= $menu_actif['img_mobile'] ?>.png" alt="<?= htmlspecialchars($menu_actif['menu_nom']) ?>" class="menu-detail-img">
            </picture>
            <div class="menu-detail-headline">
                <h2><?= htmlspecialchars($menu_actif['menu_nom']) ?></h2>
                <p class="menu-chef-note"><em>Note du Chef :</em> <?= htmlspecialchars($menu_actif['description']) ?></p>
            </div>
        </div>

        <h3>Entrée : <?= htmlspecialchars($menu_actif['entree']) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu_actif['entree_description']) as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Plat : <?= htmlspecialchars($menu_actif['plat']) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu_actif['plat_description']) as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Boisson :</h3>
        <ul>
            <?php foreach (explode('|', $menu_actif['boisson']) as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Dessert : <?= htmlspecialchars($menu_actif['dessert']) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu_actif['dessert_description']) as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Allergènes :</h3>
        <ul>
            <?php foreach (explode('|', $menu_actif['allergene']) as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <div class="menu-detail-footer">
            
            <em class="menu-price">Prix : <?= $menu_actif['prix'] ?> €/personne / Min : <?= $menu_actif['nb_perso_min'] ?> personnes</em>
            <form action="../achat.php" method="POST">
                <input type="hidden" name="menu_nom" value="<?= htmlspecialchars($menu_actif['menu_nom'])?>">
                <input type="hidden" name="nb_pers" value="<?= $nb_pers?>">
                <input type="hidden" name="menu_id" value="<?= $menu_actif['Id_menu']?>">

                <div class="nb-person-menu">
                    <span>NB.<br>PERSONNES</span>
                    <div class="btn-counter-nb">
                            <button type="button" class="counter-btn" onclick="change(this, -1)">-</button>
                            <input type="number" class="counter-val" name="nb_pers" value="1" min="1">
                            <button type="button" class="counter-btn" onclick="change(this, 1)">+</button>
                        </div>
                </div>

                <div class="order-menu-btn">
                    <button type="submit" class="btn-menu-order">Commander</button>
                </div>

            </form>
        </div>
    </article>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>