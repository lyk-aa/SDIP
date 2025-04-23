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

    .modal-content {
        position: relative;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        font-weight: normal;
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
                <h1>Research Centers</h1>
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

                <a href="<?= base_url('institution/research-centers/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light" onclick="printCenters('<?= site_url('institution/research-centers/print') ?>')">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

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
                                    <td><?= esc($center->research_center_name ?? 'N/A') ?></td>
                                    <td><?= esc($center->institution_name ?? '') ?></td>
                                    <td class="has-text-centered">
                                        <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                            <a href="<?= site_url('/institution/research-centers/edit/' . $center->research_center_id) ?>" class="button is-info is-small actions-btn">
                                                <span class="icon"><i class="fas fa-edit"></i></span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="<?= $center->research_center_id ?>">
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
        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);

        const searchInput = document.getElementById('search-input');
        const tableBody = document.querySelector('.table tbody');
        const originalCenters = <?= json_encode($research_centers) ?>;

        function renderOriginalTable() {
            tableBody.innerHTML = '';
            if (originalCenters.length > 0) {
                originalCenters.forEach(center => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${center.research_center_name}</td>
                        <td>${center.institution_name}</td>
                        <td class="has-text-centered">
                            <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                <a href="/institution/research-centers/edit/${center.research_center_id}" class="button is-info is-small actions-btn">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                    <span>Edit</span>
                                </a>
                                <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${center.research_center_id}">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </td>`;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="3" class="has-text-centered">No research centers found.</td></tr>';
            }
        }

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            if (query.length > 0) {
                fetch("<?= base_url('institution/research-centers/search') ?>?query=" + query)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(center => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${center.research_center_name}</td>
                                    <td>${center.institution_name}</td>
                                    <td class="has-text-centered">
                                        <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                            <a href="/institution/research-centers/edit/${center.research_center_id}" class="button is-info is-small actions-btn">
                                                <span class="icon"><i class="fas fa-edit"></i></span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="javascript:void(0);" class="button is-danger is-small actions-btn delete-btn" data-id="${center.research_center_id}">
                                                <span class="icon"><i class="fas fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </td>`;
                                tableBody.appendChild(row);
                            });
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="3" class="has-text-centered">No results found.</td></tr>';
                        }
                    });
            } else {
                renderOriginalTable();
            }
        });

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

        cancelDelete.addEventListener('click', () => {
            deleteModal.classList.remove('is-active');
            selectedDeleteId = null;
        });

        confirmDelete.addEventListener('click', () => {
            if (selectedDeleteId) {
                window.location.href = "<?= base_url('institution/research-centers/delete/') ?>" + selectedDeleteId;
            }
        });
    });

    function printCenters(url) {
        const printWindow = window.open(url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', () => {
            printWindow.print();
            setTimeout(() => printWindow.close(), 500);
        }, true);
    }
</script>

<?= $this->endSection() ?>
