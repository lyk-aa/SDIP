<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    /* Uniform Dropdown Styling */
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

    /* Improve dropdown items */
    .dropdown-content .dropdown-item {
        padding: 12px 16px;
        font-size: 0.9rem;
        transition: background 0.2s ease-in-out;
    }

    .dropdown-content .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    /* Button Styles */
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

    /* Institution Info */
    .institution-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-bottom: 2px solid #ddd;
    }

    .institution-info .media {
        display: flex;
        align-items: center;
    }

    .institution-info .image {
        margin-right: 15px;
    }

    .institution-info .title {
        margin: 0;
    }

    /* Dropdown and Buttons */
    .field {
        margin-left: 15px;
        margin-right: 15px;
    }

    .select,
    .button {
        margin-top: 10px;
    }

    /* Section Styling */
    .section-content {
        display: none;
        margin-top: 20px;
    }

    /* Tables */
    table {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .table thead {
        background-color: #f9f9f9;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
    }

    /* Column widths */
    .wide-column {
        width: 25%;
    }

    .narrow-column {
        width: 15%;
    }

    /* Responsiveness */
    @media (max-width: 768px) {

        .wide-column,
        .narrow-column {
            width: 100%;
        }

        .institution-info {
            flex-direction: column;
            text-align: center;
        }

        .field {
            width: 100%;
            margin-top: 10px;
        }
    }
</style>


<body>
    <section class="section">
        <div class="container">
            <div class="box">
                <!-- Institution Info -->
                <div class="institution-info">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-64x64">
                                <img src="<?= !empty($institution['image']) ? base_url($institution['image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                                    alt="Institution Image" class="preview-image">
                            </figure>
                        </div>
                    </div>
                    <div class="media-content">
                        <h1 class="title is-5 has-text-weight-bold"><?= esc($institution['name']) ?></h1>
                    </div>

                    <!-- Dropdown & Button -->
                    <div class="field">
                        <div class="control">
                            <div class="select is-smaller" style="width: 200px;">
                                <select id="categoryDropdown" onchange="navigateToCategory()">
                                    <option value="all">All</option>
                                    <option value="research_centers">Research, Development and Innovation Centers
                                    </option>
                                    <option value="consortium">Consortium Membership</option>
                                    <option value="projects">Research Projects</option>
                                    <option value="balik_scientist">Balik Scientists</option>
                                    <option value="ncrp_members">NCRP Members</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Download Button -->
                    <div class="control">
                        <button class="button is-light is-small" onclick="printForm('<?= site_url('institution/view/print') ?>')">
                            <span class="icon">
                                <i class="fas fa-download"></i>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Institution Details -->
                <div class="card-content">
                    <div class="content">
                        <div id="details">
                            <h3 class="title is-5">Institution Details</h3>
                            <div class="columns">
                                <!-- Left Column -->
                                <div class="column is-6">
                                    <p><strong>Type:</strong> <?= esc($institution['type']) ?></p>
                                    <p><strong>Person Name:</strong> <?= esc($institution['person_name']) ?></p>
                                    <p><strong>Designation:</strong> <?= esc($institution['designation']) ?></p>
                                </div>
                                <!-- Right Column -->
                                <div class="column is-6">
                                    <p><strong>Address:</strong> <?= esc($institution['street']) ?>,
                                        <?= esc($institution['barangay']) ?>,
                                        <?= esc($institution['municipality']) ?>,
                                        <?= esc($institution['province']) ?>, <?= esc($institution['country']) ?>
                                    </p>
                                    <p><strong>Telephone:</strong> <?= esc($institution['telephone_num']) ?></p>
                                    <p><strong>Email:</strong> <?= esc($institution['email_address']) ?></p>
                                </div>
                            </div>
                        </div>


                        <!-- Consortium Section -->
                        <div id="consortium" class="section-content">
                            <?php if (!empty($consortium['consortium_name'])): ?>
                                <h3 class="title is-5">Consortium</h3>
                                <ul>
                                    <?= esc($consortium['consortium_name']) ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- NRCP Members Section -->
                        <div id="ncrp_members" class="section-content">
                            <?php if (!empty($nrcp_members)): ?>
                                <h3 class="title is-5">NRCP Members</h3>
                                <ul>
                                    <?php foreach ($nrcp_members as $member): ?>
                                        <?= esc($member['honorifics'] . ' ' . $member['first_name'] . ' ' . $member['middle_name'] . ' ' . $member['last_name']) ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Balik Scientist Engaged Section -->
                        <div id="balik_scientist" class="section-content">
                            <?php if (!empty($balik_scientists)): ?>
                                <h3 class="title is-5">Balik Scientist Engaged</h3>
                                <ul>
                                    <?php foreach ($balik_scientists as $scientist): ?>
                                        <?= esc($scientist['honorifics'] . ' ' . $scientist['first_name'] . ' ' . $scientist['middle_name'] . ' ' . $scientist['last_name']) ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Research Projects Section -->
                        <div id="projects" class="section-content">
                            <h3 class="title is-5">Ongoing Research Projects</h3>
                            <table class="table is-striped is-hoverable is-fullwidth">
                                <thead>
                                    <tr>
                                        <th class="narrow-column">Sector</th>
                                        <th class="wide-column">Title</th>
                                        <th class="wide-column">Research Objectives</th>
                                        <th class="narrow-column">Duration</th>
                                        <th class="narrow-column">Project Leader</th>
                                        <th class="narrow-column">Approved Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ongoing_research_projects)): ?>
                                        <?php foreach ($ongoing_research_projects as $project): ?>
                                            <tr>
                                                <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['research_project_name'] ?? 'N/A') ?></td>
                                                <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                                                <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="has-text-centered has-text-grey-light">
                                                No ongoing projects
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div id="completed_projects" class="section-content">
                            <h3 class="title is-5">Completed Research Projects</h3>
                            <table class="table is-striped is-hoverable is-fullwidth">
                                <thead>
                                    <tr>
                                        <th class="narrow-column">Sector</th>
                                        <th class="wide-column">Title</th>
                                        <th class="wide-column">Research Objectives</th>
                                        <th class="narrow-column">Duration</th>
                                        <th class="narrow-column">Project Leader</th>
                                        <th class="narrow-column">Approved Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($completed_research_projects)): ?>
                                        <?php foreach ($completed_research_projects as $project): ?>
                                            <tr>
                                                <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['research_project_name'] ?? 'N/A') ?></td>
                                                <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                                                <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                                                <td><?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="has-text-centered has-text-grey-light">
                                                No completed projects
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</body>

