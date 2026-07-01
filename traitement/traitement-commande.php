<?php

require_once __DIR__ .'/../classes/Repository/CommandeRepository.php';
    require_once __DIR__ . '/../includes/mongodb.php';

$commandeRepository = new CommandeRepository($pdo);

$id_commande = $commandeRepository->create(
    (int)$_SESSION['user_id'],
    $datetime_final,
    $mode_paiement,
    $adresse_de_livraison,
    $ville_de_livraison,
    $complement,
    $frais_livraison,
    $distanceKM
);

$commandeRepository->createDetail(
    $id_commande,
    (int)$menu_id,
    $nb_pers,
    $prix,
    $prix_total,
    $reduction
);

$pdo->commit();
// Log MongoDB
try {
    mongoRequest('insertOne', [
        'document' => [
            'commande_id'      => (int)$id_commande,
            'menu_id'          => (int)$menu_id,
            'menu_titre'       => $menu_nom,
            'montant_total'    => (float)$prix_total,
            'nombre_personnes' => (int)$nb_pers,
            'reduction'        => (float)$reduction,
            'frais_livraison'  => (float)$frais_livraison,
            'statut'           => 'en_attente',
            'date'             => [
                '$date' => ['$numberLong' => (string)(time() * 1000)]
            ],
        ]
    ]);
} catch (Exception $e) {
    error_log('MongoDB log error : ' . $e->getMessage());
}

// Mail + redirection
if ($paiement === 'devis') {
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

        $mail->setFrom('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail->addAddress('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail->Subject = "Demande de devis #$id_commande — $nom $prenom";
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Nouvelle demande de devis #$id_commande</h2>
            <p><strong>Nom :</strong> $nom $prenom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $tel</p>
            <p><strong>Adresse de livraison:</strong> $adresse_de_livraison</p>
            <p><strong>Ville de livraison :</strong>$ville_de_livraison</p>
            <p><strong>Date :</strong> $date à $heure</p>
            <p><strong>Complément :</strong> $complement</p>
            <p><strong>Menu :</strong> $menu_nom</p>
            <p><strong>Nombre de personnes :</strong> $nb_pers</p>
            <p><strong>Prix/pers :</strong> $menu_prix €</p>
            <p><strong>Total estimé :</strong> $prix_total €</p>
        ";
        $mail->send();

        $mail->clearAddresses();
        $mail->addAddress($email, "$prenom $nom");
        $mail->Subject = "Votre demande de devis #$id_commande — Vite & Gourmand";
        $mail->Body = "
            <p>Bonjour $prenom $nom,</p>
            <p>Votre demande de devis a bien été reçue.</p>
            <p><strong>Menu :</strong> $menu_nom</p>
            <p><strong>Nombre de personnes :</strong> $nb_pers</p>
            <p><strong>Date :</strong> $date à $heure</p>
            <p><strong>Adresse :</strong> $adresse_de_livraison</p>
            <p>Vite & Gourmand</p>
        ";
        $mail->send();

        header('location: ' . BASE_URL . '/success-page/achat-succes.php?type=devis&id=' . $id_commande);
        exit;

    } catch (Exception $e) {
        $message = "Erreur mail : " . $e->getMessage();
    }
} elseif ($mode_paiement === 'carte_bancaire') {
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

        // Mail à l'entreprise
        $mail->setFrom('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail->addAddress('samymakhloufi@gmail.com', 'Vite & Gourmand');
        $mail->Subject = "Nouvelle commande #$id_commande — $nom $prenom";
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Nouvelle commande #$id_commande</h2>
            <p><strong>Nom :</strong> $nom $prenom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $tel</p>
            <p><strong>Adresse de livraison :</strong> $adresse_de_livraison</p>
            <p><strong>Ville de livraison :</strong> $ville_de_livraison</p>
            <p><strong>Date :</strong> $date à $heure</p>
            <p><strong>Complément :</strong> $complement</p>
            <p><strong>Menu :</strong> $menu_nom</p>
            <p><strong>Nombre de personnes :</strong> $nb_pers</p>
            <p><strong>Prix/pers :</strong> $menu_prix €</p>
            <p><strong>Total :</strong> $prix_total €</p>
            <p><strong>Mode de paiement :</strong> Carte bancaire</p>
        ";
        $mail->send();

        // Mail de confirmation au client
        $mail->clearAddresses();
        $mail->addAddress($email, "$prenom $nom");
        $mail->Subject = "Confirmation de votre commande #$id_commande — Vite & Gourmand";
        $mail->Body = "
            <p>Bonjour $prenom $nom,</p>
            <p>Nous avons bien reçu votre commande et nous allons la prendre en charge dans les plus brefs délais.</p>
            <p><strong>Menu :</strong> $menu_nom</p>
            <p><strong>Nombre de personnes :</strong> $nb_pers</p>
            <p><strong>Date :</strong> $date à $heure</p>
            <p><strong>Adresse :</strong> $adresse_de_livraison, $ville_de_livraison</p>
            <p><strong>Total :</strong> $prix_total €</p>
            <p>Vous pouvez suivre l'évolution de votre commande depuis votre espace personnel.</p>
            <br>
            <p>À très bientôt,<br>L'équipe Vite & Gourmand</p>
        ";
        $mail->send();

        header('location: ' . BASE_URL . '/success-page/achat-succes.php?id=' . $id_commande);
        exit;

    } catch (Exception $e) {
        error_log('Mail commande error : ' . $e->getMessage());
        header('location: ' . BASE_URL . '/success-page/achat-succes.php?id=' . $id_commande);
        exit;
    }

} else {
    header('location: ' . BASE_URL . '/success-page/achat-succes.php?id=' . $id_commande);
    exit;
}
