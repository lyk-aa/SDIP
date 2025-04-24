<!DOCTYPE html>
<html>
<head>
    <title>Print Institutions</title>
    <style>
        @media print {
            #printButton {
                display: none;
            }
            .page-break {
                page-break-before: always;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
        }

        h2 {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin-top: 0;
            margin-bottom: 10px;
        }

        h3 {
            font-weight: bold;
            background-color: #1e1c6b;
            color: white;
            padding: 6px 10px;
            margin-top: 30px;
            font-size: 14px;
        }

        .institution-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .institution-header img {
            height: 80px;
            width: auto;
        }

        .columns {
            display: flex;
            justify-content: space-between;
        }

        .column {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #eee;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<?php foreach ($allInstitutionDetails as $index => $details): ?>
    <div class="institution<?= $index > 0 ? ' page-break' : '' ?>">

        <div class="institution-header">
            <h2>Institution: <?= esc($details['institution']['name']) ?></h2>
            <?php if (!empty($details['institution']['logo_path'])): ?>
                <img src="<?= esc($details['institution']['logo_path']) ?>" alt="Logo of <?= esc($details['institution']['name']) ?>">
            <?php endif; ?>
        </div>

        <div class="columns">
            <div class="column">
                <p><strong>Type:</strong> <?= esc($details['institution']['type']) ?></p>
                <p><strong>Person Name:</strong> <?= esc($details['institution']['person_name']) ?></p>
                <p><strong>Designation:</strong> <?= esc($details['institution']['designation']) ?></p>
            </div>
            <div class="column">
                <p><strong>Address:</strong> <?= esc($details['institution']['street']) ?>,
                    <?= esc($details['institution']['barangay']) ?>, <?= esc($details['institution']['municipality']) ?>,
                    <?= esc($details['institution']['province']) ?>, <?= esc($details['institution']['country']) ?>
                </p>
                <p><strong>Telephone:</strong> <?= esc($details['institution']['telephone_num']) ?></p>
                <p><strong>Email:</strong> <?= esc($details['institution']['email_address']) ?></p>
            </div>
        </div>

        <!-- Consortium Memberships -->
        <h3>Consortium Memberships</h3>
        <?php if (!empty($details['consortiums'])): ?>
            <ul>
                <?php foreach ($details['consortiums'] as $cons): ?>
                    <li><?= esc($cons['name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No consortium memberships.</p>
        <?php endif; ?>

        <!-- Balik Scientist(s) -->
        <h3>Balik Scientist(s) Engaged</h3>
        <?php if (!empty($details['balik_scientists'])): ?>
            <ul>
                <?php foreach ($details['balik_scientists'] as $bs): ?>
                    <li><?= esc($bs['first_name']) ?> <?= esc($bs['middle_name']) ?> <?= esc($bs['last_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No Balik Scientists engaged.</p>
        <?php endif; ?>

        <!-- NRCP Members -->
        <h3>NRCP Member(s)</h3>
        <?php if (!empty($details['nrcp_members'])): ?>
            <ul>
                <?php foreach ($details['nrcp_members'] as $nrcp): ?>
                    <li><?= esc($nrcp['first_name']) ?> <?= esc($nrcp['middle_name']) ?> <?= esc($nrcp['last_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No NRCP members listed.</p>
        <?php endif; ?>

        <!-- Ongoing Research Projects -->
        <h3>Ongoing Projects</h3>
        <table>
            <thead>
                <tr>
                    <th>Sector</th>
                    <th>Title</th>
                    <th>Project Objectives</th>
                    <th>Duration</th>
                    <th>Project Leader</th>
                    <th>Approved Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($details['ongoing_research_projects'])): ?>
                    <?php foreach ($details['ongoing_research_projects'] as $project): ?>
                        <tr>
                            <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                            <td><?= esc($project['title'] ?? 'N/A') ?></td>
                            <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                            <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                            <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                            <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No ongoing projects</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Completed Research Projects -->
        <h3>Completed Projects</h3>
        <table>
            <thead>
                <tr>
                    <th>Sector</th>
                    <th>Title</th>
                    <th>Project Objectives</th>
                    <th>Duration</th>
                    <th>Project Leader</th>
                    <th>Approved Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($details['completed_research_projects'])): ?>
                    <?php foreach ($details['completed_research_projects'] as $project): ?>
                        <tr>
                            <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                            <td><?= esc($project['title'] ?? 'N/A') ?></td>
                            <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                            <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                            <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                            <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No completed projects</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
<?php endforeach; ?>
</body>
</html>
