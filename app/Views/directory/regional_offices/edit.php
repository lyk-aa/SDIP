<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div class="box">
            <h3 class="title is-4 has-text-primary">Edit Regional Office</h3>
            <form action="<?= site_url('directory/regional_offices/update/' . $regional_office->stakeholder_id) ?>"
                method="POST">
                <input type="hidden" name="person_id" value="<?= $regional_office->person_id ?>">

                <div class="columns is-multiline">
                    <div class="column is-half">
                        <label class="label">Regional Office Name:</label>
                        <input class="input" type="text" name="regional_office"
                            value="<?= esc($regional_office->regional_office) ?>" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Street:</label>
                        <input class="input" type="text" name="street" value="<?= esc($regional_office->street) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Barangay:</label>
                        <input class="input" type="text" name="barangay" value="<?= esc($regional_office->barangay) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Municipality:</label>
                        <input class="input" type="text" name="municipality"
                            value="<?= esc($regional_office->municipality) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Province:</label>
                        <input class="input" type="text" name="province" value="<?= esc($regional_office->province) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Country:</label>
                        <input class="input" type="text" name="country" value="<?= esc($regional_office->country) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Postal Code:</label>
                        <input class="input" type="text" name="postal_code"
                            value="<?= esc($regional_office->postal_code) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Honorifics:</label>
                        <input class="input" type="text" name="hon" value="<?= esc($regional_office->hon) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">First Name:</label>
                        <input class="input" type="text" name="first_name"
                            value="<?= esc($regional_office->first_name) ?>" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Last Name:</label>
                        <input class="input" type="text" name="last_name"
                            value="<?= esc($regional_office->last_name) ?>" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Designation:</label>
                        <input class="input" type="text" name="designation"
                            value="<?= esc($regional_office->designation) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Position:</label>
                        <input class="input" type="text" name="position" value="<?= esc($regional_office->position) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Telephone Number:</label>
                        <input class="input" type="text" name="telephone_num"
                            value="<?= esc($regional_office->telephone_num) ?>">
                    </div>

                    <div class="column is-half">
                        <label class="label">Email Address:</label>
                        <input class="input" type="email" name="email_address"
                            value="<?= esc($regional_office->email_address) ?>">
                    </div>
                </div>

                <div class="buttons mt-4">
                    <button type="submit" class="button is-primary">Update</button>
                    <a href="<?= site_url('directory/regional_offices') ?>" class="button is-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>