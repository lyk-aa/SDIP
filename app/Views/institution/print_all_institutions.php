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

<?php if (!empty($institutions)): ?>
    <?php foreach ($institutions as $institution): ?>
        <div class="institution">
            <h2><?= esc($institution['description']) ?></h2>

            <!-- Balik Scientists -->
            <div class="section">
                <h3>Balik Scientists</h3>
                <?php if (!empty($institution['balik_scientists'])): ?>
                    <?php foreach ($institution['balik_scientists'] as $bs): ?>
                        <div class="entity">
                            <strong>Name:</strong> <?= esc($bs['name']) ?><br>
                            <strong>Description:</strong> <?= esc($bs['description']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No Balik Scientists found.</p>
                <?php endif; ?>
            </div>

            <!-- NCRP Members -->
            <div class="section">
                <h3>NCRP Members</h3>
                <?php if (!empty($institution['ncrp_members'])): ?>
                    <?php foreach ($institution['ncrp_members'] as $member): ?>
                        <div class="entity">
                            <strong>Name:</strong> <?= esc($member['name']) ?><br>
                            <strong>Description:</strong> <?= esc($member['description']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No NCRP Members found.</p>
                <?php endif; ?>
            </div>

            <!-- Research Projects -->
            <div class="section">
                <h3>R&D Projects</h3>
                <?php if (!empty($institution['research_projects'])): ?>
                    <?php foreach ($institution['research_projects'] as $proj): ?>
                        <div class="entity">
                            <strong>Name:</strong> <?= esc($proj['name']) ?><br>
                            <strong>Leader:</strong> <?= esc($proj['project_leader']) ?><br>
                            <strong>Description:</strong> <?= esc($proj['description']) ?><br>
                            <strong>Objectives:</strong> <?= esc($proj['project_objectives']) ?><br>
                            <strong>Status:</strong> <?= esc($proj['status']) ?><br>
                            <strong>Approved Amount:</strong> <?= esc($proj['approved_amount']) ?><br>
                            <strong>Duration:</strong> <?= esc($proj['duration']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No R&D Projects found.</p>
                <?php endif; ?>
            </div>

            <!-- Research Centers (future-proofing) -->
            <div class="section">
                <h3>Research Centers</h3>
                <?php if (!empty($institution['research_centers'])): ?>
                    <?php foreach ($institution['research_centers'] as $center): ?>
                        <div class="entity">
                            <strong>Name:</strong> <?= esc($center['name']) ?><br>
                            <strong>Description:</strong> <?= esc($center['description']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No Research Centers available.</p>
                <?php endif; ?>
            </div>

            <hr>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No institutions found.</p>
<?php endif; ?>

<button id="printButton" onclick="window.print()">Print This Page</button>

</body>
</html>
