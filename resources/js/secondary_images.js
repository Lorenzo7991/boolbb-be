const addImage = document.getElementById('add-image');
const imgButton = document.getElementById('add-img-btn');
const imageInput = document.getElementById('add-secondary-image');

imgButton.addEventListener('click', () => {
    imageInput.click();
});

imageInput.addEventListener('change', () => {
    addImage.submit();
})