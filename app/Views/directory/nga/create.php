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

    .profile-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        display: inline-block;
        border: 2px solid #ddd;
        margin-bottom: 1rem;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
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
    <!-- Main Modal for NGA Form -->
    <div class="modal is-active" id="nga-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Add NGA Office</p>
                <button class="delete" id="close-nga-modal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <form id="nga-form" action="<?= site_url('directory/nga/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="columns is-multiline">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Name of Office</label>
                                <div class="control">
                                    <input type="text" name="name_of_office" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Salutation</label>
                                <div class="control">
                                    <input type="text" name="salutation" class="input">
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
                                <label class="label">Postal Code</label>
                                <div class="control">
                                    <input type="text" name="postal_code" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Telephone</label>
                                <div class="control">
                                    <input type="text" name="telephone" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Fax</label>
                                <div class="control">
                                    <input type="text" name="fax" class="input">
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input type="email" name="email_address" class="input" required>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Mobile Number</label>
                                <div class="control">
                                    <input type="text" name="mobile_number" class="input">
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
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("close-nga-modal").addEventListener("click", function () {
            window.location.href = "<?= base_url('directory/nga') ?>";
        });
    });
</script>



<?= $this->endSection() ?>