const radioDiv = document.querySelectorAll('.radio-div');

/*--------------------------------------------
    Ajout ou suppr element radio
---------------------------------------------*/
radioDiv.forEach(Option => {
    Option.addEventListener('click', (e) =>{
        e.preventDefault();
        radioDiv.forEach(opt => opt.classList.remove('selected'));
        Option.classList.add('selected');
        document.getElementById(Option.dataset.target).checked = true;
    });
});

/*--------------------------------------------
    button counter val order
---------------------------------------------*/
function change(btn, dir){
    const input = btn.parentElement.querySelector('.counter-val');
    const val = parseInt(input.value) + dir;
    if (val >= 1 && val <= 999) input.value = val;
}
const formCommande = document.getElementById('form-commande');
    if(formCommande){
        document.getElementById('form-commande').addEventListener('submit', function() {
    
        const btn = this.querySelector('.btn-direct-order');
        btn.disabled = true;
        btn.innerText = "Envoi en cours...";
        });
}

/*--------------------------------------------
    Verif du stock
---------------------------------------------*/

function verifierStock(input) {
    const form = input.closest('form');
    const error = form?.querySelector('.stock-error');

    const quantite = parseInt(input.value, 10);
    const stock = 
        input.max !== ''? 
        parseInt(input.max, 10): null;

    const stockDepasse = 
        stock !== null && 
        !Number.isNaN(quantite) && 
        quantite > stock;

    if (stockDepasse) {
        const message = `Stock insuffisant : seulement ${stock} restant(s).`;

        input.setCustomValidity(message);

        if (error) {
            error.textContent = message;
            error.hidden = false;
        }

        return false;
    }

    input.setCustomValidity('');

    if (error) {
        error.textContent = '';
        error.hidden = true;
    }

    return true;
}

function change(btn, dir) {
    const input = btn.parentElement.querySelector('.counter-val');
    const minimum = parseInt(input.min, 10) || 1;
    const valeur = (parseInt(input.value, 10) || minimum) + dir;

    if (valeur >= minimum) {
        input.value = valeur;
    }

    verifierStock(input);
}

document.querySelectorAll('.form-menu-order').forEach(form => {
    const input = form.querySelector('input[name="nb_pers"]');

    input?.addEventListener('input', () => {
        verifierStock(input);
    });

    form.addEventListener('submit', event => {
        if (!verifierStock(input)) {
            event.preventDefault();
        }
    });
});