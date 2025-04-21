<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="level">
        <div class="level-left">
            <h3 class="title is-4 has-text-grey-dark">LGUs</h3>
        </div>
        <div class="level-right">
            <a href="<?= base_url('directory/nga/create') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Create New</span>
            </a>
        </div>
    </div>

    <!-- Bulma Table -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Salutation</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office Name</th>
                    <th>Office Address</th>
                    <th>Telephone/Fax Number</th>
                    <th>Email Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hon.</td>
                    <td>Stephen A. Palmares</td>
                    <td>City Mayor</td>
                    <td>LGU Passi City</td>
                    <td>Passi City Hall, Bonifacio Street, Passi City, Iloilo, Philippines</td>
                    <td>(033) 311-5087 / (033) 311-3498</td>
                    <td>info@passi.gov.ph</td>
                    <td class="has-text-centered">
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

<div id="addLGUModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add LGU</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/lgus/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <!-- Salutation -->
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Salutation</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="salutation">
                                        <option value="Hon.">Hon.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Atty.">Atty.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Position</label>
                            <div class="control">
                                <input class="input" type="text" name="position" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Office Name</label>
                            <div class="control">
                                <input class="input" type="text" name="office_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-full">
                        <div class="field">
                            <label class="label">Office Address</label>
                            <div class="control">
                                <input class="input" type="text" name="office_address" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone/Fax Number</label>
                            <div class="control">
                                <input class="input" type="text" name="telephone_fax">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-full has-text-centered">
                        <button type="submit" class="button is-success">Save</button>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>