<?php $activePage = 'Inscription Succes'; 
require_once '../login.php'
?>
<!DOCTYPE html>
<html lang="en">
    <?php include '../includes/head.php'; ?>

    <body>
    <?php include '../includes/header.php'; ?>

    <main>
        
        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Merci pour<em> votre commande </em></h1></div>
        </div>

        <div class="succes-wrapper">

            <div class="succes-card">

                <div class="succes-icon">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M8 16 L13 21 L24 11" stroke="#F5F0E8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                    <h2>Votre commande a bien été pris en compte !</h2>
                    <p>Vous recevrez un mail de confirmation, <br>
                    lorsque votre commande sera validé par notre équipe.</p>
                    
                    <div class="succes-progress">
                        <div class="succes-progress-bar" id="bar"></div>
                    </div>
                    
                    <p class="succes-counter">Redirection dans <span id="compte-rebours">15</span> secondes</p>
                    
                    <div class="succes-btn">
                        <a href="<?= BASE_URL?>/index.php" class="btn-outline">Retour à l'accueil</a>
                    </div>
            </div>
        </div>

    </main>
    
    <script>

        // Compte à rebours
        let tempsRestant = 15;
        const compteRebours = document.getElementById('compte-rebours');

        const interval = setInterval(() => {
            tempsRestant--;
            compteRebours.textContent = tempsRestant;

            if (tempsRestant <= 0) {
                clearInterval(interval);
                window.location.href = '../espace-client.php';
            }
        },1000);
    </script>

</body>

    <?php include '../includes/footer.php'; ?>
</html>