<?php 


header('Content-Type: application/json');
require_once '../login.php';
require_once '../vendor/autoload.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['employe', 'admin'])) {
    echo json_encode(['success' => false]);
    exit;
}

$data        = json_decode(file_get_contents('php://input'), true);
$id_commande = (int) $data['id_commande'];
$statut      = $data['statut'];

$statuts_autorises = [
    'en_attente', 'accepte', 'en_preparation', 'en_cours_de_livraison',
    'livre', 'en_attente_retour_materiel', 'terminee', 'annulee'
];

if (!in_array($statut, $statuts_autorises)) {
    echo json_encode(['success' => false]);
    exit;
}
try{
    $stmt = $pdo->prepare("UPDATE commande SET statut = ? WHERE Id_commande = ?");
    $stmt->execute([$statut, $id_commande]);

    echo json_encode(['success' => true]);

    $userStmt = $pdo -> prepare("SELECT u.nom, u.prenom, u.email 
                                FROM users u
                                JOIN commande c ON u.Id_user = c.Id_user
                                WHERE c.Id_commande = ?");
    $userStmt -> execute([$id_commande]);
    $userInfo = $userStmt->fetch();

    //Mail selon statut 
    try{
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'samymakhloufi@gmail.com';
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        $mail->isHTML(true);
        $mail->setFrom('samymakhloufi@gmail.com');
        $mail->addAddress($userInfo['email'], $userInfo['prenom'].' '. $userInfo['nom']);
        


        //cmd accepte
        if($statut === 'accepte'){
            $mail->Subject = "Votre commande a été acceptée.";
            $mail->Body = "<p>Bonjour {$userInfo['prenom']} {$userInfo['nom']},</p>
                            <p>Nous avons le plaisir de vous informer que votre commande <strong>#$id_commande</strong> a été <strong>acceptée</strong> par notre équipe.</p>
                            <p>Nous allons maintenant préparer votre prestation avec soin. Vous recevrez une notification à chaque étape.</p>
                            <p>Pour toute question : <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a> — 05 56 44 12 89</p>
                            <p>Cordialement,<br><strong>L'équipe Vite & Gourmand</strong></p>";
            $mail->send();
        }

        //cmd en cours de livraison
        elseif($statut === 'en_cours_de_livraison'){
            $mail->Subject = "Votre commande #$id_commande est en cours de livraison";
            $mail->Body = "<p>Bonjour {$userInfo['prenom']} {$userInfo['nom']},</p>
                            <p>Bonne nouvelle ! Votre commande <strong>#$id_commande</strong> est actuellement <strong>en cours de livraison</strong>.</p>
                            <p>Notre équipe est en route pour vous livrer votre prestation. Assurez-vous d'être disponible à l'adresse de livraison indiquée.</p>
                            <p>Pour toute urgence : <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a> — 05 56 44 12 89</p>
                            <p>Cordialement,<br><strong>L'équipe Vite & Gourmand</strong></p>";
            $mail->send();
        }

        //cmd terminee
        elseif($statut === 'terminee'){
            $mail->Subject = "Votre avis compte pour nous.";
            $mail->Body = "<p>Bonjour {$userInfo['prenom']} {$userInfo['nom']},</p>
                            <p>Votre commande <strong>#$id_commande</strong> est désormais <strong>terminée</strong>. Nous espérons que votre événement s'est déroulé à merveille !</p>
                            <p>Votre avis compte beaucoup pour nous. Prenez 2 minutes pour nous laisser un commentaire :</p>
                            <p style='text-align:center'>
                                <a href='https://vite-et-gourmand-samy.alwaysdata.net/nosmenus.php' 
                                style='background:#7D241A;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;font-family:Arial,sans-serif;'>
                                Laisser un avis
                                </a>
                            </p>
                            <p>Merci de votre confiance et à très bientôt !</p>
                            <p>Cordialement,<br><strong>L'équipe Vite & Gourmand</strong></p>";
            $mail->send();
        }

        //cmd annulee
        elseif($statut === 'annulee'){
            $mail->Subject = "Annulation de votre commande";
            $mail->Body = "<p>Bonjour {$userInfo['prenom']} {$userInfo['nom']},</p>
                            <p>Nous vous informons que votre commande <strong>#$id_commande</strong> a été <strong>annulée</strong> par notre équipe.</p>
                            <p>Notre équipe a tenté de vous contacter au préalable. Si vous n'avez pas été joint, n'hésitez pas à nous contacter :</p>
                            <ul>
                                <li>Par email : <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a></li>
                                <li>Par téléphone : 05 56 44 12 89</li>
                            </ul>
                            <p>Nous espérons pouvoir vous accueillir à nouveau très bientôt.</p>
                            <p>Cordialement,<br><strong>L'équipe Vite & Gourmand</strong></p>";
            $mail->send();
        }

        //cmd en attente retour materiel
        elseif($statut === 'en_attente_retour_materiel'){
            $mail->Subject = "Retour du matériel prêté ";
            $mail->Body = "<p>Bonjour {$userInfo['prenom']} {$userInfo['nom']},</p>
                            <p>Suite à votre prestation, du matériel vous a été prêté par Vite & Gourmand.</p>
                            <p>Conformément à nos <a href='https://vite-et-gourmand-samy.alwaysdata.net/CGV.php'>Conditions Générales de Vente</a>, vous disposez de <strong>10 jours ouvrés</strong> pour restituer ce matériel.</p>
                            <p><strong>Passé ce délai, des frais de 600€ seront automatiquement facturés.</strong></p>
                            <p>Pour organiser le retour, veuillez nous contacter :</p>
                            <ul>
                                <li>Par email : <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a></li>
                                <li>Par téléphone : 05 56 44 12 89</li>
                            </ul>
                            <p>Cordialement,<br><strong>L'équipe Vite & Gourmand</strong></p>";
            $mail->send();
        }
    }catch(Exception $e){
        error_log('Erreur mail: '. $e->getMessage());
    }


}catch(Exception $e){
    json_encode(['Error'=> $e->getMessage()]);
}