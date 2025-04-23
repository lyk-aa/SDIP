<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-bottom: 10px;
        margin-top: -10px;
    }

    .title {
        font-size: 2.2rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .box {
        margin-top: 30px;
        padding: 20px;
    }

    .table-container {
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 12px 15px;
    }

    .table th {
        background-color: #f7f7f7;
    }

    .table .icon {
        margin-right: 5px;
    }

    .actions-btn {
        min-width: 120px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .has-text-centered {
        text-align: center;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal.is-active {
        display: flex;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;

    }

    .modal-content {
        position: relative;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        font-weight: normal;
        /* No bold text */

    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 1rem;
        color: white;
        background-color: #4a4a4a;
        border: none;
        cursor: pointer;
        z-index: 10;
    }

    .icon-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .icon-circle {
        background-color: #f14668;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-circle i {
        color: #f14668;
        font-size: 28px;
    }

    @keyframes fadeInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .notification {
        transition: opacity 0.5s ease-out;
    }
</style>

<body>
    <div class="container">
        <div class="box mt-4">

            <div class="title has-text-centered">
                <h1>Consortium Membership</h1>
            </div>

            <?php if (session()->getFlashdata('cons-success')): ?>
                <div class="notification is-success is-light auto-dismiss">
                    <?= session()->getFlashdata('cons-success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('cons-error')): ?>
                <div class="notification is-danger is-light auto-dismiss">
                    <?= session()->getFlashdata('cons-error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/consortium/create') ?>" class="button is-primary">
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
                            <th>Consortium</th>
                            <th>Institution</th>
                            <th class="has-text-centered">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($consortiums)): ?>
                            <?php foreach ($consortiums as $consortium): ?>
                                <tr>
                                    <td><?= esc($consortium->consortium_name ?? 'N/A') ?></td>
                                    <td><?= esc($consortium->institution_name ?? '') ?></td>
                                    <td class="has-text-centered">
                                        <div class="buttons is-flex is-justify-content-center is-align-items-center"
                                            style="gap: 10px;">
                                            <a href="<?= site_url('/institution/consortium/edit/' . $consortium->consortium_id) ?>"
                                                class="button is-info is-small actions-btn">
                                                <span class="icon"><i class="fas fa-edit"></i></span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="button is-danger is-small actions-btn delete-btn"
                                                data-id="<?= $consortium->consortium_id ?>">
                                                <span class="icon"><i class="fas fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="has-text-centered has-text-grey-light">No regional offices found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="icon-container">
                <div class="icon-circle">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
            <h1 class="title is-5 has-text-centered mt-5 mb-4">Are you sure you want to delete this Consortium?</h1>
            <div class="buttons is-centered mt-4">
                <button id="cancelDelete" class="button is-light">Cancel</button>
                <button id="confirmDelete" class="button is-danger">Delete</button>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);

        const searchInput = document.getElementById('search-input');
        const searchResultsContainer = document.getElementById('search-results');
        const tableBody = document.querySelector('.table tbody');

        const originalConsortiums = <?= json_encode($consortiums) ?>;

        function renderOriginalTable() {
            tableBody.innerHTML = '';

            if (originalConsortiums.length > 0) {
                originalConsortiums.forEach(consortium => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${consortium.consortium_name}</td>
                    <td>${consortium.institution_name}</td>
                    <td class="has-text-centered">
                        <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                            <a href="/institution/consortium/edit/${consortium.consortium_id}" class="button is-info is-small actions-btn">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${consortium.consortium_id}">
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
                noResultsRow.innerHTML = '<td colspan="3" class="has-text-centered">No consortiums found.</td>';
                tableBody.appendChild(noResultsRow);
            }
        }

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();

            if (query.length > 0) {
                fetchSearchResults(query);
            } else {
                searchResultsContainer.innerHTML = '';
                renderOriginalTable();
            }
        });

        function fetchSearchResults(query) {
            fetch("<?= base_url('institution/consortium/search') ?>?query=" + query)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(consortium => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${consortium.consortium_name}</td>
                            <td>${consortium.institution_name}</td>
                            <td class="has-text-centered">
                                <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                    <a href="/institution/consortium/edit/${consortium.consortium_id}" class="button is-info is-small actions-btn">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                        <span>Edit</span>
                                    </a>
                                    <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${consortium.consortium_id}">
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
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        }

        renderOriginalTable();

        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        let selectedDeleteId = null;

        document.body.addEventListener('click', function (event) {
            const deleteBtn = event.target.closest('.delete-btn');
            if (deleteBtn) {
                selectedDeleteId = deleteBtn.getAttribute('data-id');
                deleteModal.classList.add('is-active');
            }
        });

        function closeDeleteModal() {
            deleteModal.classList.remove('is-active');
            selectedDeleteId = null;
        }

        cancelDelete.addEventListener('click', closeDeleteModal);

        confirmDelete.addEventListener('click', function () {
            if (selectedDeleteId) {
                window.location.href = "<?= base_url('institution/consortium/delete/') ?>" + selectedDeleteId;
            }
        });
    });
</script>

<?= $this->endSection() ?>