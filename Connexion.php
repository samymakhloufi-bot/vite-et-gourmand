<?php $activePage = 'connexion'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>


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
                                <input type="password" id="password-login" name="password-login" maxlength="50" placeholder="Saisissez votre mot de passe">
                            </div>
                            <button type="submit" class="btn-submit" name="se-connecter">Se Connecter</button>
                            <a href="./reinitialisation-mdp.php">Mot de passe oublié ?</a>
                        </fieldset>
                    </form>
                </div>

                <div class="auth-form"> 
                    <form action="./account.php" method="post" id="form-inscription">
                        <fieldset>
                            <h3>S'inscrire</h3>
                            <div class="auth-fields">    
                                <label for="email-registration">E-mail</label>
                                <input type="email" id="email-registration" maxlength="30" name="email-registration" placeholder="Saisissez votre e-mail">
                                <label for="password-registration">Mot de passe</label>
                                <input type="password" id="password-registration" maxlength="16" name="password-registration" placeholder="Saisissez votre mot de passe">
                            </div>
                            <a href="./inscription.php" id="btn-vers-submit">S'inscrire</a>
                            
                        </fieldset>
                    </form>
                </div>

            </section>
        </main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>

