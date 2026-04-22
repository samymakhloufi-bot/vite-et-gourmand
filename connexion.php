<?php $activePage = 'Connexion'; 
require_once __DIR__.'/login.php';

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
            $redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? 'index.php';
            header('Location: /VG/'.$redirect);
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
                        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? ''); ?>">
                        <fieldset>
                            <h3>Se Connecter</h3>
                            <div class="auth-fields">
                                <label for="email-login">E-mail</label>
                                <input type="email" id="email-login" name="email-login" maxlength="255" placeholder="Saisissez votre e-mail" autocomplete="current-email">
                                <label for="password-login">Mot de passe</label>
                                
                                <div class="password-wrapper">
                                    <input type="password" id="password-login" name="password-login" maxlength="255" placeholder="*****" autocomplete="current-password">
                                    <button type="button" id="toggle-password" class="btn-eye">
                                        <!-- Oeil ouvert -->
                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                            <line x1="1" y1="1" x2="23" y2="23"/>
                                        </svg>
                                    </button>
                                    <script>
                                        const togglePassword = document.querySelector('#toggle-password');
                                        const passwordInput  = document.querySelector('#password-login');

                                        togglePassword.addEventListener('click', () => {
                                            const isPassword = passwordInput.type === 'password';
                                            passwordInput.type = isPassword ? 'text' : 'password';
                                            togglePassword.classList.toggle('active');

                                            // Change l'icône selon l'état
                                                document.querySelector('#eye-icon').innerHTML = isPassword
                                                ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>`
                                                :`<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                                <line x1="1" y1="1" x2="23" y2="23"/>`;
                                        });
                                    </script>
                                </div>
                                
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
                                <a class="btn-forget" href="/VG/reinitialisationMDP.php">Mot de passe oublié ?</a>
                            </div>
                        </fieldset>
                    </form>
                
                </div>

            </section>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>

    </body>
</html>

