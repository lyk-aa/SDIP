<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .existing-institution-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }

    .modal-card-head,
    .modal-card-foot {
        background-color: #f0f0f0;
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        padding: 0.75rem 1rem;
    }

    .modal-card-title {
        font-weight: 600;
        text-align: center;
        font-size: 1.25rem;
        color: #363636;
        margin: 0;
    }

    .modal-card-body {
        padding: 1.5rem;
        background-color: #fff;
    }

    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        cursor: pointer;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
        margin-bottom: 1rem;
        position: relative;
        background-color: #f0f0f0;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .edit-button {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        padding: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .edit-button:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .hidden-input {
        display: none;
    }

    .profile-text {
        position: absolute;
        color: rgba(54, 54, 54, 0.6);
        font-size: 0.75rem;
        font-weight: bold;
        text-align: center;
    }

    #profile-preview.hidden {
        display: none;
    }

    .title {
        color: #363636;
        margin-bottom: 0.75rem;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .label {
        color: #555;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .input,
    .select select {
        border-radius: 4px;
        border: 1px solid #ccc;
        padding: 0.5rem;
        width: 100%;
        transition: border-color 0.2s;
        box-shadow: none;
    }

    .input:focus,
    .select select:focus {
        border-color: #3273dc;
        box-shadow: 0 0 0 2px rgba(50, 115, 220, 0.2);
    }

    .button {
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    .button.is-success {
        background-color: #48c774;
        color: #fff;
    }

    .button.is-success:hover {
        background-color: #3dbb63;
    }

    .button.is-primary {
        background-color: #3273dc;
        color: #fff;
    }

    .button.is-primary:hover {
        background-color: #2759bd;
    }

    .button.is-success,
    .button.is-primary {
        box-shadow: none;
    }

    .modal-background {
        background-color: rgba(0, 0, 0, 0.4);
    }

    .delete {
        color: #888;
        transition: color 0.2s;
    }

    .delete:hover {
        color: #ff3860;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    #contact-info .field {
        margin-bottom: 1rem;
    }

    .select-input-container {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .select-input-container input {
        flex: 1;
        padding-right: 2rem;
    }

    .select-overlay {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        cursor: pointer;
        width: 2rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <!-- Main Modal for First Transaction -->
    <div class="modal is-active" id="main-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Institution</p>
                <button class="delete" id="close-modal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <form id="stakeholder-form" action="<?= site_url('institution/store') ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Image Upload -->
                    <div class="image-placeholder" onclick="document.getElementById('image').click()">
                        <figure class="profile-image">
                            <span id="profile-text" class="profile-text">Profile</span>
                            <img id="profile-preview"
                                src="<?= base_url('uploads/' . ($institution['image'] ?? 'default.png')) ?>">
                            <div class="edit-button">
                                <i class="fas fa-edit"></i>
                            </div>
                        </figure>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="hidden-input"
                            onchange="previewImage(event)">
                    </div>

                    <div class="columns is-multiline">
                        <!-- Institution Select -->
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Institution</label>
                                <div class="control">
                                    <div class="select">
                                        <select id="institution-select" name="stakeholder_id" required>
                                            <option value="">Select Institution</option>
                                            <?php foreach ($stakeholders as $stakeholder): ?>
                                                <option value="<?= $stakeholder['id'] ?>"><?= $stakeholder['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Type Input -->
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Type</label>
                                <div class="control">
                                    <div class="select-input-container">
                                        <input type="text" id="type" name="type" class="input"
                                            placeholder="Or enter manually">
                                        <select class="select-overlay"
                                            onchange="document.getElementById('type').value=this.value">
                                            <option value=""></option>
                                            <option value="State University">State University</option>
                                            <option value="College">College</option>
                                            <option value="Training Center">Training Center</option>
                                            <option value="Research Institute">Research Institute</option>
                                            <option value="Member Institution">Member Institution</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Field (Full Width) -->
                        <div class="column is-full">
                            <div class="field">
                                <label class="label">Description</label>
                                <div class="control">
                                    <textarea class="textarea" name="description"
                                        placeholder="Enter institution description here..."><?= old('description') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="modal-card-foot has-text-right">
                        <button type="submit" class="button is-success" id="submit-button" disabled>Save</button>
                    </section>
                </form>
            </section>
        </div>
    </div>
</body>

<script>
    disableSubmitButton();

    document.getElementById('institution-select').addEventListener('change', function () {
        let stakeholderId = this.value;
        const submitButton = document.querySelector('section.modal-card-foot button[type="submit"]');

        submitButton.removeAttribute('title');
        submitButton.style.backgroundColor = '';
        submitButton.style.cursor = '';

        const existingMessage = document.getElementById('existing-institution-message');
        if (existingMessage) existingMessage.remove();

        if (stakeholderId) {
            fetch('<?= site_url('institution/checkInstitutionExists') ?>/' + stakeholderId)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        showWarningMessage(data.message);
                    } else {
                        enableSubmitButton();
                    }
                })
                .catch(error => console.error('Error checking institution:', error));

            fetch('<?= site_url('institution/getStakeholderDetails') ?>/' + stakeholderId)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('input[name="type"]').value = data.type || '';
                    document.querySelector('textarea[name="description"]').value = data.description || '';
                });
        } else {
            disableSubmitButton();
        }
    });

    function disableSubmitButton() {
        const submitButton = document.querySelector('section.modal-card-foot button[type="submit"]');
        submitButton.disabled = true;
        submitButton.style.backgroundColor = 'gray';
        submitButton.style.cursor = 'not-allowed';
        submitButton.setAttribute('title', 'Please select an institution');
    }

    function showWarningMessage(message) {
        const submitButton = document.querySelector('section.modal-card-foot button[type="submit"]');
        submitButton.disabled = true;
        submitButton.style.backgroundColor = 'gray';
        submitButton.style.cursor = 'not-allowed';
        submitButton.setAttribute('title', message || '');

        const messageElement = document.createElement('p');
        messageElement.id = 'existing-institution-message';
        messageElement.style.color = 'red';
        messageElement.textContent = message;
        document.getElementById('institution-select').parentNode.appendChild(messageElement);
    }

    function enableSubmitButton() {
        const submitButton = document.querySelector('section.modal-card-foot button[type="submit"]');
        submitButton.disabled = false;
        submitButton.style.backgroundColor = '';
        submitButton.style.cursor = '';
        submitButton.removeAttribute('title');

        const existingMessage = document.getElementById('existing-institution-message');
        if (existingMessage) existingMessage.remove();
    }

    document.querySelector('form').addEventListener('submit', function (event) {
        const submitButton = document.querySelector('section.modal-card-foot button[type="submit"]');
        if (submitButton.disabled) {
            event.preventDefault(); 
            alert("This institution is already stored and cannot be added again.");
        }
    });

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    document.getElementById("close-modal").addEventListener("click", function () {
        window.location.href = "<?= base_url('institution/home') ?>"; 
    });
</script>

<?= $this->endSection() ?>