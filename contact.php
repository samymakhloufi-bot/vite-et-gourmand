<?php $activePage = 'Contact'; 

session_start();
require_once './vendor/autoload.php';

$message = '';
$message_type = '';

if(isset($_POST['submit-contact'])) {
    $email = trim($_POST['email']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $telephone = trim($_POST['telephone']);
    $contenu = trim($_POST['demande']);
    $ville = trim($_POST['ville']);
    $adresse = trim($_POST['adresse']);
    $complement_adresse = trim($_POST['complement-adresse']);
    $code_postal = trim($_POST['code-postal']);
    $type = $_POST['type-client'] ?? 'non spécifié';


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

            $mail->setFrom($email);
            $mail->addAddress('samymakhloufi@gmail.com', 'Vite et Gourmand');
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $mail->isHTML(true);
            $mail->Body ="De : $nom $prenom <br>
                        Email : $email <br>
                        Téléphone : $telephone <br>
                        Type de client : $type <br>
                        Adresse : $adresse, $complement_adresse, $code_postal, $ville <br><br>
                        Message : <br> $contenu";

            $mail->send();
            $message = "Votre message a été envoyé avec succès.";
            $message_type = 'success';
            header('Location: contactSucess.php');
            exit();
        } catch (Exception $e) {
            $message = "Erreur lors de l'envoi de l'email : ";
            $message_type = 'erreur';
        } 
    }
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
            <h2>Parlons de <em> votre événement </em></h2></div>
        </div>

        <main>
            <div class="contact-wrapper">

                <section class="contact-form">
                    <form action="" method="post" class="contact-form-inner">
                        <h3>Vos coordonnées</h3>
                        <fieldset>
                            <div class="client-type">
                                <legend>Vous ÊTES :</legend>
                                <ul> 
                                    <li><input type="radio" id="particulier" name="type-client" value="particulier"> <label for="particulier">Un Particulier</label></li>
                                    <li><input type="radio" id="professionnel" name="type-client" value="professionnel"> <label for="professionnel">Un professionnel</label></li>
                                </ul>    
                            </div>
                        </fieldset>
                        
                        <fieldset>
                            <div class="personal-info">
                                <div>
                                    <label for="nom">NOM :</label>
                                    <input type="text" id="nom" name="nom" required>
                                </div>
                                <div>
                                    <label for="prenom">PRÉNOM :</label>
                                    <input type="text" id="prenom" name="prenom" required>
                                </div>
                                <div>
                                    <label for="email">E-MAIL :</label>
                                    <input type="email" id="email" name="email" required />
                                </div>
                                <div>
                                    <label for="tel">TÉLÉPHONE :</label>
                                    <input type="tel" id="tel" name="telephone" required>
                                </div>
                                <div>
                                    <label for="adresse">ADRESSE :</label>
                                    <input type="text" id="adresse" name="adresse" required>
                                </div>
                                <div>
                                    <label for="ville">VILLE :</label>
                                    <input type="text" id="ville" name="ville" required>
                                </div>
                                <div>
                                    <label for="complement-adresse">COMPLÉMENT :</label>
                                    <input type="text" id="complement-adresse" name="complement-adresse">
                                </div>
                                <div>
                                    <label for="code-postal">CODE POSTAL :</label>
                                    <input type="text" id="code-postal" name="code-postal" required>
                                </div>
                            </div>

                            <div class="form-textarea"> 
                                <label for="demande">Votre demande :</label>
                                <textarea id="demande" rows="50" name="demande"></textarea>
                            </div>

                            <button type="submit" class="btn-submit" name="submit-contact">Envoyer</button>
                            
                        </fieldset>
                    </form>
                </section>

                <section class="contact-info">
                    <div class="contact-card">
                        <img src="./Images/call_beige.png" alt="image de Téléphone">
                        <h3>TÉLÉPHONE</h3>
                        <a href="tel:05.56.44.12.89" title="Numéro de Téléphone">05.56.44.12.89</a>
                    </div>

                    <div class="contact-card"> 
                        <img src="./Images/clock_beige_v2.png" alt="icône horloge"> 
                        <h3>HORAIRES</h3>
                        <p>Du Lundi au Vendredi de 9:00 à 13:00 et de 14:00 à 19:00</p>
                    </div>

                    <address class="contact-card"> 
                        <img src="./Images/pin_beige.png" alt="icône localisation">
                        <h3>ADRESSE</h3>
                        <ul>
                            <li>Vite & Gourmand</li>
                            <li>42 rue du Pas-Saint-Georges</li>
                            <li>33000, Bordeaux</li>
                        </ul>
                    </address>

                    <div class="contact-card">
                        <img src="./Images/email_beige.png" alt="icône email">
                        <h3>E-MAIL</h3>
                        <a href="mailto:contact@vite-et-gourmand-traiteur.fr" title="notre e-mail">contact@vite-et-gourmand-traiteur.fr</a>
                    </div>
                </section>

            </div>
        </main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>
