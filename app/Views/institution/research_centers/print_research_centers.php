<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Research Centers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
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
        }

        .no-data {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Research Centers</h1>

<?php
$hasData = false;
foreach ($allInstitutionDetails as $details) {
    if (!empty($details['research_centers'])) {
        $hasData = true;
        break;
    }
}
?>

<?php if ($hasData): ?>
    <table>
        <thead>
            <tr>
                <th>Research Center</th>
                <th>Institution</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allInstitutionDetails as $details): ?>
                <?php if (!empty($details['research_centers'])): ?>
                    <?php foreach ($details['research_centers'] as $center): ?>
                        <tr>
                            <td><?= htmlspecialchars($center['name']) ?></td>
                            <td><?= htmlspecialchars($center['institution_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">No Research Centers found.</div>
<?php endif; ?>

</body>
</html>
