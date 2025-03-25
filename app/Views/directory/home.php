<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>


<section class="section">
    <!-- 
    category -->
    <!-- <div class="field">
        <label class="label">Select Category</label>
        <div class="control">
            <div class="select">
                <select id="categoryDropdown" onchange="navigateToCategory()">
                    <option value="<?= base_url('directory/home') ?>">All</option>
                    <option value="<?= base_url('directory/regional_offices') ?>">Regional Offices</option>
                    <option value="<?= base_url('directory/nga') ?>">NGA</option>
                    <option value="<?= base_url('directory/academes') ?>">Academes</option>
                    <option value="<?= base_url('directory/lgus') ?>">LGUs</option>
                    <option value="<?= base_url('directory/sucs') ?>">SUCs</option>
                    <option value="<?= base_url('directory/business_sector') ?>">Business Sector</option>
                </select>
            </div>
        </div>
    </div> -->

    <div class="container">
        <table id="example" class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Abbreviation</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Address</th>
                    <th>Head of Office</th>
                    <th>Designation</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stakeholders as $stakeholder): ?>
                    <tr>
                        <td><?= esc($stakeholder['abbreviation']) ?></td>
                        <td><?= esc($stakeholder['name']) ?></td>
                        <td><?= esc($stakeholder['category']) ?></td>
                        <td>
                            <?= esc(
                                trim(
                                    implode(', ', array_filter([
                                        $stakeholder['street'],
                                        $stakeholder['barangay'],
                                        $stakeholder['municipality'],
                                        $stakeholder['province'],
                                        $stakeholder['country'],
                                        $stakeholder['postal_code']
                                    ]))
                                )
                            ) ?>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="button is-small is-info">Edit</button>
                            <button class="button is-small is-danger">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "paging": true
        });
    });
</script>
<script>
    function navigateToCategory() {
        var categoryUrl = document.getElementById("categoryDropdown").value;
        if (categoryUrl) {
            window.location.href = categoryUrl;
        }
    }
</script>


<?= $this->endSection() ?>