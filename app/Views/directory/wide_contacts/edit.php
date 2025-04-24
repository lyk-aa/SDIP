<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="title is-4 has-text-primary">Edit Contact</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="notification is-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/directory/wide_contacts/update/' . $contact->id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="columns is-multiline">
            <div class="column is-6">
                <div class="field">
                    <label class="label">First Name</label>
                    <div class="control">
                        <input type="text" name="first_name" class="input" value="<?= esc($contact->first_name) ?>"
                            required>
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Middle Name</label>
                    <div class="control">
                        <input type="text" name="middle_name" class="input" value="<?= esc($contact->middle_name) ?>">
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Last Name</label>
                    <div class="control">
                        <input type="text" name="last_name" class="input" value="<?= esc($contact->last_name) ?>"
                            required>
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Position</label>
                    <div class="control">
                        <input type="text" name="position" class="input" value="<?= esc($contact->position) ?>">
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Driver Number</label>
                    <div class="control">
                        <input type="text" name="driver_number" class="input" value="<?= esc($contact->driver_num) ?>">
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Plate Number</label>
                    <div class="control">
                        <input type="text" name="plate_number" class="input" value="<?= esc($contact->plate_number) ?>">
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Email Address</label>
                    <div class="control">
                        <input type="email" name="email" class="input" value="<?= esc($contact->email_address) ?>">
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">Mobile Number</label>
                    <div class="control">
                        <input type="text" name="contact_number" class="input" value="<?= esc($contact->mobile_num) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="buttons mt-4">
            <button type="submit" class="button is-primary">Update</button>
            <a href="<?= base_url('/directory/wide_contacts') ?>" class="button is-light">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>