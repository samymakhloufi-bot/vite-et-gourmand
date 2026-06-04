<?php $activePage = 'Votre Espace Client'; 
    require_once './login.php';
    require_once './vendor/autoload.php';


    //verif session
    if(!isset($_SESSION['user_id'])) {
        header('location: '. BASE_URL .'/connexion.php?redirect=nosmenus.php');
        exit();
    }

    //stockage données du menu commander
    if(isset($_POST['menu_id']) && !isset($_POST['commander'])){
        $_SESSION['menu_id'] = $_POST['menu_id'];
        $_SESSION['nb_pers'] = $_POST['nb_pers'];
    }

    // Récupération données menu depuis session
    $menu_id = $_SESSION['menu_id'] ?? null;
    $menu_nom = $_SESSION['menu_nom'] ?? '';
    $nb_pers = ((int)$_SESSION['nb_pers'] ?? 1);

    // Récupération données utilisateur pré-remplissage formulaire
    $user_commande = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
    $user_commande->execute([$_SESSION['user_id']]);
    $user = $user_commande->fetch();

        $stmtMenu = $pdo->prepare('SELECT menu_nom, prix FROM menu WHERE Id_menu = ?');
    $stmtMenu->execute([$menu_id]);
    $menu_infos = $stmtMenu ->fetch(PDO::FETCH_ASSOC);

    $menu_nom = $menu_infos['menu_nom'] ?? 'Menu inconnu';
    $menu_prix = (float)($menu_infos['prix'] ?? '');

    $message = '';

    //traitement formulaire commande
        if (isset($_POST['commander'])) {
            $nom         = trim($_POST['nom']);
            $prenom      = trim($_POST['prenom']);
            $adresse_de_livraison     = trim($_POST['address-livraison']);
            $ville_de_livraison       = trim($_POST['ville-livraison']);
            $email       = trim($_POST['email']);
            $tel         = trim($_POST['tel']);
            $date        = $_POST['date'];
            $heure       = $_POST['time'];
            $complement = trim($_POST['comment']);
            $paiement    = $_POST['mode_paiement'];
            $menu_id     = $_POST['menu_id'];
            $menu_nom = $menu_infos['menu_nom'] ?? 'Menu inconnu';
            $menu_prix = (float)($menu_infos['prix'] ?? '');

            $nb_pers     = (int)$_POST['nb_pers'];
            $prix_total       = $menu_prix * $nb_pers;
            $mode_paiement = $paiement === 'devis' ? 'devis' : 'carte_bancaire';

            if(!empty($_POST['date']) && !empty($_POST['heure']) ) {
                $datetime_final = $_POST['date'] . ' '. $_POST['heure'].':00';
                }else{ 
                header('location: '. BASE_URL .'/achat.php?error=champs_manquants');
                exit();
            }
            //Vérif envois Transaction entière 
            Try {
                $pdo -> beginTransaction();
    
                    // Insérer dans commande
                    $insert = $pdo->prepare("INSERT INTO commande 
                        (Id_user, date_livraison, statut, mode_paiement, adresse_livraison, ville_livraison, complement, date_commande) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                    $insert->execute([$_SESSION['user_id'], $datetime_final,'en_attente', $mode_paiement, $adresse_de_livraison, $ville_de_livraison, $complement]);
    
                    //Récup Id généré
                    $id_commande = $pdo->lastInsertId();
    
                    // Insérer dans commande_detail
                    $detail = $pdo->prepare("INSERT INTO commande_detail 
                        (Id_commande, Id_menu, quantite, prix, frais_livraison, distance_km) 
                        VALUES (?, ?, ?, ?, ?, ?)");
                    $detail->execute([$id_commande, $menu_id, $nb_pers, $menu_prix * $nb_pers, $frais_livraison, $distanceKM]);
    
                    //enregistrement de la commande
                    $pdo ->commit();
    
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
                                    <p><strong>Menu :</strong> $menu_nom</p>
                                    <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                                    <p><strong>Prix/pers :</strong> $menu_prix €</p>
                                    <p><strong>Total estimé :</strong> $prix_total €</p>
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
                                        <p><strong>Menu :</strong> $menu_nom</p>
                                        <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                                        <p><strong>Date de livraison :</strong> $date à $heure</p>
                                        <p><strong>Adresse :</strong> $adresse</p>
    
                                        <p>Pour toute question, contactez-nous à <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a></p>
                                        <p>Vite & Gourmand</p>
                                    ";
                                    $mail->send();
    
                                    header('location: '. BASE_URL .'/commandeSucces.php?type=devis&id=' . $id_commande);
                                    exit;
    
                        } catch (Exception $e) {
                        $message = "Erreur lors de l'envoi du mail : " . $e->getMessage();
                        } 
                    } else {
                        header('location: '. BASE_URL .'/paiement.php?id=' . $id_commande);
                        exit;
                    }
            }catch(Exception $e) {
                if($pdo -> inTransaction()){
                    $pdo ->rollBack();
                }
                $message = "Erreur lors de la transaction" .$e->getMessage();
            }
}

