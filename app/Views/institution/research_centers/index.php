<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    h2 {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 10px;
    }

    .carousel {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 90%;
        max-width: 900px;
        overflow: hidden;
        position: relative;
        margin: 0 auto;
    }

    .carousel-container {
        display: flex;
        scroll-behavior: smooth;
        width: 100%;
        padding: 60px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        scroll-snap-type: x mandatory;
    }

    .carousel-item {
        min-width: 180px;
        max-width: 200px;
        margin: 5px;
        transition: transform 0.4s ease-in-out;
        position: relative;
        background: white;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        scroll-snap-align: start;
    }

    .prev,
    .next {
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        font-size: 20px;
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        padding: 8px;
        border-radius: 8px;
    }

    .prev:hover,
    .next:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    .dropdown {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background: white;
        box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.1);
        padding: 3px;
        border-radius: 3px;
        right: 0;
        z-index: 10;
        width: 70px;
    }

    .dropdown-item {
        font-size: 11px;
        padding: 2px 4px;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .dropdown-divider {
        margin: 2px 0;
    }

    .dropdown.active .dropdown-menu {
        display: block;
    }

    /* Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        background: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 100;
        text-align: center;
        padding: 15px;
    }

    .custom-modal-active {
        display: block;
    }

    .custom-modal-content {
        padding: 10px;
    }

    .custom-modal-text {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 12px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-top: 10px;
    }

    .custom-modal-btn {
        flex: 1;
        padding: 6px 12px;
        font-size: 13px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .confirm-btn {
        background-color: #4CAF50;
        color: white;
    }

    .cancel-btn {
        background-color: #f44336;
        color: white;
    }
</style>



<body>
    <div class="field is-flex is-align-items-center is-justify-content-flex-end" style="width: 100%; gap: 10px;">
        <div class="control">
            <a href="<?= base_url('institution/consortium/create') ?>" class="button is-primary">
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

    <h2>DOST VI Consortium</h2>

    <!-- Table Section -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Institution</th>
                    <th class="has-text-centered">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consortiums)): ?>
                    <?php foreach ($consortiums as $consortium): ?>
                        <tr>
                            <td><?= esc($consortium->consortium_name ?? 'N/A') ?></td> <!-- Now works correctly -->
                            <td><?= esc($consortium->institution_name ?? '') ?></td>
                            <td class="has-text-centered">
                                <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                    <a href="<?= site_url('/directory/consortiums/edit/' . $consortium->consortium_id) ?>"
                                        class="button is-info is-small"
                                        style="margin-left: 8px; min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                        <span>Edit</span>
                                    </a>
                                    <a href="<?= site_url('consortiums/delete/' . $consortium->consortium_id); ?>"
                                        class="button is-danger is-small"
                                        style="min-width: 120px; display: flex; justify-content: center; align-items: center;"
                                        onclick="return confirm('Are you sure you want to delete this regional office?');">
                                        <span class="icon"><i class="fas fa-trash"></i></span>
                                        <span>Delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="has-text-centered has-text-grey-light">
                            No regional offices found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>



<script>
    function scrollCarousel(direction) {
        const container = document.getElementById("carouselContainer");
        const scrollAmount = 280;
        container.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
    }

    function toggleDropdown(event, button) {
        event.stopPropagation();
        closeAllDropdowns();
        button.parentElement.classList.toggle("active");
    }

    function closeAllDropdowns() {
        document.querySelectorAll(".dropdown").forEach(d => d.classList.remove("active"));
    }

    document.addEventListener("click", closeAllDropdowns);

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this scientist?")) {
            window.location.href = "<?= base_url('institution/consortium/delete/') ?>" + id;
        }
    }
</script>

<?= $this->endSection() ?>