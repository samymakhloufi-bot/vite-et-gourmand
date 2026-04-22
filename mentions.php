<?php $activePage= 'Mentions Légales'; 

session_start();

?>
<!DOCTYPE html>

<html lang="fr">

    <?php include __DIR__.'./includes/head.php';?>

    <body>
        <?php include __DIR__.'./includes/header.php';?>

        <main>
            <div class="nos-menus-banner">
                <div class="nos-menus-banner_diag"></div>
                <div class="nos-menus-banner_dark_diag"></div>
                <div class="nos-menus-banner_text">
                <h2>Mentions <em>LÉGALES</em></h2></div>
            </div>

            <div class="information-wrapper">
                <p class="update">Dernière mise à jour : avril 2026</p>
                <div class="information">
                    <h3>Éditeur du site</h3>
                    <span>RAISON SOCIALE</span>
                    <p>Vite & Gourmand - Société par actions simplifiée(SAS) <br>
                        <?php echo $adressTittle ?? '42 Rue du Pas-Saint-Georges, 33000 Bordeaux';?><br>
                        Télépgone : <?php echo $phone_title ?? '05 56 44 12 89' ; ?><br>
                        Mail : <?php echo $mail_title ?? 'contact@vite-et-gourmand-traiteur.fr' ; ?><br>
                        <br>
                    </p>

                    <span>DIRECTEUR DE PUBLICATION</span>
                    <p>Julie et José MARTINS, co-gérants de Vite & Gourmand.</p>
                </div>

                <div class="information">
                    <h3>Hébergement</h3>
                    <p>Ce site est hébergé par : 
                        Raison sociale : [Nom de l'entreprise] <br>
                        Adresse : [Adresse] <br>
                        Téléphone : [Numéro] <br>
                        Email : [Email] <br>
                        Hébergeur : [Nom de l'hébergeur]<br>
                    </p>
                </div>

                <div class="information">
                    <h3>Propriété intellectuelle</h3>
                    <p>
                        L'ensemble des contenus présents sur ce site (texte, images, logos, graphismes) sont la propriété
                        exclusive de Vite & Gourmand et sont protégés par les lois françaises et internationales relatives
                        à la propriété intellectuelle. Tout reproduction, même partielle, est strictement interdite sans autorisation
                        préalable.
                    </p>

                </div>

                <div class="information">
                    <h3>Données personnelles </h3>
                    <p>
                        Conformément au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés, 
                        vous disposez d'un droit d'accès, de rectification et de suppression de vos données. Pour exercer ce droit,
                        contactez-nous à : <?php echo $mailTitle ; ?>
                    </p>
                </div>
            </div>
        </main>

    </body>

        <?php include __DIR__.'/includes/footer.php' ; ?>

</html>