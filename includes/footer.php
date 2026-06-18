<footer>
    <div id="cookie-overlay" class="cookie-overlay">
                <div class="cookie-banner">
                    <p>
                        <strong> Cookies & confidentialité</strong><br>
                        Ce site utilise Google Maps pour le calcul des frais de livraison, 
                        ce qui implique un transfert de données vers les serveurs Google. 
                        <a href="<?= BASE_URL ?>/mentions.php" target="_blank" aria-label="s'ouvre les mentions légales dans un nouvel onglet">En savoir plus</a>
                    </p>
                    <div class="cookie-buttons">
                        <button id="refuse-cookies" class="btn-cookie-refuse">Refuser</button>
                        <button id="accept-cookies" class="btn-cookie-accept">Accepter</button>
                    </div>
                </div>
                
            </div>
            <script src="<?= BASE_URL?>/js/cookie.js"></script>
            <div> 
                <div class="footer-logo-group">
                    <img src="<?= BASE_URL ?>/Images/Logo_beige_final_v2.svg" class="footer-logo" alt="Logo Vite & Gourmand"> 
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
                <?php
                $stmt_info = $pdo->query("SELECT * FROM renseignement ");
                $informations = $stmt_info->fetch();
                ?>

                <address>
                    <address>
                <p><?= $informations['adresse'] ?? '42 Rue du Pas-Saint-Georges, 33000 Bordeaux' ?></p>
            </address>
                </address>


                <ul>
                    <li><?php echo $informations['telephone'] ?? '05 56 44 12 89' ; ?></li>
                    <li><a href="mailto:contact@vite-et-gourmand-traiteur.fr"><?php echo $informations['email'] ?? 'contact@vite-et-gourmand-traiteur.fr' ; ?></a></li>
                </ul>

            </address>

            <div>
                <h3>HORAIRES</h3>
                <ul>
                    <?php 
                        $stmt_h = $pdo->query("SELECT * FROM horaires ORDER BY Id_horaire ASC");
                        $horaires_footer = $stmt_h->fetchAll();
                    ?>
                    <?php foreach ($horaires_footer as $h): ?>
                        <?php if (!$h['ferme']):; ?>
                            <li> <?= htmlspecialchars($h['jour']) ?> - <?= substr($h['ouverture_matin'], 0, 5) ?> à <?= substr($h['fermeture_apm'], 0, 5) ?></li>
                        <?php else: ?>
                            <li> <?= htmlspecialchars($h['jour']) ?> - Fermé</li>    
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                
                    </div>

            <div> 
                <h3>INFOS</h3>
                <a href="<?= BASE_URL ?>/mentions.php"> Mentions Légales et politique de confidentialité</a>
                <br>
                <a href="<?= BASE_URL ?>/CGV.php"> Conditions Générales de Ventes </a>
            </div>
        </footer>