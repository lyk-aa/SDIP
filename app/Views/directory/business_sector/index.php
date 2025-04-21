<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">NGO Business Sectors</h6>

    <button class="button is-primary mb-4" onclick="document.getElementById('addNGOModal').classList.add('is-active');">
        Create New
    </button>

    <!-- Bulma Table -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Salutation</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Office Name</th>
                    <th>Office Address</th>
                    <th>Telephone/Fax Number</th>
                    <th>Email Address</th>
                    <th>Classification</th>
                    <th>Source Agency</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mr.</td>
                    <td>Ramon C. Cua-Locsin</td>
                    <td>President</td>
                    <td>Iloilo Business Club, Inc.</td>
                    <td>Unit 6, Iloilo City Center, Diversion Road, Iloilo City, Philippines</td>
                    <td>(033) 335-1439</td>
                    <td>info@iloilobusinessclub.com</td>
                    <td>Business Sector NGO</td>
                    <td>Private Sector</td>
                    <td class="has-text-centered">
                        <div class="buttons is-flex is-align-items-center" style="gap: 10px;">
                            <a href=""
                                class="button is-info is-small"
                                style="min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href=""
                                class="button is-danger is-small"
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

<div id="addNGOModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addNGOModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add NGO</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addNGOModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/ngos/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Salutation</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="salutation">
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Dr.">Dr.</option>
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
                            <label class="label">Designation</label>
                            <div class="control">
                                <input class="input" type="text" name="designation" required>
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
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Classification</label>
                            <div class="control">
                                <input class="input" type="text" name="classification" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Source Agency</label>
                            <div class="control">
                                <input class="input" type="text" name="source_agency" required>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <div class="control has-text-centered" style="width: 100%;">
                    <button type="submit" class="button is-success">Save</button>
                </div>
            </footer>
        </form>
    </div>
</div>

<?= $this->endSection() ?>