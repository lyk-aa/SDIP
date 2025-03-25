<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #f5f5f5;
    }

    .section {
        padding: 40px;
    }

    .custom-box {
        background: white;
        padding: 0px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }

    .completed {
        background-color: #28a745;
        color: white;
    }

    .pending {
        background-color: #ffc107;
        color: white;
    }

    .rejected {
        background-color: #dc3545;
        color: white;
    }
</style>

<body>

    <!-- Top Section: Buttons & Dropdown -->
    <div class="field is-flex is-align-items-center is-justify-content-flex-end" style="width: 100%; gap: 10px;">

        <!-- Create New Button -->
        <div class="control">
            <a href="<?= base_url('institution/create') ?>" class="button is-primary"
                style="height: 36px; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Create New</span>
            </a>
        </div>

        <!-- Dropdown -->
        <div class="control">
            <div class="select is-smaller" style="width: 200px; height: 36px; display: flex; align-items: center;">
                <select id="categoryDropdown" onchange="navigateToCategory()" style="height: 100%;">
                    <option value="<?= base_url('institution/home') ?>">All</option>
                    <option value="<?= base_url('institution/research_centers/index') ?>">Research, Development and
                        Innovation Centers</option>
                    <option value="<?= base_url('institution/consortium/index') ?>">Consortium Membership</option>
                    <option value="<?= base_url('institution/projects/index') ?>">R&D Projects</option>
                    <option value="<?= base_url('institution/balik_scientist/index') ?>">Balik Scientists</option>
                    <option value="<?= base_url('institution/ncrp_members/index') ?>">NCRP Members</option>
                </select>
            </div>
        </div>

        <!-- Download Button -->
        <div class="control">
            <button class="button is-light is-small" style="height: 36px; display: flex; align-items: center;">
                <span class="icon">
                    <i class="fas fa-download"></i>
                </span>
            </button>
        </div>
    </div>

    <!-- Research Projects Section -->
    <div class="box mt-4">
        <h2 class="title is-4">Research Projects</h2>
        <p>Completed/Pending</p>

        <div class="box is-flex is-justify-content-space-between is-align-items-center">
            <div>
                <strong>Research 1</strong>
                <p>Body text for research details.</p>
                <span class="status-badge completed">✓ COMPLETED</span>
            </div>

            <div class="is-flex is-align-items-center">
                <!-- Info Dropdown -->
                <div class="dropdown is-hoverable is-right mr-2">
                    <div class="dropdown-trigger">
                        <button class="button is-white is-small" aria-haspopup="true" aria-controls="dropdown-menu">
                            <span class="icon is-small">
                                <i class="fas fa-info-circle"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            <a class="dropdown-item edit-button">
                                Edit
                            </a>
                            <a class="dropdown-item has-text-danger">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation Button -->
                <a href="target_page.html" class="button is-white is-small">
                    <span class="icon">
                        <i class="fas fa-angle-double-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="box">
            <strong>Research 2</strong>
            <p>Body text for research details.</p>
            <span class="status-badge pending">⏳ PENDING</span>
        </div>

        <div class="box">
            <strong>Research 3</strong>
            <p>Body text for research details.</p>
            <span class="status-badge rejected">✗ REJECTED</span>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="projectModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Project Information</p>
                <button class="delete" aria-label="close" id="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Project Title</label>
                    <input class="input" type="text" placeholder="Lorem ipsum dolor">
                </div>
                <div class="columns">
                    <div class="column">
                        <label class="label">Objectives</label>
                        <input class="input" type="text" placeholder="Lorem ipsum dolor">
                    </div>
                    <div class="column">
                        <label class="label">Duration</label>
                        <input class="input" type="text" placeholder="Lorem ipsum dolor">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <label class="label">Last Name</label>
                        <input class="input" type="text">
                    </div>
                    <div class="column">
                        <label class="label">First Name</label>
                        <input class="input" type="text">
                    </div>
                    <div class="column is-narrow">
                        <label class="label">M.I.</label>
                        <input class="input" type="text" style="width: 50px;">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <label class="label">Email Address</label>
                        <input class="input" type="email" placeholder="Lorem ipsum dolor">
                    </div>
                    <div class="column">
                        <label class="label">Phone Number</label>
                        <input class="input" type="text">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <label class="label">Approved Amount</label>
                        <input class="input" type="text" placeholder="Lorem ipsum dolor">
                    </div>
                    <div class="column">
                        <label class="label">Status</label>
                        <div class="select">
                            <select>
                                <option class="completed">✓ COMPLETED</option>
                                <option class="pending">⏳ PENDING</option>
                                <option class="rejected">✗ REJECTED</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success">CONFIRM</button>
            </footer>
        </div>
    </div>

    <script>
    function navigateToCategory() {
        let dropdown = document.getElementById('categoryDropdown');
        let selectedUrl = dropdown.value;
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    }

    // Function to open the modal
    function openModal() {
        document.getElementById("projectModal").classList.add("is-active");
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("projectModal").classList.remove("is-active");
    }

    // Add event listener to "Create New" button if applicable
    const addProjectBtn = document.getElementById("addProjectBtn");
    if (addProjectBtn) {
        addProjectBtn.addEventListener("click", openModal);
    }

    // Add event listener to close button in modal
    document.getElementById("closeModal").addEventListener("click", closeModal);

    // Ensure all "Edit" buttons trigger the modal
    const editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });
</script>

</body>

<?= $this->endSection() ?>
