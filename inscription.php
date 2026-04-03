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
            <h2>Rejoignez-nous  <em> & créez votre compte </em></h2></div>
        </div>

        <main>
            
            <div class="sub-wrapper">
                
                <section class="contact-form">
                    
                    <form action="submit" method="post">
                        <fieldset>
                            <h3>Inscription</h3>
                            <div>
                                <label for="name">Nom :</label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div>
                                <label for="firstname">Prénom :</label>
                                <input type="text" id="firstname" name="firstname" required>
                            </div>

                            <div>
                                <label for="password">Téléphone :</label>
                                <input type="tel" id="password" name="password" required>
                            </div>
                            
                            <div>
                                <label for="address">Adresse :</label>
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
                                <label for="password">Mot de passe :</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            

                            <button type="submit" class="btn-submit" name="inscription">S'inscrire</button>
                        </fieldset>
                    </form>

                </section>
            </div>
        </main>

        <?php include './includes/footer.php' ;?>

    </body>
</html>
