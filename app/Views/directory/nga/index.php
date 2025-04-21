<?= $this->extend('layouts/directory-layout') ?>
<?= $this->section('content') ?>

<section class="section">

<div class="container">
        <!-- Header Section -->
        <div class="level">
            <div class="level-left">
                <h3 class="title is-4 has-text-grey-dark">NGAs</h3>
            </div>
            <div class="level-right">
                <a href="<?= base_url('directory/nga/create') ?>" class="button is-primary">
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
                    <th>Name of Office</th>
                    <th>Salutation</th>
                    <th>Honorifics</th>
                    <th>Head of Office</th>
                    <th>Address</th>
                    <th>Telephone</th>
                    <th>Fax</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Last Update</th>
                    <th class="has-text-centered">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ngas as $nga): ?>
                    <tr>
                        <td><?= esc($nga->name_of_office) ?></td>
                        <td><?= esc($nga->salutation) ?></td>
                        <td><?= esc($nga->honorifics) ?></td>
                        <td><?= esc($nga->head_of_office) ?></td>
                        <td><?= esc($nga->address) ?></td>
                        <td><?= esc($nga->telephone) ?></td>
                        <td><?= esc($nga->fax) ?></td>
                        <td><?= esc($nga->email) ?></td>
                        <td><?= esc($nga->mobile_num) ?></td>
                        <td><?= date('Y-m-d H:i:s') ?></td>
                        <td class="has-text-centered">
                            <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                <a href="<?= base_url('ngas/edit/' . $nga->office_id) ?>" 
                                    class="button is-info is-small" 
                                    style="margin-left: 8px; min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                    <span>Edit</span>
                                </a>
                                <a href="<?= base_url('ngas/delete/' . $nga->office_id) ?>" 
                                    class="button is-danger is-small"
                                    style="min-width: 120px; display: flex; justify-content: center; align-items: center;"
                                    onclick="return confirm('Are you sure?');">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection() ?>
