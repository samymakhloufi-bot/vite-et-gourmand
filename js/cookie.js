const overlay = document.getElementById('cookie-overlay');

if(document.cookie.includes('maps-consent')){
    overlay.classList.add('hidden');
    if(document.cookie.includes('maps-consent=true')) {
        loadGoogleMaps();
    }
}

document.getElementById('accept-cookies').addEventListener('click', () => {
    fetch(BASE_URL + '/traitement/traitement_cookie.php?consent=true')
    .then(() => {
        overlay.classList.add('hidden');
        if(typeof loadGoogleMaps === 'function') {
            loadGoogleMaps();
        }
    });
});

document.getElementById('refuse-cookies').addEventListener('click', () => {
    fetch(BASE_URL + '/traitement/traitement_cookie.php?consent=false')
    .then(() => {
        overlay.classList.add('hidden');
    });
});

