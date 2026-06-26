<?php
require_once __DIR__ . '/../login.php';
require_once __DIR__ . '/../classes/Repository/MenuRepository.php';
$activePage = 'détails du menu';

$menuRepository = new MenuRepository($pdo);
$menu = $menuRepository->findByLink($_GET['id'] ?? '');

if (!$menu) {
    header('Location: ' . BASE_URL . '/nos-menus.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/../includes/head.php'; ?>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <article class="menu-detail">
        <div class="menu-detail-header">
            <picture>
                <img src="../Images/<?= $menu->getImgMenuUrl() ?>" alt="Photo du menu <?= htmlspecialchars($menu->getNom()) ?>" class="menu-detail-img">
            </picture>
            <div class="menu-detail-headline">
                <h2><?= htmlspecialchars($menu->getNom()) ?></h2>
                <p class="menu-chef-note"><em>Note du Chef :</em> <?= htmlspecialchars($menu->getDescription()) ?></p>
            </div>
        </div>

        <h3>Entrée : <?= htmlspecialchars($menu->getEntree()) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu->getEntreeDescription() ?? '') as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Plat : <?= htmlspecialchars($menu->getPlat()) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu->getPlatDescription() ?? '') as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <?php if ($menu->getBoisson()): ?>
    <h3>Boisson :</h3>
    <ul>
        <?php foreach (explode('|', $menu->getBoisson() ?? '') as $ligne): ?>
            <li><?= htmlspecialchars($ligne) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

        <h3>Dessert : <?= htmlspecialchars($menu->getDessert()) ?></h3>
        <ul>
            <?php foreach (explode('|', $menu->getDessertDescription() ?? '') as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Allergènes :</h3>
        <ul>
            <?php foreach (explode('|', $menu->getAllergene() ?? '') as $ligne): ?>
                <li><?= htmlspecialchars($ligne) ?></li>
            <?php endforeach; ?>
        </ul>
        

        <div class="menu-detail-footer">
            <em class="menu-price">Prix : <?= $menu->getPrix() ?> €/personne / Min : <?= $menu->getNbPersoMin() ?> personnes</em>
            <form id="form-commande" action="../achat.php" method="POST">
                <input type="hidden" name="menu_nom" value="<?= htmlspecialchars($menu->getNom()) ?>">
                <input type="hidden" name="nb_pers" value="1">
                <input type="hidden" name="menu_id" value="<?= $menu->getId() ?>">
                <?php if ($menu->getStock() !== null): ?>
    <span class="menu-stock <?= $menu->getStock() <= 3 ? 'stock-low' : '' ?>">
        <?= $menu->getStock() > 0 ? $menu->getStock() . ' restant(s)' : 'Épuisé' ?>
    </span>
<?php endif; ?>

                <div class="nb-person-menu">
                    <span>NB.<br>PERSONNES</span>
                    <div class="input-nb-perso">
                        <button type="button" class="counter-btn" onclick="change(this, -1)" aria-label="Diminuer le nombre de personnes">-</button>
                        <input type="number" class="counter-val" name="nb_pers" value="1" min="1">
                        <button type="button" class="counter-btn" onclick="change(this, 1)" aria-label="Augmenter le nombre de personnes">+</button>
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
<script src="<?= BASE_URL ?>/js/commande.js"></script>
</body>
</html>