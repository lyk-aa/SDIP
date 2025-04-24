<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Consortium</title>
    <style>
        @media print {
            #printButton {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
        }

        h1 {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 20px;
            position: relative;
        }

        h1::after {
            content: '';
            display: block;
            height: 4px; /* Line thickness */
            background-color: blue; /* Line color */
            width: 100%; /* Full width */
            position: absolute;
            bottom: -10px; /* Position below the title */
            left: 0;
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
    </style>
</head>
<body>

<h1>Consortium Details</h1>

<table>
    <thead>
        <tr>
            <th>Consortium</th>
            <th>Institution</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($consortiumDetails as $consortium): ?>
            <?php foreach ($consortium['institutions'] as $institution): ?>
                <tr>
                    <td><?= htmlspecialchars($consortium['consortium_name']) ?></td>
                    <td><?= htmlspecialchars($institution) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="has-text-centered">
    <button id="printButton" onclick="window.print()">Print</button>
</div>

</body>
</html>
