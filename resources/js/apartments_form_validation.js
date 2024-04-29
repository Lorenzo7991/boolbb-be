// Validazione
// Recupero gli elementi
const inputTitle = document.getElementById('title');
const inputImage = document.getElementById('image');
const inputRooms = document.getElementById('rooms');
const inputBathRooms = document.getElementById('bathrooms');
const inputBeds = document.getElementById('beds');
const inputSquareMeters = document.getElementById('square_meters');
const inputPricePerNight = document.getElementById('price_per_night');
const inputServices = document.querySelectorAll('.services-group');
const serviceWrapper = document.getElementById('services-wrapper')
const forms = document.querySelectorAll('.apartment-form')
const inputLongitude = document.getElementById('longitude');
const inputLatitude = document.getElementById('latitude');

const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
forms.forEach(form => {
    form.addEventListener('submit', e => {

        // Controllo se è già presente un alert e lo cancello
        const prevErrorsAlert = document.getElementById('errors-alert')
        if (prevErrorsAlert) prevErrorsAlert.remove();
        let isValid = true;
        let servicesChecked = false;
        let errorMessages = '<ul>';

        // Validazione title
        if (!inputTitle.value || inputTitle.value.length > 70) {
            inputTitle.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Titolo: inserire un titolo non superiore a 70 caratteri</li>';
        } else {
            inputTitle.classList.remove('is-invalid')
            inputTitle.classList.add('is-valid')
        }

        // Validazione image
        if (!inputImage.value || !allowedExtensions.exec(inputImage.value)) {
            inputImage.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Immagine: selezionare un file jpg, jpeg o png</li>';
        } else {
            inputImage.classList.remove('is-invalid')
            inputImage.classList.add('is-valid')
        }

        // Validazione rooms
        if (!inputRooms.value || isNaN(inputRooms.value) || inputRooms.value < 1 || inputRooms
            .value > 50) {
            inputRooms.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Stanze: inserire un numero compreso tra 1 e 50</li>';
        } else {
            inputRooms.classList.remove('is-invalid')
            inputRooms.classList.add('is-valid')
        }

        // Validazione bathrooms
        if (!inputBathRooms.value || isNaN(inputBathRooms.value) || inputBathRooms.value < 1 ||
            inputRooms
                .value > 50) {
            inputBathRooms.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Bagni: inserire un numero compreso tra 1 e 50</li>';
        } else {
            inputBathRooms.classList.remove('is-invalid')
            inputBathRooms.classList.add('is-valid')
        }

        // Validazione beds
        if (!inputBeds.value || isNaN(inputBeds.value) || inputBeds.value < 1 || inputBeds
            .value > 50) {
            inputBeds.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Letti: inserire un numero compreso tra 1 e 50</li>';
        } else {
            inputBeds.classList.remove('is-invalid')
            inputBeds.classList.add('is-valid')
        }

        // Validazione square meters
        if (!inputSquareMeters.value || isNaN(inputSquareMeters.value) || inputSquareMeters.value <
            10 || inputSquareMeters
                .value > 10000) {
            inputSquareMeters.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Metri quadri: inserire un numero compreso tra 10 e 10.000</li>';
        } else {
            inputSquareMeters.classList.remove('is-invalid')
            inputSquareMeters.classList.add('is-valid')
        }

        // Validazione price per night
        if (!inputPricePerNight.value || isNaN(inputPricePerNight.value) || inputPricePerNight
            .value < 1) {
            inputPricePerNight.classList.add('is-invalid')
            isValid = false;
            errorMessages += '<li>Prezzo per notte: inserire un valore superiore a 1</li>';
        } else {
            inputPricePerNight.classList.remove('is-invalid')
            inputPricePerNight.classList.add('is-valid')
        }

        // Validazione services
        inputServices.forEach(input => {
            if (input.checked) servicesChecked = true;

        })
        if (!servicesChecked) {
            {

                serviceWrapper.classList.add('is-invalid')
                isValid = false;
                errorMessages += '<li>Servizi: selezionare almeno 1 servizio</li>';
            }

        } else {
            serviceWrapper.classList.remove('is-invalid')
            serviceWrapper.classList.add('is-valid')

        }

        // Validazione indirizzo
        if (!inputAddressBox.value) {
            inputAddressBox.classList.add('is-invalid')

            isValid = false;
            errorMessages += '<li>Indirizzo: selezionare un indirizzo</li>';

        } else {
            inputAddressBox.classList.remove('is-invalid')
            inputAddressBox.classList.add('is-valid')

        }


        if (!isValid) {
            e.preventDefault();
            const errorsAlert = document.createElement('div')
            errorsAlert.id = 'errors-alert'
            errorsAlert.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade',
                'show',)
            errorsAlert.role = 'alert';
            errorsAlert.innerHTML = `<h4>Ci sono dei campi non validi!</h4>
                 ${errorMessages}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </ul>`
            const alertParent = document.getElementById('form-alert')
            alertParent.appendChild(errorsAlert);
        }
    })
});