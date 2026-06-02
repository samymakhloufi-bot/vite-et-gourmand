/*--------------------------------------------
    animation index
---------------------------------------------*/
const observer = new IntersectionObserver((entries) =>{
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add('visible');
        }else {
            entry.target.classList.remove('visible');
        }
    });
}, {threshold : 0.2});

document.querySelectorAll('.card-gout, .card-passion, main h2').forEach(el=> {
    observer.observe(el);
})


//Cookie Overlay
const cookieOverlay = document.getElementById('cookie-overlay');

// Affiche uniquement si pas encore de choix
if (!localStorage.getItem('maps-consent')) {
    cookieOverlay.style.display = 'flex';
} else {
    cookieOverlay.style.display = 'none';
}

document.getElementById('accept-cookies').addEventListener('click', () => {
    localStorage.setItem('maps-consent', 'true');
    cookieOverlay.style.display = 'none';
    loadGoogleMaps(); // ta fonction d'init Maps
});

document.getElementById('refuse-cookies').addEventListener('click', () => {
    localStorage.setItem('maps-consent', 'false');
    cookieOverlay.style.display = 'none';
});