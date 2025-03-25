// Function to preview uploaded image inside card
function previewImage(event, input) {
    const reader = new FileReader();
    reader.onload = function () {
        const imgElement = input.closest('.image-upload').querySelector('.preview-image');
        imgElement.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}


// Function to open the Edit Modal
function openEditModal(element) {
    document.getElementById("edit-modal").classList.add("is-active");


    // Fill modal fields with existing card data
    const card = element.closest('.card');
    document.getElementById("edit-title").value = card.querySelector('.card-title').textContent;
    document.getElementById("edit-description").value = card.querySelector('.card-description').textContent;
    document.getElementById("modal-image-preview").src = card.querySelector('.preview-image').src;
}


// Function to close the Edit Modal
function closeEditModal() {
    document.getElementById("edit-modal").classList.remove("is-active");
}


// Function to preview image inside modal
function previewModalImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById("modal-image-preview").src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}


// Function to save edited card data
function saveCardEdit() {
    const title = document.getElementById("edit-title").value;
    const description = document.getElementById("edit-description").value;
    const imageSrc = document.getElementById("modal-image-preview").src;


    // Find the original card and update content
    const card = document.querySelector('.card-link .card');
    card.querySelector('.card-title').textContent = title;
    card.querySelector('.card-description').textContent = description;
    card.querySelector('.preview-image').src = imageSrc;


    // Close modal after saving
    closeEditModal();
}


// Function to toggle dropdown menu (kebab menu)
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.kebab-menu .dropdown-trigger button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            this.closest('.dropdown').classList.toggle('is-active');
        });
    });


    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown.is-active').forEach(dropdown => {
            dropdown.classList.remove('is-active');
        });
    });
});


