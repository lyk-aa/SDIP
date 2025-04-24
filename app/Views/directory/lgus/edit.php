<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h6 class="title is-4">Edit Local Government Unit (LGU)</h6>

        <form action="<?= base_url('/directory/lgus/update/' . $lgu['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="columns is-multiline">

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Office Name</label>
                        <div class="control">
                            <input class="input" type="text" name="office_name" value="<?= esc($lgu['name'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </div>

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Street</label>
                        <div class="control">
                            <input class="input" type="text" name="street" value="<?= esc($lgu['street'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Barangay</label>
                        <div class="control">
                            <input class="input" type="text" name="barangay" value="<?= esc($lgu['barangay'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Municipality</label>
                        <div class="control">
                            <input class="input" type="text" name="municipality"
                                value="<?= esc($lgu['municipality'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Province</label>
                        <div class="control">
                            <input class="input" type="text" name="province" value="<?= esc($lgu['province'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Country</label>
                        <div class="control">
                            <input class="input" type="text" name="country" value="<?= esc($lgu['country'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Postal Code</label>
                        <div class="control">
                            <input class="input" type="text" name="postal_code"
                                value="<?= esc($lgu['postal_code'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>


                <?php if (!empty($members)): ?>
                    <div class="column is-full">
                        <h6 class="title is-5">LGU Members</h6>
                    </div>

                    <?php foreach ($members as $index => $member):
                        $person = $member['person'] ?? [];
                        $contact = $member['contact'] ?? [];
                        ?>
                        <input type="hidden" name="member_ids[]" value="<?= $member['person_id'] ?>">

                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Salutation</label>
                                <div class="control">
                                    <input class="input" type="text" name="salutation[]"
                                        value="<?= $person['salutation'] ?? '' ?>" placeholder="Enter salutation">
                                </div>
                            </div>
                        </div>


                        <div class="column is-one-quarter">
                            <label class="label">First Name</label>
                            <input class="input" type="text" name="first_name[]" value="<?= esc($person['first_name'] ?? '') ?>"
                                required>
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Middle Name</label>
                            <input class="input" type="text" name="middle_name[]"
                                value="<?= esc($person['middle_name'] ?? '') ?>">
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Last Name</label>
                            <input class="input" type="text" name="last_name[]" value="<?= esc($person['last_name'] ?? '') ?>"
                                required>
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Position</label>
                            <input class="input" type="text" name="position[]" value="<?= esc($person['designation'] ?? '') ?>"
                                required>
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Telephone Number</label>
                            <input class="input" type="text" name="telephone_num[]"
                                value="<?= esc($contact['telephone_num'] ?? '') ?>">
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Fax Number</label>
                            <input class="input" type="text" name="fax_num[]" value="<?= esc($contact['fax_num'] ?? '') ?>">
                        </div>

                        <div class="column is-one-quarter">
                            <label class="label">Email Address</label>
                            <input class="input" type="email" name="email_address[]"
                                value="<?= esc($contact['email_address'] ?? '') ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="column is-full has-text-centered">
                    <button type="submit" class="button is-success">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Update</span>
                    </button>
                    <a href="<?= base_url('/directory/lgus') ?>" class="button is-danger">
                        <span class="icon"><i class="fas fa-times"></i></span>
                        <span>Cancel</span>
                    </a>
                </div>

            </div>
        </form>
    </div>
</section>

<?= $this->endSection() ?>