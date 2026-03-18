<header> 
            <div class="nav-bar">
            
                <div id="logo">
                <a href="../index.php"> <img src='../Images/Logo_bordeaux.svg' class="logo-img" alt='Logo V&G'>
                <h1> V&G </h1></a>
                </div>
                
                <nav class="nav-menu">
                    <button aria-label="Ouvrir le menu"> <img src="../Images/menu.png" class="burger-btn"> </button>
                    <ul class="nav-list"> 
                        <li> <a href="../index.php" class="<?php echo $activePage ==='accueil' ? 'nav-active' : '' ;?>" >Accueil</a></li>
                        <li> <a href="../Nosmenus.php" class="<?php echo $activePage ==='nos menus' ? 'nav-active' : '' ;?>">Nos Menus</a></li>
                        <li> <a href="../Contact.php" class="<?php echo $activePage ==='contact' ? 'nav-active' : '' ;?>" >Contact</a></li>
                        <li> <a href="../Connexion.php" class="<?php echo $activePage ==='connexion' ? 'nav-active' : '' ;?>">Connexion</a></li>
                    </ul>
                </nav>
            
            </div>
        </header>
        