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
                    <th>Classification</th>
                    <th>Source Agency</th>
                    <th>Telephone/Fax Number</th>
                    <th>Email Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ngos as $ngo): ?>
                    <?php foreach ($ngo['members'] as $member): ?>
                        <tr>
                            <td><?= esc($member['person']['salutation'] ?? 'N/A') ?></td>
                            <td>
                                <?= esc($member['person']['first_name'] ?? '') ?>
                                <?= esc($member['person']['middle_name'] ?? '') ?>
                                <?= esc($member['person']['last_name'] ?? '') ?>
                            </td>
                            <td><?= esc($member['person']['designation'] ?? 'N/A') ?></td>
                            <td><?= esc($ngo['name'] ?? 'N/A') ?></td>
                            <td><?= esc($ngo['address'] ?? 'N/A') ?></td>
                            <td><?= esc($ngo['classification'] ?? 'N/A') ?></td>
                            <td><?= esc($ngo['source_agency'] ?? 'N/A') ?></td>
                            <td>
                                <?= esc($member['contact']['telephone_num'] ?? 'N/A') ?><br>
                                <?= esc($member['contact']['fax_num'] ?? 'N/A') ?>
                            </td>
                            <td><?= esc($member['contact']['email_address'] ?? 'N/A') ?></td>
                            <td>
                                <button class="button is-small is-info">Edit</button>
                                <button class="button is-small is-danger">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
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

        <form action="<?= base_url('/directory/business_sector/store') ?>" method="post">
            <section class="modal-card-body" style="max-height: 60vh; overflow-y: auto;">
                <div class="columns is-multiline">

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Salutation</label>
                            <div class="control">
                                <input class="input" type="text" name="salutation" required>
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
                        <h6 class="title is-6">Office Address</h6>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input class="input" type="text" name="street" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Barangay</label>
                            <div class="control">
                                <input class="input" type="text" name="barangay" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Municipality</label>
                            <div class="control">
                                <input class="input" type="text" name="municipality" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Province</label>
                            <div class="control">
                                <input class="input" type="text" name="province" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input class="input" type="text" name="postal_code" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-full">
                        <h6 class="title is-6">Additional Details</h6>
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

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone/Fax Number</label>
                            <div class="control">
                                <input class="input" type="text" name="telephone_fax" required>
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

                </div>
            </section>

            <footer class="modal-card-foot is-flex is-justify-content-center">
                <button type="submit" class="button is-success">Save</button>
                <button type="button" class="button"
                    onclick="document.getElementById('addNGOModal').classList.remove('is-active');">Cancel</button>
            </footer>
        </form>
    </div>
</div>


<?= $this->endSection() ?>