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

    .button.is-success {
        background-color: #48c774;
        color: #fff;
    }

    .button.is-primary {
        background-color: #3273dc;
        color: #fff;
    }
</style>

<body>
    <div class="modal is-active" id="edit-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Edit Regional Office</p>
                <button class="delete" id="close-modal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <form action="<?= site_url('directory/regional_offices/update/' . ($regionalOffice->stakeholder_id ?? '')) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="person_id" value="<?= $regionalOffice->person_id ?? '' ?>">

                    <div class="columns is-multiline">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Regional Office</label>
                                <div class="control">
                                    <input type="text" name="regional_office" class="input" value="<?= $regionalOffice->regional_office ?? '' ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Honorifics</label>
                                <div class="control">
                                    <input type="text" name="honorifics" class="input" value="<?= $regionalOffice->honorifics ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input type="text" name="first_name" class="input" value="<?= $regionalOffice->first_name ?? '' ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input type="text" name="last_name" class="input" value="<?= $regionalOffice->last_name ?? '' ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Position</label>
                                <div class="control">
                                    <input type="text" name="position" class="input" value="<?= $regionalOffice->position ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Designation</label>
                                <div class="control">
                                    <input type="text" name="designation" class="input" value="<?= $regionalOffice->designation ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Province</label>
                                <div class="control">
                                    <input type="text" name="province" class="input" value="<?= $regionalOffice->province ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Municipality</label>
                                <div class="control">
                                    <input type="text" name="municipality" class="input" value="<?= $regionalOffice->municipality ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Street</label>
                                <div class="control">
                                    <input type="text" name="street" class="input" value="<?= $regionalOffice->street ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Postal Code</label>
                                <div class="control">
                                    <input type="text" name="postal_code" class="input" value="<?= $regionalOffice->postal_code ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Telephone Number</label>
                                <div class="control">
                                    <input type="text" name="telephone_num" class="input" value="<?= $regionalOffice->telephone_num ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input type="email" name="email_address" class="input" value="<?= $regionalOffice->email_address ?? '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="modal-card-foot has-text-right">
                        <button type="submit" class="button is-success">Update</button>
                        <a href="<?= site_url('directory/regional_offices') ?>" class="button is-light">Cancel</a>
                    </section>
                </form>
            </section>
        </div>
    </div>
</body>

<script>
    document.getElementById("close-modal").addEventListener("click", function() {
        window.location.href = "<?= base_url('directory/regional_offices') ?>";
    });
</script>

<?= $this->endSection() ?>
