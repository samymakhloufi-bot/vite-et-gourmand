<?php require_once './login.php';

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
            header('Location: inscriptionSucces.php');
            exit();
            }};?>

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
                    
                    <form action="" method="post">
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
                                <input type="text" id="city" name="city" required>
                            </div>
                
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
                                <input type="password" id="password" name="password" minlength="8" required>
                            </div>

                            

                            <button type="submit" class="btn-submit" name="inscription" >S'inscrire</button>
                        </fieldset>
                    </form>

                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>
