<?php $activePage = 'réinitialisation mot de passe'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/index/head.php';?>
    
    <body>
        <?php include __DIR__.'/index/header.php';?>

        <main>
            <section class="auth-form">
                <form action="./account.php" method="post" class="reset-password-form">
                    <p>Mot de passe perdu ? Veuillez saisir votre adresse e-mail. Vous recevrez un lien par e-mail pour créer un nouveau mot de passe.</p>
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Veuillez saisir votre adresse mail">
                    <button type="submit" id="btn-reset-password" name="reset-password">Réinitialiser le mot de passe</button>
                </form>
                <a href="/vite-gourmand/Connexion.php">Retour à la page de Connexion</a>
            </section>
        </main>

        <?php include __DIR__.'/index/footer.php' ;?>

    </body>
</html>