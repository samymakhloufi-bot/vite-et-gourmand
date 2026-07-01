<?php 
require_once './login.php';
require_once './vendor/autoload.php';
require_once './classes/Repository/UserRepository.php';

$message = "";
$activePage = 'Inscription';
$userRepository = new UserRepository($pdo);

if (isset($_POST['inscription'])) {
    $name        = trim($_POST['name']);
    $firstname   = trim($_POST['firstname']);
    $phone       = trim($_POST['tel']);
    $address     = trim($_POST['address']);
    $city        = trim($_POST['city']);
    $postal_code = trim($_POST['postal_code']);
    $email       = trim($_POST['email']);
    $password    = trim($_POST['password']);

    if ($userRepository->emailExists($email)) {
        $message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $mdp_hashed = password_hash($password, PASSWORD_DEFAULT);
        $userRepository->create($name, $firstname, $phone, $address, $city, $postal_code, $email, $mdp_hashed);

        // Mail de bienvenue
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'samymakhloufi@gmail.com';
            $mail->Password   = MAIL_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->setFrom('samymakhloufi@gmail.com', 'Vite et Gourmand');
            $mail->addAddress($email);
            $mail->Subject = 'Bienvenue chez Vite&Gourmand 🍽️ Votre compte est activé';
            $mail->isHTML(true);
            $mail->Body = "<div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto;'>
        <h2 style='color: #d9534f;'>Bonjour " . htmlspecialchars($firstname) . ",</h2>
        <p>Toute l'équipe de <strong>Vite & Gourmand</strong> est ravie de vous compter parmi ses nouveaux clients ! Votre compte a bien été créé avec succès.</p>
        <p>Que ce soit pour un déjeuner sur le pouce, un repas de famille ou un événement professionnel, nous mettons tout en œuvre pour vous régaler avec des plats savoureux, cuisinés avec soin et livrés en un clin d'œil.</p>
        
        <h3 style='color: #5bc0de;'>🚀 Vos avantages en un coup d'œil :</h3>
        <ul>
            <li><strong>Commandes simplifiées :</strong> Enregistrez vos adresses et vos préférences pour commander encore plus vite.</li>
            <li><strong>Historique clair :</strong> Retrouvez toutes vos factures et vos anciens menus en un clic.</li>
            <li><strong>Offres exclusives :</strong> Soyez le premier informé de nos nouvelles cartes saisonnières et de nos promotions.</li>
        </ul>
        
        <h3 style='color: #f0ad4e;'>🎁 Un petit cadeau de bienvenue</h3>
        <p>Pour fêter votre arrivée, profitez de <strong>10% de réduction</strong> sur votre toute première commande avec le code : <strong style='font-size: 1.2em; color: #d9534f;'>BIENVENUE10</strong> <em>(valable pendant 30 jours)</em>.</p>
        
        <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
        
        <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #5bc0de; margin-bottom: 20px;'>
            <strong>Besoin d'aide ou d'un devis sur-mesure ?</strong><br>
            Notre équipe reste à votre entière disposition pour adapter nos menus à vos envies ou vos contraintes alimentaires. N'hésitez pas à nous contacter directement depuis votre espace client.
        </div>
        
        <p>À très vite pour votre prochaine dégustation !</p>
        <p><strong>L'équipe de Vite & Gourmand</strong><br>
        <a href='https://www.viteetgourmand.fr' style='color: #d9534f; text-decoration: none;'>Visiter notre application</a></p>
    </div>
    ";
            $mail->send();
        } catch (Exception $e) {}

        header('Location: '. BASE_URL .'/success-page/inscription-succes.php');
        exit();
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
                        <fieldset>
                            <h3>Inscription</h3>
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
                                <?php if ($message) : ?>
                                <p class="message-erreur"><?php echo htmlspecialchars($message); ?></p>
                                <?php endif; ?>
                            </div>
                        
                            <div>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required>
                            </div>
        
                            <div>
                                <label for="password">Mot de passe :</label>
                                <div class="password-wrapper-sub">
                                    <input type="password" id="password" name="password" required >
                                    
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
