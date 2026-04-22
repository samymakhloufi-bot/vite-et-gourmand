<?php $activePage = 'Réinitialisation de votre Mot de Passe'; 
require_once __DIR__.'/login.php';

$message = '';
$message_type = '';

if(isset($_POST['reset-password'])) {
    $email = trim($_POST['email']);

    $check = $pdo -> prepare("SELECT id_user FROM users WHERE email = ? AND actif = 1");
    $check -> execute([$email]);
    $user = $check-> fetch();
    
    if($user){
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', time() + 3600);

        $stmt = $pdo -> prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id_user = ?");
        $stmt -> execute([$token, $expiry, $user['id_user']]);

        require_once './vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host  ='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'samymakhloufi@gmail.com';
            $mail->Password = 'hocmmjyvvvnuovkd';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('samymakhloufi@gmail.com', 'Vite et Gourmand');
            $mail->addAddress($email);
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $reset_link = "http://localhost/V%26G/modificationMDP.php?token=". $token;
            $mail->isHTML(true);
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
            $message = "Erreur lors de l'envoi de l'email : ";
            $message_type = 'erreur';
        }
    } else {
        $message = "Si ce mail existe, vous recevrez les instructions pour réinitialiser votre mot de passe.";
        $message_type = "success";
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
            <h2>Réinitialisation de votre <em> mot de passe </em></h2></div>
        </div>
        
        <main>
            <section class="auth-wrapper">
                <div class="auth-form">
                    <form action="./reinitialisationMDP.php" method="post" class="reset-password-form">
                        <fieldset>
                            <h3>Mot de passe perdu ? Veuillez saisir votre adresse e-mail. Vous recevrez un lien par e-mail pour créer un nouveau mot de passe.</h3>
                            <div class="auth-fields">
                                <label for="email">E-mail :</label>
                                <input type="email" id="email" name="email" placeholder="Veuillez saisir votre mail">
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