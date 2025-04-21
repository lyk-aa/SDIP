<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="level">
        <div class="level-left">
            <h3 class="title is-4 has-text-grey-dark">Academes</h3>
        </div>
        <div class="level-right">
            <a href="<?= base_url('directory/academes/create') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Create New</span>
            </a>
        </div>
    </div>
    <!-- Bulma Table -->
    <div class="table-container">
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Agency</th>
                    <th>Name</th>
                    <th>Head of Office</th>
                    <th>Designation</th>
                    <th>Address</th>
                    <th>Fax</th>
                    <th>Telephone</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>West Visayas State University</td>
                    <td>Western Visayas</td>
                    <td>Dr. Joselito F. Villaruz</td>
                    <td>University President</td>
                    <td>West Visayas State University, Luna Street, La Paz, Iloilo City, Philippines</td>
                    <td>(033) 320-0870</td>
                    <td>(033) 320-0871</td>
                    <td>+63 917 987 6543</td>
                    <td>info@wvsu.edu.ph</td>
                    <td class="has-text-centered">
                        <div class="buttons is-flex is-align-items-center" style="gap: 10px;">
                            <a href="" class="button is-info is-small"
                                style="min-width: 120px; display: flex; justify-content: center; align-items: center;">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="" class="button is-danger is-small"
                                style="min-width: 120px; display: flex; justify-content: center; align-items: center;"
                                onclick="return confirm('Are you sure?');">
                                <span class="icon"><i class="fas fa-trash"></i></span>
                                <span>Delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<div id="addAcademeModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('addAcademeModal').classList.remove('is-active');">
    </div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add Academe</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('addAcademeModal').classList.remove('is-active');"></button>
        </header>
        <form action="<?= base_url('/academes/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Agency</label>
                            <div class="control">
                                <input class="input" type="text" name="agency" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Head of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="head_of_office" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Designation</label>
                            <div class="control">
                                <input class="input" type="text" name="designation">
                            </div>
                        </div>
                    </div>

                    <div class="column is-full">
                        <div class="field">
                            <label class="label">Address</label>
                            <div class="control">
                                <input class="input" type="text" name="address" required>
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="text" name="telephone">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Mobile</label>
                            <div class="control">
                                <input class="input" type="text" name="mobile">
                            </div>
                        </div>
                    </div>

                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field has-text-centered mt-4">
                    <button type="submit" class="button is-success">Save</button>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>