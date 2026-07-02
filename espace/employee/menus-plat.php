<div class="menus-toolbar">
    <span class="toolbar-title">Menus <em>&</em> plats</span>
<div>
                    <?php // Message image à jour
                    if (isset($_GET['success'])): ?>
                        <p class="message-succes">Image mise à jour avec succès.</p>
                    <?php elseif (isset($_GET['error'])): ?>
                        <p class="message-erreur">Erreur lors de l'upload.</p>
                    <?php endif; ?>
                </div>
    <input type="text" class="search-menu" id="search-menu" placeholder="Rechercher un menu...">
</div>
<div id="menus-list">
    <?php foreach ($menus as $menu): 
        $img = $menu['img_menu'];
        $src = str_contains($img, '.') ? $img : $img . '.png';
    ?>
    <div class="menu-card" data-nom="<?= strtolower(htmlspecialchars($menu['menu_nom'])) ?>">
	    <div class="menu-card-header">
            <div class="menu-card-header-header">
                <img src="<?= BASE_URL ?>/Images/<?= $src ?>" alt="<?= htmlspecialchars($menu['menu_nom']) ?>" class="menu-thumb">
                <span class="menu-name"><?= htmlspecialchars($menu['menu_nom']) ?></span>
            </div>
            <div class="menu-card-header-badge">
                <span class="badge badge-<?= $menu['theme'] ?>"><?= $menu['theme'] ?></span>
                <span class="badge badge-<?= $menu['regime'] ?>"><?= $menu['regime'] ?></span>
                <?php if (!$menu['actif']): ?>
                    <span class="badge badge-inactif"> Désactivé</span>
                <?php endif; ?>
            </div>
            <span class="menu-prix"><?= $menu['prix_menu'] ?> €/pers</span>
            <span class="chevron">›</span>
        </div>
    
        <div class="menu-body">
            <div class="fields-grid">
                <div class="field">
                    <label for="Titre menu">Titre menu</label>
                    <div class="val editable" contenteditable="true" 
                        data-id="<?= $menu['Id_menu'] ?>" data-field="menu_nom"><?= $menu['menu_nom'] ?></div>
                </div>
                <div class="field">
                    <label for="Thème">Thème</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="theme"><?= htmlspecialchars($menu['theme']) ?></div>
                </div>
                <div class="field">
                    <label for="prix par personne">Prix / pers (€)</label>
                    <div class="val editable" contenteditable="true" 
                        data-id="<?= $menu['Id_menu'] ?>" data-field="prix"><?= $menu['prix_menu'] ?></div>
                </div>
                
                <div class="field full">
                    <label for="Description du chef">Description chef</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="description"><?= htmlspecialchars($menu['description']) ?></div>
                </div>
                <div class="field">
                    <label for="Régime">Régime</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="regime"><?= htmlspecialchars($menu['regime']) ?></div>
                </div>
                <div class="field">
                    <label for="nombre de personnes minimum">Nb personnes min</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="nb_perso_min"><?= $menu['nb_perso_min'] ?></div>
                </div>
                <div class="field full">
                    <label for="entrée">Entrée</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="entree"><?= htmlspecialchars($menu['entree']) ?></div>
                </div>
                <div class="field full">
                    <label for="plat">Plat</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="plat"><?= htmlspecialchars($menu['plat']) ?></div>
                </div>
                <div class="field full">
                    <label for="dessert">Dessert</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="dessert"><?= htmlspecialchars($menu['dessert']) ?></div>
                </div>
                <div class="field full">
                    <label for="boissons">Boissons (séparées par |)</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="boisson"><?= htmlspecialchars($menu['boisson']) ?></div>
                </div>
                <div class="field full">
                    <label for="allergènes">Allergènes (séparés par |)</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="allergene"><?= htmlspecialchars($menu['allergene']) ?></div>
                </div>

            </div>
            <div class="card-footer-menus-plat">
                <div class="img-row">
                    <img src="<?= BASE_URL ?>/Images/<?= $src ?>" alt="" class="img-preview">
                    <form action="<?= BASE_URL ?>/traitement/upload-img-menu.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="menu_id" value="<?= $menu['Id_menu'] ?>">
                        <input type="file" name="img_menu" accept=".png" style="display:none" id="upload-<?= $menu['Id_menu'] ?>">
                        <label for="upload-<?= $menu['Id_menu'] ?>" class="btn-sm">Modifier</label>
                        <button type="submit" class="btn-sm">Uploader</button>
                    </form>
                </div>
                <div class="btn-menus-plat">
                    <button class="btn-save" onclick="saveMenu(<?= $menu['Id_menu'] ?>, this)">Enregistrer</button>
                    <button class="btn-<?= $menu['actif'] ? 'desactivate' : 'reactivate' ?>" data-actif= "<?= $menu['actif'] ?>"data-id="<?= $menu['Id_menu'] ?>," onclick="toggleActifMenu(this)"><?= $menu['actif'] ? 'Désactiver' : 'Réactiver'?></button>

                    <span class="saved-toast" id="toast-<?= $menu['Id_menu'] ?>"></span>

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
