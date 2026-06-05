<?php $activePage= 'Conditions Générales de Vente'; 
require_once './login.php';
session_start();
?>
<!DOCTYPE html>

<html lang="fr">

        <?php include './includes/head.php';?>
    
    <body>
        <?php include './includes/header.php';?>

        <main>

            <div class="nos-menus-banner">
                <div class="nos-menus-banner_diag"></div>
                <div class="nos-menus-banner_dark_diag"></div>
                <div class="nos-menus-banner_text">
                <h2>Conditions Générales de <em>Ventes</em></h2></div>
            </div>

            <div class="information-wrapper">
                <p class="update">Dernière mise à jour : Juin 2026</p>
                <div class="information">
                    <h3>1. Objet</h3>
                    <p>
                        Les présentes conditions générales de vente régissent les relations contractuelles entre Vite & 
                        Gourmand(ci-après "le Traiteur") et tout client(ci-après "le Client") passant commande via le site internet, par téléphone ou directement auprès de nos services.
                    </p>
                </div>

                <div class="information">
                    <h3>2. Commandes</h3>
                    <span>2.1 PROCESSUS DE COMMANDE </span>
                    <ul>
                        <li>Les demandes de commandes sont reçues via l'espace employé de Vite & Gourmand</li>
                        <li>Vite & Gourmand se réserve le droit d'accepter ou de refuser toute commande.</li>
                        <li>Une commande n'est confirmée que lorsque l'équipe l'a validée manuellement. La confirmation est alors visible
                            dans l'espace client, via le statut de la commande (ex : "En attente", "Accepté", "Annulée").
                        </li>
                        <li>Le Client est informé de la décision par notification dans l'espace client et/ou par mail. </li>
                    </ul>

                    <span>2.2 DÉLAI DE COMMANDE</span>
                    <ul>
                        <li><b>Commande standard</b> </b>: Minimum 72h avant la livraison.</li>
                        <li><b>Événements de plus de 50 personnes </b>: Minimum 10 jours ouvrés avant la livraison.</li>
                        <li>Les délais sont indicatifs et peuvent varier selon la disponibilité des produits.</li>
                    </ul>

                </div>

                <div class="information">
                    <h3>3. Tarifs & Paiement</h3>
                    <span>3.1 Tarifs</span>
                    <ul>
                        <li>Les prix sont indiqués en euros TTC et sont valables au moment de la commande.</li>
                        <li>Aucune modification de tarif ne sera appliquée après confirmation de la commande, sauf accord exprès du Client.</li>
                    </ul>
                    <span>3.2 Modalités de paiement</span>
                    <ul>
                        <li>Le paiement intégral est dû lors de la prise de commande.</li>
                        <li><b>Paiement accepté par </b>: 
                            <ul>
                            <li>Virement bancaire (RIB communiqué sur devis).</li>
                            <li>Carte bancaire via plateforme sécurisée (Stripe/Paypal).</li>
                        </ul></li>
                    </ul>

                    <span>3.3 Frais de livraison</span>
                    <table>
                        <thead>
                            <th>Zone</th>
                            <th>Tarif</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Bordeaux (intra-muros)</th>
                                <td>Gratuit</td>
                            </tr>
                            <tr>
                                <th>Hors Bordeaux</th>
                                <td>5€ + 0,65€/km</td>
                            </tr>
                        </tbody>
                        <ul>
                            <li>Les frais sont calculés automatiquement lors de la commande et affichés avant validation.</li>
                        </ul>
                    </table>
                </div>

                <div class="information">
                    <h3>4. Annulation</h3>
                    <p>Toute annulation doit être notifiée (email ou téléphone). </p>
                    <table>
                        <thead>
                            <th>Délai avant la livraison</th>
                            <th>Conséquences</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Plus de 7 jours</th>
                                <td>Remboursement itnégral sous 15 jours.</td>
                            </tr>
                            <tr>
                                <th>Entre 72h et 7jours</th>
                                <td>Retenue de 50% du montant total.</td>
                            </tr>
                            <tr>
                                <th>Moins de 72h</th>
                                <td>Montant total conservé.</td>
                            </tr>
                        </tbody>
                        <ul>
                            <li>Les frais sont calculés automatiquement lors de la commande et affichés avant validation.</li>
                        </ul>
                    </table>
                </div>

                <div class="information">
                    <h3>5. Livraison</h3>

                    <ul>
                        <li><b>Lieu </b>: À l'adresse indiquée par le Client (Validée par Vite & Gourmand).</li>
                        <li><b>Horaires </b>: Selon créneau convenu lors de la commande.</li>
                        <li><b>Retard </b>: En cas de retard indépendant de notre volonté, le Client sera informé dans les plus brefs
                            deélais. Aucun dédommagement ne sera dû pour un retard inférieur à 2h.y
                        </li>
                    </ul>
                </div>

                <div class="information">
                    <h3>6. Litiges</h3>    
                    <ul>
                        <li><b>Solution amiable</b> : En cas de litige, une solution sera recherchée en priorité par échange écrit.</li>
                        <li><b>Médiation</b>: Le client peut saisir le médiateur de la consommation : Médiateur du Tourisme et des Voyages -<a href="www.mtv.travel">www.mtv.travel</a>.</li>
                        <li><b>Tribunaux </b>compétents : À défaut de solution sous 30 jours, les tribunaux de Bordeaux seront saisis, conformément au droit français.</li>
                    </ul>
                </div>

                <div class="information">
                    <h3>7. Données personnelles </h3>
                        <p>Les données collectées sont utilisées uniquement pour la gestion des commandes. Conformément au RGPD, le Client dispose d’un droit d’accès, 
                            de rectification et de suppression de ses données (contact : vetg@traiteur.fr). </p>
                    
                </div>

                <div class="information">
                    <h3>8. Divers</h3>
                    <ul>
                        <li><b>Droit applicable</b> : Droit français</li>
                        <li><b>Modification des CGV </b>: Vite & Gourmand se réserve le droit de modifier les présenter CGV.
                            Les CGV applicables sont celles en vigueur au moment de la commande.
                        </li>
                    </ul>
                </div>
                <div class="information">
                    <h3>9. Prêt de matériel</h3>
                    <p>En cas de prêt de matériel par Vite & Gourmand, le client s’engage à le restituer en parfait état
                        dans les délais convenus. Dès que le statut "Matériel prêté" est atteint, le client reçoit un email
                        de rappel lui indiquant que :
                    </p>
                    <ul>
                        <li>S’il ne restitue pas le matériel <strong>sous 10 jours ouvrés</strong> à compter de la date de réception de cet email,
                            il devra s’acquitter d’une <strong>pénalité de 600 €</strong> (conformément à l’article X des présentes conditions générales de vente).
                        </li>
                        <li>Pour organiser la restitution, le client doit <strong>prendre contact avec notre société</strong>
                            par email à <a href="mailto:contact@vite-et-gourmand.fr">contact@vite-et-gourmand.fr</a>
                            ou par téléphone au 05 56 44 12 89.
                        </li>
                    </ul>
                    <p>Cette pénalité couvre les frais de remplacement, de location ou de réparation du matériel non restitué.
                        Aucun remboursement ne sera effectué tant que le matériel n’aura pas été restitué.
                    </p>
                </div>
            </div>
        </main>

    </body>

        <?php include __DIR__.'/includes/footer.php' ; ?>

</html>