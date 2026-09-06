<?php

require_once __DIR__ . '/login.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/Repository/UserRepository.php';
require_once __DIR__ . '/includes/password.php';

$message = '';
$activePage = 'Inscription';

$userRepository = new UserRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription'])) {

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $message = 'Votre session a expiré, veuillez réessayer.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $firstname = trim($_POST['firstname'] ?? '');
        $phone = trim($_POST['tel'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password-confirm'] ?? '';

        if (
            $name === '' ||
            $firstname === '' ||
            $phone === '' ||
            $address === '' ||
            $city === '' ||
            $postalCode === '' ||
            $email === '' ||
            $password === ''
        ) {
            $message = 'Veuillez remplir tous les champs.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Veuillez saisir une adresse e-mail valide.';
        } elseif (($passwordError = password_validation_error($password)) !== null) {
            $message = $passwordError;
        } elseif ($password !== $passwordConfirm) {
            $message = 'Les mots de passe ne correspondent pas.';
        } elseif ($userRepository->emailExists($email)) {
            $message = 'Cette adresse e-mail est déjà utilisée.';
        } else {
            // Token brut envoyé dans l’e-mail.
            $token = bin2hex(random_bytes(32));

            // Le mot de passe est haché avant son stockage.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $userRepository->create(
                    $name,
                    $firstname,
                    $phone,
                    $address,
                    $city,
                    $postalCode,
                    $email,
                    $hashedPassword,
                    $token
                );

                $confirmationLink =
                    rtrim(BASE_URL, '/') .
                    '/confirmation-inscription.php?token=' .
                    urlencode($token);

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'samymakhloufi@gmail.com';
                $mail->Password = MAIL_PASS;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom(
                    'samymakhloufi@gmail.com',
                    'Vite & Gourmand'
                );

                $mail->addAddress(
                    $email,
                    $firstname . ' ' . $name
                );

                $safeFirstname = htmlspecialchars(
                    $firstname,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $safeConfirmationLink = htmlspecialchars(
                    $confirmationLink,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $mail->Subject =
                    'Confirmez votre inscription chez Vite & Gourmand';

                $mail->isHTML(true);

                $mail->Body = "
                    <div style='font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                                max-width: 600px;
                                margin: 0 auto;'>

                        <h2 style='color: #7D241A;'>
                            Bonjour {$safeFirstname},
                        </h2>

                        <p>
                            Votre pré-inscription chez
                            <strong>Vite & Gourmand</strong>
                            a bien été enregistrée.
                        </p>

                        <p>
                            Cliquez sur le bouton suivant pour confirmer
                            votre adresse e-mail et activer votre compte :
                        </p>

                        <p style='text-align: center; margin: 30px 0;'>
                            <a href='{$safeConfirmationLink}'
                               style='background: #7D241A;
                                      color: white;
                                      padding: 12px 22px;
                                      border-radius: 5px;
                                      text-decoration: none;'>
                                Confirmer mon inscription
                            </a>
                        </p>

                        <p>
                            Ce lien est valable pendant
                            <strong>24 heures</strong>
                            et ne peut être utilisé qu'une seule fois.
                        </p>

                        <p>
                            Si vous n'êtes pas à l'origine de cette demande,
                            vous pouvez ignorer cet e-mail.
                        </p>

                        <p>
                            Cordialement,<br>
                            <strong>L'équipe Vite & Gourmand</strong>
                        </p>
                    </div>
                ";

                $mail->AltBody =
                    "Confirmez votre inscription : {$confirmationLink} " .
                    "(lien valable pendant 24 heures).";

                $mail->send();

                header(
                    'Location: ' .
                    BASE_URL .
                    '/success-page/inscription-succes.php'
                );
                exit;
            } catch (Throwable $e) {
                error_log(
                    'Erreur inscription : ' . $e->getMessage()
                );

                $message =
                    "Impossible de terminer l'inscription pour le moment.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h1>Rejoignez-nous  <em> & créez votre compte </em></h1></div>
        </div>

        <main>
            
            <div class="sub-wrapper">
                
                <section class="contact-form">
                    
                    <form action="" method="post" id="form-inscription">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <fieldset>
                            <h3>Inscription</h3>
                            <?php if ($message) : ?>
                                <p class="message-erreur" role="alert"><?= htmlspecialchars($message) ?></p>
                            <?php endif; ?>
                            <div>
                                <label for="name">Nom :</label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div>
                                <label for="firstname">Prénom :</label>
                                <input type="text" id="firstname" name="firstname" required>
                            </div>

                            <div>
                                <label for="tel">Téléphone :</label>
                                <input type="tel" id="tel" name="tel" required maxlength="20">
                            </div>
                            
                            <div>
                                <label for="address">Adresse :</label>
                                <input type="text" id="address" name="address" required>
                            </div>
        
                            <div>
                                <label for="city">Ville :</label>
                                <input type="text" id="city" name="city" required>   </div>
                
                            <div>
                                <label for="postal_code">Code Postal :</label>
                                <input type="text" id="postal_code" name="postal_code" required maxlength="5" >
                            </div>
                        
                            <div>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required>
                            </div>
        
                            <div>
                                <label for="password">Mot de passe :</label>
                                <div class="password-wrapper-sub">
                                    <input type="password" id="password" name="password" minlength="10" maxlength="255" autocomplete="new-password" required>
                                    
                                        <button type="button" id="toggle-password" class="btn-eye">
                                            <!-- Oeil ouvert -->
                                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                                <line x1="1" y1="1" x2="23" y2="23"/>
                                            </svg>
                                        </button>
                                        
                                </div>
                            </div>

                            <div>
                                <label for="password-confirm">Confirmez le mot de passe :</label>
                                <input type="password" id="password-confirm" name="password-confirm" minlength="10" maxlength="255" autocomplete="new-password" required>
                            </div>

                            

                            <button type="submit" class="btn-submit" name="inscription" >S'inscrire</button>
                        </fieldset>
                    </form>

                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/password.js"></script>

    </body>
</html>