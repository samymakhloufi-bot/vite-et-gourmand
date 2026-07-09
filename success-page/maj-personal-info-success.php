<?php $activePage = 'Inscription Succes'; 
require_once '../login.php'
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include '../includes/head.php'; ?>

    <body>
    <?php include '../includes/header.php'; ?>

    <main>
        
        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Bienvenue chez nous<em> & compte créé avec succès </em></h1></div>
        </div>

        <div class="succes-wrapper">

            <div class="succes-card">

                <div class="succes-icon">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M8 16 L13 21 L24 11" stroke="#F5F0E8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                    <h2>  !</h2>
                    <p>Votre compte a été créé avec succés. <br>
                    Vous pouvez maintenant vous connecter à votre compte.</p>
                    
                    <div class="succes-progress">
                        <div class="succes-progress-bar" id="bar"></div>
                    </div>
                    
                    <p class="succes-counter">Redirection dans <span id="compte-rebours">15</span> secondes</p>
                    
                    <div class="succes-btn">
                        <a href="connexion.php" class="btn-submit">Se connecter</a>
                        <a href="index.php" class="btn-outline">Retour à l'accueil</a>
                    </div>
            </div>
        </div>

    </main>

</body>

    <?php include '../includes/footer.php'; ?>

    <script src="../js/succes.js"></script>
</html>