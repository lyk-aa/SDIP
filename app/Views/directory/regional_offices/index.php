<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">Regional Offices</h3>
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


            <div class="column is6 has-text-right">
                <!-- <a href="<?= site_url('directory/regional_offices/create') ?>" class="button is-success is-rounded">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a> -->

                <button class="button is-success is-rounded" onclick="openModal()">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </button>
                <a href="<?= site_url('directory/regional_offices/export') ?>" class="button is-primary is-rounded">
                    <span class="icon"><i class="fas fa-file-export"></i></span>
                    <span>Export</span>
                </a>
            </div>


        </div>

        <div class="table-container mt-4">
            <table class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead>
                    <tr class="has-background-light">
                        <th class="has-text-centered">Regional Office</th>
                        <th class="has-text-centered">Honorifics</th>
                        <th class="has-text-centered">Name</th>
                        <!-- <th class="has-text-centered">Designation</th> -->
                        <th class="has-text-centered">Position</th>
                        <th class="has-text-centered">Office Address</th>
                        <th class="has-text-centered">Contact Details</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php if (!empty($regional_offices)): ?>
                        <?php foreach ($regional_offices as $office): ?>
                            <tr onclick="window.location.href='<?= site_url('/directory/regional_offices/view/' . $office->stakeholder_id) ?>'"
                                style="cursor:pointer;">
                                <td><?= esc($office->regional_office ?? 'N/A') ?></td>
                                <td><?= esc($office->hon ?? '') ?></td>
                                <td><?= esc(trim($office->first_name . ' ' . ($office->middle_name ?? '') . ' ' . $office->last_name)) ?>
                                </td>
                                <!-- <td><?= esc($office->designation ?? '') ?></td> -->
                                <td><?= esc($office->position ?? '') ?></td>
                                <td><?= esc($office->office_address ?? 'N/A') ?></td>
                                <td>
                                    <h6><b>Telephone:</b></h6><?= esc($office->telephone_num ?? 'N/A') ?><br>
                                    <h6><b>Email Address:</b></h6><?= esc($office->email_address ?? 'N/A') ?><br>
                                </td>
                                <td class="has-text-centered">
                                    <a href="<?= site_url('/directory/regional_offices/edit/' . $office->stakeholder_id) ?>"
                                        class="button is-small is-info">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                    </a>
                                    <a href="<?= site_url('/directory/regional_offices/delete/' . $office->stakeholder_id); ?>"
                                        class="button is-small is-danger"
                                        onclick="return confirm('Are you sure you want to delete this regional office?');">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="has-text-centered">No regional offices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Regional Office Modal -->
<div class="modal" id="create-modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head has-background-light">
            <p class="modal-card-title">Create New Regional Office</p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <form action="<?= base_url('/directory/regional_offices/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Name of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="regional_office" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Honorifics</label>
                            <div class="control">
                                <input class="input" type="text" name="hon">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">First Name</label>
                            <div class="control">
                                <input class="input" type="text" name="first_name" required>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="column is-4">
                        <div class="field">
                            <label class="label">Middle Name</label>
                            <div class="control">
                                <input class="input" type="text" name="middle_name">
                            </div>
                        </div>
                    </div> -->
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Last Name</label>
                            <div class="control">
                                <input class="input" type="text" name="last_name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input class="input" type="text" name="street" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Barangay</label>
                            <div class="control">
                                <input class="input" type="text" name="barangay" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Municipality</label>
                            <div class="control">
                                <input class="input" type="text" name="municipality" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Province</label>
                            <div class="control">
                                <input class="input" type="text" name="province" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <input class="input" type="text" name="country" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input class="input" type="text" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Designation</label>
                            <div class="control">
                                <input class="input" type="text" name="designation">
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Position</label>
                            <div class="control">
                                <input class="input" type="text" name="position">
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="tel" name="telephone_num">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <!-- <div class="column is-6">
                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax_num">
                            </div>
                        </div>
                    </div> -->
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Email Address</label>
                            <div class="control">
                                <input class="input" type="email" name="email_address" required>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
            <footer class="modal-card-foot is-justify-content-center">
                <button type="submit" class="button is-success">Save</button>
                <button type="button" class="button" onclick="closeModal()">Cancel</button>
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
        max-height: 90vh;
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

            const filteredRows = tableRows.filter(row => {
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
<script>
    function openModal() {
        document.getElementById('create-modal').classList.add('is-active');
    }

    function closeModal() {
        document.getElementById('create-modal').classList.remove('is-active');
    }

    document.querySelector('.modal-background')?.addEventListener('click', closeModal);
</script>


<?= $this->endSection() ?>