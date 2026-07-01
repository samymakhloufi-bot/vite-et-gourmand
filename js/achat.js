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
        fraisLivraison = 0;
        distanceKM = 0;
        updateRecap();
    }
});

/*---------------------------
    Date Livraison condition
----------------------------*/
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('date');
    const dateError = document.getElementById('dateError');
    const form = dateInput.closest('form');
    const delaiCommande = parseInt(dateInput.dataset.delai); // Convertit en nombre

    // Calcul de la date minimale
    const today = new Date();
    const minDate = new Date(today);
    minDate.setDate(today.getDate() + delaiCommande);
    const minDateStr = minDate.toISOString().split('T')[0];

    dateInput.min = minDateStr;

    dateInput.addEventListener('input', () => {
        const selectedDate = new Date(dateInput.value);
        if (selectedDate < minDate) {
            dateError.style.display = 'inline';
            dateError.textContent = `La date doit être ≥ aujourd'hui + ${delaiCommande} jours`;
            dateInput.setCustomValidity(`La date doit être ≥ aujourd'hui + ${delaiCommande} jours`);
        } else {
            dateError.style.display = 'none';
            dateInput.setCustomValidity('');
        }
    });

    if (form) {
        form.addEventListener('submit', (e) => {
            const selectedDate = new Date(dateInput.value);
            if (selectedDate < minDate) {
                e.preventDefault();
                dateError.style.display = 'inline';
                dateInput.reportValidity();
            }
        });
    }
});