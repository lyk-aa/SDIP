<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<!-- Styles remain unchanged -->

<body>
    <div class="container">
        <div class="box mt-4">

            <div class="title has-text-centered">
                <h1>Research & Innovation Centers</h1>
            </div>

            <?php if (session()->getFlashdata('center-success')): ?>
                <div class="notification is-success is-light auto-dismiss">
                    <?= session()->getFlashdata('center-success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('center-error')): ?>
                <div class="notification is-danger is-light auto-dismiss">
                    <?= session()->getFlashdata('center-error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/research_centers/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div id="search-results" style="margin-top: 20px;"></div>

            <div class="table-container">
                <table class="table is-striped is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>Research Center</th>
                            <th>Institution</th>
                            <th class="has-text-centered">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($centers)): ?>
                            <?php foreach ($centers as $center): ?>
                                <tr>
                                    <td><?= esc($center->center_name ?? 'N/A') ?></td>
                                    <td><?= esc($center->institution_name ?? '') ?></td>
                                    <td class="has-text-centered">
                                        <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                            <a href="<?= site_url('/institution/research_centers/edit/' . $center->center_id) ?>" class="button is-info is-small actions-btn">
                                                <span class="icon"><i class="fas fa-edit"></i></span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="<?= $center->center_id ?>">
                                                <span class="icon"><i class="fas fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="has-text-centered has-text-grey-light">No research centers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="icon-container">
                <div class="icon-circle">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
            <h1 class="title is-5 has-text-centered mt-5 mb-4">Are you sure you want to delete this Research Center?</h1>
            <div class="buttons is-centered mt-4">
                <button id="cancelDelete" class="button is-light">Cancel</button>
                <button id="confirmDelete" class="button is-danger">Delete</button>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Flash notifications
        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);

        const searchInput = document.getElementById('search-input');
        const tableBody = document.querySelector('.table tbody');
        const originalCenters = <?= json_encode($centers) ?>;

        function renderOriginalTable() {
            tableBody.innerHTML = '';
            if (originalCenters.length > 0) {
                originalCenters.forEach(center => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${center.center_name}</td>
                        <td>${center.institution_name}</td>
                        <td class="has-text-centered">
                            <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                <a href="/institution/research_centers/edit/${center.center_id}" class="button is-info is-small actions-btn">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                    <span>Edit</span>
                                </a>
                                <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${center.center_id}">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                const noResultsRow = document.createElement('tr');
                noResultsRow.innerHTML = '<td colspan="3" class="has-text-centered">No research centers found.</td>';
                tableBody.appendChild(noResultsRow);
            }
        }

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            if (query.length > 0) {
                fetchSearchResults(query);
            } else {
                renderOriginalTable();
            }
        });

        function fetchSearchResults(query) {
            fetch("<?= base_url('institution/research_centers/search') ?>?query=" + query)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(center => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${center.center_name}</td>
                                <td>${center.institution_name}</td>
                                <td class="has-text-centered">
                                    <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                        <a href="/institution/research_centers/edit/${center.center_id}" class="button is-info is-small actions-btn">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                            <span>Edit</span>
                                        </a>
                                        <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${center.center_id}">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        const noResultsRow = document.createElement('tr');
                        noResultsRow.innerHTML = '<td colspan="3" class="has-text-centered">No results found.</td>';
                        tableBody.appendChild(noResultsRow);
                    }
                });
        }

        renderOriginalTable();

        const deleteModal = document.getElementById('deleteModal');
        let selectedDeleteId = null;

        document.body.addEventListener('click', function (event) {
            const deleteBtn = event.target.closest('.delete-btn');
            if (deleteBtn) {
                selectedDeleteId = deleteBtn.getAttribute('data-id');
                deleteModal.classList.add('is-active');
            }
        });

        document.getElementById('cancelDelete').addEventListener('click', () => {
            deleteModal.classList.remove('is-active');
        });

        document.getElementById('confirmDelete').addEventListener('click', () => {
            if (selectedDeleteId) {
                window.location.href = "<?= base_url('institution/research_centers/delete/') ?>" + selectedDeleteId;
            }
        });
    });
</script>

<?= $this->endSection() ?>
