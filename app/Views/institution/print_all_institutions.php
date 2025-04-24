<!DOCTYPE html>
<html>
<head>
    <title>Print Institutions</title>
    <style>
        @media print {
            #printButton {
                display: none;
            }
        }
        body { font-family: Arial, sans-serif; }
        .institution { margin-bottom: 40px; }
        .section { margin-left: 20px; margin-top: 10px; }
        .entity { margin-bottom: 15px; }
        hr { margin: 20px 0; }
    </style>
</head>
<body>

<h1>All Institutions and Their Data</h1>

<?php foreach ($allInstitutionDetails as $details): ?>
    <div id="details">
        <h2>Institution: <?= $details['institution']['name'] ?></h2>
        <div class="columns">
            <div class="column is-6">
                <p><strong>Type:</strong> <?= $details['institution']['type'] ?></p>
                <p><strong>Person Name:</strong> <?= $details['institution']['person_name'] ?></p>
                <p><strong>Designation:</strong> <?= $details['institution']['designation'] ?></p>
            </div>
            <div class="column is-6">
                <p><strong>Address:</strong> <?= $details['institution']['street'] ?>,
                    <?= $details['institution']['barangay'] ?>, <?= $details['institution']['municipality'] ?>,
                    <?= $details['institution']['province'] ?>, <?= $details['institution']['country'] ?>
                </p>
                <p><strong>Telephone:</strong> <?= $details['institution']['telephone_num'] ?></p>
                <p><strong>Email:</strong> <?= $details['institution']['email_address'] ?></p>
            </div>
        </div>
    </div>

    <h3>Ongoing Research Projects:</h3>
    <div id="projects" class="section-content">
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
                <?php if (!empty($details['ongoing_research_projects'])): ?>
                    <?php foreach ($details['ongoing_research_projects'] as $project): ?>
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

    <h3>Completed Research Projects:</h3>
    <div id="completed_projects" class="section-content">
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
                <?php if (!empty($details['completed_research_projects'])): ?>
                    <?php foreach ($details['completed_research_projects'] as $project): ?>
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
<?php endforeach; ?>
</body>
</html>
