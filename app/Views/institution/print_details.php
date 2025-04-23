<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Details</title>
</head>
<body>
    <!-- Institution Details -->
    <div id="details">
        <h2>Institution: <?= esc($institution['name']) ?></h2>
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
</body>
</html>