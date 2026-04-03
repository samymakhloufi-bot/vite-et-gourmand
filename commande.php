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
            <h2>Ma commande  <em> & livraison </em></h2></div>
        </div>

        <main>
            <div class="form-commande">

                

                
                    <div class="connect">
                        <h3>Remplissez automatiquement vos informations</h3>
                        <a href="./Connexion.php?redirect=command&id=<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>" class="btn-login">Se connecter</a>
                    </div>
    
                    <form action="" method="post" id="form-commande">
                    
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
                                    <input type="text" id="company" name="company" >
                                </div>

                                <div>
                                    <label for="address">Adresse de livraison :</label>
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
                            <h3>LIVRAISON</h3>
                            <div >
                                <label for="date">Date de livraison :</label>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <div>
                                <label for="time">Heure de livraison :</label>
                                <input type="time" id="time" name="time" required>
                            </div>

                            <div>
                                <label for="comment">Commentaire :</label>
                                <textarea type="text" id="comment" name="comment" placeholder=""></textarea>
                            </div>
                        </fieldset>

                        <div class="demande-command">
                            <h3>MODE DE RÉGLEMENT</h3>
            
                            <div class="radio">
                                <input type="radio" name="paiement" id="radio-card" value="card" hidden>
                                <input type="radio" name="paiement" id="radio-devis" value="devis" hidden checked>
                                    
                                <div class="radio-div selected" data-target="radio-devis">
                                    <div class="radio-dot"></div>
                                    <label for="devis">Demander un devis</label>     
                                    <p>Recevez un devis personnalisé</p>
                                </div>
            
                                <div class="radio-div" data-target="radio-card">
                                    <div class="radio-dot"></div>
                                    <label for="credit-card">Carte bancaire</label>
                                    <p>Paiement sécurisé en ligne</p>
                                </div>
                            </div>
                        </div>
                        
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
                                    <td></td>
                                    <td>100€</td>
                                </tfoot>
                            </table>    
                            <button type="submit" class="btn-order">Commander </button>
                        </div>

                        
                    </form>

                
                
            </div>
        </main>

        <script src="./js/commande.js"></script>
        <?php include './includes/footer.php' ;?>

    </body>
</html>
