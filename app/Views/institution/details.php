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

    .institution-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        border-bottom: 2px solid #ddd;
    }

    .wide-column {
        width: 23%;
        /* Adjust as needed */
    }

    .narrow-column {
        width: 11%;
        /* Adjust as needed */
    }
</style>

<body>
    <section class="section">
        <div class="container">
            <div class="box">
                <h1>Hello World</h1>
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

                    <!-- Spacer -->
                    <div class="column"></div>
                    <!-- Dropdown -->
                    <div class="field mr-4">
                        <div class="control">
                            <div class="select is-smaller" style="width: 200px; padding: 6px;">
                                <select id="categoryDropdown" onchange="navigateToCategory()">
                                    <option value="<?= base_url('institution/home') ?>">All</option>
                                    <option value="<?= base_url('institution/research_centers/index') ?>">Research,
                                        Development
                                        and Innovation Centers</option>
                                    <option value="<?= base_url('institution/consortium/index') ?>">Consortium
                                        Membership</option>
                                    <option value="<?= base_url('institution/projects/index') ?>">R&D Projects</option>
                                    <option value="<?= base_url('institution/balik_scientist/index') ?>">Balik
                                        Scientists</option>
                                    <option value="<?= base_url('institution/ncrp_members/index') ?>">NCRP Members
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Download Button -->
                    <div class="control">
                        <button class="button is-light is-small" onclick="printForm()">
                            <span class="icon">
                                <i class="fas fa-download"></i>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="box mt-4">
                    <h2 class="title is-4 has-text-weight-bold">Institution Details</h2>
                    <div class="card-content">
                        <div class="content">
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

                            <?php if (!empty($consortium['consortium_name'])): ?>
                                <h3 class="title is-5">Consortium</h3>
                                <ul>
                                    <?= esc($consortium['consortium_name']) ?>
                                </ul>
                            <?php endif; ?>


                            <!-- NRCP Members -->
                            <?php if (!empty($nrcp_members)): ?>
                                <h3 class="title is-5">NRCP Members</h3>
                                <ul>
                                    <?php foreach ($nrcp_members as $member): ?>
                                        <?= esc($member['honorifics'] . ' ' . $member['first_name'] . ' ' . $member['middle_name'] . ' ' . $member['last_name']) ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>


                            <!-- Balik Scientist Engaged Members -->
                            <?php if (!empty($balik_scientists)): ?>
                                <h3 class="title is-5">Balik Scientist Engaged</h3>
                                <ul>
                                    <?php foreach ($balik_scientists as $scientist): ?>
                                        <?= esc($scientist['honorifics'] . ' ' . $scientist['first_name'] . ' ' . $scientist['middle_name'] . ' ' . $scientist['last_name']) ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>


                            <!-- Research Projects -->
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
    function printForm() {
        console.log("Print");
    }
</script>

<?= $this->endSection() ?>