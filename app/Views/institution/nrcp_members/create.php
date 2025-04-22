<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
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
        cursor: pointer;
        margin-bottom: 1.5rem;
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

    .profile-text {
        position: absolute;
        color: rgba(54, 54, 54, 0.6);
        font-size: 0.75rem;
        font-weight: bold;
    }

    .hidden-input {
        display: none;
    }

    .label {
        color: #555;
        font-weight: 500;
    }

    .input,
    .select select,
    textarea.textarea {
        border-radius: 4px;
        border: 1px solid #ccc;
        padding: 0.5rem;
        width: 100%;
        transition: border-color 0.2s;
    }

    .input:focus,
    .select select:focus,
    textarea.textarea:focus {
        border-color: #3273dc;
        box-shadow: 0 0 0 2px rgba(50, 115, 220, 0.2);
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

    .select-input-container {
        display: flex;
        align-items: center;
        position: relative;
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

    .mt-4 {
        margin-top: 1.5rem;
    }

    .columns.is-multiline .column {
        padding: 0.5rem;
    }

    .modal-background {
        background-color: rgba(0, 0, 0, 0.4);
    }
</style>

<body>
    <!-- Main Modal -->
    <div class="modal is-active" id="main-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Member</p>
                <button class="delete" id="close-modal" aria-label="close"></button>
            </header>

            <section class="modal-card-body">
                <form id="balik-scientist-form" action="<?= site_url('/institution/nrcp_members/store') ?>"
                    method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Image Upload -->
                    <div class="image-placeholder" onclick="document.getElementById('image').click()">
                        <figure class="profile-image">
                            <span id="profile-text" class="profile-text">Profile</span>
                            <img id="profile-preview"
                                src="<?= base_url('uploads/' . ($scientist['image'] ?? 'default.png')) ?>">
                            <div class="edit-button">
                                <i class="fas fa-edit"></i>
                            </div>
                        </figure>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="hidden-input"
                            onchange="previewImage(event)">
                    </div>

                    <!-- Membership Selection -->
                    <div class="field">
                        <label class="label">Select Membership</label>
                        <div class="control" style="display: flex; gap: 20px;">
                            <label class="checkbox">
                                <input type="checkbox" name="dynamic_choice[]" value="Balik Scientist"
                                    onclick="generateFields()">
                                Balik Scientist
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="dynamic_choice[]" value="NRCP" onclick="generateFields()">
                                NRCP
                            </label>
                        </div>
                    </div>

                    <!-- Honorifics and Role -->
                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Honorifics</label>
                                <div class="control select-input-container">
                                    <input type="text" id="honorifics" name="honorifics" class="input"
                                        placeholder="Or enter manually">
                                    <select class="select-overlay"
                                        onchange="document.getElementById('honorifics').value=this.value">
                                        <option value=""></option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Role</label>
                                <div class="control select-input-container">
                                    <input type="text" id="role" name="role" class="input"
                                        placeholder="Or enter manually" required>
                                    <select class="select-overlay"
                                        onchange="document.getElementById('role').value=this.value">
                                        <option value=""></option>
                                        <option value="Key Official">Key Official</option>
                                        <option value="Scientist">Scientist</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Name Fields -->
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input type="text" name="first_name" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Middle Initial</label>
                                <div class="control">
                                    <input type="text" name="middle_name" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input type="text" name="last_name" class="input" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Fields -->
                    <div class="columns is-multiline" id="dynamic-fields"></div>

                    <!-- Description -->
                    <div class="field">
                        <label class="label">Description</label>
                        <div class="control">
                            <textarea name="description" class="textarea" required
                                oninput="checkWordLimit(this, 25)"></textarea>
                        </div>
                        <p id="word-warning" class="help is-danger" style="display: none;">You have exceeded the
                            description-word limit.</p>
                    </div>

                    <!-- Footer -->
                    <footer class="modal-card-foot is-flex is-justify-content-end">
                        <button type="submit" class="button is-success">Save</button>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</body>

<script>
    function generateFields() {
        const container = document.getElementById('dynamic-fields');
        container.innerHTML = '';

        const selectedOptions = document.querySelectorAll('input[name="dynamic_choice[]"]:checked');
        const institutions = <?= json_encode($institutions) ?>;

        selectedOptions.forEach(option => {
            const column = document.createElement('div');
            column.className = 'column is-half';

            const field = document.createElement('div');
            field.className = 'field';

            const label = document.createElement('label');
            label.className = 'label';
            label.textContent = `Select Institution for ${option.value}`;

            const control = document.createElement('div');
            control.className = 'control';

            const selectDiv = document.createElement('div');
            selectDiv.className = 'select is-fullwidth';

            const select = document.createElement('select');
            select.name = `institution_${option.value}`;

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Institution';
            select.appendChild(defaultOption);

            institutions.forEach(inst => {
                const opt = document.createElement('option');
                opt.value = inst.id;
                opt.textContent = inst.name;
                select.appendChild(opt);
            });

            selectDiv.appendChild(select);
            control.appendChild(selectDiv);
            field.appendChild(label);
            field.appendChild(control);
            column.appendChild(field);
            container.appendChild(column);
        });
    }

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profile-preview').src = e.target.result;
                document.getElementById('profile-text').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".select-input-container").forEach(container => {
            const inputField = container.querySelector("input");
            const selectField = container.querySelector("select");

            selectField.addEventListener("change", function () {
                inputField.value = this.value;
                this.selectedIndex = 0;
            });

            inputField.addEventListener("input", function () {
                if (!this.value) {
                    selectField.selectedIndex = 0;
                }
            });
        });

        document.getElementById("close-modal").addEventListener("click", function () {
            window.location.href = "<?= base_url('institution/balik_scientist/index') ?>";
        });
    });

    function checkWordLimit(textarea, maxWords) {
        const words = textarea.value.trim().split(/\s+/).filter(word => word.length > 0);
        const warning = document.getElementById('word-warning');

        if (words.length > maxWords) {
            warning.style.display = 'block';
        } else {
            warning.style.display = 'none';
        }
    }

    document.querySelector('form').addEventListener('submit', function (e) {
        const textarea = document.querySelector('textarea[name="description"]');
        const words = textarea.value.trim().split(/\s+/).filter(word => word.length > 0);
        const warning = document.getElementById('word-warning');

        if (words.length > 25) {
            e.preventDefault(); // prevent submission
            warning.style.display = 'block';
        }
    });
</script>

<?= $this->endSection() ?>