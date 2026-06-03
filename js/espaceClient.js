
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

        const contenu = this.querySelector('textarea').value.trim();
        if(!contenu) return;

        fetch(BASE_URL + '/traitement/submit-avis.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contenu })
        })
        .then(res => res.json())
        .then(data => {
            const msg = document.getElementById('avis-message');
            msg.textContent = data.success ? 'Avis envoyé, merci !' : "Erreur lors de l'envoi.";
            msg.className = data.success ? 'message-succes' : 'message-erreur';
            if (data.success) this.querySelector('textarea').value = '';
            setTimeout(() => msg.textContent = '', 4000);
        });
    });



/*----------------
    Menu card
----------------*/

    function toggleMenu(header) {
        const card = header.closest('.menu-card');
        const body = card.querySelector('.menu-body');
        const chevron = header.querySelector('.chevron');
        const isOpen = !body.classList.contains('hidden');
    
        document.querySelectorAll('.menu-body').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('.menu-card-header .chevron').forEach(c => c.classList.remove('open'));
        if (!isOpen) {
            body.classList.remove('hidden');
            chevron.classList.add('open');
        }
    }
    
}); 

