const deleteForms = document.querySelectorAll('.delete-form');
const modal = document.getElementById('delete-modal');
const modalMessage = document.querySelector('.modal-body');
const confirmationButton = document.getElementById('modal-confirmation-button');

let activeForm = null;

deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();

        activeForm = form;
        modalMessage.innerText = `Sei sicuro di voler eliminare ${form.dataset.title}?`;
    })
})

confirmationButton.addEventListener('click', () => {
    if (activeForm) activeForm.submit();
});

modal.addEventListener('hidden.bs.modal', () => {
    activeForm = null;
})
