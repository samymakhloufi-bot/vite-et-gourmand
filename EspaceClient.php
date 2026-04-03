<?php $activePage = 'espace client'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <div class="nos-menus-banner">
            <div class="nos-menus-banner_diag"></div>
            <div class="nos-menus-banner_dark_diag"></div>
            <div class="nos-menus-banner_text">
            <h2>Mon espace <em> & commandes </em></h2></div>
        </div>

        <main class="main-espace-client">
            <div class="espace-client-wrapper">
                <div class="sidebar-espace-client">
                    <button type="button" class="btn-commande" data-target="mes-commandes">Mes Commandes</button>
                    <button type="button" class="btn-infos" data-target="mes-informations">Mes Informations</button>
                </div>


                <section id="orders-wrapper" class="account-panel" >
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
                                <td><span class="order-status order-status--waiting">EN ATTENTE</span></td>
                                    <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-status order-status--accepted">ACCEPTÉ</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-status order-status--done">TERMINÉE</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                            <tr>
                                <th scope="row">#0001</th>
                                <td>Menu de Noël</td>
                                <td>20/12/2024</td>
                                <td>280.00€</td>
                                <td><span class="order-status order-status--cancelled">ANNULÉ</span></td>
                                <td><a href="" class="btn-details">DÉTAILS</a></td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </section>

                <section id="sub-form" class="account-panel">

                    <form action="./account.php" method="post" id="form-update-account">
                        <fieldset>
                            <h3>Vos Coordonnées</h3>

                            <div class="personal-info">
                                <label for="nom">NOM</label>
                                <input type="text" id="nom" name="nom" placeholder="Votre nom de famille" readonly>
                                
                                <label for="prenom">PRÉNOM</label>
                                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" readonly>
                                
                                <label for="email">E-MAIL</label>
                                <input type="email" id="email" name="email" placeholder="Votre e-mail" readonly>
                                

                                <label for="tel">TÉLÉPHONE</label>
                                <input type="tel" id="tel" name="telephone" placeholder="Votre numéro de téléphone" readonly>

                                <label for="adresse">ADRESSE</label>
                                <input type="text" id="adresse" name="adresse" placeholder="Votre adresse" readonly>

                                <label for="ville">VILLE</label>
                                <input type="text" id="ville" name="ville" placeholder="Votre ville de domiciliation" readonly>

                                <label for="complement-adresse">COMPLÉMENT D'ADRESSE</label>
                                <input type="text" id="complement-adresse" name="complement-adresse" placeholder="Complément d'adresse" readonly>

                                <label for="code-postal">CODE POSTAL</label>
                                <input type="text" id="code-postal" name="code-postal" placeholder="code postal" readonly>

                                <label for="pays">PAYS</label>
                                <input type="text" id="pays" name="pays" placeholder="Votre pays" readonly>
                            </div>
                            <button type="button" class="btn-edit">Modifier</button>
                            <button type="submit" class="btn-submit">Mettre à jour</button>
                        </fieldset>
                    </form>
                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>
        <script src="./js/espaceclient.js"></script>
    </body>
</html>
