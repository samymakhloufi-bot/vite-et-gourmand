document.addEventListener('DOMContentLoaded', () => {

/*---------------------
    FILTRE COMMANDES
----------------------*/
    document.getElementById('search-client')?.addEventListener('input', filtrerCommandes);
    document.getElementById('search-statut')?.addEventListener('change', filtrerCommandes);

/*----------------
    FILTRE MENUS
-----------------*/
    document.getElementById('search-menu')?.addEventListener('input', function() {
        const q = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        document.querySelectorAll('.menu-card').forEach(card => {
            if (q === '') { card.style.display = ''; return; }
            let text = '';
            card.querySelectorAll('[data-field]').forEach(f => text += ' ' + f.innerText.trim());
            const target = text.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            card.style.display = target.includes(q) ? '' : 'none';
        });
    });

/*----------------
    FILTRE AVIS
-----------------*/
    document.getElementById('filter-avis')?.addEventListener('change', function() {
        const filtre = this.value;
        document.querySelectorAll('.avis-item').forEach(item => {
            item.style.display = (!filtre || item.dataset.statut === filtre) ? 'block' : 'none';
        });
    });

});

/*--------------------------
    TOGGLE COMMANDE CARD
---------------------------*/
function toggleCmd(header) {
    const card = header.closest('.client-card');
    const body = card.querySelector('.client-body');
    const chevron = header.querySelector('.chevron');
    const isOpen = !body.classList.contains('hidden');
    document.querySelectorAll('.client-body').forEach(b => b.classList.add('hidden'));
    document.querySelectorAll('.client-card-header .chevron').forEach(c => c.classList.remove('open'));
    if (!isOpen) {
        body.classList.remove('hidden');
        chevron.classList.add('open');
    }
}

/*----------------------------------
    ENREGISTREMENT STATUT COMMANDE
----------------------------------*/

function saveStatut(id, btn) {
    const statut = document.getElementById('sel-' + id).value;
    const toast  = document.getElementById('toast-' + id);

    fetch(BASE_URL +'/traitement/update-status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_commande: id, statut })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.style.background = '#1D9E75';
            btn.textContent = 'Enregistré';
            if (toast) { toast.textContent = 'Statut mis à jour'; toast.style.color = '#1D9E75'; }
            const card = btn.closest('.client-card');
            if (card) card.dataset.statut = statut;
        } else {
            btn.style.background = '#E24B4A';
            btn.textContent = 'Erreur';
        }
        setTimeout(() => {
            btn.style.background = '';
            btn.textContent = 'Enregistrer';
            if (toast) toast.textContent = '';
        }, 2000);
    });
}

/*----------------------------------
    CHECK ANNULATION CMD
----------------------------------*/

function checkAnnul(id) {
    const select = document.getElementById('sel-' + id);
    const annulSection = document.getElementById('annul-' + id);
    if (select && annulSection) {
        annulSection.style.display = select.value === 'annulee' ? 'block' : 'none';
    }
}

/*----------------------------------
    CONFIRMER ANNULATION CMD
----------------------------------*/

function confirmerAnnulation(id) {
    const container = document.getElementById('annul-' + id);
    const mode    = container.querySelector('select[name="mode_contact"]').value;
    const contact = container.querySelector('input').value.trim();
    const motif   = container.querySelector('textarea').value.trim();

    if (!contact || !motif) {
        alert('Le nom du contact et le motif sont obligatoires.');
        container.querySelectorAll('input, textarea').forEach(el => {
            el.style.border = el.value.trim() === '' ? '1px solid red' : '';
        });
        return;
    }

    fetch(BASE_URL + '/traitement/annuler-commande.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_commande: id, mode_contact: mode, motif })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const toast = document.getElementById('toast-' + id);
            if (toast) { toast.textContent = 'Commande annulée'; toast.style.color = '#E24B4A'; }
            const card = container.closest('.client-card');
            if (card) card.dataset.statut = 'annulee';
        }
    });
}

/*----------------------------------
    FILTRE COMMANDES (fonction)
----------------------------------*/

function filtrerCommandes() {
    const client = document.getElementById('search-client')?.value.toLowerCase() ?? '';
    const statut = document.getElementById('search-statut')?.value ?? '';
    document.querySelectorAll('.client-card').forEach(card => {
        const matchClient = card.dataset.nom?.includes(client) ?? true;
        const matchStatut = !statut || card.dataset.statut === statut;
        card.style.display = matchClient && matchStatut ? '' : 'none';
    });
}

