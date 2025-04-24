<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Research Projects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            padding: 0;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        h2 {
            font-size: 16px; /* Title size set to 16px */
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
            width: 25%;
        }

        td {
            width: 75%;
        }

        .no-data {
            text-align: center;
            margin-top: 20px;
        }

        .project-container {
            margin-bottom: 30px;
        }

        /* Ensure the first project is on the same page */
        .first-project {
            margin-top: 20px;
        }

        /* Page break settings */
        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* Add a page break only after the first project */
            .project-container:not(.first-project) {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>

<h1>Research Projects</h1>

<?php if (!empty($projectDetails)): ?>
    <!-- First project will appear directly under the title -->
    <div class="project-container first-project">
        <h2>Research Project: <?= htmlspecialchars($projectDetails[0]->name) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Research Name</th>
                    <td><?= htmlspecialchars($projectDetails[0]->name) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?= htmlspecialchars($projectDetails[0]->status) ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?= htmlspecialchars($projectDetails[0]->description) ?></td>
                </tr>
                <tr>
                    <th>Sector</th>
                    <td><?= htmlspecialchars($projectDetails[0]->sector) ?></td>
                </tr>
                <tr>
                    <th>Duration</th>
                    <td><?= htmlspecialchars($projectDetails[0]->duration) ?></td>
                </tr>
                <tr>
                    <th>Project Leader</th>
                    <td><?= htmlspecialchars($projectDetails[0]->project_leader) ?></td>
                </tr>
                <tr>
                    <th>Objectives</th>
                    <td>
                        <ul>
                            <?php if (!empty($objectives[$projectDetails[0]->project_id])): ?>
                                <?php foreach ($objectives[$projectDetails[0]->project_id] as $objective): ?>
                                    <li><?= htmlspecialchars($objective->objective) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No objectives available</li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Approved Amount</th>
                    <td>₱<?= htmlspecialchars($projectDetails[0]->approved_amount) ?></td>
                </tr>
                <tr>
                    <th>Stakeholder Name</th>
                    <td><?= htmlspecialchars($projectDetails[0]->stakeholder_name) ?></td>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Loop through remaining projects, each on a new page -->
    <?php for ($i = 1; $i < count($projectDetails); $i++): ?>
        <div class="project-container">
            <h2>Research Project: <?= htmlspecialchars($projectDetails[$i]->name) ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Research Name</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->name) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->status) ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->description) ?></td>
                    </tr>
                    <tr>
                        <th>Sector</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->sector) ?></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->duration) ?></td>
                    </tr>
                    <tr>
                        <th>Project Leader</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->project_leader) ?></td>
                    </tr>
                    <tr>
                        <th>Objectives</th>
                        <td>
                            <ul>
                                <?php if (!empty($objectives[$projectDetails[$i]->project_id])): ?>
                                    <?php foreach ($objectives[$projectDetails[$i]->project_id] as $objective): ?>
                                        <li><?= htmlspecialchars($objective->objective) ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>No objectives available</li>
                                <?php endif; ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>Approved Amount</th>
                        <td>₱<?= htmlspecialchars($projectDetails[$i]->approved_amount) ?></td>
                    </tr>
                    <tr>
                        <th>Stakeholder Name</th>
                        <td><?= htmlspecialchars($projectDetails[$i]->stakeholder_name) ?></td>
                    </tr>
                </thead>
            </table>
        </div>
    <?php endfor; ?>

<?php else: ?>
    <div class="no-data">No active projects found!</div>
<?php endif; ?>

</body>
</html>
