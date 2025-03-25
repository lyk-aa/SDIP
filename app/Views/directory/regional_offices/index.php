<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">Regional Offices</h6>

    <button class="button is-success" id="open-modal">Create New</button>

    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Regional Office</th>
                    <th>Honorifics</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Designation</th>
                    <th>Position</th>
                    <th>Office Address</th>
                    <th>Telephone Number</th>
                    <th>Email Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($regional_offices)): ?>
                    <?php foreach ($regional_offices as $office): ?>
                        <tr>
                            <td><?= esc($office->regional_office ?? 'N/A') ?></td>
                            <td><?= esc($office->hon ?? '') ?></td>
                            <td><?= esc($office->first_name ?? '') ?></td>
                            <td><?= esc($office->last_name ?? '') ?></td>
                            <td><?= esc($office->designation ?? '') ?></td>
                            <td><?= esc($office->position ?? '') ?></td>
                            <td><?= esc($office->office_address ?? 'N/A') ?></td>
                            <td><?= esc($office->telephone_num ?? 'N/A') ?></td>
                            <td><?= esc($office->email_address ?? 'N/A') ?></td>
                            <td>
                                <a href="<?= site_url('/directory/regional_offices/edit/' . $office->stakeholder_id) ?>"
                                    class="button is-small is-info">Edit</a>
                                <a href="<?= site_url('regional_offices/delete/' . $office->stakeholder_id); ?>"
                                    class="button is-small is-danger"
                                    onclick="return confirm('Are you sure you want to delete this regional office?');">
                                    Delete
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="has-text-centered">No regional offices found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>

<!-- Modal -->
<div class="modal" id="add-office-modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add Regional Office</p>
            <button class="delete" id="close-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form action="<?= site_url('/directory/regional_offices/store') ?>" method="post">
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
                            <label class="label">Honorifics</label>
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
                            <label class="label">Municipality</label>
                            <div class="control">
                                <input type="text" name="municipality" class="input">
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
                            <label class="label">Country</label>
                            <div class="control">
                                <input type="text" name="country" class="input">
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

                <div class="field has-text-centered">
                    <button type="submit" class="button is-success">Save</button>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('add-office-modal');
        document.getElementById('open-modal').addEventListener('click', () => modal.classList.add('is-active'));
        document.getElementById('close-modal').addEventListener('click', () => modal.classList.remove('is-active'));
    });
</script>

<?= $this->endSection() ?>