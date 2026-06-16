<?php 
$activePage = 'Nos Menus';
require_once __DIR__ . '/login.php';
require_once __DIR__ . '/classes/Repository/MenuRepository.php';

$menuRepository = new MenuRepository($pdo);
$menus = $menuRepository->findAll();
$nb_pers = 0;
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
    <main>
        <h1 class="hidden-h1">Nos menus et formules</h1>
        <div class="page-menu-wrapper">

            <section class="filters-sidebar">
                <button type="button" class="filter-toggle" id="filter-toggle" aria-label="Afficher les filtres">FILTRES
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
                        <label for="regime">RÉGIME</label>
                        <button type="button" class="tag on" data-value="">Tous</button>
                        <button type="button" class="tag" data-value="non-vegan">Non-Vegan</button>
                        <button type="button" class="tag" data-value="vegan">Vegan</button>
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
                    data-regime="<?= htmlspecialchars($menu->getRegime()) ?>"
                    data-theme="<?= htmlspecialchars($menu->getTheme()) ?>"
                    data-prix="<?= $menu->getPrix() ?>"
                    data-nb-max="<?= $menu->getNbPersoMin() ?>">
                                
                    <picture>
                        <source media="(min-width:750px)" srcset="./Images/<?= $menu->getImgDesktop() ?>.png">
                        <img src="./Images/img/<?= $menu->getImgMobile() ?>.png" alt="<?= htmlspecialchars($menu->getNom()) ?>">
                    </picture>
                                
                    <div class="info-menu">
                        <h3><?= htmlspecialchars($menu->getNom()) ?></h3>
                        <span><?= $menu->getTheme() ?> - <?= $menu->getRegime() ?></span>
                        <span><?= $menu->getPrix() ?> €/PERS.</span>
                        <span><?= $menu->getNbPersoMin() ?> PERS./min</span>
                    </div>
                                
                    <div>
                        <form action="./achat.php" method="POST">
                            <input type="hidden" name="menu_id" value="<?= $menu->getId() ?>">
                            <input type="hidden" name="menu_nom" value="<?= htmlspecialchars($menu->getNom()) ?>">
                            <input type="hidden" name="nb_pers" value="<?= $nb_pers ?>">
                                
                            <div class="menu-card-footer">
                                <div class="nb-person">
                                    <span>NB.<br>PERSONNES</span>
                                    <div class="input-nb-person">
                                        <button type="button" class="counter-btn" onclick="change(this, -1)" aria-label="Diminuer le nombre de personnes">-</button>
                                        <input type="number" class="counter-val" name="nb_pers" value="1" min="<?= $menu->getNbPersoMin() ?>">
                                        <button type="button" class="counter-btn" onclick="change(this, 1)" aria-label="Augmenter le nombre de personnes">+</button>
                                    </div>
                                </div>
                                <div class="btn-footer-card-menu">
                                    <button type="submit" class="btn-direct-order">Commander</button>
                                    <a href="./data/menu-detail.php?id=<?= $menu->getLink() ?>" class="btn-details">Détails</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </article>
                <?php endforeach; ?>
            </section>
            </div>
    </main> 
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="./js/commande.js"></script>
    <script src="./js/filtre.js"></script>
    </body>
</html>