<?php $activePage = 'Votre commande'; 
    require_once './login.php';
    require_once './vendor/autoload.php';
    require_once './classes/Repository/MenuRepository.php';
    require_once './classes/Repository/UserRepository.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/connexion.php?redirect=nos-menus.php');
    exit();
}

if (isset($_POST['menu_id']) && !isset($_POST['commander'])) {
    $_SESSION['menu_id'] = $_POST['menu_id'];
    $_SESSION['nb_pers'] = $_POST['nb_pers'];
}

$menu_id = $_POST['menu_id'] ?? $_SESSION['menu_id'] ?? null;
$nb_pers = (int)($_POST['nb_pers'] ?? $_SESSION['nb_pers'] ?? 1);

$menuRepository = new MenuRepository($pdo);
$menu = $menuRepository->findById((int)$menu_id);

$userRepository = new UserRepository($pdo);
$user = $userRepository->findById((int)$_SESSION['user_id']);

$menu_nom    = $menu ? $menu->getNom() : 'Menu inconnu';
$menu_prix   = $menu ? $menu->getPrix() : 0;
$nb_pers_min = $menu ? $menu->getNbPersoMin() : 1;
$reduction   = ($nb_pers >= $nb_pers_min + 5) ? 0.10 : 0;
$frais_livraison = (float)($_POST['frais_livraison'] ?? 0);
$distanceKM      = (float)($_POST['distance_km'] ?? 0);
$prix_total  = ($menu_prix * $nb_pers) * (1 - $reduction) + $frais_livraison;

if (isset($_POST['commander'])) {
    $nom              = trim($_POST['nom']);
    $prenom           = trim($_POST['prenom']);
    $adresse_de_livraison = trim($_POST['address-livraison-precis']);
    $ville_de_livraison   = trim($_POST['ville-livraison']) === 'autre' ? trim($_POST['ville-livraison-autre']) : 'Bordeaux';
    $email            = trim($_POST['email']);
    $tel              = trim($_POST['tel']);
    $date             = $_POST['date'];
    $heure            = $_POST['time'];
    $complement       = trim($_POST['comment']);
    $paiement         = $_POST['mode_paiement'];
    $nb_pers          = (int)$_POST['nb_pers'];
    $prix             = $menu_prix * $nb_pers;
    $reduction        = ($nb_pers >= $nb_pers_min + 5) ? 0.10 : 0;
    $prix_total       = $prix * (1 - $reduction) + $frais_livraison;
    $mode_paiement    = $paiement === 'devis' ? 'devis' : 'carte_bancaire';

    if (empty($date) || empty($heure)) {
        header('Location: ' . BASE_URL . '/achat.php?error=champs_manquants');
        exit();
    }

    $datetime_final = $date . ' ' . $heure . ':00';

    try {
        $pdo->beginTransaction();
        require_once __DIR__ . '/traitement/traitement-commande.php';
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $message = "Erreur lors de la transaction : " . $e->getMessage();
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
            <h1>Ma commande  <em> & livraison </em></h1></div>
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
                                    value="<?php echo htmlspecialchars($user-> getNom() ?? ''); ?>">
                                    
                                </div>
                                

                                <div>
                                    <label for="prenom">Prénom :</label>
                                    <input type="text" id="prenom" name="prenom" required
                                    value="<?php echo htmlspecialchars($user->getPrenom() ?? ''); ?>">
                                </div>

                                <div>
                                    <label for="company">Nom de l'entreprise :</label>
                                    <input type="text" id="company" name="company" >
                                </div>

                                <div>
                                    <label for="address">Adresse :</label>
                                    <input type="text" id="address" name="address" required
                                    value="<?php echo htmlspecialchars($user->getAdresse()?? ''); ?>">
                                </div>
    
                                <div>
                                    <label for="ville">Ville :</label>
                                    <input type="text" id="ville" name="ville" required
                                    value="<?php echo htmlspecialchars($user->getVille() ?? ''); ?>">
                                </div>
                
                                <div>
                                    <label for="postal_code">Code Postal :</label>
                                    <input type="text" id="postal_code" name="postal_code" required
                                    value="<?php echo htmlspecialchars($user->getCodePostal() ?? ''); ?>">
                                </div>
                    
                                <div>
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" required
                                    value="<?php echo htmlspecialchars($user->getEmail() ?? ''); ?>">
                                </div>
    
                                <div>
                                    <label for="tel">Téléphone :</label>
                                    <input type="text" id="tel" name="tel" required
                                    value="<?php echo htmlspecialchars($user->getTel() ?? ''); ?>">
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
                                <label for="ville-livraison-autre">Précisez la ville : </label>
                                <input type="text" id="ville-livraison-autre" name="ville-livraison-autre" placeholder="Bègles, Bruges, Talence,...">
                            </div>

                            <div>
                                    <label for="address-livraison-precis">Adresse de livraison:</label>
                                    <input type="text" id="address-livraison-precis" name="address-livraison-precis" required
                                    value="<?php echo htmlspecialchars($user->getAdresse() ?? ''); ?>">
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
                                <?php if($nb_pers >= $nb_pers_min + 5):?>                                    
                                    <tr>
                                        <th>Réduction</th>
                                        <td></td>
                                        <td>-10% (<?= round($menu_prix * $nb_pers * 0.10, 2) ?>€)</td>
                                    </tr>
                                <?php endif ;?>
                                
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
                            <input type="hidden" name="frais_livraison" id="hidden-frais" value="0">
                            <input type="hidden" name="distance_km" id="hidden-distance" value="0">   
                            <button type="submit" name="commander" class="btn-order">Commander </button>
                        </div>

                        
                    </form>

                
                
            </div>
        </main>

        <script> const menuPrix = <?= $menu_prix ?>;
                const nbPers = <?= $nb_pers ?>;
        </script>

        
        <script src="<?= BASE_URL ?>/js/google-maps.js"></script>
        <script src="<?= BASE_URL ?>/js/commande.js"></script>
        <script src="<?= BASE_URL ?>/js/achat.js"></script>
        <?php include './includes/footer.php' ;?>

    </body>
</html>
