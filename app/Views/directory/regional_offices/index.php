<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<body class="section">
    <div class="container">
        <!-- Header Section -->
        <div class="level">
            <div class="level-left">
                <h3 class="title is-4 has-text-grey-dark">Regional Offices</h3>
            </div>
            <div class="level-right">
                <a href="<?= base_url('directory/regional_offices/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Regional Office</th>
                        <th>Honorifics</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Designation</th>
                        <th>Position</th>
                        <th>Office Address</th>
                        <th>Telephone Number</th>
                        <th>Email Address</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($regional_offices)): ?>
                        <?php foreach ($regional_offices as $office): ?>
                            <tr>
                                <td><?= esc($office->regional_office ?? 'N/A') ?></td>
                                <td><?= esc($office->hon ?? '') ?></td>
                                <td><?= esc($office->first_name ?? '') ?></td>
                                <td><?= esc($office->last_name ?? '') ?></td>
                                <td><?= esc($office->designation ?? '') ?></td>
                                <td><?= esc($office->position ?? '') ?></td>
                                <td><?= esc($office->office_address ?? 'N/A') ?></td>
                                <td><?= esc($office->telephone_num ?? 'N/A') ?></td>
                                <td><?= esc($office->email_address ?? 'N/A') ?></td>
                                <td class="has-text-centered">
                                    <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                        <a href="<?= site_url('/directory/regional_offices/edit/' . $office->stakeholder_id) ?>" 
                                            class="button is-info is-small"
                                            style="margin-left: 8px; min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                            <span>Edit</span>
                                        </a>
                                        <a href="<?= site_url('regional_offices/delete/' . $office->stakeholder_id); ?>" 
                                            class="button is-danger is-small"
                                            style="min-width: 120px; display: flex; justify-content: center; align-items: center;"
                                            onclick="return confirm('Are you sure you want to delete this regional office?');">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="has-text-centered has-text-grey-light">
                                No regional offices found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?= $this->endSection() ?>
