<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">Create Regional Office</h3>

        <form action="<?= site_url('directory/regional_offices/store') ?>" method="post">
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
            </div>

            <h4 class="title is-5 mt-4">Office Address</h4>
            <div class="columns is-multiline">
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
                            <input type="text" name="country" class="input" required>
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
            </div>

            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Telephone</label>
                        <div class="control">
                            <input type="text" name="telephone_num" class="input">
                        </div>
                    </div>
                </div>

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input type="email" name="email_address" class="input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="field mt-4">
                <div class="control">
                    <button type="submit" class="button is-primary">Save</button>
                    <a href="<?= site_url('directory/regional_offices') ?>" class="button is-light">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>