<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">Local Government Units (LGUs)</h3>

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
                <button class="button is-success is-rounded"
                    onclick="document.getElementById('addLGUModal').classList.add('is-active');">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </button>
                <a href="<?= site_url('directory/lgus/export') ?>" class="button is-primary is-rounded">
                    <span class="icon"><i class="fas fa-file-export"></i></span>
                    <span>Export</span>
                </a>
            </div>
        </div>
        <div class="table-container mt-4">
            <table class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead>
                    <tr class="has-background-light">
                        <th class="has-text-centered">Salutation</th>
                        <th class="has-text-centered">Name</th>
                        <th class="has-text-centered">Position</th>
                        <th class="has-text-centered">Office Name</th>
                        <th class="has-text-centered">Office Address</th>
                        <th class="has-text-centered">Contact Details</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php if (!empty($lgus)): ?>
                        <?php foreach ($lgus as $lgu): ?>
                            <?php foreach ($lgu['members'] as $member): ?>
                                <tr onclick="window.location.href='<?= site_url('/directory/lgus/view/' . $lgu['id']) ?>'"
                                    style="cursor: pointer;">

                                    <td><?= esc($member['person']['salutation'] ?? 'N/A') ?></td>
                                    <td><?= esc(($member['person']['first_name'] ?? '') . ' ' . ($member['person']['middle_name'] ?? '') . ' ' . ($member['person']['last_name'] ?? '')) ?>
                                    </td>
                                    <td><?= esc($member['person']['designation'] ?? 'N/A') ?></td>
                                    <td><?= esc($lgu['name'] ?? 'N/A') ?></td>
                                    <td>
                                        <?= esc(implode(', ', array_filter([
                                            $lgu['street'] ?? 'N/A',
                                            $lgu['barangay'] ?? 'N/A',
                                            $lgu['municipality'] ?? 'N/A',
                                            $lgu['province'] ?? 'N/A',
                                            $lgu['country'] ?? 'N/A',
                                            $lgu['postal_code'] ?? 'N/A'
                                        ]))) ?>
                                    </td>

                                    </td>
                                    </td>
                                    </td>
                                    <td>
                                        <h6><b>Telephone:</b></h6><?= esc($member['contact']['telephone_num'] ?? 'N/A') ?><br>
                                        <h6><b>Fax:</b></h6> <?= esc($member['contact']['fax_num'] ?? 'N/A') ?><br>
                                        <h6><b>Email Address:</b></h6><?= esc($member['contact']['email_address'] ?? 'N/A') ?><br>
                                    </td>

                                    <td class="has-text-centered">
                                        <a href="<?= base_url('/directory/lgus/edit/' . $member['stakeholder_id']) ?>"
                                            class="button is-small is-info"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url('/directory/lgus/delete/' . $member['stakeholder_id']) ?>"
                                            class="button is-small is-danger"
                                            onclick="return confirm('Are you sure you want to delete this LGU entry?');"><i
                                                class="fas fa-trash"></i></a>
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
    </div>
    </div>

</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const entriesSelect = document.getElementById('entries-select');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const pageInfo = document.getElementById('page-info');

        let currentPage = 1;
        let entriesPerPage = parseInt(entriesSelect.value);

        function getAllRows() {
            return Array.from(document.querySelectorAll('#table-body tr'));
        }

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const allRows = getAllRows();

            const filteredRows = allRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                return rowText.includes(searchText);
            });

            updatePagination(filteredRows);
        }

        function updatePagination(filteredRows) {
            const totalRows = filteredRows.length;
            const totalPages = entriesPerPage === 'all' ? 1 : Math.ceil(totalRows / entriesPerPage);

            if (currentPage > totalPages) currentPage = totalPages || 1;

            const startIdx = (currentPage - 1) * (entriesPerPage === 'all' ? totalRows : entriesPerPage);
            const endIdx = entriesPerPage === 'all' ? totalRows : startIdx + entriesPerPage;

            getAllRows().forEach(row => row.style.display = 'none');
            filteredRows.slice(startIdx, endIdx).forEach(row => row.style.display = '');

            pageInfo.textContent = `Page ${currentPage} of ${totalPages || 1}`;
            prevPageBtn.disabled = currentPage === 1;
            nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
        }

        entriesSelect.addEventListener('change', () => {
            entriesPerPage = entriesSelect.value === 'all' ? 'all' : parseInt(entriesSelect.value);
            currentPage = 1;
            filterTable();
        });

        searchInput.addEventListener('input', () => {
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

        // Initial load
        filterTable();
    });
</script>


<?= $this->include('directory/lgus/create') ?>

<?= $this->endSection() ?>