/*----------------
    Menu card
----------------*/

    document.querySelectorAll('.menu-card-header').forEach(header => {
        header.addEventListener('click', () => {
        const card = header.closest('.menu-card');
        const body = card.querySelector('.menu-body');
        const chevron = header.querySelector('.chevron');
        const isOpen = body.classList.contains('open');

        document.querySelectorAll('.menu-body').forEach(b => b.classList.remove('open'));
        document.querySelectorAll('.menu-card-header .chevron').forEach(c => c.classList.remove('open'));
        if (!isOpen) {
            body.classList.add('open');
            chevron.classList.add('open');
        }
    });
});

/*----------------------------------
    ENREGISTREMENT MENU
----------------------------------*/
function saveMenu(id, btn) {
    const fields = document.querySelectorAll(`.editable[data-id="${id}"]`);
    const data = { id };
    fields.forEach(f => { data[f.dataset.field] = f.innerText.trim(); });

    fetch(BASE_URL + '/traitement/update-menu.php', {
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
            if (toast) { toast.textContent = 'Modifications sauvegardées'; toast.style.color = '#1D9E75'; toast.style.opacity = '1'; }
        } else {
            btn.style.background = '#E24B4A';
            btn.textContent = 'Erreur';
        }
        setTimeout(() => {
            btn.style.background = '';
            btn.textContent = 'Enregistrer';
            if (toast) { toast.textContent = ''; toast.style.opacity = '0'; }
        }, 2000);
    });
}

/*----------------------------------
    TOGGLE ACTIVER/DESACTIVER  MENU
----------------------------------*/

function toggleActifMenu(btn) {
    const id          = parseInt(btn.dataset.id);
    const actifActuel = parseInt(btn.dataset.actif);
    const nouvelEtat  = actifActuel ? 0 : 1;
    const action      = actifActuel ? 'désactiver' : 'réactiver';

    if (!confirm(`Voulez-vous vraiment ${action} ce menu ?`)) return;

    fetch(BASE_URL + '/traitement/toggle-menu.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, actif: nouvelEtat })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const card = btn.closest('.menu-card');
            btn.dataset.actif = nouvelEtat;
            btn.textContent   = nouvelEtat ? 'Désactiver' : 'Réactiver';
            btn.className     = nouvelEtat ? 'btn-delete' : 'btn-reactivate';
            card.classList.toggle('menu-inactif', !nouvelEtat);

            const badge = card.querySelector('.badge-actif, .badge-inactif');
            if (badge) {
                badge.className   = `badge ${nouvelEtat ? 'badge-actif' : 'badge-inactif'}`;
                badge.textContent = nouvelEtat ? 'Actif' : 'Désactivé';
            }

            const toast = document.getElementById('toast-' + id);
            if (toast) {
                toast.textContent   = nouvelEtat ? 'Menu réactivé' : 'Menu désactivé';
                toast.style.color   = nouvelEtat ? '#1D9E75' : '#E24B4A';
                toast.style.opacity = '1';
                setTimeout(() => { toast.style.opacity = '0'; toast.textContent = ''; }, 2000);
            }
        }
    });
}


/*----------------------------------
    MODÉRATION AVIS
----------------------------------*/

function actionAvis(id, action) {
    fetch(BASE_URL + '/traitement/valider-avis.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ Id_avis: id, action })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const item = document.getElementById('avis-item-' + id);
            item.dataset.statut = action;

            const badge = item.querySelector('.avis-badge');
            if (badge) {
                badge.className = 'avis-badge';
                if (action === 'valide')     { badge.classList.add('badge-ok');   badge.textContent = 'Validé'; }
                if (action === 'refuse')     { badge.classList.add('badge-non');  badge.textContent = 'Refusé'; }
                if (action === 'en_attente') { badge.classList.add('badge-wait'); badge.textContent = 'En attente'; }
            }

            item.querySelectorAll('.btn-valider, .btn-refuser').forEach(b => b.classList.remove('active'));
            if (action === 'valide') item.querySelector('.btn-valider')?.classList.add('active');
            if (action === 'refuse') item.querySelector('.btn-refuser')?.classList.add('active');

            updateCompteur();
        }
    });
}

function updateCompteur() {
    const total = document.querySelectorAll('.avis-item[data-statut="en_attente"]').length;
    const el = document.getElementById('avis-count');
    if (el) el.textContent = total + ' avis en attente';
}

/*----------------------------------
    TOGGLE HORAIRES
----------------------------------*/
function toggleFerme(id, cb) {
    const row = document.getElementById('row-' + id);
    ['ouverture_matin', 'fermeture_matin', 'ouverture_apm', 'fermeture_apm'].forEach(p => {
        const inp = row.querySelector(`input[name="${p}_${id}"]`);
        if (inp) {
            inp.disabled = cb.checked;
            if (cb.checked) inp.value = '';
        }
    });
    row.classList.toggle('ferme', cb.checked);
}
