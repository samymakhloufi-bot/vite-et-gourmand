<header> 
            <div class="nav-bar">
            
                <div id="logo">
                <a href="../index.php"> <img src='../Images/Logo_bordeaux.svg' class="logo-img" alt='Logo V&G'>
                <h1 class="short-logo"> V&G </h1>
                <h1 class="long-logo">Vite & Gourmand</h1></a>
                </div>
                
                <nav class="nav-menu">
                    <button aria-label="Ouvrir le menu"  class="burger-btn"> ☰ </button>
                    <ul class="nav-list"> 
                        <li> <a href="../index.php" class="<?php echo $activePage ==='accueil' ? 'nav-active' : '' ;?>" >Accueil</a></li>
                        <li> <a href="../Nosmenus.php" class="<?php echo $activePage ==='nos menus' ? 'nav-active' : '' ;?>">Nos Menus</a></li>
                        <li> <a href="../Contact.php" class="<?php echo $activePage ==='contact' ? 'nav-active' : '' ;?>" >Contact</a></li>
                        <li> <a href="../inscription.php" class="<?php echo $activePage ==='inscription' ? 'nav-active' : '' ;?>">Inscription</a></li>
                        <li> <a href="../Connexion.php" class="<?php echo $activePage ==='connexion' ? 'nav-active' : '' ;?>" id="login">Connexion</a></li>
                    </ul>
                </nav>
            
            </div>
            <script src="../js/main.js"></script>
        </header>
        