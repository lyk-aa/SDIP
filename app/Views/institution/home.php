<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        position: relative;
    }

    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .image-upload {
        position: relative;
        cursor: pointer;
    }

    .image-upload input[type="file"] {
        display: none;
    }

    .image-upload-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        border: 2px dashed #ccc;
        height: 250px;
        position: relative;
    }

    .plus-icon {
        position: absolute;
        color: #aaa;
        font-size: 3rem;
        pointer-events: none;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        /* Modal Styling */
        .modal-card {
            width: 500px;
            max-width: 90%;
            border-radius: 12px;
            overflow: hidden;
        }

        .modal-card-head {
            background-color: #3273dc;
            color: white;
            padding: 1rem;
            font-weight: bold;
        }

        .modal-card-title {
            font-size: 1.25rem;
        }

        .delete {
            background: none;
            border: none;
            color: white;
        }

        .modal-card-body {
            padding: 1.5rem;
        }

        /* Form Fields */
        .field {
            margin-bottom: 1rem;
        }

        .label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .select select,
        .input,
        .textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* File Upload Styling */
        .file-upload {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #fafafa;
        }

        .file-upload:hover {
            border-color: #3273dc;
            background-color: #f0f7ff;
        }

        .file-upload i {
            font-size: 2rem;
            color: #3273dc;
            margin-right: 10px;
        }

        /* Modal Footer */
        .modal-card-foot {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background-color: #f5f5f5;
        }

        .button {
            border-radius: 6px;
            padding: 10px 15px;
        }

        .button.is-success {
            background-color: #48c78e;
            color: white;
        }

        .button.is-success:hover {
            background-color: #36a375;
        }

        .button.is-cancel {
            background-color: #e0e0e0;
            color: #333;
        }
    }
</style>

<div class="container">
    <div class="field is-flex is-align-items-center is-justify-content-space-between" style="width: 100%;">
        <button class="button is-primary" onclick="openCreateModal()">Create New</button>
        <div class="control">
            <div class="select" style="width: 200px;">
                <select id="categoryDropdown" onchange="navigateToCategory()">
                    <option value="<?= base_url('institution/home') ?>">All</option>
                    <option value="<?= base_url('institution/research_centers') ?>">Research, Development and Innovation
                        Centers</option>
                    <option value="<?= base_url('institution/consortium') ?>">Consortium Membership</option>
                    <option value="<?= base_url('institution/projects') ?>">R&D Projects</option>
                    <option value="<?= base_url('institution/balik_scientist') ?>">Balik Scientists</option>
                    <option value="<?= base_url('institution/ncrp_members') ?>">NCRP Members</option>
                </select>
            </div>
        </div>
    </div>

    <div class="columns is-multiline" id="card-container">
        <div class="column is-one-fifth-desktop is-half-tablet is-full-mobile">
            <div class="card">
                <div class="card-image">
                    <label class="image-upload">
                        <input type="file" accept="image/*" onchange="previewImage(event, this)">
                        <figure class="image is-4by3 image-upload-placeholder">
                            <span class="plus-icon"><i class="fas fa-plus"></i></span>
                            <img src="<?= base_url('images/institution.png') ?>" class="preview-image">
                        </figure>
                    </label>
                </div>
                <a href="<?= base_url('institution/details') ?>" class="card-content">
                    <p class="title is-5">Lorem Ipsum</p>
                    <p class="subtitle is-6">Description goes here.</p>
                </a>
                <div class="dropdown is-right kebab-menu">
                    <button class="button is-white is-small" onclick="toggleDropdown(event)">
                        <span class="icon"><i class="fas fa-ellipsis-v"></i></span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            <a href="#" class="dropdown-item" onclick="openEditModal(this); return false;">Edit</a>
                            <a href="#" class="dropdown-item has-text-danger"
                                onclick="deleteCard(this); return false;">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="create-modal">
    <div class="modal-background" onclick="closeCreateModal()"></div>
    <div class="modal-card">
        <form action="<?= base_url('/institution/home/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <header class="modal-card-head">
                <p class="modal-card-title">Add New</p>
                <button class="delete" aria-label="close" type="button" onclick="closeCreateModal()"></button>
            </header>

            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Select Institution</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="title" required>
                                <option value="">Select an Institution</option>
                                <?php foreach ($stakeholders as $stakeholder): ?>
                                    <?php if ($stakeholder['category'] === 'Academe'): ?>
                                        <option value="<?= $stakeholder['id'] ?>"><?= esc($stakeholder['name']) ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Upload Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <div class="field">
                    <label class="label">Description</label>
                    <textarea class="textarea" name="description" required></textarea>
                </div>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-success" type="submit">Save</button>
                <button class="button" type="button" onclick="closeCreateModal()">Cancel</button>
            </footer>
        </form>
    </div>
</div>



<script>
    function openCreateModal() {
        document.getElementById('create-modal').classList.add('is-active');
    }

    function closeCreateModal() {
        document.getElementById('create-modal').classList.remove('is-active');
    }

    function createNewCard() {
        let title = document.getElementById('create-title').value;
        let description = document.getElementById('create-description').value;
        let container = document.getElementById('card-container');

        let column = document.createElement('div');
        column.className = 'column is-one-fifth-desktop is-half-tablet is-full-mobile';
        column.innerHTML = `
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="<?= base_url('images/institution.png') ?>">
                    </figure>
                </div>
                <div class="card-content">
                    <p class="title is-5">${title}</p>
                    <p class="subtitle is-6">${description}</p>
                </div>
            </div>
        `;
        container.appendChild(column);
        closeCreateModal();
    }

    function navigateToCategory() {
        let dropdown = document.getElementById('categoryDropdown');
        let selectedUrl = dropdown.value;
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    }
</script>

<?= $this->endSection() ?>