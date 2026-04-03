<?php $activePage = 'connexion'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Bon retour  <em> & connexion </em></h2></div>
        </div>

        <main>
            <section class="auth-wrapper">

                <div class="auth-form"> 
                    <form action="./login.php" method="post" id="form-login">
                        <fieldset>
                            <h3>Se Connecter</h3>
                            <div class="auth-fields">
                                <label for="email-login">E-mail</label>
                                <input type="email" id="email-login" name="email-login" maxlength="30" placeholder="Saisissez votre e-mail" autocomplete="on">
                                <label for="password-login">Mot de passe</label>
                                <input type="password" id="password-login" name="password-login" maxlength="50" placeholder="Saisissez votre mdp" autocomplete="current-password">
                            </div>
                            <button type="submit" class="btn-submit" name="se-connecter">Se Connecter</button>
                            <a href="./reinitialisation-mdp.php">Mot de passe oublié ?</a>
                        </fieldset>
                    </form>
                
                </div>

            </section>
        </main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>

