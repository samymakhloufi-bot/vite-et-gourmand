<?php $activePage = 'Votre Espace Client'; 
    require_once './login.php';
    require_once './vendor/autoload.php';


    //verif session
    if(!isset($_SESSION['user_id'])) {
        header('Location: /VG/connexion.php?redirect=commande.php');
        exit();
    }

    //stockage données du menu commander
    if(isset($_POST['menu_id']) && !isset($_POST['commander'])){
        $_SESSION['menu_id'] = $_POST['menu_id'];
        $_SESSION['menu_name'] = $_POST['menu_name'];
        $_SESSION['menu_prix'] = $_POST['menu_prix'];
        $_SESSION['nb_pers'] = $_POST['nbr-commande'];
    }

    // Récupération données menu depuis session
    $menu_id = $_SESSION['menu_id'] ?? null;
    $menu_name = $_SESSION['menu_name'] ?? '';
    $menu_prix = $_SESSION['menu_prix'] ?? 0;
    $nb_pers = $_SESSION['nbr_pers'] ?? 1;
    $total = $menu_prix * $nb_pers;

    // Récupération données utilisateur pré-remplissage formulaire
    $user_commande = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
    $user_commande->execute([$_SESSION['user_id']]);
    $user = $user_commande->fetch();

    $message = '';

    //traitement formulaire commande
        if (isset($_POST['commander'])) {
        $nom         = trim($_POST['name']);
        $prenom      = trim($_POST['firstname']);
        $adresse     = trim($_POST['address']) . ', ' . trim($_POST['postal_code']) . ' ' . trim($_POST['city']);
        $email       = trim($_POST['email']);
        $tel         = trim($_POST['tel']);
        $date        = $_POST['date'];
        $heure       = $_POST['time'];
        $complement = trim($_POST['comment']);
        $paiement    = $_POST['paiement'];
        $menu_id     = $_POST['menu_id'];
        $menu_name   = $_POST['menu_name'];
        $menu_prix   = $_POST['menu_prix'];
        $nb_pers     = $_POST['nb_pers'];
        $total       = $menu_prix * $nb_pers;
        $mode_paiement = $paiement === 'devis' ? 'devis' : 'carte_bancaire';

        // Insérer dans commande
        $insert = $pdo->prepare("INSERT INTO commande 
            (Id_user, date_livraison, heure_livraison, statut, mode_paiement, adresse_livraison, complement, date_commande) 
            VALUES (?, ?, ?, 'en_attente', ?, ?, ?, NOW())");
        $insert->execute([$_SESSION['user_id'], $date, $heure, $mode_paiement, $adresse, $complement]);
        $id_commande = $pdo->lastInsertId();

        // Insérer dans commande_detail
        $detail = $pdo->prepare("INSERT INTO commande_detail 
            (Id_commande, Id_menu, quantite, prix) 
            VALUES (?, ?, ?, ?)");
        $detail->execute([$id_commande, $menu_id, $nb_pers, $total]);

        // Suite — mail devis ou redirection paiement
        if ($paiement === 'devis') {
            // envoi mail

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ton-email@gmail.com';
                $mail->Password   = 'ton-app-password';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                // Mail interne à l'équipe
                    $mail->setFrom('ton-email@gmail.com', 'Vite & Gourmand');
                    $mail->addAddress('ton-email@gmail.com', 'Vite & Gourmand');
                    $mail->Subject = "Demande de devis #$id_commande — $nom $prenom";
                    $mail->isHTML(true);
                    $mail->Body = "
                        <h2>Nouvelle demande de devis #$id_commande</h2>                
                        <h3>Informations client</h3>
                        <p><strong>Nom :</strong> $nom $prenom</p>
                        <p><strong>Email :</strong> $email</p>
                        <p><strong>Téléphone :</strong> $tel</p>                
                        <h3>Livraison</h3>
                        <p><strong>Adresse :</strong> $adresse</p>
                        <p><strong>Date :</strong> $date à $heure</p>
                        <p><strong>Complément :</strong> $complement</p>                
                        <h3>Commande</h3>
                        <p><strong>Menu :</strong> $menu_name</p>
                        <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                        <p><strong>Prix/pers :</strong> $menu_prix €</p>
                        <p><strong>Total estimé :</strong> $total €</p>
                        ";
                        $mail->send();

                        // Mail de confirmation au client
                        $mail->clearAddresses();
                        $mail->addAddress($email, "$prenom $nom");
                        $mail->Subject = "Votre demande de devis #$id_commande — Vite & Gourmand";
                        $mail->Body = "
                            <p>Bonjour $prenom $nom,</p>
                            <p>Votre demande de devis a bien été reçue. Notre équipe reviendra vers vous dans les plus brefs délais avec un devis personnalisé.</p>

                            <h3>Récapitulatif</h3>
                            <p><strong>Menu :</strong> $menu_name</p>
                            <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                            <p><strong>Date de livraison :</strong> $date à $heure</p>
                            <p><strong>Adresse :</strong> $adresse</p>

                            <p>Pour toute question, contactez-nous à <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a></p>
                            <p>Vite & Gourmand</p>
                        ";
                        $mail->send();

                        header('Location: /VG/commandeSucces.php?type=devis&id=' . $id_commande);
                        exit;
            

            } catch (Exception $e) {
            $message = "Erreur lors de l'envoi du mail : " . $e->getMessage();
            } 
        } else {
            header('Location: /VG/paiement.php?id=' . $id_commande);
            exit;
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
            <h2>Ma commande  <em> & livraison </em></h2></div>
        </div>

        <main>
            <div class="form-commande">
            
                
    
                    <form action="" method="post" id="form-commande">
                        <input type="hidden" name="menu_id"    value="<?= $menu_id ?>">
                        <input type="hidden" name="menu_name"  value="<?= htmlspecialchars($menu_name) ?>">
                        <input type="hidden" name="menu_prix"  value="<?= $menu_prix ?>">
                        <input type="hidden" name="nbr-commande" value="<?= $nb_pers ?>">
                        
                        <fieldset class="detail-facturation">
                            <h3>Détails de facturation</h3>
                            <div class="personal-info">
                                <div>
                                    <label for="name">Nom :</label>
                                    <input type="text" id="name" name="name" required
                                    value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>">
                                    
                                </div>
                                

                                <div>
                                    <label for="firstname">Prénom :</label>
                                    <input type="text" id="firstname" name="firstname" required
                                    value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>">
                                </div>

                                <div>
                                    <label for="company">Nom de l'entreprise :</label>
                                    <input type="text" id="company" name="company" >
                                </div>

                                <div>
                                    <label for="address">Adresse de livraison :</label>
                                    <input type="text" id="address" name="address" required
                                    value="<?php echo htmlspecialchars($user['adresse'] ?? ''); ?>">
                                </div>
    
                                <div>
                                    <label for="city">Ville :</label>
                                    <input type="text" id="city" name="city" required
                                    value="<?php echo htmlspecialchars($user['ville'] ?? ''); ?>">
                                </div>
                
                                <div>
                                    <label for="postal_code">Code Postal :</label>
                                    <input type="text" id="postal_code" name="postal_code" required
                                    value="<?php echo htmlspecialchars($user['code_postal'] ?? ''); ?>">
                                </div>
                    
                                <div>
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" required
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                </div>
    
                                <div>
                                    <label for="tel">Téléphone :</label>
                                    <input type="text" id="tel" name="tel" required
                                    value="<?php echo htmlspecialchars($user['tel'] ?? ''); ?>">
                                </div>
                            </div>
                        </fieldset>
                
                        <fieldset class="livraison">
                            <h3>LIVRAISON</h3>
                            <div >
                                <label for="date">Date de livraison :</label>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <div>
                                <label for="time">Heure de livraison :</label>
                                <input type="time" id="time" name="time" required>
                            </div>

                            <div>
                                <label for="comment">Commentaire :</label>
                                <textarea type="text" id="comment" name="comment" placeholder="Complément d'adresse, instructions de livraison...."></textarea>
                            </div>
                        </fieldset>

                        <div class="demande-command">
                            <h3>MODE DE RÉGLEMENT</h3>
            
                            <div class="radio">
                                <input type="radio" name="paiement" id="radio-card" value="card" hidden>
                                <input type="radio" name="paiement" id="radio-devis" value="devis" hidden checked>
                                    
                                <div class="radio-div selected" data-target="radio-devis">
                                    <div class="radio-dot"></div>
                                    <label for="devis">Demander un devis</label>     
                                    <p>Recevez un devis personnalisé</p>
                                </div>
            
                                <div class="radio-div" data-target="radio-card">
                                    <div class="radio-dot"></div>
                                    <label for="credit-card">Carte bancaire</label>
                                    <p>Paiement sécurisé en ligne</p>
                                </div>
                            </div>
                        </div>
                        
                            <div class="detail-commande">
                                <h3>Détails de votre commande</h3>
                            <table>
                                <thead>
                                    <th scope="col">Produit</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Prix</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?= htmlspecialchars($menu_name) ?></th>
                                        <td><?= $nb_pers ?></td>
                                        <td><?= $menu_prix ?> €</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <td></td>
                                        <td><?= ($menu_prix * $nb_pers) ?> €</td>
                                    </tr>
                                </tfoot>
                            </table>    
                            <button type="submit" name="commander" class="btn-order">Commander </button>
                        </div>

                        
                    </form>

                
                
            </div>
        </main>

        <script src="./js/commande.js"></script>
        <?php include './includes/footer.php' ;?>

    </body>
</html>
