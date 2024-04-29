// Recupero gli elementi dal DOM
const passwordForm = document.getElementById('update-password-form')
const currentPasswordInput = document.getElementById('current_password')
const newPasswordInput = document.getElementById('password')
const confirmPasswordInput = document.getElementById('password_confirmation')
const currentPasswordParent = document.getElementById('current-pswrd-parent')
const newPasswordParent = document.getElementById('new-pswrd-parent')
const confirmPasswordParent = document.getElementById('confirm-pswrd-parent')

passwordForm.addEventListener('submit', e => {

    let isValid = true;

    // Controllo se c'è un messaggio di errore nella passowrd corrente e lo cancello
    const prevCurrentPswrdError = document.getElementById('current-password-error')
    if (prevCurrentPswrdError) {
        prevCurrentPswrdError.remove();
        currentPasswordInput.classList.remove('is-invalid')
    }

    // Controllo se c'è un messaggio di errore nella nuova passowrd e lo cancello
    const prevNewPswrdError = document.getElementById('new-password-error')
    if (prevNewPswrdError) {
        prevNewPswrdError.remove();
        newPasswordInput.classList.remove('is-invalid')
        newPasswordInput.classList.remove('is-valid')
    }

    // Controllo se c'è un messaggio di errore nella conferma passowrd e lo cancello
    const prevConfirmPswrdError = document.getElementById('confirm-password-error')
    if (prevConfirmPswrdError) {
        prevConfirmPswrdError.remove();
        confirmPasswordInput.classList.remove('is-invalid')
        confirmPasswordInput.classList.remove('is-valid')
    }

    // Validazione passowrd attuale
    if (!currentPasswordInput.value) {
        isValid = false;
        currentPasswordInput.classList.add('is-invalid');
        const currentPasswordError = document.createElement('span');
        currentPasswordError.id = "current-password-error";
        currentPasswordError.classList.add('invalid-feedback');
        currentPasswordError.role = 'alert';
        currentPasswordError.innerHTML = '<strong>Devi inserire la tua password attuale</strong>'
        currentPasswordParent.appendChild(currentPasswordError);
    }

    // Validazione nuova passowrd
    if (!newPasswordInput.value) {
        isValid = false;
        newPasswordInput.classList.add('is-invalid');
        const newPasswordError = document.createElement('span');
        newPasswordError.id = "new-password-error";
        newPasswordError.classList.add('invalid-feedback');
        newPasswordError.role = 'alert';
        newPasswordError.innerHTML = '<strong>Devi inserire una nuova password</strong>'
        newPasswordParent.appendChild(newPasswordError);
    } else if (newPasswordInput.value.length < 8) {
        isValid = false;
        newPasswordInput.classList.add('is-invalid');
        const newPasswordError = document.createElement('span');
        newPasswordError.id = "new-password-error";
        newPasswordError.classList.add('invalid-feedback');
        newPasswordError.role = 'alert';
        newPasswordError.innerHTML = '<strong>La passowrd deve contenere almeno 8 caratteri</strong>'
        newPasswordParent.appendChild(newPasswordError);
    } else if (newPasswordInput.value === currentPasswordInput.value) {
        isValid = false;
        newPasswordInput.classList.add('is-invalid');
        const newPasswordError = document.createElement('span');
        newPasswordError.id = "new-password-error";
        newPasswordError.classList.add('invalid-feedback');
        newPasswordError.role = 'alert';
        newPasswordError.innerHTML =
            '<strong>La nuova passoword non può coincidere con la vecchia password</strong>'
        newPasswordParent.appendChild(newPasswordError);
    } else {
        newPasswordInput.classList.add('is-valid');
    }

    // Validazione conferma password
    if (newPasswordInput.value && !confirmPasswordInput.value || confirmPasswordInput.value !==
        newPasswordInput.value) {
        isValid = false;
        confirmPasswordInput.classList.add('is-invalid');
        const confirmPasswordError = document.createElement('span');
        confirmPasswordError.id = "confirm-password-error";
        confirmPasswordError.classList.add('invalid-feedback');
        confirmPasswordError.role = 'alert';
        confirmPasswordError.innerHTML =
            '<strong>Devi inserire il valore della tua nuova passoword</strong>'
        confirmPasswordParent.appendChild(confirmPasswordError);
    }



    if (!isValid) e.preventDefault();
})