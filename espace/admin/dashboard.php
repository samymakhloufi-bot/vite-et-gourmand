<?php
// Calculs pour le dashboard
$nb_attente = 0;
$nb_retour_materiel = 0;
$nb_avis_attente = 0;
$ca_mois = 0;
$dernières_commandes = array_slice($commandes, 0, 5);

foreach ($commandes as $cmd) {
    if ($cmd['statut'] === 'en_attente') $nb_attente++;
    if ($cmd['statut'] === 'en_attente_retour_materiel') $nb_retour_materiel++;
}

foreach ($avis as $a) {
    if ($a['statut_avis'] === 'en_attente') $nb_avis_attente++;
}

// CA du mois depuis MongoDB
require_once __DIR__ . '/../../includes/mongodb.php';
    $debut_mois_ts = (new DateTime('first day of this month 00:00:00'))->getTimestamp() * 1000;

$result = mongoRequest('find', [
    'filter' => [
        'date' => [
            '$gte' => [
                '$date' => ['$numberLong' => (string)$debut_mois_ts]
            ]
        ]
    ]
]);

foreach ($result['documents'] ?? [] as $doc) {
    $ca_mois += (float)$doc['montant_total'];
}

?>

<div class="dashboard-container">

    <h2>Tableau de bord</h2>

    <!-- Bloc stats rapides -->
    <div class="dashboard-stats">

        <div class="stat-card">
            <span class="stat-value"><?= count($commandes) ?></span>
            <span class="stat-label">Commandes totales</span>
        </div>

        <div class="stat-card">
            <span class="stat-value"><?= number_format($ca_mois, 2, ',', ' ') ?> €</span>
            <span class="stat-label">CA ce mois</span>
        </div>

        <div class="stat-card">
            <span class="stat-value"><?= count($avis) ?></span>
            <span class="stat-label">Avis reçus</span>
        </div>

    </div>


    <!-- Important -->
    <div class="dashboard-alerts">

        <!-- Commandes en attente -->
        <div class="dashboard-section">
            <h3>Commandes en attente <span class="badge-count"><?= $nb_attente ?></span></h3>

            <?php if ($nb_attente === 0): ?>
                <p class="empty-msg">Aucune commande en attente.</p>
            <?php else: ?>
                <div class="recent-table-wrapper" id="waiting-cmd-table">
                    <table class="recent-table" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="col-secondaire">Client</th>
                                <th>Menu</th>
                                <th class="col-secondaire">Date commande</th>
                                <th>Livraison</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commandes as $cmd): ?>
                                <?php if ($cmd['statut'] !== 'en_attente') continue; ?>
                                    <tr>
                                        <td><?= $cmd['Id_commande'] ?></td>
                                        <td class="col-secondaire"><?= htmlspecialchars($cmd['nom']) ?></td>
                                        <td><?= htmlspecialchars($cmd['menu_nom']) ?></td>
                                        <td class="col-secondaire"><?= date('d/m/Y', strtotime($cmd['date_commande'])) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($cmd['date_livraison'])) ?></td>
                                    </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Retour matériel -->
        <div class="dashboard-section">
            <h3>Retours matériel<span class="badge-count badge-urgent"><?= $nb_retour_materiel ?></span></h3>

            <?php if ($nb_retour_materiel === 0): ?>
                <p class="empty-msg">Aucun retour matériel en attente.</p>
            <?php else: ?>
                <div class="recent-table-wrapper">
                    <table class="recent-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th >Client</th>
                                <th class="col-secondaire">Menu</th>
                                <th class="col-secondaire">Date livraison</th>
                                <th>Jours écoulés</th>
                                <th>Alerte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commandes as $cmd): ?>
                                <?php if ($cmd['statut'] !== 'en_attente_retour_materiel') continue; ?>
                                <?php
                                    $date_liv = new DateTime($cmd['date_livraison']);
                                    $aujourd_hui = new DateTime();
                                    $jours = (int)$aujourd_hui->diff($date_liv)->days;
                                    $alerte = $jours >= 8 ? 'critique' : ($jours >= 5 ? 'warning' : 'ok');
                                ?>
                                <tr class="retour-row--<?= $alerte ?>">
                                    <td><?= $cmd['Id_commande'] ?></td>
                                    <td ><?= htmlspecialchars($cmd['nom']) ?></td>
                                    <td class="col-secondaire"><?= htmlspecialchars($cmd['menu_nom']) ?></td>
                                    <td class="col-secondaire"><?= date('d/m/Y', strtotime($cmd['date_livraison'])) ?></td>
                                    <td><?= $jours ?> jour<?= $jours > 1 ? 's' : '' ?></td>
                                    <td>
                                        <?php if ($alerte === 'critique'): ?>
                                            <span class="badge-alerte critique">🔴 Urgent</span>
                                        <?php elseif ($alerte === 'warning'): ?>
                                            <span class="badge-alerte warning">🟠 Surveiller</span>
                                        <?php else: ?>
                                            <span class="badge-alerte ok">🟢 OK</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                    <a href="<?= BASE_URL ?>/espace-employe.php" class="btn-voir-tout">Gérer les commandes →</a>
            <?php endif; ?>
        </div>
        
        <!-- Avis en attente -->
        <div class="dashboard-section">
            <h3>Avis en attente <span class="badge-count"><?= $nb_avis_attente ?></span></h3>

            <?php if ($nb_avis_attente === 0): ?>
                <p class="empty-msg">Aucun avis en attente de modération.</p>
            <?php else: ?>
                <p>Vous avez <strong><?= $nb_avis_attente ?></strong> avis en attente de modération.</p>
                <a href="<?= BASE_URL ?>/espace-employe.php" class="btn-voir-tout">Modérer les avis →</a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Dernières commandes -->
    <div class="dashboard-section">
        <h3>Dernières commandes</h3>
        <div class="recent-table-wrapper">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="col-secondaire">Client</th>
                        <th>Menu</th>
                        <th class="col-secondaire">Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dernières_commandes as $cmd): ?>
                        <tr>
                            <td><?= $cmd['Id_commande'] ?></td>
                            <td class="col-secondaire"><?= htmlspecialchars($cmd['nom']) ?></td>
                            <td><?= htmlspecialchars($cmd['menu_nom']) ?></td>
                            <td class="col-secondaire"><?= date('d/m/Y', strtotime($cmd['date_commande'])) ?></td>
                            <td><span class="order-statut order-statut--<?= $cmd['statut'] ?>">
                                <?= ucfirst(str_replace('_', ' ', $cmd['statut'])) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>