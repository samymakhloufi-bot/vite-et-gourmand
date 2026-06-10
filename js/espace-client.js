
document.addEventListener('DOMContentLoaded', () => {
/*----------------  
    SIDEBAR
-----------------*/

    const buttons = document.querySelectorAll('[data-target]');
    
    if (buttons.length > 0) {
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.dataset.target;
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    document.querySelectorAll('.account-panel').forEach(section => {
                        section.classList.remove('active');
                    });

                    targetElement.classList.add('active');

                    buttons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                } else {
                    console.error("Cible non trouvée pour l'ID :", targetId);
                }
            });
        });
    }

/*-------------------
    Envois avis
--------------------*/

    document.getElementById('form-avis')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const toast  = document.getElementById('toast-avis');

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {
            toast.textContent = data.success ? 'Merci pour votre retour. À bientôt.'
            : (data.error || 'Erreur lors de l\'envois de l\'avis.');
            toast.style.color = data.success ? '#1D9E75' :'#E74C3C'; 

            if(data.success) form.reset();

            setTimeout(() => toast.textContent = '', 5000);
            })
        .catch(()=> {
            toast.textContent = 'Erreur réseau. Veuillez réessayer.';
            toast.style.color ='#E74C3C';
            setTimeout(() => {
                toast.textContent='', 3000;
        });    
    });

/*---------------------------
    commande card / body
---------------------------*/

    document.querySelectorAll('.btn-details').forEach(btn => {
        btn.addEventListener('click', () => {
        const card = btn.closest('.commande-card');
        const body = card.querySelector('.commande-body');
        const isOpen = body.classList.contains('open');

        document.querySelectorAll('.commande-body').forEach(b => b.classList.remove('open'));
        document.querySelectorAll('.btn-details').forEach(c => c.classList.remove('open'));
        if (!isOpen) {
            body.classList.add('open');
            btn.classList.add('open');
        }
    });
});

/*----------------------------
    Mes commandes card / modif
-----------------------------*/
//Open Modif
    document.querySelectorAll('.btn-edit-cmd').forEach(btnEdit => {
        btnEdit.addEventListener('click', () => {
        const body = btnEdit.closest('.commande-body');
        const edit = body.querySelector('.cmd-edit');

            edit.classList.add('open');
            btnEdit.classList.add('open');
    });
});

//Close Modif

    document.querySelectorAll('.btn-cancel-cmd').forEach(btnEdit => {
        btnEdit.addEventListener('click', () => {
        const body = btnEdit.closest('.commande-body');
        const edit = body.querySelector('.cmd-edit');

            edit.classList.remove('open');
            btnEdit.classList.remove('open');
    });
});

/*---------------------------
    Enregistrer modif cmd
----------------------------*/

function saveCmd(idCommande, btn){
    const card = btn.closest('.commande-card');

    //récupération valeurs édité
    const data = {
        id_commande : idCommande,
        quantite : card.querySelector('input[type="number"]').value,
        date_livraison : card.querySelector('input[type="date"]').value,
        heure_livraison :card.querySelector('input[type="time"]').value,
        adresse_livraison : card.querySelectorAll('input[type="text"]')[0].value,
        ville_livraison : card.querySelectorAll('input[type="text"]')[1].value,
        complement : card.querySelector('[data-info-row="complement"]').innerText.trim(),
    }

    fetch(BASE_URL +'/traitement/modif-commande.php' ,{
        method : 'POST',
        headers : {
            'Content-Type' : 'application/json',
            'X-Requested-With' : 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })

    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const toast = document.getElementById('saved-toast-'+idCommande);
            toast.textContent ='Enregistré';
            setTimeout(() => toast.textContent ='' ,2000);
            card.querySelector('.cmd-edit').classList.remove('open');
        }else{
            alert('Erreur : ' + data.error);
        }
    });
}

/*---------------------------
    Annuler cmd
----------------------------*/

function cancelCmd(idCommande, btn){

    //confirmation de l'annulation
    if(!confirm('Êtes-vous sûr de vouloir annuler votre commande ?')){
        return;}

    fetch(BASE_URL +'/traitement/annul-commande.php' ,{
        method : 'POST',
        headers : {
            'Content-Type' : 'application/json',},
        body: JSON.stringify({id_commande: idCommande})
    })

    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const toast = document.getElementById('cancel-toast-'+idCommande);
            toast.textContent ='Commande annulé';
            setTimeout(() => toast.textContent ='' ,2000);
            
            //Enlever btn-details / btn-delete
            btn.style.display = 'none';
            btn.closest('.commande-card').querySelector('btn-details').style.display = 'none';


        }else{
            alert('Erreur : ' + data.error);
        }
    });
}
});
})