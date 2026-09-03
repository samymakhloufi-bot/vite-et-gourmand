<?php 
require_once './login.php';
require_once __DIR__ . '/includes/password.php';
require_once __DIR__.'/classes/Repository/UserRepository.php';


$message = '';
$message_type = '';
$token_valide = false;
$token = $_GET['token'] ?? '';
$userRepository = new UserRepository($pdo);

if (!is_string($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) {
    $token = '';
} else {
    $user = $userRepository->findByResetToken($token);
    $token_valide = $user !== null;
}

if(isset($_POST['nouveau-mdp']) && $token_valide) {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $message = "Votre session a expiré, veuillez recommencer.";
        $message_type = 'erreur';
    } else {
    $mdp = $_POST['password'] ?? '';
    $mdp_confirm = $_POST['password-confirm'] ?? '';

    if (($passwordError = password_validation_error($mdp)) !== null) {
        $message = $passwordError;
        $message_type = 'erreur';
    } elseif ($mdp !== $mdp_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
        $message_type = 'erreur';
    } else {
        $mdp_hashed = password_hash($mdp, PASSWORD_DEFAULT);

        if ($userRepository->resetPassword($token, $mdp_hashed)) {
            header('Location: connexion.php?status=mdp-modifie');
            exit();
        }

        $token_valide = false;
        $message = "Ce lien est invalide ou expiré.";
        $message_type = 'erreur';
    }
    }
}

$activePage = 'Changement de mot de passe';
?>
<!DOCTYPE html>
    <html lang="fr">
        <?php include './includes/head.php';?>
    <body>
        <?php include './includes/header.php';?>
        <main>
            <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Nouveau <em>Mot de Passe </em></h1></div>
        </div>
            <section class="auth-wrapper">
                <div class="msg-password">
                    <?php if(!$token_valide):?>
                        <p class="message-erreur">Ce lien est invalide ou expiré : </br> <a href="reinitialisation-mdp.php" class="new_link"> Demander un nouveau lien.</a></p>
                        <?php else:?>
                        <form action="./modification-mdp.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <fieldset>
                                <legend>Réinitialisation Mot de passe</legend>
                                <?php if ($message) : ?>
                                    <p class="message-<?= $message_type?>" role="alert"><?= htmlspecialchars($message); ?></p>
                                <?php endif; ?>
                                <div class="reset-password-field"></div>
                                    <div class="first-password">
                                        <label for="password">Nouveau mot de passe</label>
                                        <input type="password" id="password" name="password" minlength="8"  autocomplete="new-password" required>
                                    </div>
                                        <div class="recall-password">
                                        <label for="password-confirm">Confirmez mot de passe</label>
                                        <input type="password" id="password-confirm" name="password-confirm" minlength="8" autocomplete="new-password" required>
                                    </div>
                                </div>
                                
                                <button type="submit" name="nouveau-mdp">Modifier le mot de passe</button>
                                
                            </fieldset>
                        </form>
                    <?php endif;?>
                </div>
            </section>
        </main>
        <?php include './includes/footer.php';?>
    </body>
</html>