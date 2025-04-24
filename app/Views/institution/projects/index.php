<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #fff;
    }

    .section {
        padding: 40px;
    }

    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-bottom: 10px;
        margin-top: -10px;
        flex-wrap: wrap;
    }

    .title {
        font-size: 2.2rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .box {
        margin-top: 10px;
    }

    .custom-box {
        background: white;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
    }

    .completed {
        background-color: #48c78e;
        color: white;
    }

    .ongoing {
        background-color: rgb(255, 224, 138);
        color: #4a4a4a;
    }

    .pending {
        background-color: #3273dc;
        color: white;
    }

    .button i {
        margin-right: 5px;
    }

    .filter-buttons button {
        margin-right: 8px;
        transition: background-color 0.2s ease;
    }

    .filter-buttons .button.is-light:hover {
        background-color: rgb(188, 186, 186);
    }

    .filter-buttons .button.is-success:hover {
        background-color: rgb(56, 179, 123);
    }

    .filter-buttons .button.is-warning:hover {
        background-color: #ffca4a;
    }

    .filter-buttons .button.pending {
        background-color: #3273dc;
        color: white;
        border: none;
    }

    .filter-buttons .button.pending:hover {
        background-color: #275fad;
    }

    .filter-buttons .button.is-active {
        box-shadow: 0 0 0 2px rgba(50, 115, 220, 0.25);
        border-color: #3273dc;
        font-weight: bold;
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

    .notification {
        transition: opacity 0.5s ease-out;
    }
</style>

<body>
    <div class="container">
        <div class="box mt-4">
            <div class="title has-text-centered">
                <h1>Research Projects</h1>
            </div>

            <?php if (session()->getFlashdata('project-success')): ?>
                <div class="notification is-success is-light auto-dismiss">
                    <?= session()->getFlashdata('project-success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('project-error')): ?>
                <div class="notification is-danger is-light auto-dismiss">
                    <?= session()->getFlashdata('project-error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/projects/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light" onclick="printProjects('<?= site_url('institution/projects/print') ?>')">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div class="filter-buttons">
                <button class="button is-light" onclick="filterByStatus('', this)">All</button>
                <button class="button is-success" onclick="filterByStatus('Completed', this)">
                    <i class="fas fa-check-circle"></i> Completed
                </button>
                <button class="button is-warning" onclick="filterByStatus('Ongoing', this)">
                    <i class="fas fa-spinner"></i> Ongoing
                </button>
                <button class="button is-orange" onclick="filterByStatus('Pending', this)">
                    <i class="fas fa-clock"></i> Pending
                </button>
            </div>

            <div id="project-list">
                <!-- Project list gets loaded here via JavaScript -->
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
            <h1 class="title is-5 has-text-centered mt-5 mb-4">Are you sure you want to delete this Project?</h1>
            <div class="buttons is-centered mt-4">
                <button id="cancelDelete" class="button is-light">Cancel</button>
                <button id="confirmDelete" class="button is-danger">Delete</button>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchProjects();

        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);
    });

    document.getElementById('search-input').addEventListener('input', function () {
        fetchProjects();
    });

    function fetchProjects(status = '') {
        const searchQuery = document.getElementById('search-input').value;

        fetch('<?= base_url('institution/projects/search') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ search_query: searchQuery, status: status })
        })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('project-list');
                container.innerHTML = '';

                if (data.projects && data.projects.length > 0) {
                    data.projects.forEach(project => {
                        const statusClass = project.status.toLowerCase();
                        let icon = '';
                        if (statusClass === 'completed') icon = '<i class="fas fa-check-circle"></i>';
                        if (statusClass === 'ongoing') icon = '<i class="fas fa-spinner"></i>';
                        if (statusClass === 'pending') icon = '<i class="fas fa-clock"></i>';

                        const element = `
                    <div class="box is-flex is-justify-content-space-between is-align-items-center" style="cursor: pointer;" onclick="window.location.href='<?= base_url('institution/projects/view/') ?>${project.id}'">
                        <div>
                            <strong>${project.name}</strong>
                            <p class="description-text">${project.description}</p>
                            <span class="status-badge ${statusClass}">
                                ${icon} ${project.status.toUpperCase()}
                            </span>
                        </div>
                        <div class="is-flex is-align-items-center" onclick="event.stopPropagation();">
                            <div class="dropdown is-hoverable is-right">
                                <div class="dropdown-trigger">
                                    <button class="button is-white is-small">
                                        <span class="icon is-small">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-content">
                                        <a href="<?= base_url('institution/projects/edit/') ?>${project.id}" class="dropdown-item edit-button">Edit</a>
                                        <a href="javascript:void(0);" onclick="openDeleteModal(${project.id})" class="dropdown-item has-text-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        container.innerHTML += element;
                    });
                } else {
                    container.innerHTML = '<p>No research projects found.</p>';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Something went wrong while fetching projects.');
            });
    }

    function filterByStatus(status, clickedButton) {
        fetchProjects(status);

        const buttons = document.querySelectorAll('.filter-buttons .button');
        buttons.forEach(button => button.classList.remove('is-active'));

        clickedButton.classList.add('is-active');
    }

    function openDeleteModal(projectId) {
        deleteProjectId = projectId;
        document.getElementById('deleteModal').classList.add('is-active');
    }

    function closeDeleteModal() {
        deleteProjectId = null;
        document.getElementById('deleteModal').classList.remove('is-active');
    }

    document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);
    document.getElementById('confirmDelete').addEventListener('click', function () {
    if (deleteProjectId) {
        // Use full page redirect to match controller behavior
        window.location.href = `<?= base_url('institution/projects/delete/') ?>${deleteProjectId}`;
    }
});

    function printProjects(url) {
        const printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');

        printWindow.addEventListener('load', () => {
            if (Boolean(printWindow.chrome)) {
                printWindow.print();
                setTimeout(function(){
                    printWindow.close();
                }, 500);
            } else {
                printWindow.print();
                printWindow.close();
            }
        }, true);
    }
</script>


<?= $this->endSection() ?>