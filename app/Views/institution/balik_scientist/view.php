<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientist Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Scientist Details</h2>

        <?php if ($scientist): ?>
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body text-center">
                    <?php if ($scientist['image']): ?>
                        <img src="<?= !empty($scientist['image']) ? base_url($scientist['image']) : '/images/profile.png' ?>"
                            alt="<?= esc($scientist['first_name']) ?>" class="img-fluid mb-3"
                            style="max-width: 300px; border-radius: 10px;">
                    <?php else: ?>
                        <img src="<?= base_url('uploads/default.png') ?>" alt="Default Image" class="img-fluid mb-3"
                            style="max-width: 300px; border-radius: 10px;">
                    <?php endif; ?>
                    <?php if (!empty($scientist['institution_image'])): ?>
                        <img src="<?= !empty($scientist['institution_image']) ? base_url($scientist['institution_image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                            alt="Institution Image" class="img-fluid mb-3" style="max-width: 200px; border-radius: 10px;">
                    <?php endif; ?>

                    <p><strong>Name:</strong>
                        <?= $scientist['honorifics'] . ' ' . $scientist['first_name'] . ' ' . $scientist['middle_name'] . ' ' . $scientist['last_name'] ?>
                    </p>
                    <p><strong>Role:</strong> <?= $scientist['role'] ?></p>
                    <p><strong>Institution:</strong> <?= $scientist['institution_name'] ?></p>
                    <p><strong>Description:</strong> <?= $scientist['description'] ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">Scientist not found.</div>
        <?php endif; ?>

        <a href="<?= base_url('institution/balik_scientist/index') ?>" class="btn btn-primary mt-3">Back</a>
    </div>
</body>

</html>