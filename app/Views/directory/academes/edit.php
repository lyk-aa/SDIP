<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2 class="title is-size-3 has-text-centered has-text-primary">Edit Academe</h2>

    <div class="box">
        <form action="<?= site_url('/directory/academes/update/' . $academe->stakeholder_id) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($academe->stakeholder_id) ?>">

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Abbreviation</label>
                        <div class="control">
                            <input class="input" type="text" name="abbreviation"
                                value="<?= esc($academe->abbreviation) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text" name="name" value="<?= esc($academe->academe_name)
                                ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h3 class="subtitle has-text-weight-semibold has-text-primary">Head of Office</h3>

            <div class="columns is-multiline">
                <div class="column is-one-third">
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control">
                            <input class="input" type="text" name="first_name" value="<?= esc($academe->first_name) ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="field">
                        <label class="label">Middle Name</label>
                        <div class="control">
                            <input class="input" type="text" name="middle_name"
                                value="<?= esc($academe->middle_name) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="field">
                        <label class="label">Last Name</label>
                        <div class="control">
                            <input class="input" type="text" name="last_name" value="<?= esc($academe->last_name) ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-full">
                    <div class="field">
                        <label class="label">Designation</label>
                        <div class="control">
                            <input class="input" type="text" name="designation"
                                value="<?= esc($academe->designation) ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h3 class="subtitle has-text-weight-semibold has-text-primary">Address</h3>

            <div class="columns is-multiline">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Street</label>
                        <div class="control">
                            <input class="input" type="text" name="street" value="<?= esc($academe->street) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Barangay</label>
                        <div class="control">
                            <input class="input" type="text" name="barangay" value="<?= esc($academe->barangay) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="field">
                        <label class="label">Municipality</label>
                        <div class="control">
                            <input class="input" type="text" name="municipality"
                                value="<?= esc($academe->municipality) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="field">
                        <label class="label">Province</label>
                        <div class="control">
                            <input class="input" type="text" name="province" value="<?= esc($academe->province) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-sixth">
                    <div class="field">
                        <label class="label">Country</label>
                        <div class="control">
                            <input class="input" type="text" name="country" value="<?= esc($academe->country) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-sixth">
                    <div class="field">
                        <label class="label">Postal Code</label>
                        <div class="control">
                            <input class="input" type="text" name="postal_code"
                                value="<?= esc($academe->postal_code) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h3 class="subtitle has-text-weight-semibold has-text-primary">Contact Details</h3>

            <div class="columns is-multiline">
                <div class="column is-one-quarter">
                    <div class="field">
                        <label class="label">Fax Number</label>
                        <div class="control">
                            <input class="input" type="text" name="fax_num" value="<?= esc($academe->fax_num) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-quarter">
                    <div class="field">
                        <label class="label">Telephone Number</label>
                        <div class="control">
                            <input class="input" type="text" name="telephone_num"
                                value="<?= esc($academe->telephone_num) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-quarter">
                    <div class="field">
                        <label class="label">Mobile Number</label>
                        <div class="control">
                            <input class="input" type="text" name="mobile_num" value="<?= esc($academe->mobile_num) ?>">
                        </div>
                    </div>
                </div>
                <div class="column is-one-quarter">
                    <div class="field">
                        <label class="label">Email Address</label>
                        <div class="control">
                            <input class="input" type="email" name="email_address"
                                value="<?= esc($academe->email_address) ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-grouped is-justify-content-center mt-4">
                <button type="submit" class="button is-success">Update</button>
                <a href="<?= site_url('/directory/academes') ?>" class="button is-light ml-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>