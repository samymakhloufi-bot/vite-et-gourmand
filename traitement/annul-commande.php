<?php

header('Content-Type: application/json');
require_once '../login.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'non connecté']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id_commande = (int)$data['id_commande'];

if(!$id_commande){
    echo json_encode(['error' =>'Commande non existante']);
    exit();
}

try{
    //verif commande existante
    $checkCmd = $pdo -> prepare("SELECT Id_commande, Id_user FROM commande WHERE Id_commande = ? AND Id_user = ? AND statut ='en_attente'");
    $checkCmd-> execute([$id_commande, $_SESSION['user_id']]);
    $commande = $checkCmd-> fetch();

    if(!$commande){
        echo json_encode(['error' => 'Commande introuvable ou non annulable, veuillez contacter le service client.']);
        exit();
        }

    //Info user
    $user = $pdo ->prepare("SELECT nom, prenom, email FROM users WHERE id_user = ?");
    $user -> execute([$commande['Id_user']]);
    $userInfo = $user -> fetch();


    //Annulation cmd
    $cancel = $pdo -> prepare("UPDATE commande SET statut ='annulee' WHERE Id_commande = ?");
    $cancel -> execute([$id_commande]);

    require_once '../vendor/autoload.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'samymakhloufi@gmail.com';
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        //envoi mail à l'user d'annulation 
        $mail->setFrom('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail ->addAddress($userInfo['email'], $userInfo['prenom']. ' ' . $userInfo['nom']);
        $mail ->Subject ="Annulation de votre commande";
        $mail->isHTML(true);
        $mail -> Body ="<p>Bonjour ". $userInfo['prenom'] ." " . $userInfo['nom'] .",</p>

                    <p>Nous avons bien pris en compte l’annulation de votre commande.</p>
                    <p>Nous regrettons de ne pas pouvoir vous livrer cette fois-ci, mais sachez que vous pouvez <strong>passer une nouvelle commande à tout moment</strong> !</p>

                    <p>Notre équipe reste à votre disposition pour toute question ou pour vous aider à choisir un autre menu.</p>
                    <p>N’hésitez pas à nous contacter :</p>
                    <ul>
                        <li>Par email : <a href=\"mailto:contact@vite-et-gourmand.fr\">contact@vite-et-gourmand.fr</a></li>
                        <li>Par téléphone : 05 56 44 12 89</li>
                    </ul>

                    <p>Nous espérons vous retrouver très bientôt !</p>
                    <p>Cordialement,<br><strong>L’équipe Vite & Gourmand</strong></p>";
        $mail -> send();

        //Mail en interne
        $mail->clearAddresses();
        $mail->addAddress ('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail->Subject = "Annulation de commande #$id_commande";
        $mail->isHTML(true);
        $mail-> Body = "<p><strong>Client :</strong> " . $userInfo['prenom']. " " . $userInfo['nom'] . "(". $userInfo['email'] . ").</p>
                                <p><strong>Commande #". $id_commande." </strong> a été annulée.</p>";
        $mail-> send();
        }catch(Exception $e){
    echo json_encode(['error' => $e -> getMessage()]);
}
        echo json_encode(['success'=> true]);
    }catch(Exception $e){
    echo json_encode(['error' => $e -> getMessage()]);
}
