<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">Academes</h3>

        <div class="columns is-multiline is-vcentered">
            <div class="column is-3">
                <div class="field">
                    <label class="label">Show Entries</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select id="entries-select">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-3">
                <div class="field">
                    <p class="control has-icons-left">
                        <input type="text" id="search-input" class="input is-rounded" placeholder="Search...">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </p>
                </div>
            </div>
            <div class="column is6 has-text-right">
                <!-- <a href="<?= site_url('directory/academes/create') ?>" class="button is-success is-rounded">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a> -->
                <button class="button is-success is-rounded"
                    onclick="document.getElementById('addAcademeModal').classList.add('is-active')">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </button>
                <a href="<?= site_url('directory/academes/export') ?>" class="button is-primary is-rounded">
                    <span class="icon"><i class="fas fa-file-export"></i></span>
                    <span>Export</span>
                </a>


            </div>
        </div>

        <div class="table-container mt-4">
            <table class="table is-striped is-hoverable is-fullwidth is-bordered" id="academeTable">
                <thead>
                    <tr class="has-background-light">
                        <th class="has-text-centered">Abbreviation</th>
                        <th class="has-text-centered">Name</th>
                        <th class="has-text-centered">Designation</th>
                        <th class="has-text-centered">Head of Office</th>
                        <th class="has-text-centered">Address</th>
                        <th class="has-text-centered">Contact Details</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php if (!empty($academes)): ?>
                        <?php foreach ($academes as $academe): ?>
                            <tr onclick="window.location='<?= site_url('/directory/academes/view/' . $academe->stakeholder_id) ?>'"
                                style="cursor: pointer;">
                                <td><?= esc($academe->abbreviation ?? 'N/A') ?></td>
                                <td><?= esc($academe->academe_name ?? 'N/A') ?></td>
                                <td class="designation"><?= esc($academe->designation ?? 'N/A') ?></td>
                                <td>
                                    <?= esc($academe->first_name ?? '') ?>
                                    <?= esc($academe->middle_name ?? '') ?>
                                    <?= esc($academe->last_name ?? '') ?>
                                </td>
                                <td><?= esc($academe->address ?? 'N/A') ?></td>
                                <td>
                                    <h6><b>Fax:</b></h6><?= esc($academe->fax_num ?? 'N/A') ?><br>
                                    <h6><b>Telephone:</b></h6><?= esc($academe->telephone_num ?? 'N/A') ?><br>
                                    <h6><b>Mobile Number:</b></h6><?= esc($academe->mobile_num ?? 'N/A') ?><br>
                                    <h6><b>Email Address:</b></h6><?= esc($academe->email_address ?? 'N/A') ?>
                                </td>
                                <td class="has-text-centered">
                                    <a href="<?= site_url('/directory/academes/edit/' . $academe->stakeholder_id) ?>"
                                        class="button is-small is-info" onclick="event.stopPropagation();">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                    </a>
                                    <a href="<?= site_url('/directory/academes/delete/' . $academe->stakeholder_id) ?>"
                                        class="button is-small is-danger"
                                        onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this record?');">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="has-text-centered">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Academe Modal -->
    <div class="modal" id="addAcademeModal">
        <div class="modal-background"
            onclick="document.getElementById('addAcademeModal').classList.remove('is-active')"></div>
        <div class="modal-card" style="width: 80%; max-width: 1100px;">
            <header class="modal-card-head has-background-light">
                <p class="modal-card-title has-text-black">Create New Academe</p>
                <button class="delete" aria-label="close"
                    onclick="document.getElementById('addAcademeModal').classList.remove('is-active')"></button>
            </header>
            <section class="modal-card-body">
                <form action="<?= site_url('/directory/academes/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Basic Info -->
                    <div class="columns is-multiline">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label has-text-weight-semibold">Abbreviation</label>
                                <div class="control">
                                    <input class="input" type="text" name="abbreviation" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label has-text-weight-semibold">Name</label>
                                <div class="control">
                                    <input class="input" type="text" name="name" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3 class="subtitle is-6 has-text-black has-text-weight-semibold">Head of Office</h3>

                    <div class="columns is-multiline">
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input class="input" type="text" name="first_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">Middle Name</label>
                                <div class="control">
                                    <input class="input" type="text" name="middle_name">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input class="input" type="text" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="column is-full">
                            <div class="field">
                                <label class="label">Designation</label>
                                <div class="control">
                                    <input class="input" type="text" name="designation" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3 class="ssubtitle is-6 has-text-black has-text-weight-semibold">Address</h3>

                    <div class="columns is-multiline">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Street</label>
                                <div class="control">
                                    <input class="input" type="text" name="street">
                                </div>
                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Barangay</label>
                                <div class="control">
                                    <input class="input" type="text" name="barangay">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">Municipality</label>
                                <div class="control">
                                    <input class="input" type="text" name="municipality">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">Province</label>
                                <div class="control">
                                    <input class="input" type="text" name="province">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-sixth">
                            <div class="field">
                                <label class="label">Country</label>
                                <div class="control">
                                    <input class="input" type="text" name="country">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-sixth">
                            <div class="field">
                                <label class="label">Postal Code</label>
                                <div class="control">
                                    <input class="input" type="text" name="postal_code">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3 class="subtitle is-6 has-text-black has-text-weight-semibold">Contact Details</h3>

                    <div class="columns is-multiline">
                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Fax Number</label>
                                <div class="control">
                                    <input class="input" type="text" name="fax_num">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Telephone Number</label>
                                <div class="control">
                                    <input class="input" type="text" name="telephone_num">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Mobile Number</label>
                                <div class="control">
                                    <input class="input" type="text" name="mobile_num">
                                </div>
                            </div>
                        </div>
                        <div class="column is-one-quarter">
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input class="input" type="email" name="email_address" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer>
                        <div class="field is-grouped is-justify-content-center mt-5">
                            <div class="control">
                                <button type="submit" class="button is-success">Save</button>
                            </div>
                            <div class="control ml-2">
                                <button type="button" class="button"
                                    onclick="document.getElementById('addAcademeModal').classList.remove('is-active')">Cancel</button>
                            </div>
                        </div>
                    </footer>

                </form>
            </section>
        </div>
    </div>


</section>
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

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("search-input");
        const entriesSelect = document.getElementById("entries-select");
        const tableBody = document.getElementById("table-body");
        const rows = Array.from(tableBody.querySelectorAll("tr"));

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const maxEntries = entriesSelect.value === 'all' ? Infinity : parseInt(entriesSelect.value);
            let count = 0;

            rows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                const matchSearch = rowText.includes(search);

                if (matchSearch && count < maxEntries) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener("input", filterTable);
        entriesSelect.addEventListener("change", filterTable);

        filterTable(); // Initialize filtering
    });

</script>

<?= $this->endSection() ?>