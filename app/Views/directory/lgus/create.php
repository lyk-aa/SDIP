<div id="addLGUModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head has has-background-light">
            <p class="modal-card-title">Create New LGU</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addLGUModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/directory/lgus/store') ?>" method="post">
            <?= csrf_field() ?>
            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <?php
                    $fields = [
                        'Salutation' => ['type' => 'text', 'name' => 'salutation'],
                        'First Name' => ['type' => 'text', 'name' => 'first_name'],
                        'Middle Name' => ['type' => 'text', 'name' => 'middle_name'],
                        'Last Name' => ['type' => 'text', 'name' => 'last_name'],
                        'Position' => ['type' => 'text', 'name' => 'position'],
                        'Office Name' => ['type' => 'text', 'name' => 'office_name'],
                        'Street' => ['type' => 'text', 'name' => 'street'],
                        'Barangay' => ['type' => 'text', 'name' => 'barangay'],
                        'Municipality' => ['type' => 'text', 'name' => 'municipality'],
                        'Province' => ['type' => 'text', 'name' => 'province'],
                        'Country' => ['type' => 'text', 'name' => 'country'],
                        'Postal Code' => ['type' => 'text', 'name' => 'postal_code'],
                        'Telephone Number' => ['type' => 'text', 'name' => 'telephone_num'],
                        'Fax Number' => ['type' => 'text', 'name' => 'fax_num'],
                        'Email Address' => ['type' => 'email', 'name' => 'email_address']
                    ];
                    foreach ($fields as $label => $field): ?>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label"> <?= $label ?> </label>
                                <div class="control">
                                    <?php if ($field['type'] === 'select'): ?>
                                        <div class="select is-fullwidth">
                                            <select name="<?= $field['name'] ?>">
                                                <?php foreach ($field['options'] as $key => $value): ?>
                                                    <option value="<?= $key ?>"> <?= $value ?> </option>
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
                        <button type="submit" class="button is-success">
                            <span>Save</span>
                        </button>
                        <button type="button" class="button"
                            onclick="document.getElementById('addLGUModal').classList.remove('is-active');">Cancel</button>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
<style>
    .modal-card {
        max-width: 900px;
        width: 95%;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        max-height: 80vh;
        overflow: hidden;
    }

    .modal-card-body {
        padding: 1.5rem;
        overflow-y: auto;
        max-height: 70vh;
    }

    .modal-card-head {
        background-color: rgb(211, 213, 216);
        color: white;
        border-radius: 12px 12px 0 0;
    }

    .modal-card-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    .delete {
        background-color: transparent;
        color: white;
    }

    .modal-card-foot {
        justify-content: flex-end;
        background-color: #f5f5f5;
        border-top: 1px solid #eaeaea;
        padding: 1rem;
        border-radius: 0 0 12px 12px;
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f5f5f5;
    }

    button {
        margin-left: 5px;
    }

    @media screen and (max-width: 768px) {
        .columns {
            flex-direction: column;
        }

        .column {
            width: 100%;
        }

        .modal-card {
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-card-body {
            max-height: 60vh;
        }
    }
</style>
<style>
    .modal-card-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>