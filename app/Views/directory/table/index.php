<!DOCTYPE html>
<html>

<head>
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            margin: 40px;
        }

        h1 {
            text-align: center;
            font-size: 20pt;
            margin-bottom: 30px;
        }

        .institution-info {
            width: 100%;
            border-collapse: collapse;
        }

        .institution-info th,
        .institution-info td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        .institution-info th {
            background-color: #f2f2f2;
        }

        .section-title {
            font-size: 14pt;
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1><?= esc($title) ?></h1>

    <div class="section-title">Institution Information</div>
    <table class="institution-info">
        <tr>
            <th>Name</th>
            <td><?= esc($institution['name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= esc($institution['address'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($institution['email'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?= esc($institution['phone'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <th>Website</th>
            <td><?= esc($institution['website'] ?? 'N/A') ?></td>
        </tr>
    </table>

    <div class="section-title">Additional Details</div>
    <p><?= esc($content) ?></p>

</body>

</html>