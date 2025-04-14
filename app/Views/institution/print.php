<!DOCTYPE html>
<html>
<head>
    <title>Institution Print View</title>
    <style>
        body { font-family: Arial; }
        .institution {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body onload="window.print()">
    <h2>Institution Directory</h2>
    <?php foreach($institutions as $institution): ?>
        <div class="institution">
            <h3><?= esc($institution['name']) ?></h3>
            <p><?= esc($institution['address']) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
