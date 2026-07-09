document.addEventListener('DOMContentLoaded', function() {
    let tempsRestant = 15;
    const compteRebours = document.getElementById('compte-rebours');

    const interval = setInterval(() => {
        tempsRestant--;
        compteRebours.textContent = tempsRestant;

        if (tempsRestant <= 0) {
            clearInterval(interval);
            window.location.href = '../espace-client.php';
        }
    }, 1000);
});