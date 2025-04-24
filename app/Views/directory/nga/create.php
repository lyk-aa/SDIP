<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">Create New National Government Agency</h6>

    <form action="<?= base_url('/directory/nga/store') ?>" method="post">
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Name of Office</label>
                    <div class="control">
                        <input class="input" type="text" name="office_name" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Salutation</label>
                    <div class="control">
                        <input type="text" name="salutation" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Head of Office</label>
                    <div class="columns">
                        <div class="column">
                            <label class="label">First Name</label>
                            <div class="control">
                                <input class="input" type="text" name="first_name" required>
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Middle Name</label>
                            <div class="control">
                                <input class="input" type="text" name="middle_name">
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Last Name</label>
                            <div class="control">
                                <input class="input" type="text" name="last_name" required>
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
                                <input class="input" type="text" name="street" required>
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Barangay</label>
                            <div class="control">
                                <input class="input" type="text" name="barangay" required>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <label class="label">Municipality</label>
                            <div class="control">
                                <input class="input" type="text" name="municipality" required>
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Province</label>
                            <div class="control">
                                <input class="input" type="text" name="province" required>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <label class="label">Country</label>
                            <div class="control">
                                <input class="input" type="text" name="country" required>
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input class="input" type="text" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label">Telephone</label>
                    <div class="control">
                        <input class="input" type="tel" name="telephone_num">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Fax</label>
                    <div class="control">
                        <input class="input" type="text" name="fax_num">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Email Address</label>
                    <div class="control">
                        <input class="input" type="email" name="email_address" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="field has-text-centered mt-4">
            <button type="submit" class="button is-success">Save</button>
            <a href="<?= base_url('/directory/nga') ?>" class="button is-light">Cancel</a>
        </div>
    </form>
</section>

<?= $this->endSection() ?>