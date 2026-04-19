<header> 
            <div class="nav-bar">
            
                <div id="logo">
                <a href="/VG/index.php"> <img src='/VG/Images/Logo_bordeaux.svg' class="logo-img" alt='Logo VG'>
                <h1 class="short-logo"> VG </h1>
                <h1 class="long-logo">Vite & Gourmand</h1></a>
                </div>
                
                <nav class="nav-menu">
                    <button aria-label="Ouvrir le menu"  class="burger-btn"> ☰ </button>
                    <ul class="nav-list"> 
                        <li> <a href="/VG/index.php" class="<?php echo $activePage ==='Accueil' ? 'nav-active' : '' ;?>" >Accueil</a></li>
                        <li> <a href="/VG/Nosmenus.php" class="<?php echo $activePage ==='Nos Menus' ? 'nav-active' : '' ;?>">Nos Menus</a></li>
                        <li> <a href="/VG/Contact.php" class="<?php echo $activePage ==='Contact' ? 'nav-active' : '' ;?>" >Contact</a></li>

                        <?php if(isset($_SESSION['user_id'])) : ?>

                            <?php if($_SESSION['role'] === 'admin') : ?>
                                <li> <a href="/VG/espaceAdmin.php" class="<?php echo $activePage ==='Admin' ? 'nav-active' : '' ;?>">Espace Admin</a></li>
                                <li> <a href="/VG/espaceEmploye.php" class="<?php echo $activePage ==='Employé' ? 'nav-active' : '' ;?>">Espace Employé</a></li>

                            <?php elseif ($_SESSION['role'] === 'employe') : ?>
                                <li> <a href="/VG/espaceEmploye.php" class="<?php echo $activePage ==='Employé' ? 'nav-active' : '' ;?>">Espace Employé</a></li>

                            <?php else :?>
                                <li> <a href="/VG/espaceClient.php" class="<?php echo $activePage ==='Mon Compte' ? 'nav-active' : '' ;?>">Mon Compte</a></li>
                            <?php endif; ?>

                            <li> <a href="/VG/deconnexion.php" class="<?php echo $activePage ==='Déconnexion' ? 'nav-active' : '' ;?>">Déconnexion</a></li>

                        <?php  else: ?> 
                                <li> <a href="/VG/inscription.php" class="<?php echo $activePage ==='Inscription' ? 'nav-active' : '' ;?>">Inscription</a></li>
                                <li> <a href="/VG/Connexion.php" class="<?php echo $activePage ==='Connexion' ? 'nav-active' : '' ;?>" id="login">Connexion</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            
            </div>
            <script src="/VG/js/main.js"></script>
        </header>
        