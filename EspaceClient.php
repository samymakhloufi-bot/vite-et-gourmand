<?php $activePage = 'espace client'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './index/head.php';?>
    
    <body>
        <?php include './index/header.php';?>

        <img src="./Images/baniere_pano.png" class="hero-banner" alt="épice">

        <main>
            <h2>Mes Commandes</h2>
            <div class="orders-wrapper">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th scope="col">Commande</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Date de Livraison</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">#0001</th>
                            <td>Menu de Noël</td>
                            <td>20/12/2024</td>
                            <td>280.00€</td>
                            <td><span class="order-status order-status--done">TERMINÉE</span></td>
                            <td><a href="" class="btn-details">DÉTAILS</a></td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

            <div class="auth-wrapper">

                <section class="auth-form">
                    <h2>Mon Compte</h2>
                    <form action="./account.php" method="post" id="form-update-account">
                        <fieldset>
                            <h3>Vos Coordonnées</h3>

                            <div class="personal-info">
                                <label for="nom">NOM</label>
                                <input type="text" id="nom" name="nom" placeholder="Votre nom de famille">

                                <label for="prenom">PRÉNOM</label>
                                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom">

                                <label for="email">E-MAIL</label>
                                <input type="email" id="email" name="email" placeholder="Votre e-mail" required>

                                <label for="tel">TÉLÉPHONE</label>
                                <input type="tel" id="tel" name="telephone" placeholder="Votre numéro de téléphone">

                                <label for="adresse">ADRESSE</label>
                                <input type="text" id="adresse" name="adresse" placeholder="Votre adresse">

                                <label for="ville">VILLE</label>
                                <input type="text" id="ville" name="ville" placeholder="Votre ville de domiciliation">

                                <label for="complement-adresse">COMPLÉMENT D'ADRESSE</label>
                                <input type="text" id="complement-adresse" name="complement-adresse" placeholder="Complément d'adresse">

                                <label for="code-postal">CODE POSTAL</label>
                                <input type="text" id="code-postal" name="code-postal" placeholder="Le code postal de votre ville">

                                <label for="pays">PAYS</label>
                                <input type="text" id="pays" name="pays" placeholder="Votre pays de domiciliation">
                            </div>

                            <button type="submit" class="btn-submit">Mettre à jour</button>
                        </fieldset>
                    </form>
                </section>
            </div>
        </main>

        <?php include './index/footer.php' ;?>

    </body>
</html>
