<?php $activePage = 'Connexion'; 
session_start();
require_once './login.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$message ='';

if (isset($_POST['se-connecter'])) {
    $email = trim($_POST['email-login']);
    $password = trim($_POST['password-login']);

    // Vérification de l'email
    $check = $pdo -> prepare("SELECT id_user, password, role FROM users WHERE email = ?");
    $check -> execute([$email]);
    $user = $check->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        session_start();
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];
        
        //remember me
        if (isset($_POST['remember-me'])) {
            $token = bin2hex(random_bytes(32));

            // Stocker le token dans la base de données
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id_user = ?");
            $stmt->execute([$token, $user['id_user']]);

            // Stocker le token dans un cookie pendant 30 jours
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), "/");
        }

        if ($user['role'] ==='admin') {
            header('Location: /VG/espaceAdmin.php');
        } elseif ($user['role'] ==='employe'){
            header('Location: /VG/espaceEmploye.php');
        } else {
            header('Location: /VG/index.php');
        }
        exit();
    } else {
        // Échec de la connexion
        $message = "Email ou mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Bon retour  <em> & connexion </em></h2></div>
        </div>

        <main>
            <section class="auth-wrapper">

                <div class="auth-form"> 
                    <form action="/VG/connexion.php" method="post" id="form-login">
                        <fieldset>
                            <h3>Se Connecter</h3>
                            <div class="auth-fields">
                                <label for="email-login">E-mail</label>
                                <input type="email" id="email-login" name="email-login" maxlength="255" placeholder="Saisissez votre e-mail" autocomplete="current-email">
                                <label for="password-login">Mot de passe</label>
                                <input type="password" id="password-login" name="password-login" maxlength="255" placeholder="Saisissez votre mdp" autocomplete="current-password">
                            </div>
                            <div class="erreur-div">
                                    <?php if ($message):?>
                                    <p class="message-erreur"><?php echo htmlspecialchars($message); ?></p>
                                    <?php endif; ?>
                                </div>
                            <div class="remember">
                                <input type="checkbox" id="remember-me" name="remember-me">
                                <label for="remember-me">Se souvenir de moi</label>
                            </div>
                            <div class="login">
                                <button type="submit" class="btn-submit" name="se-connecter">Se Connecter</button>
                                <a href="/VG/reinitialisationMDP.php">Mot de passe oublié ?</a>
                            </div>
                        </fieldset>
                    </form>
                
                </div>

            </section>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>

    </body>
</html>

