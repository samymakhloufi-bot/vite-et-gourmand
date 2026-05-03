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
                                            <label class="info-label">MENU :</label>
                                            <span class="info-val"><?= htmlspecialchars($commande['menu_nom']) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <label class="info-label">NB PERSONNES :</label>
                                            <span class="info-val"><?= htmlspecialchars($commande['quantite']) ?></span>
                                        </div>    
                                        
                                        <div class="info-row">
                                            <label class="info-label">TOTAL :</label>
                                            <span class="info-val"><?= htmlspecialchars($commande['prix']) ?></span>
                                        </div>
                                        
                                        <div class="info-row">
                                            <label class="info-label">PAIEMENT :</label>
                                            <span class="info-val"><?= htmlspecialchars($commande['mode_paiement']) ?></span>
                                        </div>
                                        
                                        <div class="info-row" style="grid-column: 1/-1;">
                                            <label class="info-label">ADRESSE DE LIVRAISON :</label>
                                            <span class="info-val"><?= htmlspecialchars($commande['adresse_livraison']) ?></span>
                                        </div>

                                        <div class="info-row" style="grid-column: 1/-1">
                                            <label class="info-label">HEURE DE LIVRAISON</label>
                                            <span class="info-val"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_livraison']))) ?></span>
                                        </div>
                                    </div>

                                    <div class="statut-row">
                                        <label class="info-label">STATUT :</label>
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
                                        <div class="annul-title"><label>Contact client obligatoire avant annulation</label></div>
                                            <div class="annul-grid">
                                                <select name="mode_contact">
                                                    <option value="appel">Appel</option>
                                                    <option value="mail">Email</option>
                                                </select>
                                                <input type="text" placeholder="Nom du contact...">
                                                <textarea placeholder="Motif d'annulation..."></textarea>
                                            </div>
                                        <button class="btn-annul" onclick="confirmerAnnulation(<?= $commande['Id_commande'] ?>)">Confirmer l'annulation</button>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                        <?php endif ;?>
                    </div>