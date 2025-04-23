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

    .institution-info {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-bottom: 2px solid #ddd;
        gap: 1rem;
    }

    .institution-info .media {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .institution-info .title {
        margin: 0;
        font-weight: bold;
    }

    .institution-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-content {
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        border-top: 1px solid #ddd;
        padding-top: 20px;
        margin-top: 20px;
    }

    .section-content.show {
        display: block;
        opacity: 1;
    }

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

    .wide-column {
        width: 25%;
    }

    .narrow-column {
        width: 15%;
    }

    .title-column {
        width: 20%;
    }

    .small-column {
        width: 10%;
    }

    .box {
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .column.is-one-fourth {
        transition: transform 0.2s ease;
    }

    p {
        line-height: 1.6;
        color: #4a4a4a;
    }

    @media (max-width: 768px) {
        .institution-info {
            flex-direction: column;
            text-align: center;
        }

        .institution-controls {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
        }

        .wide-column,
        .narrow-column {
            width: 100%;
        }

        .column.is-one-fourth {
            width: 100%;
        }
    }
</style>

<body>
    <section class="section">
        <div class="container">
            <div class="box">
                <div class="institution-info">
                    <div class="media">
                        <figure class="image is-64x64">
                            <img src="<?= !empty($institution['image']) ? base_url($institution['image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                                alt="Institution Image" class="preview-image">
                        </figure>
                        <div>
                            <h1 class="title is-5"><?= esc($institution['name']) ?></h1>
                        </div>
                    </div>

                    <div class="institution-controls">
                        <div class="select is-small">
                            <select id="categoryDropdown" onchange="navigateToCategory()">
                                <option value="all">All</option>
                                <option value="research_centers">Research, Development and Innovation Centers</option>
                                <option value="consortium">Consortium Membership</option>
                                <option value="projects">Research Projects</option>
                                <option value="balik_scientist">Balik Scientists</option>
                                <option value="ncrp_members">NCRP Members</option>
                            </select>
                        </div>

                        <button class="button is-light is-small" onclick="printDetails('<?= site_url('institution/view/print/' . $details_id) ?>')">
                            <span class="icon"><i class="fas fa-download"></i></span>
                            <span>Download</span>
                        </button>
                    </div>
                </div>

                <div class="card-content">
                    <div class="content">
                        <!-- Institution Details -->
                        <div id="details">
                            <h3 class="title is-5"><i class="fas fa-university mr-2"></i> Institution Details</h3>
                            <div class="columns">
                                <div class="column is-6">
                                    <p><strong>Type:</strong> <?= esc($institution['type']) ?></p>
                                    <p><strong>Person Name:</strong> <?= esc($institution['person_name']) ?></p>
                                    <p><strong>Designation:</strong> <?= esc($institution['designation']) ?></p>
                                </div>
                                <div class="column is-6">
                                    <p><strong>Address:</strong> <?= esc($institution['street']) ?>,
                                        <?= esc($institution['barangay']) ?>, <?= esc($institution['municipality']) ?>,
                                        <?= esc($institution['province']) ?>, <?= esc($institution['country']) ?>
                                    </p>
                                    <p><strong>Telephone:</strong> <?= esc($institution['telephone_num']) ?></p>
                                    <p><strong>Email:</strong> <?= esc($institution['email_address']) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Consortium Membership -->
                        <div id="consortium" class="section-content">
                            <?php if (!empty($consortiums)): ?>
                                <h3 class="title is-5"><i class="fas fa-users mr-2"></i> Consortium Membership</h3>
                                <div class="columns is-multiline">
                                    <?php foreach ($consortiums as $consortium): ?>
                                        <div class="column is-one-fourth">
                                            <?= esc($consortium['consortium_name']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <!-- NRCP Members -->
                        <div id="ncrp_members" class="section-content">
                            <?php if (!empty($nrcp_members)): ?>
                                <h3 class="title is-5"><i class="fas fa-address-book mr-2"></i> NRCP Members</h3>
                                <div class="columns is-multiline">
                                    <?php foreach ($nrcp_members as $member): ?>
                                        <div class="column is-one-fourth">
                                            <?= esc($member['honorifics'] . ' ' . $member['first_name'] . ' ' . $member['middle_name'] . ' ' . $member['last_name']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Balik Scientists -->
                        <div id="balik_scientist" class="section-content">
                            <?php if (!empty($balik_scientists)): ?>
                                <h3 class="title is-5"><i class="fas fa-user-tie mr-2"></i> Balik Scientist Engaged</h3>
                                <div class="columns is-multiline">
                                    <?php foreach ($balik_scientists as $scientist): ?>
                                        <div class="column is-one-fourth">
                                            <?= esc($scientist['honorifics'] . ' ' . $scientist['first_name'] . ' ' . $scientist['middle_name'] . ' ' . $scientist['last_name']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Ongoing Projects -->
                        <div id="projects" class="section-content">
                            <h3 class="title is-5"><i class="fas fa-project-diagram mr-2"></i> Ongoing Research Projects
                            </h3>
                            <table class="table is-striped is-hoverable is-fullwidth">
                                <thead>
                                    <tr>
                                        <th class="narrow-column">Sector</th>
                                        <th class="title-column">Title</th>
                                        <th class="wide-column">Research Objectives</th>
                                        <th class="small-column">Duration</th>
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
                                                <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
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

                        <!-- Completed Projects -->
                        <div id="completed_projects" class="section-content">
                            <h3 class="title is-5"><i class="fas fa-project-diagram mr-2"></i> Completed Research
                                Projects</h3>
                            <table class="table is-striped is-hoverable is-fullwidth">
                                <thead>
                                    <tr>
                                        <th class="narrow-column">Sector</th>
                                        <th class="title-column">Title</th>
                                        <th class="wide-column">Research Objectives</th>
                                        <th class="small-column">Duration</th>
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
                                                <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
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
        let selectedValue = dropdown.value;

        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.remove('show');
        });

        let institutionDetails = document.getElementById('details');
        institutionDetails.style.display = (selectedValue === 'all') ? 'block' : 'none';

        if (selectedValue === 'all') {
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('show');
            });
        } else if (selectedValue === 'projects') {
            document.getElementById('projects').classList.add('show');
            document.getElementById('completed_projects').classList.add('show');
        } else {
            let section = document.getElementById(selectedValue);
            if (section) section.classList.add('show');
        }
    }

    function printDetails(url) {
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

    window.onload = navigateToCategory;
</script>

<?= $this->endSection() ?>