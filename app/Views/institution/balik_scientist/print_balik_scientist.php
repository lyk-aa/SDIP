<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Balik Scientist</title>
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

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<h1>Balik Scientist</h1>

<?php if (!empty($balikScientistDetails)): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Role</th>
                <th>Institution</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($balikScientistDetails as $scientist): ?>
                <tr>
                    <td><?= htmlspecialchars($scientist->first_name . ' ' . $scientist->middle_name . ' ' . $scientist->last_name) ?></td>
                    <td>
                        <?php if (!empty($scientist->image)): ?>
                            <img src="<?= base_url($scientist->image) ?>" alt="Image">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($scientist->role) ?></td>
                    <td><?= htmlspecialchars($scientist->institution_name) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">No Balik Scientists found.</div>
<?php endif; ?>

</body>
</html>
