<?php $activePage = 'réinitialisation mot de passe'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>
        
        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Réinitialisation de votre <em> mot de passe </em></h2></div>
        </div>
        
        <main>
            <section class="auth-wrapper">
                <div class="auth-form">
                    <form action="./account.php" method="post" class="reset-password-form">
                        <fieldset>
                            <h3>Mot de passe perdu ? Veuillez saisir votre adresse e-mail. Vous recevrez un lien par e-mail pour créer un nouveau mot de passe.</h3>
                            <div class="auth-fields">
                                <label for="email">E-mail :</label>
                                <input type="email" id="email" name="email" placeholder="Veuillez saisir mail">
                            </div>                
                            <button type="submit" id="btn-reset" name="reset-password">Réinitialiser le mot de passe</button>
                            <a href="./Connexion.php">Retour à la Connexion</a>
                        </fieldset>
                    </form>
                </div>
            </section>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>

    </body>
</html>