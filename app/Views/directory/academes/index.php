<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">Academes</h6>

    <button class="button is-primary mb-4"
        onclick="document.getElementById('addAcademeModal').classList.add('is-active');">
        Create New
    </button>

    <!-- Bulma Table -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Abbreviation</th>
                    <th>Name</th>
                    <th>Head of Office</th>
                    <th>Designation</th>
                    <th>Address</th>
                    <th>Fax</th>
                    <th>Telephone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($academes)): ?>
                    <?php foreach ($academes as $academe): ?>
                        <tr>
                            <td><?= esc($academe['name']) ?></td>
                            <td><?= esc($academe['abbreviation']) ?></td>

                            <td>
                                <?php if (!empty($academe['members'])): ?>
                                    <?= esc($academe['members'][0]['person']['salutation'] . ' ' . $academe['members'][0]['person']['first_name'] . ' ' . $academe['members'][0]['person']['last_name']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($academe['members'])): ?>
                                    <?= esc($academe['members'][0]['person']['designation']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= esc(
                                    ($academe['street'] ?? '') . ', ' .
                                    ($academe['barangay'] ?? '') . ', ' .
                                    ($academe['municipality'] ?? '') . ', ' .
                                    ($academe['province'] ?? '') . ', ' .
                                    ($academe['country'] ?? '') . ' ' .
                                    ($academe['postal_code'] ?? '')
                                ) ?: 'N/A' ?>
                            </td>

                            <td>
                                <?php if (!empty($academe['members']) && !empty($academe['members'][0]['contact'])): ?>
                                    <?= esc($academe['members'][0]['contact']['fax_num']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($academe['members']) && !empty($academe['members'][0]['contact'])): ?>
                                    <?= esc($academe['members'][0]['contact']['telephone_num']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($academe['members']) && !empty($academe['members'][0]['contact'])): ?>
                                    <?= esc($academe['members'][0]['contact']['mobile_num']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($academe['members']) && !empty($academe['members'][0]['contact'])): ?>
                                    <?= esc($academe['members'][0]['contact']['email_address']) ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" class="button is-small is-info">Edit</a>
                                <a href="#" class="button is-small is-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="has-text-centered">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal for Adding a New Academe -->
<div id="addAcademeModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addAcademeModal').classList.remove('is-active');">
    </div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add Academe</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addAcademeModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/directory/academes/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="agency" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Abbreviation</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Head of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="head_of_office" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Designation</label>
                            <div class="control">
                                <input class="input" type="text" name="designation">
                            </div>
                        </div>
                    </div>

                    <div class="column is-full">
                        <div class="field">
                            <label class="label">Address</label>
                            <div class="control">
                                <input class="input" type="text" name="address" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="text" name="telephone">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Mobile</label>
                            <div class="control">
                                <input class="input" type="text" name="mobile">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required>
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