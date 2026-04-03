        <footer>
            <div> 
                <div class="footer-logo-group">
                    <img src="../Images/Logo_beige_final_v2.svg" class="footer-logo" alt="Logo V&G"> 
                    <div class="footer-logo-text">
                        <h3>V&G</h3>
                        <p>Vite & Gourmand</p>
                    </div>
                </div>
                <br>
                <p>Traiteur Bordelais depuis 2001 Julie et José mettent leur savoir-faire artisanal au service de vos événements. <br> Une cuisine de saison, authentique et livrée avec soin dans toute la métropole.</p>
            </div>

            <address>
                <h3> CONTACT </h3>
                <ul>
                    <li> <?php echo $adress_title ?? '42 Rue du Pas-Saint-Georges, 33000 Bordeaux' ; ?></li>
                    <li><?php echo $phone_title ?? '05 56 44 12 89' ; ?></li>
                    <li><a href="mailto:contact@vite-et-gourmand-traiteur.fr"><?php echo $mail_title ?? 'contact@vite-et-gourmand-traiteur.fr' ; ?></a></li>
                    <li> <?php echo $horaire_title ?? 'Lun - Dim : 9h00 - 19h00'; ?></li>
                </ul>
            </address>

            <div> 
                <h3>INFORMATIONS</h3>
                <a href="Mentions.html"> Mentions Légales </a>
                <br>
                <a href="CGV.html"> Conditions Générales de Ventes </a>
            </div>
        </footer>