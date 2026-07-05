<?php $activePage = 'Accueil'; 

require_once __DIR__ . '/login.php';
require_once __DIR__ . '/classes/Repository/MenuRepository.php';

$stmtAvis = $pdo -> prepare("SELECT a.contenu, a.note, u.nom, u.prenom
                            FROM avis a
                            JOIN users u ON a.Id_user = u.id_user
                            WHERE a.statut_avis ='valide'
                            ORDER BY a.note DESC, a.created_at DESC
                            LIMIT 3");
$stmtAvis -> execute();
$avis = $stmtAvis ->fetchAll();

?>
<!DOCTYPE html>

<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>
        
        <img src="./Images/baniere_pano.png" class="hero-banner" alt="Bannière Vite & Gourmand avec épices et ingrédients de cuisine">

        <main id="main-content" role="main">
            <div class="nos-menus-banner" id="banner-accueil">
                <div class="nos-menus-banner_diag"></div>
                <div class="nos-menus-banner_dark_diag"></div>
                <div class="nos-menus-banner_text">
                <h1>Bienvenue sur notre Site</h1></div>
            </div>
            <section class="history-box">
        
                <div class="card-gout"> 
                    <div class="card-img">
                        <div class="card-overlay-top"></div>
                        <div class="card-overlay-bottom"></div>
                        <div class="card-overlay-right"></div>
                        <picture class="img-gout">
                            <source media="(min-width:600px)" srcset="./Images/Goût.png">
                            <img src='Images/Goût.png' alt="Steak grillé">
                        </picture>
                    </div>
        
                    <div class="card-text">
                        <span>NOTRE ENGAGEMENT</span>
                        <h2> Le Goût de <em>l'excellence</em></h2>
                        <p> Nous travaillons exclusivement avec des producteurs locaux de Nouvelle-Aquitaine, Produits frais, circuits courts et menus faits maison, chaque jour.</p>
                    </div>
                </div>
            
                <div class="card-passion">
                    <div class="card-img"> 
                        <div class="card-overlay-top"></div>
                        <div class="card-overlay-bottom"></div>
                        <div class="card-overlay-right"></div>
                        <picture class="img-passion">
                            <source media="(min-width:600px)" srcset="./Images/Passion.png">
                            <img src='./Images/passion-min.png' alt='Julie et José, fondateurs de Vite & Gourmand'>
                        </picture>
                    </div>

                    <div class="card-text">
                        <span>NOTRE HISTOIRE</span>
                        <h2> 25 ans de<em>passion</em></h2>
                        <p> Fondé en 2011 par Julie et José, notre service traiteur cultive l'art de la réception à la bordelaise. Une histoire de famille dédiée au goût.</p>
                    </div>
                </div>

            </section>

            <h2> Nos Menus</h2>
        
            <section class="menu-grid-index">
            
                <article class="menu-card--light"> 
                    <picture>
                        <source media="(min-width:750px)" srcset="./Images/EclatF-max.png">
                        <img src="Images/EclatF-min.png" alt="Menu Éclats de Fêtes">
                    </picture>
                    <h3>Menus Éclats de Fêtes (classique):</h3>
                    <p>Le prestige des grands classiques de Noël sublimé par la truffe et le foie gras.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu-detail.php?id=EclatF" aria-label="Détails du Menu Éclats de Fêtes en détails">Détails du Menu</a>
                </article>

                <article class="menu-card--dark"> 
                    <picture>
                        <img src="./Images/<?= $menu->getImgMenuUrl() ?>" alt="<?= htmlspecialchars($menu->getNom()) ?>">
                    </picture>
                    <h3>Menus Renouveau (classique):</h3>
                    <p>La tradition pascale célébrée à travers la tendreté d'un agneau de sept heures.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu-detail.php?id=Renouveau" aria-label="Détails du Menu Renouveau en Détails">Détails du Menu</a>
                </article>

                <article class="menu-card--light"> 
                    <picture>
                        <source media="(min-width:750px)" srcset="./Images/AmourE-max.png">
                        <img src="Images/AmourE-min.png" alt="Menu Amour Éternel"> 
                    </picture>
                    <h3>Menus Amour Éternel (Vegan):</h3>
                    <p>Une célébration haute en couleurs et en saveurs pour un mariage éthique et chic.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu-detail.php?id=AmourE" aria-label="Détails Menu Amour Éternel en détails">Détails du Menu</a>
                </article>

            </section>

            <div class="div-index-to-menu"><a href="./nos-menus.php"  class="index-to-menus">Tous nos menus</a></div>

            <h2>Notre savoir-faire</h2>

            <section class="skills-section"> 

                <article class="skill-card"> 
                    <img src="Images/cooking.png" class="skill-icon" alt="Toque du chef">
                    <h3> Excellence Gastronomique</h3>
                    <p> Des créations artisanales mêlant tradition et modernité pour sublimer vos tables.</p>
                </article>

                <article class="skill-card"> 
                    <img src="Images/vegetable_bordeaux.png" class="skill-icon" alt="Panier de légume frais">
                    <h3> Produit du Terroir</h3>
                    <p> Une sélection rigoureuse de produits frais et locaux pour une saveur authentique.</p>
                </article>

                <article class="skill-card"> 
                    <img src="Images/truck_bordeaux.png" class="skill-icon" alt="Camion de livraison assurant notre ponctualité">
                    <h3> Service clé en Main</h3>
                    <p> Une logistique soignée et ponctuelle pour des réceptions en toute sérénité.</p>
                </article>

            </section>
            
            <section class="reviews-section">
                <h2> Ils nous ont fait confiance! <br>
                Pourquoi pas vous ?</h2>
                <div class="reviews-grid">
                    <?php foreach ($avis as $a):?>
                    <article class="review-card">
                        <div class="review-header">
                            <h3 class="review-author" aria-label="auteur de l'avis"><?= htmlspecialchars($a['prenom'])?><?=htmlspecialchars(substr($a['nom'], 0,1)) ?></h3> 
                            <p class="review-stars" aria-label="5 étoiles sur 5"><?= str_repeat('★', ($a['note'])). str_repeat('☆', 5 -$a['note'])?></p>
                        </div>
                        <p class="review-text" aria-label="avis"><?= htmlspecialchars($a['contenu']) ?></p>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

        </main>
    
        <?php include __DIR__.'/includes/footer.php' ; ?>
        <script src="<?= BASE_URL ?>/js/animation.js"></script>

    </body>
</html>
