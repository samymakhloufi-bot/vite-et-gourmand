const togglePassword = document.getElementById('toggle-password');
const passwordInput = document.getElementById('password');
const passwordError = document.getElementById('password-error');
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[+!@#$%^&amp;*(),.?:|&lt;&gt;_-]).{10,}$/;

/*--------------------------------------------
    Toggle pour afficher/masquer le mot de passe
---------------------------------------------*/  
togglePassword.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    togglePassword.classList.toggle('active');

    document.querySelector('#eye-icon').innerHTML = isPassword
        ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
        : `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
});

/*--------------------------------------------
    Conformité mot de passe
---------------------------------------------*/ 

const form = document.getElementById('form-inscription');

if (form && passwordInput) {
    form.addEventListener('submit', (e) => {
        if (!passwordRegex.test(passwordInput.value)) {
            e.preventDefault();
            alert("Le mot de passe doit contenir au moins 10 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial (!@#$%^&*(),.?':{}|<>).");
        }
    });
}