const btnBurger = document.querySelector('.burger-btn');
const navList = document.querySelector('.nav-list');

/*--------------------------------------------
    Ouvre Nav Menu
---------------------------------------------*/
btnBurger.addEventListener('click', () => {
    navList.classList.toggle('nav-open');
});

/*--------------------------------------------
    Switch MENU / FERMER
---------------------------------------------*/
btnBurger.addEventListener('click', () => {
    if (navList.classList.contains('nav-open')) {
        btnBurger.textContent = '✕';
    } else {
        btnBurger.textContent = '☰';
    }
});

/*--------------------------------------------
    ferme menu burger click en dehors
---------------------------------------------*/
document.addEventListener('click', (event) => {
    if (!navList.contains(event.target) && !btnBurger.contains(event.target)) {
        navList.classList.remove('nav-open');
        btnBurger.textContent = '☰';
    }
});

