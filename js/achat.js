/*---------------------------
    input ville livraison
----------------------------*/
const lieuSelect = document.getElementById('ville-livraison');
const villeAutre = document.getElementById('ville-livraison-autre-div');

lieuSelect.addEventListener('change', () => {
    if(lieuSelect.value ==='autre'){
        villeAutre.style.display ='block';
    }else{
        villeAutre.style.display = 'none';
        document.getElementById('ville-livraison-autre').value ='' ;
    }
});


document.getElementById('adresse-livraison').addEventListener('blur', updateFraisLivraison);
document.getElementById('ville-livraison-autre').addEventListener('change', updateFraisLivraison);

//Calcul Frais de livraison via AJAX
async function updateFraisLivraison(){
    const villeSelect = document.getElementById('ville-livraison-select').value;
    const autreville = document.getElementById('ville-livraison-autre').value;
    const adresse = document.getElementById('adresse-livraison').value;

    document.getElementById('distance_km').value = '0';
    document.getElementById('frais_livraison').value = '0';

    // Si bordeaux frais = 0€
    if(villeSelect === 'bordeaux'){
        document.getElementById('radio-card').disabled = false;
        document.getElementById('radio-devis').disabled = true;
        document.getElementById('radio-devis').disabled = false;
        document.getElementById('radio-card').disabled = true;
        updateTotal();
        return;
    }

    //Si ville = Autre mais pas de précision, bloque carte
    if(villeSelect === 'autre' && !autreville){
        document.getElementById('radio-card').disabled = true;
        document.getElementById('radio-devis').disabled = false;
        document.getElementById('radio-devis').checked = true;
        return;
    }

    //Adress complète pour API
    const ville = villeSelect === 'autre' ? autreville : 'Bordeaux';
    const adresseComplete = `${adresse}, ${ville}, France`;

    try {
        const response = await fetch('/calcul-frais.php', {
            method : 'POST',
            headers : {'Content-Type' : 'application/x-www-form-urlencoded'},
            body : `adresse=${encodeURIComponent(adresseComplete)}`
        });
        const data = await response.json();

        //Mise à jour des champs
        document.getElementById('distance_km').value = data.distance_km.toFixed(2);
        document.getElementById('frais_livraison').value = data.frais_livraison.toFixed(2);
    
        //Activer ou désactiver les options de paiement
        updateTotal();
    } catch (error) {
        console.error("erreur :", error);
        document.getElementById('radio-card').disabled = true;
        document.getElementById('radio-devis').disabled = false;
        document.getElementById('radio-devis').checked = true;
    }
}

// Mise à jour du total en fonction des frais de livraison
function updateTotal(){
    const prixMenu = parseFloat('<=?= $menu_prix ?>');
    const nbPers = parseInt('<=?= $nb_pers ?>');
    const fraisLivraison = parseFloat(document.getElementById('frais_livraison').value) || 0;
    const sousTotal = prixMenu * nbPers;
    const total = sousTotal + fraisLivraison;

    // Affichage du total
    const totalCell = document.querySelector('.detail-commande tfoot td:last-child');
    totalCell.textContent = `${total.toFixed(2)} €`;
}