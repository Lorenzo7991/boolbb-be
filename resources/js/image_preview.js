const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
const inputImage = document.getElementById('image');
const preview = document.getElementById('preview');
const changeImageButton = document.getElementById('change-image-btn');
const fakeImageField = document.getElementById('fake-image-field');

// Gestione image preview
let blobUrl;
inputImage.addEventListener('change', () => {

    // Controllo se è stato selezionato un file
    if (inputImage.files && inputImage.files[0]) {
        // prendo il file
        const file = inputImage.files[0];
        // preparo un url temporaneo
        blobUrl = URL.createObjectURL(file);
        preview.src = blobUrl;
    } else {
        preview.src = placeholder;
    }
})

window.addEventListener('beforeunload', () => {
    if (blobUrl) URL.revokeObjectURL(blobUrl);
})

// Gestione campo file
// al click del bottono cambio l'input mostrato
changeImageButton.addEventListener('click', () => {
    fakeImageField.classList.add('d-none');
    inputImage.classList.remove('d-none');
    preview.src = placeholder;
    inputImage.click();
})
