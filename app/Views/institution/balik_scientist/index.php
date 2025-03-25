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


<!-- Flex container to align elements to the right -->
<div class="field is-flex is-align-items-center is-justify-content-flex-end" style="width: 100%;">

    <!-- Dropdown -->
    <div class="control">
        <div class="select is-smaller" style="width: 200px;">
            <select id="categoryDropdown" onchange="navigateToCategory()">
                <option value="<?= base_url('institution/home') ?>">All</option>
                <option value="<?= base_url('/institution/research_centers') ?>">Research,
                    Development
                    and Innovation Centers</option>
                <option value="<?= base_url('/institution/consortium') ?>">Consortium Membership
                </option>
                <option value="<?= base_url('/institution/projects') ?>">R&D Projects</option>
                <option value="<?= base_url('/institution/balik_scientist') ?>">Balik Scientists
                </option>
                <option value="<?= base_url('/institution/ncrp_members') ?>">NCRP Members</option>
            </select>
        </div>
    </div>

    <!-- Download Button -->
    <div class="control">
        <button class="button is-light is-small" style="">
            <span class="icon">
                <i class="fas fa-download"></i>
            </span>
        </button>
    </div>

</div>

<h2>DOST VI Balik Scientist</h2>

<div class="carousel">
    <button class="prev" onclick="scrollCarousel(-1)">&#10094;</button>
    <div class="carousel-container" id="carouselContainer"></div>
    <button class="next" onclick="scrollCarousel(1)">&#10095;</button>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <p id="confirmText" class="custom-modal-text"></p>
        <div class="custom-modal-footer">
            <button id="confirmYes" class="custom-modal-btn confirm-btn">Yes</button>
            <button onclick="closeModal()" class="custom-modal-btn cancel-btn">No</button>
        </div>
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
    const scientists = [
        { name: "Dr. Juan Dela Cruz", desc: "Expert in AI Research", image: "/images/profile.png" },
        { name: "Dr. Maria Santos", desc: "Pioneer in Nanotechnology", image: "/images/profile.png" },
        { name: "Dr. Jose Rizal", desc: "Medical Innovations Specialist", image: "/images/profile.png" },
        { name: "Dr. Ana Mendoza", desc: "Biotechnology Enthusiast", image: "/images/profile.png" },
        { name: "Dr. Who Ever", desc: "Technology Guru", image: "/images/profile.png" }
    ];

    const container = document.getElementById("carouselContainer");

    function renderCarousel() {
        container.innerHTML = "";
        scientists.forEach((scientist, index) => {
            let card = document.createElement("div");
            card.className = "carousel-item";
            card.innerHTML = `
                <img src="${scientist.image}" alt="${scientist.name}" width="100%">
                <h3 style="font-size: 14px; margin-top: 6px;">${scientist.name}</h3>
                <p style="font-size: 12px; margin-top: 4px;">${scientist.desc}</p>
                <div class="dropdown">
                    <button onclick="toggleDropdown(event, this)">⋮</button>
                    <div class="dropdown-menu">
                        <div class="dropdown-content">
                            <a href="<?= base_url('institution/balik_scientist/edit') ?>" class="dropdown-item has-text-link">
                                ✏️ Edit
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item has-text-danger" onclick="confirmDelete(${index})">
                                🗑️ Delete
                            </a>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    renderCarousel();

    function scrollCarousel(direction) {
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

    function confirmDelete(index) {
        let modal = document.getElementById("confirmModal");
        modal.classList.add("custom-modal-active");

        document.getElementById("confirmText").innerText = "Are you sure you want to delete?";

        document.getElementById("confirmYes").onclick = function () {
            scientists.splice(index, 1);
            closeModal();
            renderCarousel();
        };
    }

    function closeModal() {
        document.querySelectorAll(".custom-modal").forEach(m => m.classList.remove("custom-modal-active"));
    }
</script>

<?= $this->endSection() ?>