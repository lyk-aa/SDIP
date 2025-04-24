<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">Edit NGO</h3>
        <form action="<?= base_url('/directory/business_sector/update/' . $ngo['members'][0]['person']['id']) ?>"
            method="post">
            <?= csrf_field() ?>

            <!-- Person Details -->
            <div class="column is-half">
                <label class="label">Salutation</label>
                <input class="input" type="text" name="salutation"
                    value="<?= esc($ngo['members'][0]['person']['salutation'] ?? '') ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">First Name</label>
                <input class="input" type="text" name="first_name"
                    value="<?= esc($ngo['members'][0]['person']['first_name'] ?? '') ?>" required>
            </div>
            <div class="column is-half">
                <label class="label">Middle Name</label>
                <input class="input" type="text" name="middle_name"
                    value="<?= esc($ngo['members'][0]['person']['middle_name'] ?? '') ?>" required>
            </div>
            <div class="column is-half">
                <label class="label">Last Name</label>
                <input class="input" type="text" name="last_name"
                    value="<?= esc($ngo['members'][0]['person']['last_name'] ?? '') ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">Designation</label>
                <input class="input" type="text" name="designation"
                    value="<?= esc($ngo['members'][0]['person']['designation'] ?? '') ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">Office Name</label>
                <input class="input" type="text" name="office_name" value="<?= esc($ngo['name'] ?? '') ?>" required>
            </div>

            <!-- Address -->
            <div class="column is-full mt-3">
                <h6 class="title is-6">Office Address</h6>
            </div>

            <div class="column is-half">
                <label class="label">Street</label>
                <input class="input" type="text" name="street" value="<?= esc($ngo['address']['street'] ?? '') ?>"
                    required>
            </div>

            <div class="column is-half">
                <label class="label">Barangay</label>
                <input class="input" type="text" name="barangay" value="<?= esc($ngo['address']['barangay'] ?? '') ?>"
                    required>
            </div>

            <div class="column is-half">
                <label class="label">Municipality</label>
                <input class="input" type="text" name="municipality"
                    value="<?= esc($ngo['address']['municipality'] ?? '') ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">Province</label>
                <input class="input" type="text" name="province" value="<?= esc($ngo['address']['province'] ?? '') ?>"
                    required>
            </div>

            <div class="column is-half">
                <label class="label">Postal Code</label>
                <input class="input" type="text" name="postal_code"
                    value="<?= esc($ngo['address']['postal_code'] ?? '') ?>" required>
            </div>

            <!-- Classification and Contact -->
            <div class="column is-full mt-3">
                <h6 class="title is-6">Additional Details</h6>
            </div>

            <div class="column is-half">
                <label class="label">Classification</label>
                <input class="input" type="text" name="classification" value="<?= esc($ngo['classification'] ?? '') ?>"
                    required>
            </div>

            <div class="column is-half">
                <label class="label">Source Agency</label>
                <input class="input" type="text" name="source_agency" value="<?= esc($ngo['source_agency'] ?? '') ?>"
                    required>
            </div>

            <div class="column is-half">
                <label class="label">Telephone Number</label>
                <input class="input" type="text" name="telephone_num"
                    value="<?= esc($ngo['members'][0]['contact']['telephone_num'] ?? '') ?>" required>
            </div>

            <div>
                <label class="label">Fax</label>
                <input class="input" type="text" name="fax_num"
                    value="<?= esc($ngo['members'][0]['contact']['fax_num'] ?? '') ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">Email Address</label>
                <input class="input" type="email" name="email"
                    value="<?= esc($ngo['members'][0]['contact']['email_address'] ?? '') ?>" required>
            </div>
    </div>

    <div class="field has-text-centered mt-4">
        <button type="submit" class="button is-success">Update</button>
        <a href="<?= base_url('/directory/business_sector') ?>" class="button is-light">Cancel</a>
    </div>
    </form>
    </div>
</section>

<?= $this->endSection() ?>