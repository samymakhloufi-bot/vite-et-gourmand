<?php 
$activePage = 'Nos Menus';
require_once __DIR__ . '/login.php';
$stmt = $pdo->query("SELECT * FROM menu ORDER BY menu_nom ASC");
$menus = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="nos-menus-banner">
    <div class="nos-menus-banner_diag"></div>
    <div class="nos-menus-banner_dark_diag"></div>
    <div class="nos-menus-banner_text">
        <h2>Nos menus <em>& formules</em></h2>
    </div>
</div>

<div class="page-menu-wrapper">

    <section class="filters-sidebar">
        <button class="filter-toggle" id="filter-toggle" aria-label="Afficher les filtres">FILTRES
            <span class="toggle-chevron">></span>
        </button>
        <div class="sidebar-wrapper">
            <div class="filter-name">
                <h3>Filtres</h3>
                <button type="button" class="filter-reset">Réinitialiser</button>
            </div>
            <div class="filter">
                <label for="select-theme">THÈME</label>
                <select name="theme" id="select-theme">
                    <option value="">Tous les Thèmes</option>
                    <option value="noel">Noël</option>
                    <option value="paque">Pâques</option>
                    <option value="mariage">Mariage</option>
                    <option value="seminaire">Séminaire</option>
                </select>
            </div>
            <div class="filter" id="tags-regime">
                <label>RÉGIME</label>
                <button class="tag on" data-value="">Tous</button>
                <button class="tag" data-value="non-vegan">Non-Vegan</button>
                <button class="tag" data-value="vegan">Vegan</button>
            </div>
            <div class="filter">
                <label for="select-nb-personnes">NOMBRE DE PERSONNES</label>
                <input type="number" class="counter-val" name="nb-personnes" id="select-nb-personnes" placeholder="Ex. 10">
            </div>
            <div class="filter">
                <label for="select-prix">PRIX MAX. (€/pers)</label>
                <input type="number" class="counter-val" name="prix-max" id="select-prix" placeholder="Ex. 50">
            </div>
            <div class="filter">
                <label for="select-price-fork">Budget</label>
                <select name="theme" id="select-price-fork">
                    <option value="">Tous les budgets</option>
                    <option value="[20,30]">20 - 30</option>
                    <option value="[30,40]">30 - 40</option>
                    <option value="[40,50]">40 - 50</option>
                    <option value="[50,100]">+ 50</option>
                </select>
            </div>
        </div>
    </section>

    <section class="menu-grid">
        <?php foreach ($menus as $menu): ?>
        <article class="menu-card"
            data-regime="<?= htmlspecialchars($menu['regime']) ?>"
            data-theme="<?= htmlspecialchars($menu['theme']) ?>"
            data-prix="<?= $menu['prix'] ?>"
            data-nb-max="<?= $menu['nb_perso_max'] ?>">

            <picture>
                <source media="(min-width:750px)" srcset="./Images/<?= $menu['img_desktop'] ?>.png">
                <img src="./Images/img/<?= $menu['img_mobile'] ?>.png" alt="<?= htmlspecialchars($menu['menu_nom']) ?>">
            </picture>

            <div class="info-menu">
                <h3><?= htmlspecialchars($menu['menu_nom']) ?></h3>
                <span><?= $menu['theme'] ?> - <?= $menu['regime'] ?></span>
                <span><?= $menu['prix'] ?> €/PERS.</span>
            </div>

            <div>
                <form action="./commande.php" method="POST">
                    <input type="hidden" name="menu_id"    value="<?= $menu_id ?>">
                    <input type="hidden" name="menu_name"  value="<?= htmlspecialchars($menu_name) ?>">
                    <input type="hidden" name="menu_prix"  value="<?= $menu_prix ?>">
                    <input type="hidden" name="nb_pers" value="<?= $nb_pers ?>">

                    <div class="menu-card-footer">
                        <div class="nb-person">
                            <span>NB.<br>PERSONNES</span>
                            <button type="button" class="counter-btn" onclick="change(this, -1)">-</button>
                            <input type="number" class="counter-val" name="nb_pers" value="1" min="1">
                            <button type="button" class="counter-btn" onclick="change(this, 1)">+</button>
                        </div>
                        <div class="btn-footer-card-menu">
                            <button type="submit" class="btn-direct-order">Commander</button>
                            <a href="./data/menu.php?id=<?= $menu['link'] ?>" class="btn-details">Détails</a>
                        </div>
                    </div>
                </form>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="./js/commande.js"></script>
<script src="./js/filtre.js"></script>
</body>
</html>