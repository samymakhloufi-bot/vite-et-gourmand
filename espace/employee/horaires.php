<?php
// partials/employe/horaires.php
$stmt_h = $pdo->query("SELECT * FROM horaires ORDER BY Id_horaire ASC");
$horaires = $stmt_h->fetchAll();

if (isset($_POST['save-horaires'])) {
    foreach ($horaires as $h) {
        $id     = $h['Id_horaire'];
        $ferme  = isset($_POST['ferme_' . $id]) ? 1 : 0;
        $om     = $ferme ? null : ($_POST['om_' . $id] ?: null);
        $fm     = $ferme ? null : ($_POST['fm_' . $id] ?: null);
        $oa     = $ferme ? null : ($_POST['oa_' . $id] ?: null);
        $fa     = $ferme ? null : ($_POST['fa_' . $id] ?: null);

        $upd = $pdo->prepare("UPDATE horaires SET 
            ouverture_matin = ?, fermeture_matin = ?,
            ouverture_apm = ?, fermeture_apm = ?,
            ferme = ? WHERE Id_horaire = ?");
        $upd->execute([$om, $fm, $oa, $fa, $ferme, $id]);
    }
    $stmt_h = $pdo->query("SELECT * FROM horaires ORDER BY Id_horaire ASC");
    $horaires = $stmt_h->fetchAll();
    $message_horaires = "Horaires mis à jour avec succès.";
}
?>

<?php if (isset($message_horaires)): ?>
    <p class="message-succes"><?= $message_horaires ?></p>
<?php endif; ?>

<form method="post" action="?section=horaires">
    <div class="card">
        <table class="horaires-table">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Ouv. matin</th>
                    <th>Ferm. matin</th>
                    <th>Ouv. après-midi</th>
                    <th>Ferm. après-midi</th>
                    <th>Fermé</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $h): ?>
                <tr class="<?= $h['ferme'] ? 'ferme' : '' ?>" id="row-<?= $h['Id_horaire'] ?>">
                    <td class="jour-label"><?= htmlspecialchars($h['jour']) ?></td>
                    <td><input type="time" name="om_<?= $h['Id_horaire'] ?>" 
                        value="<?= $h['ouverture_matin'] ?? '' ?>"
                        <?= $h['ferme'] ? 'disabled' : '' ?>></td>
                    <td><input type="time" name="fm_<?= $h['Id_horaire'] ?>"
                        value="<?= $h['fermeture_matin'] ?? '' ?>"
                        <?= $h['ferme'] ? 'disabled' : '' ?>></td>
                    <td><input type="time" name="oa_<?= $h['Id_horaire'] ?>"
                        value="<?= $h['ouverture_apm'] ?? '' ?>"
                        <?= $h['ferme'] ? 'disabled' : '' ?>></td>
                    <td><input type="time" name="fa_<?= $h['Id_horaire'] ?>"
                        value="<?= $h['fermeture_apm'] ?? '' ?>"
                        <?= $h['ferme'] ? 'disabled' : '' ?>></td>
                    <td><input type="checkbox" name="ferme_<?= $h['Id_horaire'] ?>"
                        <?= $h['ferme'] ? 'checked' : '' ?>
                        onchange="toggleFerme(<?= $h['Id_horaire'] ?>, this)"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="horaires-footer">
            <button type="submit" name="save-horaires" class="btn-save-h">Enregistrer</button>
        </div>
    </div>
</form>