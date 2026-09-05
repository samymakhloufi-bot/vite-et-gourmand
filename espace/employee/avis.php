<div class="toolbar-avis">
    <div class="avis-count">
        <?php $count = 0;
            foreach ($avis as $avi){
                if($avi['statut_avis'] ==='en_attente') $count++;} ?> 
            <span class="avis-count" id="avis-count"> 
        
            <?= $count?> avis en attente</span>
    </div>
    
    <select name="toolbar-avis" id="toolbar-avis" >
        <option value="en_attente"> En attente</option>
        <option value="valide">Validés</option>
        <option value="refuse">Refusés</option>
        <option value="">Tous</option>
    </select>
    
</div>

<div class="card-avis" id="avis-list">
    <?php if (empty($avis)) : ?>
        <div class="avis-empty">Aucun avis en attente</div>
        <?php else :?>
        <?php foreach($avis as $a):
            $initiale    = mb_strtoupper(mb_substr($a['prenom'] ?: $a['nom'], 0, 1));
            $note        = max(0, min(5, (int) ($a['note'] ?? 0)));
            $badgeClass  = $a['statut_avis'] === 'en_attente' ? 'badge-wait' : ($a['statut_avis'] === 'valide' ? 'badge-ok' : 'badge-non');
            $badgeLabel  = $a['statut_avis'] === 'en_attente' ? 'En attente' : ($a['statut_avis'] === 'valide' ? 'Validé' : 'Refusé');
        ?>
            <div class="avis-item" id="avis-item-<?= $a['Id_avis'] ?>" data-statut="<?= $a['statut_avis']?>">

                <div class="avis-top">
                    <div class="avis-identity">
                        <span class="avis-avatar"><?= htmlspecialchars($initiale) ?></span>
                        <div class="avis-identity-text">
                            <span class="nom-avis"><?= htmlspecialchars($a['prenom']) ?> <?= htmlspecialchars($a['nom']) ?></span>
                            <span class="id-avis">Avis #<?= htmlspecialchars($a['Id_avis']) ?></span>
                        </div>
                    </div>
                    <span class="avis-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                </div>

                <div class="avis-stars" aria-label="<?= $note ?> étoiles sur 5">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="avis-star<?= $i <= $note ? ' is-filled' : '' ?>">★</span>
                    <?php endfor; ?>
                </div>

                <p class="avis-text">« <?= htmlspecialchars($a['contenu']) ?> »</p>

                <div class="avis-footer">
                    <span class="date-avis"><?php $date = new DateTime($a['created_at']); echo $date->format('d/m/Y à H:i'); ?></span>
                    <div class="avis-action">
                        <button class="btn-valider" onclick="actionAvis(<?= $a['Id_avis']?>, 'valide')">Valider</button>
                        <button class="btn-refuse" onclick="actionAvis(<?= $a['Id_avis']?>, 'refuse')">Refuser</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>