
/*--------------------------------------------
    Conformité mot de passe
---------------------------------------------*/ 
const togglePassword = document.getElementById('toggle-password');
const passwordInput = document.getElementById('password-employe');
const passwordError = document.getElementById('password-error');
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[+!@#$%^&amp;*(),.?:|&lt;&gt;_-]).{10,}$/;
const form = document.getElementById('form-employe-account');

if (form && passwordInput) {
    form.addEventListener('submit', (e) => {
        if (!passwordRegex.test(passwordInput.value)) {
            e.preventDefault();
            alert("Le mot de passe doit contenir au moins 10 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial (!@#$%^&*(),.?':{}|<>).");
        }
    });

}