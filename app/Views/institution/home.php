<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
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
        margin-top: 30px;
    }

    .card {
        border-radius: 8px;
        margin-top: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-image {
        width: 100%;
        height: 220px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        overflow: hidden;
        border-bottom: 1px solid #eee;
        padding: 15px;
    }

    .card-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #000;
        margin-bottom: 6px;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .card-title:hover {
        color: #3273dc;
    }

    .card-description {
        font-size: 0.95rem;
        color: #4a4a4a;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .columns.is-multiline {
        align-items: stretch;
    }

    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .button.is-white {
        background: none;
        border: none;
        box-shadow: none;
    }

    .button.is-white:hover {
        background: rgba(0, 0, 0, 0.05);
    }

    @media screen and (max-width: 768px) {

        .card-title,
        .card-description {
            font-size: 0.95rem;
        }

        .buttons-container {
            justify-content: center;
        }
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
                <h1>Institutions</h1>
            </div>

            <?php if (session()->getFlashdata('institution-success')): ?>
                <div class="notification is-success is-light auto-dismiss">
                    <?= session()->getFlashdata('institution-success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('institution-error')): ?>
                <div class="notification is-danger is-light auto-dismiss">
                    <?= session()->getFlashdata('institution-error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div id="search-results" style="margin-top: 20px;">
                <!-- Search results will be shown here -->
            </div>

            <div class="columns is-multiline" id="card-container">
                <?php foreach ($institutions as $institution): ?>
                    <div class="column is-one-fifth-desktop is-half-tablet is-full-mobile">
                        <div class="card">
                            <div class="card-image">
                                <img src="<?= !empty($institution['image']) ? base_url($institution['image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                                    alt="Institution Image" class="preview-image">
                            </div>

                            <div class="dropdown is-right kebab-menu">
                                <div class="dropdown-trigger">
                                    <button class="button is-white is-small">
                                        <span class="icon is-small">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a href="<?= base_url('institution/edit/' . $institution['id']) ?>"
                                            class="dropdown-item">✏️ Edit</a>
                                        <a href="<?= base_url('institution/delete/' . $institution['id']) ?>"
                                            class="dropdown-item has-text-danger"
                                            onclick="event.preventDefault(); confirmDelete(this)">
                                            🗑️ Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content">
                                <p class="card-title">
                                    <a href="<?= base_url('institution/view/' . $institution['id']) ?>">
                                        <?= esc($institution['name']) ?> (<?= esc($institution['abbreviation']) ?>)
                                    </a>
                                </p>
                                <p class="card-description">
                                    <?= esc($institution['street']) ?>, <?= esc($institution['barangay']) ?>,
                                    <?= esc($institution['municipality']) ?>, <?= esc($institution['province']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="icon-container">
                <div class="icon-circle">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
            <h1 class="title is-5 has-text-centered mt-5 mb-4">Are you sure you want to delete this institution?</h1>
            <div class="buttons is-centered mt-4">
                <button id="cancelDelete" class="button is-light">Cancel</button>
                <button id="confirmDelete" class="button is-danger">Delete</button>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);

        document.querySelectorAll('.dropdown-trigger button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('is-active');
            });
        });

        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('is-active'));
        });

        document.querySelectorAll('.notification .delete').forEach(($delete) => {
            const $notification = $delete.parentNode;
            $delete.addEventListener('click', () => {
                $notification.remove();
            });
        });

        const deleteModal = document.getElementById('deleteModal');
        const closeModal = document.getElementById('closeModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        let deleteUrl = '';

        window.confirmDelete = function (link) {
            deleteUrl = link.getAttribute('href');
            deleteModal.classList.add('is-active');
        }

        cancelDelete.addEventListener('click', () => {
            deleteModal.classList.remove('is-active');
        });

        confirmDelete.addEventListener('click', () => {
            window.location.href = deleteUrl;
        });

        closeModal.addEventListener('click', () => {
            deleteModal.classList.remove('is-active');
        });
    });

    const searchInput = document.getElementById('search-input');
    const cardContainer = document.getElementById('card-container');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length > 0) {
            fetch(`<?= base_url('institution/search') ?>?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    let resultsHtml = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            resultsHtml += `
                                <div class="column is-one-fifth-desktop is-half-tablet is-full-mobile">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="${item.image ? `<?= base_url() ?>/${item.image}` : 'https://via.placeholder.com/200x150?text=No+Image'}"
                                                 alt="Institution Image" class="preview-image">
                                        </div>
                                        <div class="card-content">
                                            <p class="card-title">
                                                <a href="<?= base_url('institution/view/') ?>${item.id}">
                                                    ${item.name} (${item.abbreviation})
                                                </a>
                                            </p>
                                            <p class="card-description">
                                                ${item.street}, ${item.barangay}, ${item.municipality}, ${item.province}
                                            </p>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        resultsHtml = '<p>No results found</p>';
                    }

                    searchResults.innerHTML = `<div class="columns is-multiline">${resultsHtml}</div>`;
                    cardContainer.style.display = 'none';
                })
                .catch(error => {
                    console.error('Search Error:', error);
                });
        } else {
            searchResults.innerHTML = '';
            cardContainer.style.display = 'flex';
        }
    });
</script>

<?= $this->endSection() ?>