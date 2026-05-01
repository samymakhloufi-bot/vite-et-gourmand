<?php $activePage = 'espace employe'; 

require_once './login.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'] , ['admin', 'employe'])) {
    header('Location: /VG/index.php');
    exit();
}

$commandes = [];
$menus =[];
$avis =[];
$horaires = [];


// Récupérer les données nécessaires pour chaque section

        //Commande 
        $stmt = $pdo -> query("SELECT c.Id_commande, u.nom, m.menu_nom, c.date_commande, c.statut, c.mode_paiement, c.adresse_livraison, cd.prix, cd.quantite, c.date_livraison
        FROM commande c 
        JOIN users u ON c.Id_user = u.Id_user 
        JOIN commande_detail cd ON c.Id_commande = cd.Id_commande
        JOIN menu m ON cd.Id_menu = m.Id_menu 
        ORDER BY date_commande DESC");
        $commandes = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //Menu 
        $stmt = $pdo -> query("SELECT * FROM menu ORDER BY menu_nom DESC");
        $menus = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //Avis
        $stmt = $pdo->query("SELECT a.*, u.nom, u.prenom 
        FROM avis a 
        JOIN users u ON a.Id_user = u.Id_user 
        WHERE a.statut = 'en_attente' 
        ORDER BY a.created_at DESC");
        $avis = $stmt -> fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include __DIR__.'/includes/head.php';?>
    
    <body>
        <?php include __DIR__.'/includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Mon espace <em> employé </em></h2></div>
        </div>

        <main>

            <div class="espace-wrapper">

                <div class="sidebar-espace">
                    <button type="button" class="btn-commande" data-target="commandes-wrapper" aria-selected="commandes">Commandes</button>
                    <button type="button" class="btn-menus" data-target="menus-plat" aria-selected="Menus et plats">Menus & Plats</button>
                    <button type="button" class="btn-avis" data-target="moderation-avis" aria-selected="Modération Avis">Modération Avis</button>
                    <button type="button" class="btn-horaires" data-target="horaires" aria-selected="Horaires">Horaires</button>
                </div>


                <section id="commandes-wrapper" class="account-panel active">

                    <div class="menu-toolbar">
                        <span class="toolbar-title-cmd">Commandes</span>
                        <input type="text" class="search-client" id="search-client" placeholder="Rechercher un client">
                        <select name="search-statut" id="search-statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente">EN ATTENTE</option>
                            <option value="en_preparation">EN PRÉPARATION</option>
                            <option value="en_cours_de_livraison">EN LIVRAISON</option>
                            <option value="terminee">TERMINÉE</option>
                            <option value="annulee">ANNULÉ</option>
                            <option value="en_attente_retour_materiel">RETOUR DE MATERIEL</option>
                        </select>
                    </div>

                    <div id="client-list">
                        <?php if(empty($commandes)): ?>
                                <tr>
                                    <td colspan="6" class="no-orders">Il n'y a pas de commande.</td>
                                </tr>
                            <?php else: ?>

                        <?php foreach($commandes as $commande): ?>
                            <div class="client-card" data-nom="<?= strtolower(htmlspecialchars($commande['nom'])) ?>" data-statut="<?= strtolower(htmlspecialchars($commande['statut'])) ?>">
                                
                                <div class="client-card-header" onclick="toggleCmd(this)">
                                    <span class="client-id">#<?= htmlspecialchars($commande['Id_commande']) ?></span>
                                    <span class="client-name"><?= htmlspecialchars($commande['nom']) ?></span>
                                    <span class="client-menu"><?= htmlspecialchars($commande['menu_nom']) ?></span>
                                    <span class="client-date">Fait le <?= htmlspecialchars(date('d/m/Y', strtotime($commande['date_commande']))) ?></span>
                                    <span class="order-statut order-statut--<?= $commande['statut'] ?>"><?= strtolower(htmlspecialchars($commande['statut'])) ?></span>
                                    <span class="chevron">›</span>
                                </div>

                                <div class="client-body hidden">

                                    <div class="cmd-grid">
                                        
                                        <div class="info-row">
                                            <span class="info-label">MENU :</span>
                                            <span class="info-val"><?= htmlspecialchars($commande['menu_nom']) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <span class="info-label">NB PERSONNES :</span>
                                            <span class="info-val"><?= htmlspecialchars($commande['quantite']) ?></span>
                                        </div>    
                                        
                                        <div class="info-row">
                                            <span class="info-label">TOTAL :</span>
                                            <span class="info-val"><?= htmlspecialchars($commande['prix']) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <span class="info-label">PAIEMENT :</span>
                                            <span class="info-val"><?= htmlspecialchars($commande['mode_paiement']) ?></span>
                                        </div>
                                        
                                        <div class="info-row" style="grid-column: 1/-1;">
                                            <span class="info-label">ADRESSE DE LIVRAISON :</span>
                                            <span class="info-val"><?= htmlspecialchars($commande['adresse_livraison']) ?></span>
                                        </div>

                                        <div class="info-row" style="grid-column: 1/-1">
                                            <span class="info-label">HEURE DE LIVRAISON</span>
                                            <span class="info-val"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_livraison']))) ?></span>
                                        </div>
                                    </div>

                                    <div class="statut-row">
                                        <span class="info-label">STATUT :</span>
                                        <select class="statut-select" id="sel-<?= $commande['Id_commande'] ?>" onchange="checkAnnul(<?= $commande['Id_commande'] ?>)">
                                            <option value="en_attente"<?= $commande['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                            <option value="accepte"<?= $commande['statut'] === 'accepte' ? 'selected' : '' ?>>Accepté</option>
                                            <option value="en_preparation"<?= $commande['statut'] === 'en_preparation' ? 'selected' : '' ?>>En préparation</option>
                                            <option value="en_cours_de_livraison"<?= $commande['statut'] === 'en_cours_de_livraison' ? 'selected' : '' ?>>En livraison</option>
                                            <option value="livre"<?= $commande['statut'] === 'livre' ? 'selected' : '' ?>>Livré</option>
                                            <option value="en_attente_retour_materiel"<?= $commande['statut'] === 'en_attente_retour_materiel' ? 'selected' : '' ?>>Retour matériel</option>
                                            <option value="terminee"<?= $commande['statut'] === 'terminee' ? 'selected' : '' ?>>Terminée</option>
                                            <option value="annulee"<?= $commande['statut'] === 'annulee' ? 'selected' : '' ?>>Annulée</option>
                                        </select>
                                    
                                        <button class="btn-save" onclick="saveStatut(<?= $commande['Id_commande']?>, this)">Enregistrer</button>
                                        <span class="toast" id="toast-<?= $commande['Id_commande'] ?>"></span>
                                    </div>

                                    <div class="annul-section" id="annul-<?= $commande['Id_commande'] ?>">
                                        <div class="annul-title">Contact client obligatoire avant annulation</div>
                                            <div class="annul-grid">
                                                <select name="mode_contact">
                                                    <option value="appel">Appel</option>
                                                    <option value="mail">Email</option>
                                                </select>
                                                <input type="text" placeholder="Nom du contact..." required>
                                                <textarea placeholder="Motif d'annulation..." required></textarea>
                                            </div>
                                        <button class="btn-annul" onclick="confirmerAnnulation(<?= $commande['Id_commande'] ?>)">Confirmer l'annulation</button>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                        <?php endif ;?>
                    </div>
                </section>


                    <?php if (isset($_GET['success'])): ?>
                        <p class="message-succes">Image mise à jour avec succès.</p>
                    <?php elseif (isset($_GET['error'])): ?>
                        <p class="message-erreur">Erreur lors de l'upload.</p>
                    <?php endif; ?>
                    
                <section id="menus-plat" class="account-panel">

                        <div class="menus-toolbar">
                            <span class="toolbar-title">Menus <em>&</em> plats</span>
                            <input type="text" class="search-menu" id="search-menu" placeholder="Rechercher un menu...">
                        </div>
                    
                        <div id="menus-list">
                            <?php foreach ($menus as $menu): 
                                $img = $menu['img_desktop'];
                                $src = str_contains($img, '.') ? $img : $img . '.png';
                            ?>
                            <div class="menu-card" data-nom="<?= strtolower(htmlspecialchars($menu['menu_nom'])) ?>">

                                <div class="menu-card-header" onclick="toggleMenu(this)">
                                    <img src="/VG/Images/<?= $src ?>" alt="<?= htmlspecialchars($menu['menu_nom']) ?>" class="menu-thumb">
                                    <span class="menu-name"><?= htmlspecialchars($menu['menu_nom']) ?></span>
                                    <span class="badge badge-<?= $menu['theme'] ?>"><?= $menu['theme'] ?></span>
                                    <span class="badge badge-<?= $menu['regime'] ?>"><?= $menu['regime'] ?></span>
                                    <span class="menu-prix"><?= $menu['prix'] ?> €/pers</span>
                                    <span class="chevron">›</span>
                                </div>
                            
                                <div class="menu-body hidden">
                                    <div class="fields-grid">
                                        <div class="field">
                                            <label>Titre menu</label>
                                            <div class="val editable" contenteditable="true" 
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="menu_nom"><?= $menu['menu_nom'] ?></div>
                                        </div>
                                        <div class="field">
                                            <label>Prix / pers (€)</label>
                                            <div class="val editable" contenteditable="true" 
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="prix"><?= $menu['prix'] ?></div>
                                        </div>
                                        <div class="field">
                                            <label>Thème</label>
                                            <div class="val editable" contenteditable="true"
                                            data-id="<?= $menu['Id_menu'] ?>" data-field="theme"><?= htmlspecialchars($menu['theme']) ?></div>
                                        </div>
                                        <div class="field">
                                            <label>Régime</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="regime"><?= htmlspecialchars($menu['regime']) ?></div>
                                        </div>
                                        <div class="field">
                                            <label>Nb personnes min</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="nb_perso_min"><?= $menu['nb_perso_min'] ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Entrée</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="entree"><?= htmlspecialchars($menu['entree']) ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Plat</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="plat"><?= htmlspecialchars($menu['plat']) ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Dessert</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="dessert"><?= htmlspecialchars($menu['dessert']) ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Boissons (séparées par |)</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="boisson"><?= htmlspecialchars($menu['boisson']) ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Allergènes (séparés par |)</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="allergene"><?= htmlspecialchars($menu['allergene']) ?></div>
                                        </div>
                                        <div class="field full">
                                            <label>Description chef</label>
                                            <div class="val editable" contenteditable="true"
                                                data-id="<?= $menu['Id_menu'] ?>" data-field="description"><?= htmlspecialchars($menu['description']) ?></div>
                                        </div>
                                    </div>
                            
                                    <div class="img-row">
                                        <img src="/VG/Images/<?= $src ?>" alt="" class="img-preview">
                                        <form action="/VG/traitement/upload-img-menu.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="menu_id" value="<?= $menu['Id_menu'] ?>">
                                            <input type="file" name="img_menu" accept=".png" style="display:none" id="upload-<?= $menu['Id_menu'] ?>">
                                            <label for="upload-<?= $menu['Id_menu'] ?>" class="btn-sm">Changer l'image</label>
                                            <button type="submit" class="btn-sm">Uploader</button>
                                        </form>
                                        <button class="btn-save" onclick="saveMenu(<?= $menu['Id_menu'] ?>, this)">Enregistrer</button>
                                        <span class="saved-toast" id="toast-<?= $menu['Id_menu'] ?>"></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                </section>

                <section id="moderation-avis" class="account-panel">

                </section>

                <section id="horaires" class="account-panel">
                    <div class="horaire-body">
                        <table>
                            <td>
                                <th>Jour</th>
                                <th>Matin</th>
                                <th>Après-midi</th>
                                <th>Fermé</th>
                            </td>
                        </table>
                    </div>
                

                </section>

        </main>

        <?php include __DIR__.'/includes/footer.php' ;?>
        <script src="/VG/js/espaceclient.js"></script>
    </body>
</html>