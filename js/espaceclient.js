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

document.querySelectorAll('.editable').forEach(cell => {
    cell.addEventListener('blur', () => {
        const id = cell.dataset.id;
        const field = cell.dataset.field;
        const value = cell.innerText.trim();

        fetch('/VG/traitement/update-menu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, field, value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cell.style.outline = '2px solid green';
                setTimeout(() => cell.style.outline = '', 2000);
            } else {
                cell.style.outline = '2px solid red';
            }
        });
    });
});   