<?php
//Initialisation $employe
$stmt_employes = $pdo->query("SELECT id_user, nom, prenom, email, actif FROM users WHERE role ='employe' ");
$employes = $stmt_employes->fetchAll();

//Modération compte
if(isset($_POST['toggle-employe'])){
    $stmt = $pdo->prepare("UPDATE users SET actif = ? WHERE id_user = ? AND role ='employe' ");
    $stmt -> execute([$_POST['actif'], $_POST['id_user']]);
}

//Mise à jour table
$stmt_employes = $pdo->query("SELECT id_user, nom, prenom, email, actif FROM users WHERE role ='employe' ");
$employes = $stmt_employes->fetchAll();
    
//Création compte
if(isset($_POST['create-employe'])){
    $mdp_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users(nom,prenom, email,password,role)
                    VALUES(?,?,?,?,'employe')");
    $stmt ->execute([$_POST['nom'],$_POST['prenom'],$_POST['email'],$mdp_hashed]);
    }
?>

<div id="create-employe-panel" class="sub-tabs">

    <h3>Création d'un compte pour employé : </h3>
        <form method="post" action="">
            <fieldset>
                <div class="info-employe">
                    <label for="email-employé">Email de l'employé : </label>    
                    <input type="email" name="email" required>
                </div>

                <div class="info-employe">
                    <label for="password-employe">Mot de passe : </label>
                    <input type="password" name="password" required>
                </div>

                <div class="info-employe">
                    <label for="nom-employe">Nom de l'employé : </label>
                    <input type="text" name="nom" required>
                </div>

                <div class="info-employe">
                    <label for="prénom-employe">Prénom de l'employé : </label>
                    <input type="text" name="prenom" required>    
                </div>
            
                <button type="submit" class="btn-create-employe" name="create-employe">Créer un compte</button>
            </fieldset>
        </form>

</div>

<div id="manage-employe-panel" class="sub-tabs">
                        
    <h3>Compte employé :</h3>
    <div class="employees-list">
    
    <?php foreach($employes as $employe): ?>
        
        <div class="employee-card">
            

                <div class="employee-field"><strong>Nom:</strong> <?= htmlspecialchars($employe['nom']) ?></div>
                <div class="employee-field"><strong>Prénom:</strong> <?= htmlspecialchars($employe['prenom']) ?></div>
                <div class="employee-field"><strong>Email:</strong> <?= htmlspecialchars($employe['email']) ?></div>
                <div class="employee-field"><strong>Statut:</strong> <?= $employe['actif'] ? 'Actif' : 'Désactivé' ?></div>

                <form method="post" action="">
                    <input type="hidden" name="id_user" value="<?=$employe['id_user']?>">
                    <input type="hidden" name="actif" value="<?=$employe['actif'] ? 0 :1 ?>">
                    <button type="submit" name="toggle-employe"><?= $employe['actif'] ? 'Désactiver' : 'Activer' ?></button>
                </form>

        </div>
    <?php endforeach; ?>
    
    </div>
</div>