<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">DOST Wide-Contacts</h3>

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

            <!-- Search -->
            <div class="column is-5">
                <div class="field">
                    <p class="control has-icons-left">
                        <input type="text" id="search-input" class="input is-rounded" placeholder="Search...">
                        <span class="icon is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </p>
                </div>
            </div>

            <!-- Buttons (Create + Export) -->
            <div class="column is-4 is-flex is-justify-content-flex-end is-align-items-flex-end">
                <div class="buttons">
                    <button class="button is-success is-rounded"
                        onclick="document.getElementById('add-contact-modal').classList.add('is-active')">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Create New</span>
                    </button>
                    <a href="<?= site_url('directory/wide_contacts/export') ?>" class="button is-primary is-rounded">
                        <span class="icon"><i class="fas fa-file-export"></i></span>
                        <span>Export</span>
                    </a>
                </div>
            </div>
        </div>


        <div class="table-container mt-4">
            <table class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead>
                    <tr class="has-background-light">
                        <th class="has-text-centered">Name</th>
                        <th class="has-text-centered">Position</th>
                        <th class="has-text-centered">Contact Details</th>
                        <th class="has-text-centered">Plate Number</th>
                        <th class="has-text-centered">Driver Number</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php foreach ($contacts as $contact): ?>
                        <tr onclick="window.location.href='<?= site_url('/directory/wide_contacts/view/' . $contact->person_id) ?>'"
                            style="cursor: pointer;">
                            <td>
                                <?= esc($contact->first_name) ?>
                                <?= esc(data: $contact->middle_name) ?>
                                <?= esc(data: $contact->last_name) ?>
                            </td>
                            <td><?= esc($contact->position ?? 'N/A') ?></td>
                            <td>
                                <h6><b>Email Address:</b></h6><?= esc($contact->email_address ?? 'N/A') ?>
                                <h6><b>Telephone Number:</b></h6>
                                <?= esc($contact->mobile_num ?? $contact->telephone_num ?? $contact->fax_num ?? 'N/A') ?>
                            </td>

                            <td><?= esc($contact->plate_number ?? 'N/A') ?></td>
                            <td><?= esc($contact->driver_num ?? 'N/A') ?></td>
                            <td class="has-text-centered">
                                <!-- Edit Button -->
                                <a href="<?= base_url('/directory/wide_contacts/edit/' . $contact->person_id) ?>"
                                    class="button is-small is-info" title="Edit">
                                    <span class="icon is-small">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>

                                <!-- Delete Button -->
                                <a href="<?= base_url('/directory/wide_contacts/delete/' . $contact->person_id) ?>"
                                    class="button is-small is-danger" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this contact?');">
                                    <span class="icon is-small">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</section>

<!-- Add Contact Modal -->
<div class="modal" id="add-contact-modal">
    <div class="modal-background" onclick="document.getElementById('add-contact-modal').classList.remove('is-active')">
    </div>
    <div class="modal-card">
        <header class="modal-card-head has-background-light">
            <p class="modal-card-title">Add Contact</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('add-contact-modal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form method="POST" action="<?= base_url('directory/wide_contacts/store') ?>">
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">First Name</label>
                            <div class="control">
                                <input type="text" class="input" name="first_name" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Middle Name</label>
                            <div class="control">
                                <input type="text" class="input" name="middle_name" placeholder="Middle Initial"
                                    required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Last Name</label>
                            <div class="control">
                                <input type="text" class="input" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Position</label>
                            <div class="control">
                                <input type="text" class="input" name="position" placeholder="Position" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input type="email" class="input" name="email" placeholder="Email Address" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone Number</label>
                            <div class="control">
                                <input type="text" class="input" name="contact_number" placeholder="Telephone Number"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Plate Number</label>
                            <div class="control">
                                <input type="text" class="input" name="plate_number" placeholder="Plate Number">
                            </div>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Driver Number</label>
                            <div class="control">
                                <input type="text" class="input" name="driver_number" placeholder="Driver Number">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field has-text-centered mt-4">
                    <button type="submit" class="button is-success">Save</button>
                    <button type="button" class="button"
                        onclick="document.getElementById('add-contact-modal').classList.remove('is-active');">Cancel</button>
                </div>
            </form>
        </section>
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
        const searchInput = document.getElementById('search-input');
        const entriesSelect = document.getElementById('entries-select');
        const tableRows = Array.from(document.querySelectorAll('#table-body tr'));
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const pageInfo = document.getElementById('page-info');

        let currentPage = 1;
        let entriesPerPage = parseInt(entriesSelect.value);

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();

            let filteredRows = tableRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                return rowText.includes(searchText);
            });

            updatePagination(filteredRows);
        }

        function updatePagination(filteredRows) {
            const totalRows = filteredRows.length;
            let totalPages = Math.ceil(totalRows / entriesPerPage);
            if (entriesPerPage === 'all') totalPages = 1;

            if (currentPage > totalPages) currentPage = totalPages || 1;

            let startIdx = (currentPage - 1) * entriesPerPage;
            let endIdx = entriesPerPage === 'all' ? totalRows : startIdx + entriesPerPage;

            tableRows.forEach(row => row.style.display = 'none');
            filteredRows.slice(startIdx, endIdx).forEach(row => row.style.display = '');

            pageInfo.textContent = `Page ${currentPage} of ${totalPages || 1}`;
            prevPageBtn.disabled = currentPage === 1;
            nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
        }

        searchInput.addEventListener('input', filterTable);
        entriesSelect.addEventListener('change', () => {
            entriesPerPage = entriesSelect.value === 'all' ? 'all' : parseInt(entriesSelect.value);
            currentPage = 1;
            filterTable();
        });

        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                filterTable();
            }
        });

        nextPageBtn.addEventListener('click', () => {
            currentPage++;
            filterTable();
        });

        filterTable();
    });
</script>

<?= $this->endSection() ?>