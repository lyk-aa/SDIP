<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .modal-card-head,
    .modal-card-foot {
        background-color: #f0f0f0;
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        padding: 0.75rem 1rem;
    }

    .modal-close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: #888;
    }

    .modal-close-btn:hover {
        color: #000000;
    }

    .modal-card-title {
        font-weight: 600;
        text-align: center;
        font-size: 1.25rem;
        color: #363636;
        margin-bottom: 20px;
    }

    .modal-card-body {
        padding: 1.5rem;
        background-color: #fff;
        overflow: visible !important;
        position: relative;
    }

    .modal-card {
        max-height: 90vh;
        overflow: visible;
    }

    .ts-dropdown {
        z-index: 1000 !important;
        position: absolute !important;
    }

    .title {
        color: #363636;
        margin-bottom: 0.75rem;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .label {
        color: #555;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .input,
    .select select {
        border-radius: 4px;
        border: 1px solid #ccc;
        padding: 0.5rem;
        width: 100%;
        transition: border-color 0.2s;
        box-shadow: none;
    }

    .input:focus,
    .select select:focus {
        border-color: #3273dc;
        box-shadow: 0 0 0 2px rgba(50, 115, 220, 0.2);
    }

    .button.is-success {
        background-color: #48c774;
        color: #fff;
    }

    .button.is-success:hover {
        background-color: #3dbb63;
    }

    .field.has-addons .control .button {
        border-radius: 0 4px 4px 0;
        padding: 0.5rem 0.75rem;
    }

    .field.has-addons .control.is-expanded .input {
        border-radius: 4px 0 0 4px;
    }

    .has-text-right {
        text-align: right;
    }

    .columns.is-multiline .column {
        padding: 0.5rem;
    }

    .modal-background {
        background-color: rgba(0, 0, 0, 0.4);
    }

    .delete {
        color: #888;
        transition: color 0.2s;
    }

    .delete:hover {
        color: #ff3860;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }
</style>

<body>
    <!-- Main Modal for Add Research Center -->
    <div class="modal is-active" id="main-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section class="modal-card-body">
                <p class="modal-card-title">Add Research Centers</p>

                <button class="modal-close-btn" id="close-modal" aria-label="close">
                    <i class="fas fa-times"></i>
                </button>

                <form id="projects-form" action="<?= site_url('institution/research_centers/store') ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Institution</label>
                                <div class="control">
                                    <!-- Tom Select on the Institution Dropdown -->
                                    <div class="select is-fullwidth">
                                        <select id="institution-select" name="institution" required>
                                            <option value="">Select Institution</option>
                                            <?php if (!empty($institutions)): ?>
                                                <?php foreach ($institutions as $institution): ?>
                                                    <?php if (isset($institution->name)): ?>
                                                        <option value="<?= $institution->id ?>"><?= htmlspecialchars($institution->name) ?></option>
                                                    <?php else: ?>
                                                        <option value="">No Name Available</option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No Institutions Found</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Consortium Name</label>
                                <div class="control">
                                    <input type="text" name="name" class="input" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="has-text-right">
                        <button type="submit" class="button is-success" id="submit-button">Save</button>
                    </section>
                </form>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new TomSelect("#institution-select", {
                create: false, // No "Add ..." option
                maxItems: 1,   // Single selection only
                selectOnTab: true,
                placeholder: "Select Institution",
                onType: function (str) {
                    // Optional: remove selection when typing starts
                    this.clear(true);
                }
            });

            document.getElementById("close-modal").addEventListener("click", function () {
                window.location.href = "<?= base_url('institution/research_centers/index') ?>";
            });
        });
    </script>
</body>

<?= $this->endSection() ?>
