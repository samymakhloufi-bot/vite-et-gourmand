<header> 
    
            <div class="nav-bar">
            
                <div id="logo">
                <a href="<?= BASE_URL ?>/index.php"> <img src='<?= BASE_URL ?>/Images/Logo_bordeaux.svg' class="logo-img" alt='Logo VG'>
                <h1 class="short-logo"> VG </h1>
                <h1 class="long-logo">Vite & Gourmand</h1></a>
                </div>
                
                <nav class="nav-menu">
                    <button aria-label="Ouvrir le menu"  class="burger-btn"> ☰ </button>
                    <ul class="nav-list"> 
                        <li> <a href="<?= BASE_URL ?>/index.php" class="<?php echo $activePage ==='Accueil' ? 'nav-active' : '' ;?>" >Accueil</a></li>
                        <li> <a href="<?= BASE_URL ?>/nosmenus.php" class="<?php echo $activePage ==='Nos Menus' ? 'nav-active' : '' ;?>">Nos Menus</a></li>
                        <li> <a href="<?= BASE_URL ?>/contact.php" class="<?php echo $activePage ==='Contact' ? 'nav-active' : '' ;?>" >Contact</a></li>

                        <?php if(isset($_SESSION['user_id'])) : ?>

                            <?php if($_SESSION['role'] === 'admin') : ?>
                                <li> <a href="<?= BASE_URL ?>/espaceAdmin.php" class="<?php echo $activePage ==='espace admin' ? 'nav-active' : '' ;?>">Espace Admin</a></li>
                                <li> <a href="<?= BASE_URL ?>/espaceEmploye.php" class="<?php echo $activePage ==='espace employe' ? 'nav-active' : '' ;?>">Espace Employé</a></li>

                            <?php elseif ($_SESSION['role'] === 'employe') : ?>
                                <li> <a href="<?= BASE_URL ?>/espaceEmploye.php" class="<?php echo $activePage ==='espace employe' ? 'nav-active' : '' ;?>">Espace Employé</a></li>

                            <?php else :?>
                                <li> <a href="<?= BASE_URL ?>/espaceClient.php" class="<?php echo $activePage ==='espace client' ? 'nav-active' : '' ;?>">Mon Compte</a></li>
                            <?php endif; ?>

                            <li> <a href="<?= BASE_URL ?>/deconnexion.php" class="<?php echo $activePage ==='Déconnexion' ? 'nav-active' : '' ;?>">Déconnexion</a></li>

                        <?php  else: ?> 
                                <li> <a href="<?= BASE_URL ?>/inscription.php" class="<?php echo $activePage ==='Inscription' ? 'nav-active' : '' ;?>">Inscription</a></li>
                                <li> <a href="<?= BASE_URL ?>/connexion.php" class="<?php echo $activePage ==='Connexion' ? 'nav-active' : '' ;?>" id="login">Connexion</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            
            </div>

            <div id="cookie-overlay" class="cookie-overlay">
                <div class="cookie-banner">
                    <p>
                        <strong> Cookies & confidentialité</strong><br>
                        Ce site utilise Google Maps pour le calcul des frais de livraison, 
                        ce qui implique un transfert de données vers les serveurs Google. 
                        <a href="<?= BASE_URL ?>/confidentialite.php" target="_blank">En savoir plus</a>
                    </p>
                    <div class="cookie-buttons">
                        <button id="refuse-cookies" class="btn-cookie-refuse">Refuser</button>
                        <button id="accept-cookies" class="btn-cookie-accept">Accepter</button>
                    </div>
                </div>
            </div>
            <script src="<?= BASE_URL ?>/js/main.js"></script>
        </header>
        