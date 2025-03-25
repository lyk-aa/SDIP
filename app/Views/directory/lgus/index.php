<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <h6 class="title">LGUs</h6>

    <button class="button is-primary mb-4" onclick="document.getElementById('addLGUModal').classList.add('is-active');">
        Create New
    </button>

    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Salutation</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office Name</th>
                    <th>Office Address</th>
                    <th>Telephone/Fax Number</th>
                    <th>Email Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lgus)): ?>
                    <?php foreach ($lgus as $lgu): ?>
                        <?php foreach ($lgu['members'] as $member): ?>
                            <tr>
                                <td><?= esc($member['person']['salutation'] ?? 'N/A') ?></td>
                                <td><?= esc(($member['person']['first_name'] ?? '') . ' ' . ($member['person']['middle_name'] ?? '') . ' ' . ($member['person']['last_name'] ?? '')) ?>
                                </td>
                                <td><?= esc($member['person']['designation'] ?? 'N/A') ?></td>
                                <td><?= esc($lgu['name'] ?? 'N/A') ?></td>
                                <td><?= esc($lgu['office_address'] ?? 'N/A') ?></td>
                                <td>
                                    <?= esc($member['contact']['telephone_num'] ?? 'N/A') ?> /
                                    <?= esc($member['contact']['fax_num'] ?? 'N/A') ?>
                                </td>
                                <td><?= esc($member['contact']['email_address'] ?? 'N/A') ?></td>
                                <td>
                                    <a href="#" class="button is-small is-info">Edit</a>
                                    <a href="#" class="button is-small is-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="has-text-centered">No LGUs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</section>

<div id="addLGUModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add LGU</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/directory/lgus/store') ?>" method="post">
            <?= csrf_field() ?>
            <section class="modal-card-body">
                <div class="columns is-multiline">

                    <?php
                    $fields = [
                        'Salutation' => ['type' => 'select', 'name' => 'salutation', 'options' => ['Hon.' => 'Hon.', 'Dr.' => 'Dr.', 'Atty.' => 'Atty.']],
                        'First Name' => ['type' => 'text', 'name' => 'first_name'],
                        'Middle Name' => ['type' => 'text', 'name' => 'middle_name'],
                        'Last Name' => ['type' => 'text', 'name' => 'last_name'],
                        'Position' => ['type' => 'text', 'name' => 'position'],
                        'Office Name' => ['type' => 'text', 'name' => 'office_name'],
                        'Office Address' => ['type' => 'text', 'name' => 'office_address'],
                        'Telephone Number' => ['type' => 'text', 'name' => 'telephone_num'],
                        'Fax Number' => ['type' => 'text', 'name' => 'fax_num'],
                        'Email Address' => ['type' => 'email', 'name' => 'email_address']
                    ];

                    foreach ($fields as $label => $field): ?>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label"><?= $label ?></label>
                                <div class="control">
                                    <?php if ($field['type'] === 'select'): ?>
                                        <div class="select is-fullwidth">
                                            <select name="<?= $field['name'] ?>">
                                                <?php foreach ($field['options'] as $key => $value): ?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <input class="input" type="<?= $field['type'] ?>" name="<?= $field['name'] ?>" required>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="column is-full has-text-centered">
                        <button type="submit" class="button is-success">Save</button>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>