<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print NRCP Members</title>
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

<h1>NRCP Members</h1>

<?php if (!empty($nrcpMembersDetails)): ?>
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
            <?php foreach ($nrcpMembersDetails as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member->first_name . ' ' . $member->middle_name . ' ' . $member->last_name) ?></td>
                    <td>
                        <?php if (!empty($member->image)): ?>
                            <img src="<?= base_url($member->image) ?>" alt="Image">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($member->role) ?></td>
                    <td><?= htmlspecialchars($member->institution_name) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">No NRCP members found.</div>
<?php endif; ?>

</body>
</html>
