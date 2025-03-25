<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">NGAs</h6>

    <button class="button is-primary" onclick="document.getElementById('addNgaModal').classList.add('is-active');">
        Create New
    </button>

    <!-- Bulma Table -->
    <div class="table-container mt-4">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Name of Office</th>
                    <th>Salutation</th>
                    <th>Head of Office</th>
                    <th>Address</th>
                    <th>Telephone</th>
                    <th>Fax</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ngas as $nga): ?>
                    <tr>
                        <td><?= esc($nga->name_of_office) ?></td>
                        <td><?= esc($nga->salutation) ?></td>
                        <td><?= esc($nga->head_of_office) ?></td>
                        <td><?= esc($nga->address) ?></td>
                        <td><?= esc($nga->telephone) ?></td>
                        <td><?= esc($nga->fax) ?></td>
                        <td><?= esc($nga->email) ?></td>
                        <td><?= esc($nga->mobile_num) ?></td>
                        <td><?= date('Y-m-d H:i:s') ?></td>
                        <td>
                            <a href="<?= base_url('ngas/edit/' . $nga->office_id) ?>"
                                class="button is-small is-info">Edit</a>
                            <a href="<?= base_url('ngas/delete/' . $nga->office_id) ?>" class="button is-small is-danger"
                                onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div id="addNgaModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addNgaModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add New NGA</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addNgaModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/ngas/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Name of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="name_of_office" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Head of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="head_of_office" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Salutation</label>
                            <div class="control"> <input type="text" name="salutation" class="input">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Address</label>
                            <div class="control">
                                <textarea class="textarea" name="address" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="column">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="tel" name="telephone">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Mobile Number</label>
                            <div class="control">
                                <input class="input" type="tel" name="mobile_number">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field has-text-centered mt-4">
                    <button type="submit" class="button is-success">Save</button>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>