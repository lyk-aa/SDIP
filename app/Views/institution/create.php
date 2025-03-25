<?= $this->extend('layouts/directory-layout') ?>
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

    .title.is-5 {
        font-weight: 700;
        /* Makes the title bold */
        font-size: 1.25rem;
        color: #363636;
        margin-bottom: 0.5rem;


        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #363636;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.3rem;
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

    .field.has-addons .control .button {
        border-radius: 0 4px 4px 0;
        padding: 0.5rem 0.75rem;
    }

    .field.has-addons .control.is-expanded .input {
        border-radius: 4px 0 0 4px;
    }

    .has-text-right {
        text-align: right;
    }

    .columns.is-multiline .column {
        padding: 0.5rem;
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
        /* Space for dropdown */
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
                <!-- Profile Picture Upload -->
                <div class="image-placeholder" onclick="document.getElementById('profile-upload').click()">
                    <figure class="profile-image">
                        <span id="profile-text" class="profile-text">Profile</span>
                        <img id="profile-preview" src="" alt="Profile Picture" class="hidden">
                        <div class="edit-button">
                            <i class="fas fa-edit"></i>
                        </div>
                    </figure>
                    <input type="file" id="profile-upload" name="institution_image" accept="image/png, image/jpeg"
                        class="hidden-input">
                </div>

                <form id="stakeholder-form" action="<?= site_url('directory/institution/store') ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="columns is-multiline">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Institution</label>
                                <div class="control">
                                    <input type="text" name="regional_office" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Honorifics</label>
                                <div class="control">
                                    <div class="select-input-container">
                                        <input type="text" id="honorifics-input" name="hon" class="input"
                                            placeholder="Or enter manually">
                                        <select class="select-overlay"
                                            onchange="document.getElementById('honorifics-input').value=this.value">
                                            <option value=""></option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Prof.">Prof.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input type="text" name="first_name" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input type="text" name="last_name" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Designation</label>
                                <div class="control">
                                    <input type="text" name="designation" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Position</label>
                                <div class="control">
                                    <input type="text" name="position" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Country</label>
                                <div class="control">
                                    <div class="select-input-container">
                                        <input type="text" id="country-input" name="country" class="input"
                                            placeholder="Or enter manually">
                                        <select class="select-overlay"
                                            onchange="document.getElementById('country-input').value=this.value">
                                            <option value=""></option>
                                            <option value="USA">USA</option>
                                            <option value="Canada">Canada</option>
                                            <option value="UK">UK</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Philippines">Philippines</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Province</label>
                                <div class="control">
                                    <input type="text" name="province" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Municipality</label>
                                <div class="control">
                                    <input type="text" name="municipality" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Street</label>
                                <div class="control">
                                    <input type="text" name="street" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Barangay</label>
                                <div class="control">
                                    <input type="text" name="barangay" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Postal Code</label>
                                <div class="control">
                                    <input type="text" name="postal_code" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Telephone Number</label>
                                <div class="control">
                                    <input type="text" name="telephone_num" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input type="email" name="email_address" class="input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="modal-card-foot has-text-right">
                        <button type="submit" class="button is-success">Save</button>
                    </section>
                </form>
            </section>
        </div>
    </div>

    <script>
        document.getElementById("profile-upload").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("profile-preview").src = e.target.result;
                    document.getElementById("profile-preview").classList.remove("hidden");
                    document.getElementById("profile-text").style.display = "none";
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById("close-modal").addEventListener("click", function () {
            window.location.href = "<?= base_url('institution/home') ?>";
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".select-input-container").forEach(container => {
                let inputField = container.querySelector("input");
                let selectField = container.querySelector("select");

                selectField.addEventListener("change", function () {
                    if (this.value) {
                        inputField.value = this.value;  // Update input field with selected value
                        this.selectedIndex = 0;  // Reset dropdown to default empty option
                    }
                });

                inputField.addEventListener("input", function () {
                    if (this.value === "") {
                        selectField.selectedIndex = 0;  // Reset dropdown if input is cleared
                    }
                });
            });

            document.getElementById("close-modal").addEventListener("click", function () {
                window.location.href = "<?= base_url('institution/home') ?>"; // Redirect to institution/home
            });
        });
    </script>

    <?= $this->endSection() ?>