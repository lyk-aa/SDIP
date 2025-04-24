<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">National Government Agencies</h3>

        <div class="columns is-multiline is-vcentered">
            <div class="column is-3">
                <div class="field">
                    <label class="label">Show Entries</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select id="entriesSelect">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-4">
                <div class="control has-icons-left mt-5">
                    <input type="text" id="searchInput" class="input is-rounded" placeholder="Search...">
                    <span class="icon is-left"><i class="fas fa-search"></i></span>
                </div>
            </div>

            <div class="column is6 has-text-right">
                <!-- Trigger button for modal -->
                <button id="modalButton" class="button is-success is-rounded">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </button>
                <a href="<?= site_url('directory/nga/export') ?>" class="button is-primary is-rounded">
                    <span class="icon"><i class="fas fa-file-export"></i></span>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <div class="table-container mt-4">
            <table id="ngaTable" class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead>
                    <tr class="has-background-light has-text-centered">
                        <th>Name of Office</th>
                        <th>Salutation</th>
                        <th>Head of Office</th>
                        <th>Address</th>
                        <th>Contact Details</th>
                        <th>Last Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ngas as $nga): ?>
                        <tr onclick="window.location='<?= base_url('/directory/nga/view/' . $nga->stakeholder_id) ?>'"
                            style="cursor: pointer;">
                            <td><?= esc($nga->office_name) ?></td>
                            <td><?= esc($nga->salutation) ?></td>
                            <td><?= esc($nga->full_name) ?></td>
                            <td><?= esc($nga->office_address) ?></td>
                            <td>
                                <h6><b>Telephone:</b></h6><?= esc($nga->telephone_num) ?: 'N/A' ?><br>
                                <h6><b>Fax:</b></h6><?= esc($nga->fax_num) ?: 'N/A' ?><br>
                                <h6><b>Email Address:</b></h6><?= esc($nga->email_address) ?: 'N/A' ?>
                            </td>
                            <td><?= isset($nga->updated_at) ? date('Y-m-d H:i:s', strtotime($nga->updated_at)) : 'Not Updated' ?>
                            </td>
                            <td class="has-text-centered">
                                <a href="<?= base_url('/directory/nga/edit/' . $nga->stakeholder_id) ?>"
                                    class="button is-small is-info">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <a href="<?= base_url('/directory/nga/delete/' . $nga->stakeholder_id) ?>"
                                    class="button is-small is-danger" onclick="return confirm('Are you sure?');">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- NGA Modal -->
<div class="modal" id="ngaModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head has-background-light">
            <p class="modal-card-title">Create New National Government Agency</p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <form action="<?= base_url('/directory/nga/store') ?>" method="post">
            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Name of Office</label>
                            <div class="control">
                                <input class="input" type="text" name="office_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Salutation</label>
                            <div class="control">
                                <input class="input" type="text" name="salutation">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">First Name</label>
                            <div class="control">
                                <input class="input" type="text" name="first_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Middle Name</label>
                            <div class="control">
                                <input class="input" type="text" name="middle_name">
                            </div>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Last Name</label>
                            <div class="control">
                                <input class="input" type="text" name="last_name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input class="input" type="text" name="street" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Barangay</label>
                            <div class="control">
                                <input class="input" type="text" name="barangay" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Municipality</label>
                            <div class="control">
                                <input class="input" type="text" name="municipality" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Province</label>
                            <div class="control">
                                <input class="input" type="text" name="province" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <input class="input" type="text" name="country" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input class="input" type="text" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Telephone</label>
                            <div class="control">
                                <input class="input" type="tel" name="telephone_num">
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">

                        <div class="field">
                            <label class="label">Fax</label>
                            <div class="control">
                                <input class="input" type="text" name="fax_num">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Email Address</label>
                    <div class="control">
                        <input class="input" type="email" name="email_address" required>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot is-justify-content-center">
                <button type="submit" class="button is-success">Save</button>
                <button type="button" class="button" onclick="closeModal()">Cancel</button>
            </footer>
        </form>
    </div>
</div>

<!-- Unified Modal Styles (reused from Regional Office) -->
<style>
    .modal-card {
        max-width: 900px;
        width: 95%;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow: hidden;
    }

    .modal-card-body {
        padding: 1.5rem;
        overflow-y: auto;
        max-height: 70vh;
    }

    .modal-card-head {
        background-color: rgb(211, 213, 216);
        color: white;
        border-radius: 12px 12px 0 0;
    }

    .modal-card-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    .delete {
        background-color: transparent;
        color: white;
    }

    .modal-card-foot {
        justify-content: flex-end;
        background-color: #f5f5f5;
        border-top: 1px solid #eaeaea;
        padding: 1rem;
        border-radius: 0 0 12px 12px;
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f5f5f5;
    }

    button {
        margin-left: 5px;
    }

    @media screen and (max-width: 768px) {
        .columns {
            flex-direction: column;
        }

        .column {
            width: 100%;
        }

        .modal-card {
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-card-body {
            max-height: 60vh;
        }
    }
</style>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#ngaTable tbody tr').forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

</script>


<script>
    const modalButton = document.querySelector('#modalButton');
    const modal = document.querySelector('#ngaModal');
    const modalCloseButton = modal.querySelector('.delete');
    const cancelButton = modal.querySelector('.modal-card-foot .button:not(.is-success)');

    function closeModal() {
        modal.classList.remove('is-active');
    }

    modalButton.addEventListener('click', function () {
        modal.classList.add('is-active');
    });

    modalCloseButton.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal || event.target.classList.contains('modal-background')) {
            closeModal();
        }
    });
</script>



<?= $this->endSection() ?>