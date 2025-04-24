<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div class="box">
            <h4 class="title is-4 has-text-centered">Edit National Government Agency</h4>

            <form action="<?= base_url('/directory/nga/update/' . $nga->stakeholder_id) ?>" method="post">
                <div class="columns">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="office_name"
                                    value="<?= esc($nga->office_name) ?>" required>
                            </div>
                        </div>

                        <div class="field mb-8">
                            <label class="label">Salutation</label>
                            <div class="control">
                                <input type="text" name="salutation" class="input" value="<?= esc($nga->salutation) ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Head of Office</label>
                            <div class="columns is-multiline">
                                <div class="column is-4 mb-4">
                                    <label class="label">First Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="first_name"
                                            value="<?= esc($nga->first_name) ?>" required>
                                    </div>
                                </div>
                                <div class="column is-4 mb-4">
                                    <label class="label">Middle Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="middle_name"
                                            value="<?= esc($nga->middle_name) ?>">
                                    </div>
                                </div>
                                <div class="column is-4 mb-4">
                                    <label class="label">Last Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="last_name"
                                            value="<?= esc($nga->last_name) ?>" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="field">
                            <label class="label">Address</label>
                            <div class="columns">
                                <div class="column">
                                    <label class="label">Street</label>
                                    <div class="control">
                                        <input class="input" type="text" name="street" value="<?= esc($nga->street) ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">Barangay</label>
                                    <div class="control">
                                        <input class="input" type="text" name="barangay"
                                            value="<?= esc($nga->barangay) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <label class="label">Municipality</label>
                                    <div class="control">
                                        <input class="input" type="text" name="municipality"
                                            value="<?= esc($nga->municipality) ?>" required>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">Province</label>
                                    <div class="control">
                                        <input class="input" type="text" name="province"
                                            value="<?= esc($nga->province) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <label class="label">Country</label>
                                    <div class="control">
                                        <input class="input" type="text" name="country"
                                            value="<?= esc($nga->country) ?>" required>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">Postal Code</label>
                                    <div class="control">
                                        <input class="input" type="text" name="postal_code"
                                            value="<?= esc($nga->postal_code) ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="tel" name="telephone_num"
                                    value="<?= esc($nga->telephone_num) ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax_num" value="<?= esc($nga->fax_num) ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input class="input" type="email" name="email_address"
                                    value="<?= esc($nga->email_address) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field has-text-centered mt-4">
                    <button type="submit" class="button is-success is-medium">Update</button>
                    <a href="<?= base_url('/directory/nga') ?>" class="button is-light is-medium">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>