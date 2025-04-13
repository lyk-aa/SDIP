<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .card-flip {
        perspective: 1000px;
    }

    .card {
        height: 300px;
        /* Set a fixed height for consistency */
        position: relative;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .flip-inner {
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flip-inner.is-flipped {
        transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        top: 0;
        left: 0;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: white;
        border-radius: 8px;
    }

    .card-back {
        transform: rotateY(180deg);
        background-color: #f4f4f4;
        padding: 0.8rem;
        font-size: 0.9rem;
    }

    .card-image {
        width: 100%;
        height: 100%;
        /* Ensure image container matches the card's size */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensure the image fits the square size */
    }

    .card-title {
        font-weight: bold;
        margin-top: 0.5rem;
        font-size: 1.1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .dropdown.is-active .dropdown-menu {
        display: block;
    }

    .column {
        cursor: pointer;
    }

    /* Mobile responsiveness */
    @media screen and (max-width: 768px) {
        .card {
            height: auto;
        }

        .card-image {
            height: 150px;
            /* Adjust image height on mobile */
        }

        .card-image img {
            object-fit: contain;
            /* Maintain aspect ratio on mobile */
        }
    }
</style>

<div class="container">
    <div class="box mt-4">
        <h1 class="title has-text-centered">DOST VI Balik Scientist</h1>

        <div class="buttons-container">
            <a href="<?= base_url('institution/balik_scientist/create') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Create New</span>
            </a>
            <button class="button is-light">
                <span class="icon"><i class="fas fa-download"></i></span>
                <span>Download Template</span>
            </button>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="notification is-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="notification is-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <div class="columns is-multiline">
            <?php foreach ($balik_scientists as $scientist): ?>
                <div class="column is-one-quarter-desktop is-half-tablet is-full-mobile">
                    <div class="card-flip" onclick="this.querySelector('.flip-inner').classList.toggle('is-flipped')">
                        <div class="card">
                            <div class="kebab-menu dropdown is-right is-hoverable" onclick="event.stopPropagation();">
                                <div class="dropdown-trigger">
                                    <button class="button is-white is-small">
                                        <span class="icon is-small"><i class="fas fa-ellipsis-v"></i></span>
                                    </button>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-content">
                                        <a href="<?= base_url('institution/balik_scientist/edit/' . esc($scientist['id'])) ?>"
                                            class="dropdown-item">Edit</a>
                                        <a href="#" class="dropdown-item has-text-danger"
                                            onclick="confirmDelete(<?= esc($scientist['id']) ?>);">Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="flip-inner">
                                <!-- Front -->
                                <div class="card-front">
                                    <div class="card-image">
                                        <img src="<?= !empty($scientist['image']) ? base_url($scientist['image']) : '/images/profile.png' ?>"
                                            alt="Scientist Image">
                                    </div>
                                    <div class="card-title">
                                        <?= esc($scientist['honorifics']) . ' ' . esc($scientist['first_name']) . ' ' . esc($scientist['middle_name']) . ' ' . esc($scientist['last_name']) ?>
                                    </div>
                                </div>

                                <!-- Back -->
                                <div class="card-back">
                                    <p><strong>Role:</strong> <?= esc($scientist['role']) ?></p>
                                    <p><strong>Institution:</strong> <?= esc($scientist['institution_name']) ?></p>
                                    <p><strong>Description:</strong> <?= esc($scientist['description']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this scientist?")) {
            window.location.href = "<?= base_url('institution/balik_scientist/delete/') ?>" + id;
        }
    }
</script>

<?= $this->endSection() ?>