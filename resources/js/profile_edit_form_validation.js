
//Raccolgo gli elementi dalla pagina
//Form
const updateForm = document.getElementById('update-profile-info-form');
//Email
const inputEmail = document.getElementById('email');
//Data di nascita
const inputDate = document.getElementById('date_of_birth');
//Formato corretto della data
const correctDateFormat = /^\d{4}-\d{2}-\d{2}$/;
//Formato corretto dell'email
const correctEmailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
//recupero la col dell'email
const emailCol = document.getElementById('email-col')
//recupero la col della data di nascita
const dateCol = document.getElementById('date-col')

updateForm.addEventListener('submit', e => {
    let isValid = true;
    //Constrollo se c'è un messaggio di errore nella email e lo cancello
    const prevErrorEmail = document.getElementById('email-error')
    if (prevErrorEmail) {
        prevErrorEmail.remove();
        inputEmail.classList.remove('is-invalid')
    }

    //Controllo se cè un messagio di errore nella data e lo cancello
    const prevErrorDate = document.getElementById('date-error')
    if (prevErrorDate) {
        prevErrorDate.remove();
        inputPassword.classList.remove('is-invalid')
    }

    //Validazione Email
    if (!inputEmail.value) {
        isValid = false;
        inputEmail.classList.add('is-invalid');
        const emailError = document.createElement('span');
        emailError.id = 'email-error';
        emailError.classList.add('invalid-feedback');
        emailError.role = 'alert';
        emailError.innerHTML = '<strong>Devi inserire un Email</strong>'
        emailCol.appendChild(emailError)

    } else if (!correctEmailFormat.test(inputEmail.value)) {
        isValid = false;
        inputEmail.classList.add('is-invalid');
        const emailError = document.createElement('span');
        emailError.id = 'email-error';
        emailError.classList.add('invalid-feedback');
        emailError.role = 'alert';
        emailError.innerHTML = '<strong> il formato dell\'email non è corretto</strong>'
        emailCol.appendChild(emailError)
    } else {

        inputEmail.classList.add('is-valid');
    }

    //Validazione data di nascita
    if (inputDate.value && !correctDateFormat.test(inputDate.value)) {
        isValid = false;
        inputDate.classList.add('is-invalid');
        const dateError = document.createElement('span');
        dateError.id = 'date-error';
        dateError.classList.add('invalid-feedback');
        dateError.role = 'alert';
        dateError.innerHTML = '<strong> il formato della data di nascita non è corretto</strong>'
        dateCol.appendChild(dateError)
    } else if (inputDate.value) {
        inputDate.classList.add('is-valid');
    }


    if (!isValid) e.preventDefault();
})

