<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">DOST Wide-Contacts</h6>

    <button class="button is-primary" onclick="document.getElementById('add-contact-modal').classList.add('is-active')">
        Create New
    </button>

    <!-- Bulma Table -->
    <div class="table-container mt-4">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Email Address</th>
                    <th>Contact Number</th>
                    <th>Plate Number</th>
                    <th>Driver Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Engr. Marissa R. Bautista</td>
                    <td>Assistant Regional Director</td>
                    <td>marissa.bautista@dost.gov.ph</td>
                    <td>+63 917 654 3210</td>
                    <td>ABC-1234</td>
                    <td>+63 912 345 6789</td>
                    <td>
                        <div class="buttons is-flex is-align-items-center" style="gap: 10px;">
                            <a href="" class="button is-info is-small"
                                style="min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="" class="button is-danger is-small"
                                style="min-width: 120px; display: flex; justify-content: center; align-items: center;"
                                onclick="return confirm('Are you sure you want to delete this regional office?');">
                                <span class="icon"><i class="fas fa-trash"></i></span>
                                <span>Delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<div class="modal" id="add-contact-modal">
    <div class="modal-background" onclick="document.getElementById('add-contact-modal').classList.remove('is-active')">
    </div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add Contact</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('add-contact-modal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form method="POST" action="<?= base_url('contacts/save') ?>">
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input type="text" class="input" name="name" placeholder="Full Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Position</label>
                            <div class="control">
                                <input type="text" class="input" name="position" placeholder="Position" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input type="email" class="input" name="email" placeholder="Email Address" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Contact Number</label>
                            <div class="control">
                                <input type="text" class="input" name="contact_number" placeholder="Contact Number"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Plate Number</label>
                            <div class="control">
                                <input type="text" class="input" name="plate_number" placeholder="Plate Number">
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Driver Number</label>
                            <div class="control">
                                <input type="text" class="input" name="driver_number" placeholder="Driver Number">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field has-text-centered mt-4">
                    <button type="submit" class="button is-success">Save</button>
                </div>

            </form>
        </section>
    </div>
</div>

<?= $this->endSection() ?>