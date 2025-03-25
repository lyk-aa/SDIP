<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <h6 class="title is-5">Regional Offices</h6>

        <!-- Button to Open Modal -->
        <button class="button is-primary" id="openModal">Add Regional Office</button>

        <!-- Table/List of Regional Offices -->
        <div class="box mt-4">
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>Regional Office</th>
                        <th>Hon.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Designation</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data row -->
                    <tr>
                        <td>Region 1</td>
                        <td>Hon. Juan</td>
                        <td>Juan</td>
                        <td>Dela Cruz</td>
                        <td>Director</td>
                        <td>Head</td>
                        <td>
                            <button class="button is-small is-warning">Edit</button>
                            <button class="button is-small is-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal (Overlay Form) -->
        <div class="modal" id="createModal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add Regional Office</p>
                    <button class="delete" aria-label="close" id="closeModal"></button>
                </header>

                <section class="modal-card-body">
                    <form action="<?= site_url('regional-offices/store') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="columns is-multiline">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Regional Office</label>
                                    <div class="control">
                                        <input type="text" name="regional_office" class="input" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Hon.</label>
                                    <div class="control">
                                        <input type="text" name="hon" class="input">
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
                                    <label class="label">Office Address</label>
                                    <div class="control">
                                        <input type="text" name="office_address" class="input" required>
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
                                        <input type="email" name="email_address" class="input" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-success">Save</button>
                                <button type="button" class="button is-light" id="cancelModal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Modal Control -->
<script>
    document.getElementById("openModal").addEventListener("click", function () {
        document.getElementById("createModal").classList.add("is-active");
    });

    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("createModal").classList.remove("is-active");
    });

    document.getElementById("cancelModal").addEventListener("click", function () {
        document.getElementById("createModal").classList.remove("is-active");
    });
</script>

<?= $this->endSection() ?>