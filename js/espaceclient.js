//Espace Client Open close order/account
const btnCommande = document.querySelector('.btn-commande');
const btnInfos = document.querySelector('.btn-infos');
const orderSection = document.getElementById('orders-wrapper');
const accountSection = document.getElementById('sub-form');


btnCommande.addEventListener('click', () => {
    orderSection.style.display = 'flex';
    accountSection.style.display = 'none';
});

btnInfos.addEventListener('click', () => {


    orderSection.style.display = 'none';
    accountSection.style.display = 'flex';
});