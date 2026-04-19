function updateStatus(selected, idCommande) {
    fetch('../traitement/updateStatus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: idCommande,
            status: selected.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            selected.style.borderColor = '#28a745';
            setTimetout(() => {
                selected.style.borderColor = '';
            }, 1500);
        } else {
            selected.style.borderColor = '#dc3545'; 
            alert('Erreur lors de la mise à jour du statut : ');
        }
    })
}