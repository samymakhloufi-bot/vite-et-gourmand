<div class="toolbar-avis">
    <div class="avis-count">
        <?php $count = 0;
            foreach ($avis as $a){
                if($a['statut_avis'] ==='en_attente') $count++;} ?> 
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
        <?php foreach($avis as $a): ?>
            <div class="avis-item" id="avis-item-<?= $a['Id_avis'] ?>" data-statut="<?= $a['statut_avis']?>">
                <div class="avis-content">

                    <div class="avis-meta">
                        <div class="avis-name"><span class="id-avis">#<?=htmlspecialchars($a['Id_avis'])?> - </span><span class="nom-avis"><?= htmlspecialchars($a['nom']) ?> <?= htmlspecialchars($a['prenom']) ?> - </span></div>
                        <div class="avis-date"><span class="date-avis"><?php $date = new DateTime($a['created_at']); echo $date-> format('d/m/Y H:i');?></span></div>
                        <div class="avis-badge"><span class="avis-badge-<?= $a['statut_avis'] === 'en_attente' ?'badge-wait' : 
                        ($a['statut_avis'] === 'valide' ? 'badge-ok' : 'badge-non') ?>"><?= $a['statut_avis'] === 'en_attente' ? 'En attente' : ($a['statut_avis'] === 'valide' ? 'Validé' : 'Refusé') ?> </span></div>


                    <div class="avis-text"> "<?= htmlspecialchars($a['contenu']) ?>"</div>
                    </div>
                </div>

                    <div class="avis-action">
                        <button class="btn-valider" onclick="actionAvis(<?= $a['Id_avis']?>, 'valide')">Valider</button>
                        <button class="btn-refuse" onclick="actionAvis(<?= $a['Id_avis']?>, 'refuse')">Refuser</button>
                    </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>