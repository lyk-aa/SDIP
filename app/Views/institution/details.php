<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .dropdown.is-right {
        position: relative;
    }

    .dropdown.is-right .dropdown-menu {
        right: 0;
        left: auto;
        min-width: 220px;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        border: 1px solid #ddd;
        background: white;
    }

    .dropdown-content .dropdown-item {
        padding: 12px 16px;
        font-size: 0.9rem;
        transition: background 0.2s ease-in-out;
    }

    .dropdown-content .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .dropdown-trigger .button,
    .download-button {
        display: flex;
        align-items: center;
        gap: 6px;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.9rem;
        background-color: #f5f5f5;
        transition: all 0.2s ease-in-out;
    }

    .dropdown-trigger .button:hover,
    .download-button:hover {
        background-color: #e8e8e8;
    }

    .file-placeholder {
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background: #f9f9f9;
    }

    .empty-file-icon {
        color: #bbb;
    }
</style>

<body>
    <section class="section">
        <div class="container">

            <div class="columns is-vcentered is-mobile mb-5">
                <div class="column is-narrow">
                    <h1 class="title is-5 has-text-weight-bold">West Visayas State University</h1>
                </div>

                <div class="column"></div>
                <div class="field mr-4">
                    <div class="control">
                        <div class="select is-smaller" style="width: 200px; padding: 6px;">
                            <select id="categoryDropdown" onchange="navigateToCategory()">
                                <option value="<?= base_url('institution/home') ?>">All</option>
                                <option value="<?= base_url('institution/research_centers/index') ?>">Research,
                                    Development
                                    and Innovation Centers</option>
                                <option value="<?= base_url('institution/consortium/index') ?>">Consortium Membership
                                </option>
                                <option value="<?= base_url('institution/projects/index') ?>">R&D Projects</option>
                                <option value="<?= base_url('institution/balik_scientist/index') ?>">Balik Scientists
                                </option>
                                <option value="<?= base_url('institution/ncrp_members/index') ?>">NCRP Members</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control">

                    <button class="button is-light is-small">
                        <span class="icon">
                            <i class="fas fa-download"></i>
                        </span>
                    </button>
                </div>
            </div>


            <div class="box file-placeholder">
                <div class="empty-file-icon">
                    <i class="fas fa-file fa-4x"></i>
                </div>
                <p class="mt-3 has-text-grey">No document uploaded</p>
            </div>

        </div>
    </section>
</body>

<script>
    function navigateToCategory() {
        let dropdown = document.getElementById('categoryDropdown');
        let selectedUrl = dropdown.value;
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    }
</script>

<?= $this->endSection() ?>