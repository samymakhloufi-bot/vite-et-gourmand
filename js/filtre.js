//Récupérer les éléments
const filtreBtn = document.getElementById('filter-toggle');
const filtreMenu = document.querySelector('.sidebar-wrapper');

//récupérer chevron 
const chevron = document.querySelector('.toggle-chevron');

//Afficher / Masquer le menu de filtre
filtreBtn.addEventListener('click', () => {
    filtreMenu.classList.toggle('sidebar-open');
    
    //Basculer les chevrons
    const isOpen = filtreMenu.classList.contains('sidebar-open');
    chevron.style.transform = isOpen ? 'rotate(-90deg)' : 'rotate(90deg)';

});


//filtre theme menu-card
const selTheme    = document.getElementById('select-theme');
const tagsRegime   = document.querySelectorAll('#tags-regime .tag');
const selPriceFork = document.getElementById('select-price-fork');
const inputPersonnes = document.getElementById('select-nb-personnes');
const inputPrix     = document.getElementById('select-prix');
const cards       = document.querySelectorAll('.menu-card');

function filtrer() {
    const theme    = selTheme.value;
    const regime = document.querySelector('#tags-regime .tag.on').dataset.value;
    const personnes = parseInt(inputPersonnes.value);
    const prix     = parseFloat(inputPrix.value);
    const prixForkValue = selPriceFork.value;
    const prixFork = prixForkValue ? JSON.parse(prixForkValue) : null;

    cards.forEach(card => {
        const cardTheme   = card.dataset.theme;
        const cardRegime  = card.dataset.regime;
        const cardNbMax   = parseInt(card.dataset.nbMax);
        const cardPrix    = parseFloat(card.dataset.prix);

        let visible = true;

        // Filtre thème
        if (theme && cardTheme !== theme) visible = false;

        // Filtre régime
        if (regime && cardRegime !== regime) visible = false;

        // Filtre nb personnes
        if(!isNaN(personnes) && cardNbMax < personnes) visible = false;
        if(!isNaN(prix) && cardPrix > prix) visible = false;

        //Filtre prix fouchette
        if (prixFork && (cardPrix < prixFork[0] || cardPrix > prixFork[1])) visible = false;


        card.style.display = visible ? '' : 'none';
    });
}

//Gestion des tags régime
tagsRegime.forEach(tag => {
    tag.addEventListener('click', () => {
        tagsRegime.forEach(t => t.classList.remove('on'));
            tag.classList.add('on');
            filtrer();
        });
});


[selTheme, selPriceFork].forEach(sel => {sel.addEventListener('change', filtrer);});
[inputPersonnes, inputPrix].forEach(input => {input.addEventListener('input', filtrer);});

//Bouton de réinitialisation
const btnReset = document.querySelector('.filter-reset');
btnReset.addEventListener('click', () => {
    //Réinitialiser les sélecteurs
    selTheme.value = '';
    selPriceFork.value = '';
    inputPersonnes.value = '';
    inputPrix.value = '';
    
    //Réinitialiser les tags régime
    tagsRegime.forEach(t => t.classList.remove('on'));
    tagsRegime[0].classList.add('on'); 

    cards.forEach(card => card.style.display = ''); 

    filtrer();
});
