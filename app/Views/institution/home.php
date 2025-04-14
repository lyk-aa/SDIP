<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        background: white;
        width: 380px;
        height: 420px;
        margin: auto;
        display: flex;
        flex-direction: column;
    }

    .card-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .card img.preview-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .card:hover img.preview-image {
        transform: scale(1.05);
    }

    .card-content {
        padding: 15px;
        text-align: left;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 120px;

    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 8px;
        line-height: 1.2;
        min-height: 40px;
        /* Ensures titles always occupy space */
        display: flex;
        align-items: center;
        /* Aligns text properly */
    }

    .card-description {
        font-size: 1rem;
        ` color: #555;
        margin-top: 4px;
        line-height: 1.5;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        max-height: 4.5em;
        min-height: 70px;
    }

    /* Kebab Menu Fix */
    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .button.is-white {
        background: none;
        border: none;
        box-shadow: none;
    }

    .button.is-white:hover {
        background: rgba(0, 0, 0, 0.05);
    }


    /* Modal Customizations */
    .modal-card {
        border-radius: 8px;
    }

    .modal-image-preview {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .modal-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }

    #file-input {
        margin-top: 0;
        padding-top: 0;
    }

    .institution-link{
        color: black;
    }

    .institution-link:hover{
        color: blue;
    }
</style>

<body>
    <!-- Flex container to align elements properly -->
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
                    <option value="<?= base_url('institution/nrcp_members/index') ?>">NCRP Members</option>
                </select>
            </div>
        </div>

        <!-- Download Button -->
        <button id="downloadButton" class="button is-light is-small" style="height: 36px; display: flex; align-items: center;">
    <span class="icon">
        <i class="fas fa-download"></i>
    </span>
</button>


    </div>
    <h1 class="title has-text-centered">Institutions</h1>

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
                            <a href="<?= base_url('institution/edit/' . $institution['id']) ?>" class="dropdown-item">✏️
                                Edit</a>
                            <a href="<?= base_url('institution/delete/' . $institution['id']) ?>"  class="dropdown-item has-text-danger" onclick="confirmDelete(this)">🗑️
                                Delete</a>
                        </div>
                    </div>
                </div>

                <!-- Institution Details -->
                <div class="card-content">
                    <p class="card-title">
                        <a href="<?= base_url(relativePath: 'institution/view/' . $institution['id']) ?>" class="institution-link">
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
    </section>


    <!-- JavaScript -->
    <script>

        function navigateToCategory() {
            let dropdown = document.getElementById('categoryDropdown');
            let selectedUrl = dropdown.value;
            if (selectedUrl) {
                window.location.href = selectedUrl;
            }
        }
        let currentEditingCard = null;

        function redirectToDetails(event, url) {
            window.location.href = url;
        }


        // Delete card
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
        // Kebab menu toggle
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.dropdown-trigger button').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const dropdown = this.closest('.dropdown');
                    dropdown.classList.toggle('is-active');
                });
            });

            // Prevent the dropdown from closing when clicking inside
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('is-active'));
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('downloadButton').addEventListener('click', generatePDF);
});

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('downloadButton').addEventListener('click', generatePDF);
});

function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    let y = 10;

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(16);
    doc.text('Institutions Directory', 105, y, { align: 'center' });
    y += 10;
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');

    document.querySelectorAll('.card').forEach((card, index) => {
        if (y > 270) {
            doc.addPage();
            y = 10;
        }

        let name = card.querySelector('.card-title a')?.textContent || 'No Name';
        let address = card.querySelector('.card-description')?.textContent || 'No Address';
        
        doc.setFont('helvetica', 'bold');
        doc.text(`${index + 1}. ${name}`, 10, y);
        y += 7;
        doc.setFont('helvetica', 'normal');
        doc.text(address, 15, y, { maxWidth: 180 });
        y += 10;
    });
    
    doc.save('institutions_directory.pdf');
}

// Ensure jsPDF is available
if (typeof window.jspdf === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
    script.onload = () => console.log('jsPDF loaded');
    document.head.appendChild(script);
}


    </script>

</body>



<?= $this->endSection() ?>