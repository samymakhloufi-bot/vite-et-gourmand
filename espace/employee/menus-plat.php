<div class="menus-toolbar">
    <span class="toolbar-title">Menus <em>&</em> plats</span>
    <input type="text" class="search-menu" id="search-menu" placeholder="Rechercher un menu...">
</div>
<div id="menus-list">
    <?php foreach ($menus as $menu): 
        $img = $menu['img_desktop'];
        $src = str_contains($img, '.') ? $img : $img . '.png';
    ?>
    <div class="menu-card" data-nom="<?= strtolower(htmlspecialchars($menu['menu_nom'])) ?>">        <div class="menu-card-header" onclick="toggleMenu(this)">
            <img src="/VG/Images/<?= $src ?>" alt="<?= htmlspecialchars($menu['menu_nom']) ?>" class="menu-thumb">
            <span class="menu-name"><?= htmlspecialchars($menu['menu_nom']) ?></span>
            <span class="badge badge-<?= $menu['theme'] ?>"><?= $menu['theme'] ?></span>
            <span class="badge badge-<?= $menu['regime'] ?>"><?= $menu['regime'] ?></span>
            <?php if (!$menu['actif']): ?>
                <span class="badge badge-inactif"> Désactivé</span>
            <?php endif; ?>
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
                    <label>Thème</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="theme"><?= htmlspecialchars($menu['theme']) ?></div>
                </div>
                <div class="field">
                    <label>Prix / pers (€)</label>
                    <div class="val editable" contenteditable="true" 
                        data-id="<?= $menu['Id_menu'] ?>" data-field="prix"><?= $menu['prix'] ?></div>
                </div>
                
                <div class="field full">
                    <label>Description chef</label>
                    <div class="val editable" contenteditable="true"
                        data-id="<?= $menu['Id_menu'] ?>" data-field="description"><?= htmlspecialchars($menu['description']) ?></div>
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
                
            </div>
            <div class="card-footer-menus-plat">
                <div class="img-row">
                    <img src="/VG/Images/<?= $src ?>" alt="" class="img-preview">
                    <form action="/VG/traitement/upload-img-menu.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="menu_id" value="<?= $menu['Id_menu'] ?>">
                        <input type="file" name="img_menu" accept=".png" style="display:none" id="upload-<?= $menu['Id_menu'] ?>">
                        <label for="upload-<?= $menu['Id_menu'] ?>" class="btn-sm">Changer l'image</label>
                        <button type="submit" class="btn-sm">Uploader</button>
                    </form>
                </div>
                <div class="btn-menus-plat">
                    <button class="btn-save" onclick="saveMenu(<?= $menu['Id_menu'] ?>, this)">Enregistrer</button>
                    <button class="btn-<?= $menu['actif'] ? 'desactivate' : 'reactivate' ?>" onclick="toggleActifMenu(<?= $menu['Id_menu'] ?>, <?= $menu['actif']?>,  this)"><?= $menu['actif'] ? 'Désactiver' : 'Réactiver'?></button>

                    <span class="saved-toast" id="toast-<?= $menu['Id_menu'] ?>"></span>

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>