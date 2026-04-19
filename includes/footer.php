        <footer>
            <div> 
                <div class="footer-logo-group">
                    <img src="/VG/Images/Logo_beige_final_v2.svg" class="footer-logo" alt="Logo VG"> 
                    <div class="footer-logo-text">
                        <h3>VG</h3>
                        <p>Vite & Gourmand</p>
                    </div>
                </div>
                <br>
                <p>Traiteur Bordelais depuis 2001 Julie et José mettent leur savoir-faire artisanal au service de vos événements. <br> Une cuisine de saison, authentique et livrée avec soin dans toute la métropole.</p>
            </div>

            <address>
                <h3> CONTACT </h3>
                <ul>
                    <li> <?php echo $adressTitle ?? '42 Rue du Pas-Saint-Georges, 33000 Bordeaux' ; ?></li>
                    <li><?php echo $phoneTitle ?? '05 56 44 12 89' ; ?></li>
                    <li><a href="mailto:contact@vite-et-gourmand-traiteur.fr"><?php echo $mailTitle ?? 'contact@vite-et-gourmand-traiteur.fr' ; ?></a></li>
                    <li> <?php echo $horaireTitle ?? 'Lun - Dim : 9h00 - 19h00'; ?></li>
                </ul>
            </address>

            <div> 
                <h3>INFORMATIONS</h3>
                <a href="Mentions.php"> Mentions Légales </a>
                <br>
                <a href="CGV.php"> Conditions Générales de Ventes </a>
            </div>
        </footer>