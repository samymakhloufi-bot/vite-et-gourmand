<?php $activePage = 'Réinitialisation de votre Mot de Passe'; 
require_once __DIR__.'/login.php';
require_once __DIR__.'/classes/Repository/UserRepository.php';

$userRepository = new UserRepository($pdo);
$message = '';
$message_type = '';

if(isset($_POST['reset-password'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $message = "Votre session a expiré, veuillez réessayer.";
        $message_type = 'erreur';
    } else {
        $email = trim($_POST['email'] ?? '');
        $user = filter_var($email, FILTER_VALIDATE_EMAIL)
            ? $userRepository->findByEmail($email)
            : null;

        if ($user && $user->getActif()) {
            $token = bin2hex(random_bytes(32));
            $userRepository->updateResetToken($user->getId(), $token);

        require_once './vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host  ='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'samymakhloufi@gmail.com';
            $mail->Password = MAIL_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('samymakhloufi@gmail.com', 'Vite et Gourmand');
            $mail->addAddress($email);
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $reset_link = BASE_URL . '/modification-mdp.php?token=' . urlencode($token);$mail->isHTML(true);
            $mail->Body ="
                <p>Bonjour,</p>
                <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
                <p><a href='$reset_link' style='background:#7D241A;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;'>Réinitialiser mon mot de passe</a></p>
                <p>Ce lien expire dans <strong>1 heure</strong>.</p>
                <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>";

            $mail->send();
            $message = "Un email de réinitialisation a été envoyé à votre adresse.";
            $message_type = 'success';
            } catch (Exception $e) {
                error_log('Erreur envoi réinitialisation : '. $mail->ErrorInfo);
            }
    } else {
        $message = "Si ce mail existe, vous recevrez les instructions pour réinitialiser votre mot de passe.";
        $message_type = "success";
    }
    }   
}
?>
<!DOCTYPE html>
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>
        
        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Réinitialisation de votre <em> mot de passe </em></h1></div>
        </div>
        
        <main>
            <section class="auth-wrapper">
                <div class="auth-form">
                    <form action="./reinitialisation-mdp.php" method="post" class="reset-password-form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <fieldset>
                            <h3>Vous recevrez un lien par e-mail pour créer un nouveau mot de passe.</h3>
                            <?php if ($message) : ?>
                            <p class="message-<?= htmlspecialchars($message_type) ?>" role="alert">
                                <?= htmlspecialchars($message) ?>
                            </p>
                        <?php endif; ?>
                            <div class="auth-fields">
                                <label for="email">E-mail :</label>
                                <input type="email" id="email" name="email" placeholder="Veuillez saisir votre mail" required>
                            </div>                
                            <button type="submit" id="btn-reset" name="reset-password">Réinitialiser le mot de passe</button>
                            <a href="./connexion.php" id="return" >Retour à la Connexion</a>
                        </fieldset>
                    </form>
                </div>
            </section>
        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>

    </body>
</html>