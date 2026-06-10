/*------------------------------
Chargement dynamique de l'API Google Maps
-------------------------------*/
function loadGoogleMaps(){
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${GOOGLE_MAPS_API_KEY}&libraries=places&callback=initAutocomplete`;
    document.head.appendChild(script);
}

/*--------------------------------
    Frais de Livraison MAPS
---------------------------------*/

const villeSelect = document.getElementById('ville-livraison');
const villeAutreDiv = document.getElementById('ville-livraison-autre-div');
const villeAutreInput = document.getElementById('ville-livraison-autre');
const fraisDisplay = document.querySelector('.detail-commande tfoot tr:first-child td:last-child');
const totalDisplay = document.querySelector('.detail-commande tfoot tr:last-child td:last-child');

let fraisLivraison =  0;
let distanceKM =0;

/*-----------------------------
    Calcul frais de livraison via API
------------------------------*/
villeAutreInput.addEventListener('blur', () => {
    const ville = villeAutreInput.value.trim();
    if(!ville) return;
    calculerFrais(ville);
});
function calculerFrais(ville){
    fetch(BASE_URL + '/traitement/frais-livraison.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'adresse=' + encodeURIComponent(ville + ', France')
    })
    .then(res => res.json())
    .then(data => {
        if(data.error){
            alert('Adresse non reconnue : ' + data.error);
            return;
        }
        fraisLivraison = data.frais_livraison;
        distanceKM = data.distance_km;
        updateRecap();
        document.getElementById('hidden-frais').value = fraisLivraison;
        document.getElementById('hidden-distance').value = distanceKM;
    })
    .catch((err) => {
        alert ('Erreur lors du calcul des frais de livraison')
});
};

function updateRecap(){
    const total = (menuPrix * nbPers) + fraisLivraison;
    fraisDisplay.textContent = fraisLivraison.toFixed(2) + ' €(' + distanceKM.toFixed(1) + ' km)';
    totalDisplay.textContent = total.toFixed(2) + ' €';
}


/*--------------------------
    Autocomplete Google Maps
---------------------------*/
function initAutocomplete(){
    const input = document.getElementById('ville-livraison-autre');

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['(cities)'],
        componentRestrictions: {country : 'fr'},
        fields: ['name', 'formatted_address']
    });

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        if(!place.name) return;
        calculerFrais(place.name);

    });
    }