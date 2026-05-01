document.addEventListener('DOMContentLoaded', () => {
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
    }});

//Modifier Menu / Espace Employé -Admin
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
// Menu toggle
function toggleMenu(header) {
    const body = header.nextElementSibling;
    const chevron = header.querySelector('.chevron');
    const isOpen = !body.classList.contains('hidden');
    document.querySelectorAll('.menu-body').forEach(b => b.classList.add('hidden'));
    document.querySelectorAll('.chevron').forEach(c => c.classList.remove('open'));
    if (!isOpen) {
        body.classList.remove('hidden');
        chevron.classList.add('open');
    }
}
//Commande toggle
function toggleCmd(header) {
    const body = header.nextElementSibling;
    const chevron = header.querySelector('.chevron');
    const isOpen = !body.classList.contains('hidden');
    document.querySelectorAll('.client-body').forEach(b => b.classList.add('hidden'));
    document.querySelectorAll('.client-card-header .chevron').forEach(c => c.classList.remove('open'));
    if (!isOpen) {
        body.classList.remove('hidden');
        chevron.classList.add('open');
    }
}
//Enregistrement Menu
function saveMenu(id, btn) {
    const fields = document.querySelectorAll(`.editable[data-id="${id}"]`);
    const data = { id };
    fields.forEach(f => { data[f.dataset.field] = f.innerText.trim(); });

    fetch('/VG/traitement/update-menu.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        const toast = document.getElementById('toast-' + id);
        if (result.success) {
            btn.style.background = '#1D9E75';
            btn.textContent = 'Enregistré';
            toast.textContent = 'Modifications sauvegardées';
            toast.style.color = '#1D9E75';
        } else {
            btn.style.background = '#E24B4A';
            btn.textContent = 'Erreur';
        }
        setTimeout(() => {
            btn.style.background = '';
            btn.textContent = 'Enregistrer';
            toast.textContent = '';
        }, 2000);
    });
}

// Filtre menu
document.getElementById('search-menu').addEventListener('input', function() {
    const q = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    document.querySelectorAll('.menu-card').forEach(card => {

        if(q === ""){ card.style.display = '';
            return;
        }

        const fields = card.querySelectorAll('[data-field]');
        let combinedText = "";
        fields.forEach(f => { combinedText += " " + f.innerText.trim(); });
    
        const searchTarget = combinedText.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        let isMatch = searchTarget.includes(q);

        //filtre vegan / non-vegan 
        if(q === "vegan" && searchTarget.includes("non-vegan") && !searchTarget.match(/(^|\s)vegan(\s|$)/)) {
            isMatch = false;}
            
        card.style.display = isMatch ? '' : 'none';
        
    });
});

// Commandes toggle
function toggleCmd(header) {
    const body = header.nextElementSibling;
    const chevron = header.querySelector('.chevron');
    const isOpen = !body.classList.contains('hidden');
    document.querySelectorAll('.client-body').forEach(b => b.classList.add('hidden'));
    document.querySelectorAll('.chevron').forEach(c => c.classList.remove('open'));
    if (!isOpen) { body.classList.remove('hidden'); chevron.classList.add('open'); }
}

//Check Annulation
function checkAnnul(idCommande){
    const select = document.getElementById('sel-' + idCommande);
    const annulSection = document.getElementById('annul-' + idCommande);

    if(select && annulSection){
        if (select.value ==='annulee'){
            annulSection.style.display ='block';
        } else {
            annulSection.style.display = 'none';
        }
    }
}

function confirmerAnnulation(id){
    const container = document.getElementById('annul-' + id);

    const mode = container.querySelector('select[name="mode_contact]').value;
    const contact = container.querySelector('input').value.trim();
    const motif = container.querySelector('textarea').value.trim();

    if(contact === "" || motif ===""){
        alert("Attention : Le nom du contact ainsi que le motif du refus sont obligatoire.");
        container.querySelectorAll('input, textarea').forEache(el =>{
            if(el.value.trim() ==="") el.style.border = "1px solid red";
            else el.style.border = "";
        });
        return;
    }
    
}


//Enregistrement Statut
function saveStatut(id, btn) {
    const statut = document.getElementById('sel-' + id).value;
    const toast  = document.getElementById('toast-' + id);

    fetch('/VG/traitement/updateStatus.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_commande: id, statut: statut })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.style.background = '#1D9E75';
            btn.textContent = 'Enregistré';
            toast.textContent = 'Statut mis à jour';
        } else {
            btn.style.background = '#E24B4A';
            btn.textContent = 'Erreur';
        }
        setTimeout(() => {
            btn.style.background = '';
            btn.textContent = 'Enregistrer';
            toast.textContent = '';
        }, 2000);
    });
}


// Filtre client + statut
document.getElementById('search-client')?.addEventListener('input', filtrerCommandes);
document.getElementById('search-status')?.addEventListener('change', filtrerCommandes);

function filtrerCommandes() {
    const client = document.getElementById('search-client').value.toLowerCase();
    const statut = document.getElementById('search-status').value;
    document.querySelectorAll('.client-card').forEach(card => {
        const matchClient = card.dataset.nom.includes(client);
        const matchStatut = !statut || card.dataset.statut === statut;
        card.style.display = matchClient && matchStatut ? '' : 'none';
    });
}