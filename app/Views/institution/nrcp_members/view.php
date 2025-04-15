<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NRCP Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">NRCP Details</h2>

        <?php if ($nrcp): ?>
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body text-center">
                    <?php if ($nrcp['image']): ?>
                        <img src="<?= !empty($nrcp['image']) ? base_url($nrcp['image']) : '/images/profile.png' ?>"
                            alt="<?= esc($nrcp['first_name']) ?>" class="img-fluid mb-3"
                            style="max-width: 300px; border-radius: 10px;">
                    <?php else: ?>
                        <img src="<?= base_url('uploads/default.png') ?>" alt="Default Image" class="img-fluid mb-3"
                            style="max-width: 300px; border-radius: 10px;">
                    <?php endif; ?>
                    <?php if (!empty($nrcp['institution_image'])): ?>
                        <img src="<?= !empty($nrcp['institution_image']) ? base_url($nrcp['institution_image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                            alt="Institution Image" class="img-fluid mb-3"
                            style="max-width: 200px; border-radius: 10px;">
                    <?php endif; ?>
                    <p><strong>Name:</strong>
                        <?= $nrcp['honorifics'] . ' ' . $nrcp['first_name'] . ' ' . $nrcp['middle_name'] . ' ' . $nrcp['last_name'] ?>
                    </p>
                    <p><strong>Role:</strong> <?= $nrcp['role'] ?></p>
                    <p><strong>Institution:</strong> <?= $nrcp['institution_name'] ?></p>
                    <p><strong>Description:</strong> <?= $nrcp['description'] ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">NRCP not found.</div>
        <?php endif; ?>

        <a href="<?= base_url('institution/nrcp_members/index') ?>" class="btn btn-primary mt-3">Back</a>
    </div>
</body>

</html>
