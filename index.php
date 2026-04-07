<?php $activePage = 'Accueil'; ?>
<!DOCTYPE html >

<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>
        
        <img src="./Images/baniere_pano.png" class="hero-banner" alt="épice">

        <main id="main-content" role="main">
        
            <section class="history-box">
        
                <div class="card-gout"> 
                    <div class="card-img">
                        <div class="card-overlay-top"></div>
                        <div class="card-overlay-bottom"></div>
                        <div class="card-overlay-right"></div>
                        <picture class="img-gout">
                            <source media="(min-width:600px)" srcset="./Images/Goût.png">
                            <img src='Images/Goût.png' alt='image d\'un steak'>
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
                            <img src='./Images/passion-min.png' alt='image des fondateurs'>
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
                        <img src="Images/EclatF-min.png" alt="Image du Menu Éclats de Fêtes">
                    </picture>
                    <h3>Menus Éclats de Fêtes (classique):</h3>
                    <p>Le prestige des grands classiques de Noël sublimé par la truffe et le foie gras.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu.php?id=EclatF">Détails du Menu</a>
                </article>

                <article class="menu-card--dark"> 
                    <picture>
                        <source media="(min-width:750px)" srcset="./Images/Renouveau-max.png">
                        <img src="Images/Renouveau-min.png" alt="Image du Menu Renouveau"> 
                    </picture>
                    <h3>Menus Renouveau (classique):</h3>
                    <p>La tradition pascale célébrée à travers la tendreté d'un agneau de sept heures.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu.php?id=Renouveau">Détails du Menu</a>
                </article>

                <article class="menu-card--light"> 
                    <picture>
                        <source media="(min-width:750px)" srcset="./Images/AmourE-max.png">
                        <img src="Images/AmourE-min.png" alt="Image du Menu Amour Éternel"> 
                    </picture>
                    <h3>Menus Amour Éternel (Vegan):</h3>
                    <p>Une célébration haute en couleurs et en saveurs pour un mariage éthique et chic.</p>
                    <span> À PARTIR DE 45,90€/ PERSONNE</span>
                    <a href="./data/menu.php?id=AmourE">Détails du Menu</a>
                </article>

            </section>

            <div class="div-index-to-menu"><a href="./Nosmenus.php"  class="index-to-menus">Tous nos menus</a></div>

            <h2>Notre savoir-faire</h2>

            <section class="skills-section"> 

                <article class="skill-card"> 
                    <img src="Images/cooking.png" class="skill-icon" alt="image d'une toque de chef">
                    <h3> Excellence Gastronomique</h3>
                    <p> Des créations artisanales mêlant tradition et modernité pour sublimer vos tables.</p>
                </article>

                <article class="skill-card"> 
                    <img src="Images/vegetable_bordeaux.png" class="skill-icon" alt="image d'un panier de légume">
                    <h3> Produit du Terroir</h3>
                    <p> Une sélection rigoureuse de produits frais et locaux pour une saveur authentique.</p>
                </article>

                <article class="skill-card"> 
                    <img src="Images/truck_bordeaux.png" class="skill-icon" alt="image d'un camion">
                    <h3> Service clé en Main</h3>
                    <p> Une logistique soignée et ponctuelle pour des réceptions en toute sérénité.</p>
                </article>

            </section>
            
            <section class="reviews-section">
                <h2> Ils nous ont fait confiance! <br>
                Pourquoi pas vous ?</h2>
                <div class="reviews-grid">
                    <article class="review-card">
                        <div class="review-header">
                            <h3 class="review-author" aria-label="auteur de l'avis">Orlane B.</h3> 
                            <p class="review-stars" aria-label="5 étoiles sur 5">★★★★★</p>
                        </div>
                        <p class="review-text" aria-label="avis">Prestation de Noël parfaite : plats délicieux, présentation élégante et service irréprochable, je recommande Vite & Gourmand les yeux fermés !</p>
                    </article>

                    <article class="review-card">
                        <div class="review-header">
                            <h3 class="review-author" aria-label="auteur de l'avis">Samy M.</h3> 
                            <p class="review-stars" aria-label="5 étoiles sur 5">★★★★★</p>
                        </div>
                        <p class="review-text" aria-label="avis">Menu de Pâques raffiné et savoureux, présentation magnifique et service impeccable — Vite & Gourmand a sublimé notre repas !</p>
                    </article>

                    <article class="review-card" id="review-last">
                        <div class="review-header">
                            <h3 class="review-author" aria-label="auteur de l'avis">Lana M.</h3> 
                            <p class="review-stars" aria-label="5 étoiles sur 5">★★★★★</p>
                        </div>
                        <p class="review-text" aria-label="avis">Menu de mariage réservé pour juin : dégustation exceptionnelle, équipe à l'écoute et très professionnelle, nous sommes ravis !</p>
                    </article>
                </div>
            </section>

        </main>
    
        <?php include __DIR__.'/includes/footer.php' ; ?>
        <script src="./js/animation.js"></script>

    </body>
</html>
