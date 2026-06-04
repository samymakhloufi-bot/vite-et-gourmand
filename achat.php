<?php
$activePage = 'Votre Espace Client';
require_once './login.php';
require_once './vendor/autoload.php';

// Vérification de la session
if(!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/connexion.php?redirect=nosmenus.php');
    exit();
}

// Stockage des données du menu
if(isset($_POST['menu_id']) && !isset($_POST['commander'])) {
    $_SESSION['menu_id'] = $_POST['menu_id'];
    $_SESSION['nb_pers'] = $_POST['nb_pers'];
}

// Récupération des données
$menu_id = $_SESSION['menu_id'] ?? null;
$menu_nom = $_SESSION['menu_nom'] ?? '';
$nb_pers = ((int)$_SESSION['nb_pers'] ?? 1);

$user_commande = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
$user_commande->execute([$_SESSION['user_id']]);
$user = $user_commande->fetch();

$stmtMenu = $pdo->prepare('SELECT menu_nom, prix FROM menu WHERE Id_menu = ?');
$stmtMenu->execute([$menu_id]);
$menu_infos = $stmtMenu->fetch(PDO::FETCH_ASSOC);

$menu_nom = $menu_infos['menu_nom'] ?? 'Menu inconnu';
$menu_prix = (float)($menu_infos['prix'] ?? '');
$message = '';

