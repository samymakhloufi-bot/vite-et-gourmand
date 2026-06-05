<?php 
require_once './login.php';
require_once './vendor/autoload.php';

$message = "";
$activePage = 'Inscription'; 

        // validation des données d'inscription
        if (isset($_POST['inscription'])) {
            $name = trim($_POST['name']);
            $firstname = trim($_POST['firstname']);
            $phone = trim($_POST['tel']);
            $address = trim($_POST['address']);
            $city = trim($_POST['city']);
            $postal_code = trim($_POST['postal_code']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);


            // Vérification de l'email
            $check = $pdo -> prepare("SELECT id_user FROM users WHERE email = ?");
            $check -> execute([$email]);
            if($check->fetch()){
                $message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
            } else {
        

            // Hashage du mot de passe
            $mdp_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertion des données dans la base de données
            $stmt = $pdo -> prepare ("INSERT INTO users (nom, prenom, tel , adresse, ville, code_postal, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt -> execute([$name, $firstname, $phone, $address, $city, $postal_code, $email, $mdp_hashed]);
            // Mail de bienvenue
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
            $mail->Subject = 'Bievenue chez Vite&Gourmand';
            $mail->isHTML(true);
            $mail->Body ="<p>Bonjour et bienvenu à Vite&Gourmand, n'hésitez à aller découvrir nos recettes faites maison. 
                        Prendre contact avec nous pour un futur et heureux événements, nous serons ravies de vous accompagner.
                        <a href='https://vite-et-gourmand-samy.alwaysdata.net/index.php'>A très bientôt</a>.</p>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <img src='https://vite-et-gourmand-samy.alwaysdata.net/Images/Logo_bordeaux.svg' alt='Logo' width='80'>
                            <h1 style='font-family: Georgia, serif; color: #7D241A; font-size: 2rem; margin: 5px 0;'>VG</h1>
                            <p style='font-family: Arial, sans-serif; color: #7D241A; margin: 0;'>Vite & Gourmand</p>
                        </div> " ;
            $mail-> send();
                        } catch(Exception $e){}
            header('Location: inscriptionSucces.php');
            exit();
            }};
            
            
?>

<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Rejoignez-nous  <em> & créez votre compte </em></h2></div>
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
                                <input type="tel" id="tel" name="tel" required>
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
                                <input type="text" id="postal_code" name="postal_code" required>
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
