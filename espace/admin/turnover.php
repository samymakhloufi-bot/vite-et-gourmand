<?php

require_once __DIR__ . '/../../includes/mongodb.php';
$collection = getMongoCollection();

// 1. Récupération des filtres
$filtre_menu  = $_GET['filtre_menu'] ?? '';
$date_debut   = $_GET['date_debut'] ?? '';
$date_fin     = $_GET['date_fin'] ?? '';

// 2. Construction du filtre MongoDB
$filter = [];
if (!empty($filtre_menu)) {
    $filter['menu_titre'] = $filtre_menu;
}
if (!empty($date_debut) || !empty($date_fin)) {
    $filter['date'] = [];
    if (!empty($date_debut)) {
        $filter['date']['$gte'] = new MongoDB\BSON\UTCDateTime(strtotime($date_debut) * 1000);
    }
    if (!empty($date_fin)) {
        $filter['date']['$lte'] = new MongoDB\BSON\UTCDateTime(strtotime($date_fin . ' 23:59:59') * 1000);
    }
}

// 3. Exécution de la requête
$cursor = $collection->find($filter);
$documents = iterator_to_array($cursor);

// 4. Calculs
$ca_total = 0;
$stats_par_menu = [];
foreach ($documents as $doc) {
    $titre = $doc['menu_titre'];
    $montant = (float)$doc['montant_total'];
    $ca_total += $montant;

    if (!isset($stats_par_menu[$titre])) {
        $stats_par_menu[$titre] = ['nb_commandes' => 0, 'ca' => 0];
    }
    $stats_par_menu[$titre]['nb_commandes']++;
    $stats_par_menu[$titre]['ca'] += $montant;
}

// 5. Liste des menus distincts
$menus_distincts = $collection->distinct('menu_titre');
?>

<div class="turnover-container">

    <h1>Chiffre d'affaires</h1>

    <form method="GET" action="" class="turnover-filters">
        <input type="hidden" name="tab" value="turnover-wrapper">
        
        <div>
            <label for="filtre_menu">Menu :</label>
            <select name="filtre_menu" id="filtre_menu">
                <option value="">Tous les menus</option>
                <?php foreach ($menus_distincts as $menu): ?>
                    <option value="<?= htmlspecialchars($menu) ?>" 
                        <?= $filtre_menu === $menu ? 'selected' : '' ?>>
                        <?= htmlspecialchars($menu) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="date_debut">Du :</label>
            <input type="date" name="date_debut" id="date_debut" 
                value="<?= htmlspecialchars($date_debut) ?>">
        </div>

        <div>
            <label for="date_fin">Au :</label>
            <input type="date" name="date_fin" id="date_fin" 
                value="<?= htmlspecialchars($date_fin) ?>">
        </div>

        <button type="submit">Filtrer</button>
        <a href="?tab=turnover-wrapper">Réinitialiser</a>
    </form>

    <div class="ca-total">
        <span>CA total</span>
        <strong><?= number_format($ca_total, 2, ',', ' ') ?> €</strong>
    </div>

    <table class="turnover-table">
        <thead>
            <tr>
                <th scope="col">Menu</th>
                <th scope="col">Nb commandes</th>
                <th scope="col">CA généré</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats_par_menu as $menu => $stats): ?>
                <tr>
                    <td><?= htmlspecialchars($menu) ?></td>
                    <td><?= $stats['nb_commandes'] ?></td>
                    <td><?= number_format($stats['ca'], 2, ',', ' ') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <canvas id="chartCommandes"></canvas>
</div>

<script>
const labels = <?= json_encode(array_keys($stats_par_menu)) ?>;
const nbCommandes = <?= json_encode(array_map(fn($s) => $s['nb_commandes'], $stats_par_menu)) ?>;
const caData = <?= json_encode(array_map(fn($s) => round($s['ca'], 2), $stats_par_menu)) ?>;
</script>