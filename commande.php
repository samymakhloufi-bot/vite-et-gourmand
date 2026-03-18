<?php $activePage = 'espace client'; ?>
<!DOCTYPE html >
<html lang="fr">
    
        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <img src="./Images/baniere_pano.png" class="hero-banner" alt="épice">
        

        <main>
            <div class="form-commande">
                <div class="connect">
                    <h3>Connectez-vous pour remplir automatiquement vos informations</h3>
                    <a href="./Connexion.php?redirect=command&id=<?php echo $id; ?>" class="btn-login">Connectez-vous</a>
                </div>
    
                <form action="enctype" method="post" id="form-commande">
                    
                    <fieldset class="detail-facturation">
                        <h3>Détails de facturation</h3>
                        <div class="personal-info">
                            <div>
                                <label for="name">Nom :</label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div>
                                <label for="firstname">Prénom :</label>
                                <input type="text" id="firstname" name="firstname" required>
                            </div>

                            <div>
                                <label for="company">Nom de l'entreprise :</label>
                                <input type="text" id="company" name="company" required>
                            </div>

                            <div>
                                <label for="address">Adresse de livraison:</label>
                                <input type="text" id="address" name="address" required>
                            </div>
        
                            <div>
                                <label for="city">Ville :</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                
                            <div>
                                <label for="postal_code">Code Postal :</label>
                                <input type="text" id="postal_code" name="postal_code" required>
                            </div>
                        
                            <div>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required>
                            </div>
        
                            <div>
                                <label for="tel">Téléphone :</label>
                                <input type="text" id="tel" name="tel" required>
                            </div>
                        </div>
                    </fieldset>

                    
                    
                    <fieldset class="livraison">
                        <div >
                            <label for="date">Date de livraison :</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div>
                            <label for="time">Heure de livraison :</label>
                            <input type="time" id="time" name="time" required>
                        </div>
                        <div>
                            <label for="mobile">Téléphone portable :</label>
                            <input type="text" id="mobile" name="mobile" required>
                        </div>
                        <div>
                            <label for="comment">Commentaire :</label>
                            <textarea type="text" id="comment" name="comment" required></textarea>
                        </div>
                        
                    </fieldset>
                        <div class="detail-commande">
                            <h3>Détails de votre commande</h3>
                        <table>
                            <thead>
                                <th scope="col">Produit</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Prix</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Produit 1</th>
                                    <td>1</td>
                                    <td>50€</td>
                                </tr>
                                <tr>
                                    <th scope="row">Produit 2</th>
                                    <td>2</td>
                                    <td>50€</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <th>Total</th>
                                <td>3</td>
                                <td>100€</td>
                            </tfoot>
                        </table>
                    </div>

                    <div class="demande-command">
                        <li><input type="radio" name="commande" id="devis1" value="devis1"><label for="devis">Demander un devis</label></li>
                        <li><input type="radio" name="commande" id="credit-card" value="credit-card"><label for="credit-card">Payer par carte bancaire</label></li>
                        <button type="submit" class="btn-order">Passer la commande</button>
                    </div>

                </form>
            </div>
        </main>







</main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>
