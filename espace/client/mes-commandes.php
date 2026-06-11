

<div id="commande-list">
    <?php if(empty($commandes)): ?>
                                <tr>
                                    <td colspan="6" class="no-orders">Vous n'avez pas encore passé de commande.</td>
                                </tr>
                            <?php else: ?>
    <?php foreach ($commandes as $commande):
        $date_livraison = new DateTime($commande['date_livraison']);
        $date = $date_livraison -> format('d-m-Y');
        $date_edit = $date_livraison ->format('Y-m-d');
        $heure = $date_livraison -> format('H:i');
        
    ?>

    <div class="commande-card" data-nom="<?= strtolower(htmlspecialchars($commande['menu_nom'])) ?>">
	    <div class="commande-card-header">
                <span class="commande-menu-name"><?= htmlspecialchars($commande['menu_nom']) ?></span>
                <span class="saved-toast" id="saved-toast-<?= $commande['Id_commande'] ?>"></span>
                <span class="cancel-toast" id="cancel-toast-<?= $commande['Id_commande'] ?>"></span>
                <span class="commande-date"><?= date('d/m/Y', strtotime(htmlspecialchars($commande['date_livraison']))) ?></span>
                <span class="commande-prix"><?= htmlspecialchars($commande['prix_total']) ?>€</span>
                <span class="commande-statut commande-statut--<?= $commande['statut']?>"><?= ucfirst(str_replace('_', ' ', $commande['statut']))?></span>
                <button type ="" class="btn-details">DÉTAILS</button>
                <button type ="" class="btn-delete-cmd" onclick="cancelCmd(<?= $commande['Id_commande'] ?>, this)">Annuler la commande</button>
        </div>
    
        <div class="commande-body">
            <!-----Visualisé la commande-->
            <div class="cmd-view">
                <div class="info-row-cmd ">
                    <label for="Titre menu">Titre menu</label>
                    <div class="info-cmd " 
                        data-id="<?= $commande['Id_commande'] ?>" data-info-row="menu_nom"><?= $commande['menu_nom'] ?></div>
                </div>
                
                <div class="info-row-cmd">
                    <label for="nombre de personnes">Nb personnes </label>
                    <div class="info-cmd " 
                        data-id="<?= $commande['Id_commande'] ?>" data-info-row="nb_perso_min"><?= $commande['quantite'] ?></div>
                </div>

                <div class="info-row-cmd">
                    <label for="date de livraison">Date de Livraison</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="date_livraison"><?=($date) ?></div>
                </div>

                <div class="info-row-cmd">
                    <label for="heure de livraison">Heure de Livraison</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="heure_livraison"><?=($heure) ?></div>
                </div>
                
                <div class="info-row-cmd ">
                    <label for="Adresse Livraison">Adresse Livraison</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="adresse_livraison"><?=($commande['adresse_livraison']) ?></div>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="ville"><?=($commande['ville_livraison']) ?></div>
                </div>

                <div class="info-row-cmd">
                    <label for="Complement d'adresse">Complement d'adresse</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="complement"><?=($commande['complement']?? 'Aucun complement d\'adresse') ?> </div>
                </div>

                <div class="info-row-cmd ">
                    <label for="Mode de paiement">Mode de paiement</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande'] ?>" data-info-row="adresse_livraison"><?=ucfirst(str_replace('_',' ', $commande['mode_paiement'])) ?></div>
                </div>

                <div class="info-row-cmd">
                    <label for="prix">Prix :</label>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande']?>" data-info-row="prix">Prix du menu : <?= $commande['prix']?>€</div>

                    <div class="info-cmd" data-id="<?= $commande['Id_commande']?>" data-info-row="prix">Frais de livraison : <?= $commande['frais_livraison']?>€</div>
                    <div class="info-cmd" data-id="<?= $commande['Id_commande']?>" data-info-row="prix">Réduction : <?= round(($commande['prix_total'] - $commande['prix']) -$commande['frais_livraison'], 2)?>€</div>

                    <div class="info-cmd" data-id="<?= $commande['Id_commande']?>" data-info-row="prix">Prix Total : <?= $commande['prix_total']?>€</div>

                </div>
                <div class="div-edit-cmd">
                <button type="button" class="btn-edit-cmd">Modifier</button>
                </div>
            </div>


                <!---Modifier la commande ---->
            
            <div class="cmd-edit" >

                <div class="info-row-cmd">
                    <label for="nombre de personne">Nb personnes :</label>
                    <input type="number" class="val editable" data-id="<?= $commande['Id_commande'] ?>" value="<?= $commande['quantite']?>">
                </div>
                
                <div class="info-row-cmd">
                    <label for="date de livraison">Date de Livraison :</label>
                    <input type="date" class="val editable" data-id="<?= $commande['Id_commande'] ?>" value="<?= $date_edit?>">
                </div>

                <div class="info-row-cmd">
                    <label for="heure de livraison">Heure de Livraison :</label>
                    <input type="time" class="val editable" data-id="<?= $commande['Id_commande'] ?>" value="<?=$heure ?>">
                    
                </div>
                
                <div class="info-row-cmd ">
                    <label for="adresse de livraison">Adresse Livraison :</label>
                    <input type="text" class="val editable" data-id="<?= $commande['Id_commande'] ?>" value="<?=($commande['adresse_livraison'])?>">
                    <input type="text" class="val editable" data-id="<?= $commande['Id_commande'] ?>" value="<?=($commande['ville_livraison']) ?>">
                </div>

                <div class="info-row-cmd">
                    <label for="complément d'adresse">Complement d'adresse :</label>
                    <div class="val editable" contenteditable="true" data-id="<?= $commande['Id_commande'] ?>" data-info-row="complement"><?=($commande['complement']?? 'Aucun complement d\'adresse') ?> </div>
                </div>

                <div class="div-save-edit">
                    <button class="btn-save-cmd" onclick="saveCmd(<?= $commande['Id_commande'] ?>, this)">Enregistrer</button>
                    <button class="btn-cancel-cmd" >Annuler</button>
                </div>
                
            </div>
            
            <div class="card-footer-menus-plat">
                <div class="btn-menus-plat">
                    
                    
                    

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
