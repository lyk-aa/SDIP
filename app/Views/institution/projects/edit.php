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
    }

    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        cursor: pointer;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
        margin-bottom: 1rem;
        position: relative;
        background-color: #f0f0f0;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .edit-button {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        padding: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .edit-button:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .hidden-input {
        display: none;
    }

    .profile-text {
        position: absolute;
        color: rgba(54, 54, 54, 0.6);
        font-size: 0.75rem;
        font-weight: bold;
        text-align: center;
    }

    #profile-preview.hidden {
        display: none;
    }

    .title {
        color: #363636;
        margin-bottom: 0.75rem;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .title.is-5 {
        font-weight: 700;
        font-size: 1.25rem;
        color: #363636;
        margin-bottom: 0.5rem;


        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #363636;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.3rem;
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

    .button {
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    .button.is-success {
        background-color: #48c774;
        color: #fff;
    }

    .button.is-success:hover {
        background-color: #3dbb63;
    }

    .button.is-primary {
        background-color: #3273dc;
        color: #fff;
    }

    .button.is-primary:hover {
        background-color: #2759bd;
    }

    .button.is-success,
    .button.is-primary {
        box-shadow: none;
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

    #contact-info .field {
        margin-bottom: 1rem;
    }

    .select-input-container {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .select-input-container input {
        flex: 1;
        padding-right: 2rem;
    }

    .select-overlay {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        cursor: pointer;
        width: 2rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ts-control {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
    }

    .ts-control .item {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        margin-right: 5px;
    }

    .ts-control input {
        flex: 1 1 auto;
        min-width: 0;
    }
</style>

<body>
    <div class="modal is-active" id="main-modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section class="modal-card-body">
                <p class="modal-card-title">Edit Research Project</p>

                <button class="modal-close-btn" id="close-modal" aria-label="close">
                    <i class="fas fa-times"></i>
                </button>

                <form id="projects-form"
                    action="<?= site_url('institution/projects/update/' . $project['project_id']) ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="columns">
                        <!-- Sector -->
                        <div class="column">
                            <div class="field">
                                <label class="label">Sector</label>
                                <div class="control">
                                    <div class="select-input-container">
                                        <input type="text" id="sector" name="sector" class="input"
                                            value="<?= old('sector', $project['sector'] ?? '') ?>"
                                            placeholder="Or enter manually" list="sector-list">
                                        <select class="select-overlay">
                                            <option value=""></option>
                                            <option value="Health Research and Development">Health Research and
                                                Development</option>
                                            <option value="Industry, Energy, and Emerging Technologies">Industry,
                                                Energy, and Emerging Technologies</option>
                                            <option value="Agriculture, Aquatic, and Natural Resources">Agriculture,
                                                Aquatic, and Natural Resources</option>
                                            <option value="Disaster Risk Reduction and Climate Change Adaptation">
                                                Disaster Risk Reduction and Climate Change Adaptation</option>
                                            <option value="Space Technology Applications">Space Technology Applications
                                            </option>
                                            <option value="Environment and Natural Resources">Environment and Natural
                                                Resources</option>
                                            <option value="Food Safety and Nutrition">Food Safety and Nutrition</option>
                                            <option value="Basic Research">Basic Research</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Institution -->
                        <div class="column is-one-third">
                            <div class="field">
                                <label class="label">Institution</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select id="institution-select" name="institution" required>
                                            <option value="">Select Institution</option>
                                            <?php foreach ($institutions as $institution): ?>
                                                <option value="<?= $institution->id ?>"
                                                    <?= ($institution->id == $project['institution_id']) ? 'selected' : '' ?>>
                                                    <?= $institution->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="column">
                            <div class="field">
                                <label class="label">Status</label>
                                <div class="control">
                                    <div class="select-input-container">
                                        <input type="text" id="current_status" name="status" class="input"
                                            value="<?= old('status', $project['status'] ?? '') ?>"
                                            placeholder="Or enter manually">
                                        <select class="select-overlay"
                                            onchange="document.getElementById('current_status').value=this.value">
                                            <option value=""></option>
                                            <option value="Completed" <?= ($project['status'] == 'Completed') ? 'selected' : '' ?>>Completed</option>
                                            <option value="Ongoing" <?= ($project['status'] == 'Ongoing') ? 'selected' : '' ?>>Ongoing</option>
                                            <option value="Pending" <?= ($project['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">


                        <!-- Duration -->
                        <div class="column">
                            <div class="field">
                                <label class="label">Duration</label>
                                <div class="control">
                                    <input type="text" name="duration" class="input"
                                        value="<?= old('duration', $project['duration'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Project Leader -->
                        <div class="column">
                            <div class="field">
                                <label class="label">Project Leader</label>
                                <div class="control">
                                    <input type="text" name="project_leader" class="input"
                                        value="<?= old('project_leader', $project['project_leader'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Approved Amount -->
                        <div class="column">
                            <div class="field">
                                <label class="label">Approved Amount</label>
                                <div class="control">
                                    <input type="text" name="approved_amount" class="input"
                                        value="<?= old('approved_amount', $project['approved_amount'] ?? '') ?>"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Title -->
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Research Title</label>
                                <div class="control">
                                    <input type="text" name="research_name" class="input"
                                        value="<?= old('name', $project['research_name'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="columns">
                        <div class="column is-full">
                            <div class="field">
                                <label class="label">Description</label>
                                <div class="control">
                                    <textarea name="description" class="textarea"
                                        required><?= old('description', $project['description'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Objectives -->
                    <div class="columns">
                        <div class="column is-full">
                            <div class="field">
                                <label class="label">Research Objectives</label>
                                <div class="control">
                                    <textarea name="project_objectives" class="textarea"
                                        required><?= old('project_objectives', $project['project_objectives'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="has-text-right">
                        <button type="submit" class="button is-success" id="submit-button">Update</button>
                    </section>
                </form>

            </section>
        </div>
    </div>
</body>

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

        document.querySelectorAll(".select-input-container").forEach(container => {
            let inputField = container.querySelector("input");
            let selectField = container.querySelector("select");

            selectField.addEventListener("change", function () {
                if (this.value) {
                    inputField.value = this.value;
                    this.selectedIndex = 0;
                }
            });

            inputField.addEventListener("input", function () {
                if (this.value === "") {
                    selectField.selectedIndex = 0;
                }
            });
        });

        document.getElementById("close-modal").addEventListener("click", function () {
            window.location.href = "<?= base_url('institution/projects/index') ?>";
        });
    });
</script>

<?= $this->endSection() ?>