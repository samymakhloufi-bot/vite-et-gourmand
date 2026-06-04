document.addEventListener('DOMContentLoaded', function() {
/*----------------------------------
    Gestion des cookies pour Maps
-----------------------------------*/
    const cookieOverlay = document.getElementById('cookie-overlay');
    const hasConsentKey = 'maps-consent';

    // Vérif de l'overlay
    if (!cookieOverlay) {
        console.warn("L'élément cookie-overlay n'existe pas.");
    } else {
        function hasMapsConsent() {
            return localStorage.getItem(hasConsentKey) === 'true';
        }

        function updateLivraisonFields() {
            const hasConsent = hasMapsConsent();
            const villeSelect = document.getElementById('ville-livraison-select');
            const autreVilleInput = document.getElementById('ville-livraison-autre');
            const adresseLivraison = document.getElementById('address-livraison');
            const radioCard = document.getElementById('radio-card');
            const radioDevis = document.getElementById('radio-devis');

            if (!hasConsent) {
                if (villeSelect) villeSelect.disabled = true;
                if (autreVilleInput) autreVilleInput.disabled = true;
                if (adresseLivraison) adresseLivraison.disabled = true;
                if (radioCard) radioCard.disabled = true;
                if (radioDevis) radioDevis.disabled = true;
            } else {
                if (villeSelect) villeSelect.disabled = false;
                if (autreVilleInput) autreVilleInput.disabled = false;
                if (adresseLivraison) adresseLivraison.disabled = false;
                if (radioCard) radioCard.disabled = false;
                if (radioDevis) radioDevis.disabled = false;
            }
        }

        // Affiche la bannière si refus cookie
        if (!hasMapsConsent()) {
            cookieOverlay.style.display = 'flex';
            updateLivraisonFields();
        } else {
            cookieOverlay.style.display = 'none';
            updateLivraisonFields();
        }

        // Gestion des boutons
        document.getElementById('accept-cookies')?.addEventListener('click', () => {
            localStorage.setItem(hasConsentKey, 'true');
            cookieOverlay.style.display = 'none';
            updateLivraisonFields();
            // Met aussi un cookie pour le serveur
            document.cookie = `${hasConsentKey}=true; path=/; max-age=${60 * 60 * 24 * 365}`;
        });

        document.getElementById('refuse-cookies')?.addEventListener('click', () => {
            localStorage.setItem(hasConsentKey, 'false');
            cookieOverlay.style.display = 'none';
            updateLivraisonFields();
            document.cookie = `${hasConsentKey}=false; path=/; max-age=${60 * 60 * 24 * 365}`;
            const fraisCell = document.getElementById('frais-livraison-cell');
            if (fraisCell) {
                fraisCell.innerHTML = '<span style="color: red;">⚠️ Acceptez les cookies pour calculer les frais</span>';
            }
        });
    }

/*----------------------------
    Gestion de la livraison
-----------------------------*/

    if (hasMapsConsent()) {
        const villeSelect = document.getElementById('ville-livraison-select');
        const autreVilleDiv = document.getElementById('ville-livraison-autre-div');
        const adresseLivraison = document.getElementById('address-livraison');

        if (villeSelect && autreVilleDiv) {
            villeSelect.addEventListener('change', function() {
                if (this.value === 'autre') {
                    autreVilleDiv.style.display = 'block';
                    updateFraisLivraison();
                } else {
                    autreVilleDiv.style.display = 'none';
                    document.getElementById('ville-livraison-autre').value = '';
                    updateFraisLivraison();
                }
            });

            if (adresseLivraison) {
                adresseLivraison.addEventListener('blur', updateFraisLivraison);
            }
            document.getElementById('ville-livraison-autre')?.addEventListener('blur', updateFraisLivraison);
        }
    }

/*----------------------------
    Calcul des frais
-----------------------------*/
    async function updateFraisLivraison() {
        if (!hasMapsConsent()) {
            const fraisCell = document.getElementById('frais-livraison-cell');
            if (fraisCell) {
                fraisCell.innerHTML = '<span style="color: red;"> Acceptez les cookies pour calculer les frais en direct</span>';
            }
            return;
        }

        const villeSelect = document.getElementById('ville-livraison-select');
        const autreVille = document.getElementById('ville-livraison-autre')?.value || '';
        const adresse = document.getElementById('address-livraison')?.value || '';

        const fraisCell = document.getElementById('frais-livraison-cell');
        if (fraisCell) {
            fraisCell.textContent = "Calcul en cours...";
        }
        document.getElementById('distance_km').value = '0';
        document.getElementById('frais_livraison').value = '0';

        // Si Bordeaux → 0€
        if (villeSelect?.value === 'bordeaux') {
            if (fraisCell) fraisCell.textContent = "0 € (0 km)";
            document.getElementById('distance_km').value = '0';
            document.getElementById('frais_livraison').value = '0';
            document.getElementById('radio-card')?.disabled = false;
            document.getElementById('radio-devis')?.disabled = true;
            if (document.getElementById('radio-devis')) document.getElementById('radio-devis').checked = false;
            if (document.getElementById('radio-card')) document.getElementById('radio-card').checked = true;
            updateTotal();
            return;
        }

        // Si "Autre" mais pas de ville précisée
        if (villeSelect?.value === 'autre' && !autreVille) {
            if (fraisCell) fraisCell.textContent = "Veuillez préciser la ville";
            document.getElementById('radio-card')?.disabled = true;
            document.getElementById('radio-devis')?.disabled = false;
            if (document.getElementById('radio-devis')) document.getElementById('radio-devis').checked = true;
            return;
        }

        // Construis l'adresse complète
        const ville = villeSelect?.value === 'autre' ? autreVille : 'Bordeaux';
        const adresseComplete = `${adresse}, ${ville}, France`;

        try {
            const response = await fetch('/fraisLivraison.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `adresse=${encodeURIComponent(adresseComplete)}`
            });
            const data = await response.json();

            if (data.error) {
                throw new Error(data.error);
            }

            // Met à jour les champs cachés
            document.getElementById('distance_km').value = data.distance_km.toFixed(2);
            document.getElementById('frais_livraison').value = data.frais_livraison.toFixed(2);

            // Met à jour le tableau
            if (fraisCell) {
                fraisCell.textContent = `${data.frais_livraison.toFixed(2)} € (${data.distance_km.toFixed(1)} km)`;
            }

            // Active les options de paiement
            document.getElementById('radio-card')?.disabled = false;
            document.getElementById('radio-devis')?.disabled = false;

            updateTotal();
        } catch (error) {
            console.error("Erreur :", error);
            if (fraisCell) {
                fraisCell.innerHTML = '<span style="color: red;">⚠️ ' + error.message + '</span>';
            }
            document.getElementById('radio-card')?.disabled = true;
            document.getElementById('radio-devis')?.disabled = false;
            if (document.getElementById('radio-devis')) document.getElementById('radio-devis').checked = true;
        }
    }

/*----------------------------
    Mise à jour du total
-----------------------------*/
    function updateTotal() {
        const prixMenu = parseFloat('<?= $menu_prix_js ?>');
        const nbPers = parseInt('<?= $nb_pers_js ?>');
        const fraisLivraison = parseFloat(document.getElementById('frais_livraison')?.value || 0);
        const total = (prixMenu * nbPers) + fraisLivraison;

        const totalCell = document.getElementById('total-cell');
        if (totalCell) {
            totalCell.textContent = `${total.toFixed(2)} €`;
        }
    }


/*----------------------------
    Initialisation
-----------------------------*/
    if (hasMapsConsent()) {
        const adresse = document.getElementById('address-livraison')?.value;
        const villeSelect = document.getElementById('ville-livraison-select')?.value;
        if (adresse || villeSelect === 'autre') {
            updateFraisLivraison();
        }
    }
});