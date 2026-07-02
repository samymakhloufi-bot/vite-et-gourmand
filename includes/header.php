<header> 
    
            <div class="nav-bar">
            
                <div id="logo">
                <a href="<?= BASE_URL ?>/index.php"> <img src='<?= BASE_URL ?>/Images/Logo_bordeaux.svg' class="logo-img" alt='Logo Vite & Gourmand'>
                <span class="short-logo"> VG </span>
                <span class="long-logo">Vite & Gourmand</span></a>
                </div>
                
                <nav class="nav-menu">
                    <button aria-label="Ouvrir le menu"  class="burger-btn" aria-expanded="false" aria-controls="nav-list"> ☰ </button>
                    <ul class="nav-list"> 
                        <li> <a href="<?= BASE_URL ?>/index.php" class="<?php echo $activePage ==='Accueil' ? 'nav-active' : '' ;?>" >Accueil</a></li>
                        <li> <a href="<?= BASE_URL ?>/nos-menus.php" class="<?php echo $activePage ==='Nos Menus' ? 'nav-active' : '' ;?>">Nos Menus</a></li>
                        <li> <a href="<?= BASE_URL ?>/contact.php" class="<?php echo $activePage ==='Contact' ? 'nav-active' : '' ;?>" >Contact</a></li>

                        <?php if(isset($_SESSION['user_id'])) : ?>

                            <?php if($_SESSION['role'] === 'admin') : ?>
                                <li> <a href="<?= BASE_URL ?>/espace-admin.php" class="<?php echo $activePage ==='espace admin' ? 'nav-active' : '' ;?>">Espace Admin</a></li>

                            <?php elseif ($_SESSION['role'] === 'employe') : ?>
                                <li> <a href="<?= BASE_URL ?>/espace-employe.php" class="<?php echo $activePage ==='espace employe' ? 'nav-active' : '' ;?>">Espace Employé</a></li>

                            <?php else :?>
                                <li> <a href="<?= BASE_URL ?>/espace-client.php" class="<?php echo $activePage ==='espace client' ? 'nav-active' : '' ;?>">Mon Compte</a></li>
                            <?php endif; ?>

                            <li> <a href="<?= BASE_URL ?>/deconnexion.php" class="<?php echo $activePage ==='Déconnexion' ? 'nav-active' : '' ;?>">Déconnexion</a></li>

                        <?php  else: ?> 
                                <li> <a href="<?= BASE_URL ?>/inscription.php" class="<?php echo $activePage ==='Inscription' ? 'nav-active' : '' ;?>">Inscription</a></li>
                                <li> <a href="<?= BASE_URL ?>/connexion.php" class="<?php echo $activePage ==='Connexion' ? 'nav-active' : '' ;?>" id="login">Connexion</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            
            </div>
            <script src="<?= BASE_URL ?>/js/main.js"></script>
        </header>
        