// Traitement du formulaire
if (isset($_POST['commander'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse_de_livraison = trim($_POST['address_livraison']);
    $ville_de_livraison = $_POST['ville_livraison_select'] === 'autre'
        ? trim($_POST['ville_livraison_autre'])
        : $_POST['ville_livraison_select'];
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);
    $date = $_POST['date'];
    $heure = $_POST['time'];
    $complement = trim($_POST['comment']);
    $paiement = $_POST['mode_paiement'];
    $menu_id = $_POST['menu_id'];
    $nb_pers = (int)$_POST['nb_pers'];

    // Récupère les frais calculés (champs cachés)
    $frais_livraison = (float)($_POST['frais_livraison'] ?? 0);
    $distanceKM = (float)($_POST['distance_km'] ?? 0);
    $prix_total = ($menu_prix * $nb_pers) + $frais_livraison;

    if(!empty($_POST['date']) && !empty($_POST['heure'])) {
        $datetime_final = $_POST['date'] . ' ' . $_POST['heure'] . ':00';
    } else {
        header('Location: ' . BASE_URL . '/achat.php?error=champs_manquants');
        exit();
    }

    // Transaction
    try {
        $pdo->beginTransaction();

        // Insère la commande
        $insert = $pdo->prepare("INSERT INTO commande
            (Id_user, date_livraison, statut, mode_paiement, adresse_livraison, ville_livraison, complement, date_commande)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $insert->execute([
            $_SESSION['user_id'],
            $datetime_final,
            'en_attente',
            ($paiement === 'devis' ? 'devis' : 'carte_bancaire'),
            $adresse_de_livraison,
            $ville_de_livraison,
            $complement
        ]);

        $id_commande = $pdo->lastInsertId();

        // Insère les détails
        $detail = $pdo->prepare("INSERT INTO commande_detail
            (Id_commande, Id_menu, quantite, prix, frais_livraison, distance_km)
            VALUES (?, ?, ?, ?, ?, ?)");
        $detail->execute([
            $id_commande,
            $menu_id,
            $nb_pers,
            $menu_prix * $nb_pers,
            $frais_livraison,
            $distanceKM
        ]);

        $pdo->commit();

        // Envoi des mails ou redirection
        if ($paiement === 'devis') {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ton-email@gmail.com';
                $mail->Password = 'ton-app-password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

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
                    <p><strong>Adresse :</strong> $adresse_de_livraison</p>
                    <p><strong>Ville :</strong> $ville_de_livraison</p>
                    <p><strong>Date :</strong> $date à $heure</p>
                    <p><strong>Complément :</strong> $complement</p>
                    <h3>Commande</h3>
                    <p><strong>Menu :</strong> $menu_nom</p>
                    <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                    <p><strong>Prix/pers :</strong> $menu_prix €</p>
                    <p><strong>Frais de livraison :</strong> $frais_livraison € ($distanceKM km)</p>
                    <p><strong>Total :</strong> $prix_total €</p>
                ";
                $mail->send();

                $mail->clearAddresses();
                $mail->addAddress($email, "$prenom $nom");
                $mail->Subject = "Votre demande de devis #$id_commande — Vite & Gourmand";
                $mail->Body = "
                    <p>Bonjour $prenom $nom,</p>
                    <p>Votre demande de devis a bien été reçue.</p>
                    <h3>Récapitulatif</h3>
                    <p><strong>Menu :</strong> $menu_nom</p>
                    <p><strong>Nombre de personnes :</strong> $nb_pers</p>
                    <p><strong>Date de livraison :</strong> $date à $heure</p>
                    <p><strong>Adresse :</strong> $adresse_de_livraison, $ville_de_livraison</p>
                    <p><strong>Frais de livraison :</strong> $frais_livraison € ($distanceKM km)</p>
                    <p><strong>Total :</strong> $prix_total €</p>
                    <p>Pour toute question, contactez-nous à <a href='mailto:contact@vite-et-gourmand.fr'>contact@vite-et-gourmand.fr</a></p>
                ";
                $mail->send();

                header('Location: ' . BASE_URL . '/commandeSucces.php?type=devis&id=' . $id_commande);
                exit;
            } catch (Exception $e) {
                $message = "Erreur lors de l'envoi du mail : " . $e->getMessage();
            }
        } else {
            header('Location: ' . BASE_URL . '/paiement.php?id=' . $id_commande);
            exit;
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $message = "Erreur lors de la transaction : " . $e->getMessage();
    }
}

// Initialisation des variables pour le JS
$menu_prix_js = $menu_prix;
$nb_pers_js = $nb_pers;
$frais_livraison_js = (float)($_POST['frais_livraison'] ?? 0);
$distanceKM_js = (float)($_POST['distance_km'] ?? 0);
$prix_total_js = ($menu_prix * $nb_pers) + $frais_livraison_js;
?>

<!DOCTYPE html>
<html lang="fr">
    <?php include './includes/head.php'; ?>
    <body>
        <?php include './includes/header.php'; ?>

        <div id="cookie-overlay" class="cookie-overlay">
            <div class="cookie-banner">
                <p>
                    <strong>Cookies & confidentialité</strong><br>
                    Ce site utilise Google Maps pour le calcul des frais de livraison,
                    ce qui implique un transfert de données vers les serveurs Google.
                    <a href="<?= BASE_URL ?>/confidentialite.php" target="_blank">En savoir plus</a>
                </p>
                <div class="cookie-buttons">
                    <button id="refuse-cookies" class="btn-cookie-refuse">Refuser</button>
                    <button id="accept-cookies" class="btn-cookie-accept">Accepter</button>
                </div>
            </div>
        </div>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
                <h2>Ma commande <em>& livraison</em></h2>
            </div>
        </div>

        <main>
            <div class="form-commande">
                <form action="" method="post" id="form-commande">
                    <input type="hidden" name="menu_id" value="<?= $menu_id ?>">
                    <input type="hidden" name="menu_nom" value="<?= htmlspecialchars($menu_nom) ?>">
                    <input type="hidden" name="nb_pers" value="<?= $nb_pers ?>">
                    <input type="hidden" name="frais_livraison" id="frais_livraison" value="<?= $frais_livraison_js ?>">
                    <input type="hidden" name="distance_km" id="distance_km" value="<?= $distanceKM_js ?>">

                    <fieldset class="detail-facturation">
                        <h3>Détails de facturation</h3>
                        <div class="personal-info">
                            <div>
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($user['nom'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="prenom">Prénom :</label>
                                <input type="text" id="prenom" name="prenom" required value="<?= htmlspecialchars($user['prenom'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="company">Nom de l'entreprise :</label>
                                <input type="text" id="company" name="company">
                            </div>
                            <div>
                                <label for="address">Adresse :</label>
                                <input type="text" id="address" name="address" required value="<?= htmlspecialchars($user['adresse'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="ville">Ville :</label>
                                <input type="text" id="ville" name="ville" required value="<?= htmlspecialchars($user['ville'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="postal_code">Code Postal :</label>
                                <input type="text" id="postal_code" name="postal_code" required value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="tel">Téléphone :</label>
                                <input type="text" id="tel" name="tel" required value="<?= htmlspecialchars($user['tel'] ?? '') ?>">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="livraison">
                        <h3>LIVRAISON</h3>
                        <div>
                            <label for="date">Date de livraison :</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div>
                            <label for="time">Heure de livraison :</label>
                            <input type="time" id="time" name="time" required>
                        </div>
                        <div>
                            <label for="ville-livraison-select">Ville de livraison:</label>
                            <select name="ville_livraison_select" id="ville-livraison-select" required>
                                <option value="bordeaux">Bordeaux</option>
                                <option value="autre">Autre (préciser)</option>
                            </select>
                        </div>
                        <div id="ville-livraison-autre-div" style="display: none;">
                            <label for="ville-livraison-autre">Précisez la ville :</label>
                            <input type="text" id="ville-livraison-autre" name="ville_livraison_autre" placeholder="Bègles, Bruges, Talence...">
                        </div>
                        <div>
                            <label for="address-livraison">Adresse de livraison:</label>
                            <input type="text" id="address-livraison" name="address_livraison" required value="<?= htmlspecialchars($user['adresse'] ?? '') ?>">
                        </div>
                        <div>
                            <label for="comment">Commentaire :</label>
                            <textarea id="comment" name="comment" placeholder="Complément d'adresse, instructions de livraison..."></textarea>
                        </div>

                        <input type="hidden" name="distance_km" id="distance_km" value="<?= $distanceKM_js ?>">
                        <input type="hidden" name="frais_livraison" id="frais_livraison" value="<?= $frais_livraison_js ?>">
                    </fieldset>

                    <div class="demande-command">
                        <h3>MODE DE RÈGLEMENT</h3>
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
                                    <td id="frais-livraison-cell"><?= $frais_livraison_js ?> € (<?= $distanceKM_js ?> km)</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td></td>
                                    <td id="total-cell"><?= $prix_total_js ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="submit" name="commander" class="btn-order">Commander</button>
                    </div>
                </form>
            </div>
        </main>

        <script src="./js/commande.js"></script>
        <script src="./js/achat.js"></script>
        <script src ="./fraisLivraison.js"></script>
        <?php include './includes/footer.php' ;?>

    </body>
</html>