//Récupération frais de livraison
$frais_livraison = (float)($_POST['frais_livraison'] ?? 0);
$distanceKM = (float)($_POST['distance_km'] ?? 0);

// Calcul du total Final
$prix_total = $menu_prix * $nb_pers + $frais_livraison;

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
                        <input type="hidden" name="menu_nom"  value="<?= htmlspecialchars($menu_nom) ?>">
                        <input type="hidden" name="nb_pers" value="<?= $nb_pers ?>">
                        
                        <fieldset class="detail-facturation">
                            <h3>Détails de facturation</h3>
                            <div class="personal-info">
                                <div>
                                    <label for="nom">Nom :</label>
                                    <input type="text" id="nom" name="nom" required
                                    value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>">
                                    
                                </div>
                                

                                <div>
                                    <label for="prenom">Prénom :</label>
                                    <input type="text" id="prenom" name="prenom" required
                                    value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>">
                                </div>

                                <div>
                                    <label for="company">Nom de l'entreprise :</label>
                                    <input type="text" id="company" name="company" >
                                </div>

                                <div>
                                    <label for="address">Adresse :</label>
                                    <input type="text" id="address" name="address" required
                                    value="<?php echo htmlspecialchars($user['adresse'] ?? ''); ?>">
                                </div>
    
                                <div>
                                    <label for="ville">Ville :</label>
                                    <input type="text" id="ville" name="ville" required
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
                                    <label for="ville-livraison">Ville de livraison:</label>
                                    <select name="ville-livraison" id="ville-livraison" required>
                                        <option value="bordeaux">Bordeaux</option>
                                        <option value="autre">Autre (préciser)</option>
                                    </select>
                            </div>

                            <div id="ville-livraison-autre-div" style="display: none;">
                                <label for="ville-livraison">Précisez la ville : </label>
                                <input type="text" id="ville-livraison" name="ville-livraison" placeholder="Bègles, Bruges, Talence,...">
                            </div>

                            <div>
                                    <label for="address-livraison-autre">Adresse de livraison:</label>
                                    <input type="text" id="address-livraison-autre" name="address-livraison-autre" required
                                    value="<?php echo htmlspecialchars($user['adresse'] ?? ''); ?>">
                            </div>
                            
                            <div>
                                <label for="comment">Commentaire :</label>
                                <textarea type="text" id="comment" name="comment" placeholder="Complément d'adresse, instructions de livraison...."></textarea>
                            </div>
                        </fieldset>

                        <div class="demande-command">
                            <h3>MODE DE RÉGLEMENT</h3>
            
                            <div class="radio">
                                <input type="radio" name="mode_paiement" id="radio-card" value="card" hidden>
                                <input type="radio" name="mode_paiement" id="radio-devis" value="devis" hidden checked>
                                    
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
                                    <th scope="col">Menu</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Prix /pers.</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?= htmlspecialchars($menu_nom) ?></th>
                                        <td><?= $nb_pers ?></td>
                                        <td><?= $menu_prix ?> €</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>

                                        <th>Frais de livraison</th>
                                        <td></td>
                                        <td><?= $frais_livraison ?> € (<?= $distanceKM ?> km)</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td></td>
                                        <td><?= $prix_total ?> €</td>
                                    </tr>
                                </tfoot>
                            </table>    
                            <button type="submit" name="commander" class="btn-order">Commander </button>
                        </div>

                        
                    </form>

                
                
            </div>
        </main>

        <script src="./js/commande.js"></script>
        <script src="./js/achat.js"></script>
        <?php include './includes/footer.php' ;?>

    </body>
</html>
