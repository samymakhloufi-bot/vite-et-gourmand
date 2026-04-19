<?php 
require_once './login.php';

$message = '';
$message_type = '';
$token_valide = false;
$token = $_GET['token'] ?? '';
if($token) {
    $stmt = $pdo -> prepare("SELECT id_user FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt ->execute([$token]);
    $stmt-> $check->fetch();
    if($check){
        $token_valide = true;
    };
}

if(isset($_POST['nouveau-mdp']) && $token_valide) {
    $mdp = $_POST['password'];
    $mdp_confirm = $_PPOST['password-confirm'];

    if(strlen($mdp) < 8){
        $message = "Le mot de passe doit contenir au moins 8 caractères.";
        $message_type = 'erreur';
    } elseif ($mdp !== $mdp_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
        $message_type = 'erreur';
    } else {
        $mdp_hashed = password_hash($mdp, PASSWORD_DEFAULT);
        $stmt = $pdo -> prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
        $stmt -> execute([$mdp_hashed, $token]);
        header('Location: Connexion.php?status=mdp-modifie');
        exit();
    }
}

$activePage = 'Changement de mot de passe';
?>
<!DOCTYPE html>
    <html lang="en">
        <?php include './includes/head.php';?>
    <body>
        <?php include './includes/header.php';?>
        <main>
            <section class="auth-wrapper">
                <div class="auth-form">
                    <?php if(!$token_valide):?>
                        <p class="message-erreur">Ce lien est invalide ou expiré. <a href="reinitialisation.php">Demander un nouveau lien</a></p>
                    <?php else:?>
                        <form action="./modificationMDP.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
                            <fieldset>
                                <h3>Nouveau Mot de Passe</h3>
                                <?php if ($message) : ?>
                                    <p class="message-<?= $message_type?>"><?= htmlspecialchars($message); ?></p>
                                <?php endif; ?>
                                <div class="auth-fields"></div>
                                    <label for="password">Nouveau mot de passe</label>
                                    <input type="password" id="password" name="password" minlenght="8" required>
                                    <label for="password-confirm">Confirmez le mot de passe</label>
                                    <input type="password" id="password-confirm" name="password-confirm" minlenght="8" required>
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