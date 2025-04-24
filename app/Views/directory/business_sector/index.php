<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">NGO Business Sectors</h3>
        <div class="columns is-vcentered is-multiline mb-4">
            <!-- Show Entries -->
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

            <!-- Search Input -->
            <div class="column is-4">
                <div class="field">
                    <p class="control has-icons-left">
                        <input type="text" id="search-input" class="input is-rounded" placeholder="Search...">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="column is-5 is-flex is-justify-content-flex-end is-align-items-flex-end">
                <div class="buttons">
                    <a class="button is-success is-rounded"
                        onclick="document.getElementById('addNGOModal').classList.add('is-active');">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Create New</span>
                    </a>
                    <a href="<?= site_url('directory/business_sector/export') ?>" class="button is-primary is-rounded">
                        <span class="icon"><i class="fas fa-file-export"></i></span>
                        <span>Export</span>
                    </a>
                </div>
            </div>
        </div>




        <div class="table-container mt-3">
            <table class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead>
                    <tr class="has-background-light has-text-centered">
                        <th>Salutation</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Office Name</th>
                        <th>Office Address</th>
                        <th>Classification</th>
                        <th>Source Agency</th>
                        <th>Contact Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ngos as $ngo): ?>
                        <?php foreach ($ngo['members'] as $member): ?>
                            <tr onclick="window.location.href='<?= site_url('/directory/business_sector/view/' . $ngo['id']) ?>'"
                                style="cursor: pointer;">
                                <td><?= esc($member['person']['salutation'] ?? 'N/A') ?></td>
                                <td>
                                    <?= esc($member['person']['first_name'] ?? '') ?>
                                    <?= esc($member['person']['middle_name'] ?? '') ?>
                                    <?= esc($member['person']['last_name'] ?? '') ?>
                                </td>
                                <td><?= esc($member['person']['designation'] ?? 'N/A') ?></td>
                                <td><?= esc($ngo['name'] ?? 'N/A') ?></td>
                                <td>
                                    <?= esc($ngo['street'] ?? 'N/A') ?>,
                                    <?= esc($ngo['barangay'] ?? 'N/A') ?>,
                                    <?= esc($ngo['municipality'] ?? 'N/A') ?>,
                                    <?= esc($ngo['province'] ?? 'N/A') ?>,
                                    <?= esc($ngo['country'] ?? 'N/A') ?>,
                                    <?= esc($ngo['postal_code'] ?? 'N/A') ?>
                                </td>
                                <td><?= esc($ngo['classification'] ?? 'N/A') ?></td>
                                <td><?= esc($ngo['source_agency'] ?? 'N/A') ?></td>
                                <td>
                                    <h6><b>Telephone:</b></h6><?= esc($member['contact']['telephone_num'] ?? 'N/A') ?><br>
                                    <h6><b>Fax:</b></h6><?= esc($member['contact']['fax_num'] ?? 'N/A') ?><br>
                                    <h6><b>Email Address:</b></h6><?= esc($member['contact']['email_address'] ?? 'N/A') ?>
                                </td>

                                <td class="has-text-centered">
                                    <a href="<?= base_url('/directory/business_sector/edit/' . $member['person']['id']) ?>"
                                        class="button is-small is-info">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                    </a>
                                    <a href="<?= base_url('/directory/business_sector/delete/' . $member['person']['id']) ?>"
                                        class="button is-small is-danger"
                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Add NGO Modal -->
<div id="addNGOModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addNGOModal').classList.remove('is-active');"></div>
    <div class="modal-card">
        <header class="modal-card-head has-background-light">
            <p class="modal-card-title">Add NGO</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addNGOModal').classList.remove('is-active');"></button>
        </header>

        <form action="<?= base_url('/directory/business_sector/store') ?>" method="post">
            <section class="modal-card-body" style="max-height: 60vh; overflow-y: auto;">
                <div class="columns is-multiline">
                    <!-- Person Details -->
                    <div class="column is-half">
                        <label class="label">Salutation</label>
                        <input class="input" type="text" name="salutation" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">First Name</label>
                        <input class="input" type="text" name="first_name" required>
                    </div>
                    <div class="column is-half">
                        <label class="label">Middle Name</label>
                        <input class="input" type="text" name="middle_name" required>
                    </div>
                    <div class="column is-half">
                        <label class="label">Last Name</label>
                        <input class="input" type="text" name="last_name" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Designation</label>
                        <input class="input" type="text" name="designation" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Office Name</label>
                        <input class="input" type="text" name="office_name" required>
                    </div>

                    <!-- Address -->
                    <div class="column is-full mt-3">
                        <h6 class="title is-6">Office Address</h6>
                    </div>

                    <div class="column is-half">
                        <label class="label">Street</label>
                        <input class="input" type="text" name="street" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Barangay</label>
                        <input class="input" type="text" name="barangay" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Municipality</label>
                        <input class="input" type="text" name="municipality" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Province</label>
                        <input class="input" type="text" name="province" required>
                    </div>
                    <div class="column is-half">
                        <label class="label">Country</label>
                        <input class="input" type="text" name="country" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Postal Code</label>
                        <input class="input" type="text" name="postal_code" required>
                    </div>

                    <!-- Classification and Contact -->
                    <div class="column is-full mt-3">
                        <h6 class="title is-6">Additional Details</h6>
                    </div>

                    <div class="column is-half">
                        <label class="label">Classification</label>
                        <input class="input" type="text" name="classification" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Source Agency</label>
                        <input class="input" type="text" name="source_agency" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Telephone Number</label>
                        <input class="input" type="text" name="telephone_num" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Fax</label>
                        <input class="input" type="text" name="fax_num" required>
                    </div>

                    <div class="column is-half">
                        <label class="label">Email Address</label>
                        <input class="input" type="email" name="email" required>
                    </div>
                </div>
            </section>

            <footer class="modal-card-foot is-justify-content-center">
                <button type="submit" class="button is-success">Save</button>
                <button type="button" class="button"
                    onclick="document.getElementById('addNGOModal').classList.remove('is-active');">Cancel</button>
            </footer>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const entriesSelect = document.getElementById('entries-select');
        const searchInput = document.getElementById('search-input');
        const table = document.querySelector('table tbody');
        const rows = Array.from(table.querySelectorAll('tr'));

        function filterAndDisplayRows() {
            const searchValue = searchInput.value.toLowerCase();
            const entries = entriesSelect.value === 'all' ? rows.length : parseInt(entriesSelect.value);

            let count = 0;
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const matchesSearch = rowText.includes(searchValue);

                if (matchesSearch && count < entries) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });
        }

        entriesSelect.addEventListener('change', filterAndDisplayRows);
        searchInput.addEventListener('input', filterAndDisplayRows);

        filterAndDisplayRows(); // Initialize on load
    });
</script>

<?= $this->endSection() ?>