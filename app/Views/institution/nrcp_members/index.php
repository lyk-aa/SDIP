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
        margin-top: 30px;
    }

    .card-flip {
        perspective: 1000px;
    }

    .card {
        height: 300px;
        margin-top: 20px;
        position: relative;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        overflow: visible;
        background: white;
        padding-top: 50px;
    }

    .flip-inner {
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        position: relative;
    }

    .flip-inner.is-flipped {
        transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        padding: 1.5rem 1rem;
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        text-align: center;
        border-radius: 12px;
        background: white;
        box-sizing: border-box;
    }

    .card-back {
        background-color: #f9f9f9;
        transform: rotateY(180deg);
    }

    .card-image-wrapper {
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 150px;
        background: white;
        border-radius: 50%;
        padding: px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: #2c3e50;
        margin-bottom: auto;
        margin-top: 7rem;
    }

    .card-back p {
        margin: 0.25rem 0;
        font-size: 0.9rem;
    }

    .card-action-button {
        margin-top: auto;
        background-color: #50c878;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        border: none;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .card-action-button:hover {
        background-color: #3bb16f;
    }

    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
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

    .notification {
        transition: opacity 0.5s ease-out;
    }
</style>

<body>
    <div class="container">
        <div class="box mt-4">
            <div class="title has-text-centered">
                <h1>DOST VI NRCP Members</h1>
            </div>

            <?php if (session()->getFlashdata('nrcp-success')): ?>
                <div class="notification is-success is-light auto-dismiss">
                    <?= session()->getFlashdata('nrcp-success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('nrcp-error')): ?>
                <div class="notification is-danger is-light auto-dismiss">
                    <?= session()->getFlashdata('nrcp-error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/nrcp_members/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div class="columns is-multiline">
                <?php foreach ($nrcp_members as $nrcp): ?>
                    <div class="column is-one-quarter-desktop is-half-tablet is-full-mobile">
                        <div class="card-flip">
                            <div class="card">

                                <!-- Kebab Menu -->
                                <div class="kebab-menu dropdown is-right is-hoverable" onclick="event.stopPropagation();">
                                    <div class="dropdown-trigger">
                                        <button class="button is-white is-small">
                                            <span class="icon is-small"><i class="fas fa-ellipsis-v"></i></span>
                                        </button>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-content">
                                            <a href="<?= base_url('institution/nrcp_members/edit/' . esc($nrcp['id'])) ?>"
                                                class="dropdown-item">Edit</a>
                                            <a href="#" class="dropdown-item has-text-danger"
                                                onclick="confirmDelete(<?= esc($nrcp['id']) ?>);">Delete</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="flip-inner">
                                    <!-- FRONT SIDE -->
                                    <div class="card-front">
                                        <div class="card-image-wrapper">
                                            <img src="<?= !empty($nrcp['image']) ? base_url($nrcp['image']) : '/images/profile.png' ?>"
                                                alt="nrcp Image">
                                        </div>
                                        <div class="card-title">
                                            <?= esc($nrcp['honorifics']) . ' ' . esc($nrcp['first_name']) . ' ' . esc($nrcp['middle_name']) . ' ' . esc($nrcp['last_name']) ?>
                                        </div>
                                        <button class="card-action-button"
                                            onclick="event.stopPropagation(); this.closest('.flip-inner').classList.add('is-flipped')">
                                            View More →
                                        </button>
                                    </div>

                                    <!-- BACK SIDE -->
                                    <div class="card-back">
                                        <p><strong>Role:</strong> <?= esc($nrcp['role']) ?></p>
                                        <p><strong>Institution:</strong> <?= esc($nrcp['institution_name']) ?></p>
                                        <p><strong>Description:</strong> <?= esc($nrcp['description']) ?></p>
                                        <button class="card-action-button"
                                            onclick="event.stopPropagation(); this.closest('.flip-inner').classList.remove('is-flipped')">
                                            ← Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
            <h1 class="title is-5 has-text-centered mt-5 mb-4">Are you sure you want to delete this NRCP?</h1>
            <div class="buttons is-centered mt-4">
                <button id="cancelDelete" class="button is-light">Cancel</button>
                <button id="confirmDelete" class="button is-danger">Delete</button>
            </div>
        </div>
    </div>
</body>

<script>
    let deleteId = null;

    function confirmDelete(id) {
        deleteId = id;
        const modal = document.getElementById('deleteModal');
        modal.classList.add('is-active');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('is-active');
        deleteId = null;
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            document.querySelectorAll('.notification.auto-dismiss').forEach(notification => {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);

        const cancelBtn = document.getElementById('cancelDelete');
        const confirmBtn = document.getElementById('confirmDelete');

        cancelBtn.addEventListener('click', closeDeleteModal);
        confirmBtn.addEventListener('click', function () {
            if (deleteId !== null) {
                // Send the delete request by redirecting or using an AJAX call
                window.location.href = "<?= base_url('institution/nrcp_members/delete/') ?>" + deleteId;
            }
        });

        // Search functionality
        const searchInput = document.getElementById('search-input');
        const cards = document.querySelectorAll('.columns .column');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const name = card.querySelector('.card-title')?.textContent?.toLowerCase() || '';
                const role = card.querySelector('.card-back p:nth-child(1)')?.textContent?.toLowerCase() || '';
                const institution = card.querySelector('.card-back p:nth-child(2)')?.textContent?.toLowerCase() || '';

                if (name.includes(query) || role.includes(query) || institution.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>