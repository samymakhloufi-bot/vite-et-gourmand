<?php
require_once __DIR__ . '/../../classes/Repository/StatsRepository.php';

// 1. Récupération des filtres
$filtre_menu  = $_GET['filtre_menu'] ?? '';
$date_debut   = $_GET['date_debut'] ?? '';
$date_fin     = $_GET['date_fin'] ?? '';

$statsRepository = new StatsRepository($pdo);

$documents = $statsRepository->findAll([
    'menu_titre' => $filtre_menu,
    'date_debut' => $date_debut,
    'date_fin'   => $date_fin,
]);

$menus_distincts = $statsRepository->getMenusDistincts();

$statuts_exclus = ['annulee'];

// 2. Calculs + séparation CA réalisé et prévisionnel
$ca_realise = 0;
$ca_previsionnel = 0;
$stats_par_menu = [];

foreach ($documents as $doc) {
    if (in_array($doc['statut'], $statuts_exclus)) continue;

    $titre = $doc['menu_titre'];
    $montant = (float)$doc['montant_total'];

    if ($doc['statut'] === 'terminee') {
        $ca_realise += $montant;
    } else {
        $ca_previsionnel += $montant;
    }

    if (!isset($stats_par_menu[$titre])) {
        $stats_par_menu[$titre] = ['nb_commandes' => 0, 'ca' => 0];
    }
    $stats_par_menu[$titre]['nb_commandes']++;
    $stats_par_menu[$titre]['ca'] += $montant;
}

$ca_total = $ca_realise + $ca_previsionnel;
?>

<div class="turnover-container">

    <h2>Chiffre d'affaires</h2>

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
    <span>CA réalisé</span>
    <strong><?= number_format($ca_realise, 2, ',', ' ') ?> €</strong>
</div>

<div class="ca-previsionnel">
    <span>CA prévisionnel</span>
    <strong><?= number_format($ca_previsionnel, 2, ',', ' ') ?> €</strong>
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