<script>
    function navigateToCategory() {
        let dropdown = document.getElementById('categoryDropdown');
        let selectedValue = dropdown.value;

        // Hide all sections
        document.querySelectorAll('.section-content').forEach(function (section) {
            section.style.display = 'none';
        });

        // Hide institution details (id="details") when a category other than "all" is selected
        let institutionDetails = document.getElementById('details');
        if (selectedValue === 'all') {
            institutionDetails.style.display = 'block';
        } else {
            institutionDetails.style.display = 'none';
        }

        // Show the selected section
        if (selectedValue === 'all') {
            document.querySelectorAll('.section-content').forEach(function (section) {
                section.style.display = 'block';
            });
        } else if (selectedValue === 'projects') {
            // Show both ongoing and completed projects sections
            document.getElementById('projects').style.display = 'block';
            document.getElementById('completed_projects').style.display = 'block';
        } else {
            let section = document.getElementById(selectedValue);
            if (section) {
                section.style.display = 'block';
            }
        }
    }

    // Get URL Parameters
    const params = new URLSearchParams(window.location.search);
    const name = params.get('name');
    const image = params.get('image');
    const file = params.get('file');

    // Update Page Content
    document.getElementById("institutionName").value = name || "";
    document.getElementById("institutionImage").src = image || "/images/institution.png";
    document.getElementById("downloadFile").href = file || "#";

    // Handle File Upload
    document.getElementById("fileInput").addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById("uploadedFileName").textContent = file.name;
            document.getElementById("downloadFile").href = URL.createObjectURL(file);
            document.getElementById("downloadFile").download = file.name;
        }
    });

    // Handle File Print
    function printForm(url) {
        const printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');

        printWindow.addEventListener('load', () => {
            if (Boolean(printWindow.chrome)) {
                printWindow.print();
                setTimeout(function(){
                    printWindow.close();
                }, 500);
            } else {
                printWindow.print();
                printWindow.close();
            }
        }, true);
    }
    // Initialize the page by showing all sections initially
    window.onload = navigateToCategory;
</script>

<?= $this->endSection() ?>