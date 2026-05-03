<div class="filter-bar">
    <select name="filter-avis" id="filter-avis" onchange="filtrerAvis(this.value)">
        <option value="en_attente"> En attente</option>
        <option value="valide">Validés</option>
        <option value="refusee">Refusés</option>
        <option value="">Tous</option>
    </select>
    <span class="avis-count" id="avis-count"> <?= count($avis) ?> avis en attente</span>
</div>

<div class="card" id="avis-list">
    <?php if (empty($avis)) : ?>
        <div class="avis-empty">Aucun avis en attente</div>
        <?php else :?>
        <?php foreach($avis as $a): ?>
            <div class="avis-item" id="avis-item-<?= $a['Id_avis'] ?>" data-statut="<?= $a['statut']?>">
                <div class="avis-content">
                    <div class="avis-text"> "<?= htmlspecialchars($a['contenu']) ?>"</div>
                    
                    <div class="avis-meta">
                        <?= htmlspecialchars($a['nom']) ?> <?= htmlspecialchars($a['prenom']) ?> -
                        <?= date('d/m/Y', strtotime($a['create_at'])) ?>
                        <?php if ($a['satut'] === 'en_attente') :?>
                            <span class="badge-wait">En attente</span>
                            <?php elseif ($a['statut'] === 'valide') :?>
                                <span class="badge-wait">Validé</span>
                            <?php elseif ($a['statut'] ==='refuse') : ?>
                                <span class="badge-wait">Refusé</span>
                            <?php endif;?>
                    </div>
                </div>

                <?php if ($a['staut'] ==='en_attente') : ?>
                    <div class="avis-action">
                        <button class="btn-valider" onclick="actionAvis(<?= $a['Id_avis']?>, 'valide')">Valider</button>
                        <button class="btn-refuse" onclick="actionAvis(<?= $a['Id_avis']?>, 'refuse')">Refuser</button>
                    </div>
                <?php endif;?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>