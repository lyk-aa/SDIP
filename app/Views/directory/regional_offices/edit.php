<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<!-- Edit Modal -->
<div class="modal" id="edit-office-modal">
    <div class="modal-background" id="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Edit Regional Office</p>
            <button class="delete" id="close-edit-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form id="edit-office-form" action="{{ url('directory/regional_offices/update') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="edit-id">

                <div class="field">
                    <label class="label">Regional Office</label>
                    <div class="control">
                        <input type="text" name="regional_office" id="edit-regional_office" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Hon.</label>
                    <div class="control">
                        <input type="text" name="hon" id="edit-hon" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">First Name</label>
                    <div class="control">
                        <input type="text" name="first_name" id="edit-first_name" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Last Name</label>
                    <div class="control">
                        <input type="text" name="last_name" id="edit-last_name" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Designation</label>
                    <div class="control">
                        <input type="text" name="designation" id="edit-designation" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Position</label>
                    <div class="control">
                        <input type="text" name="position" id="edit-position" class="input">
                    </div>
                </div>

                <!-- Address Fields -->
                <div class="field">
                    <label class="label">Street</label>
                    <div class="control">
                        <input type="text" name="street" id="edit-street" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">City</label>
                    <div class="control">
                        <input type="text" name="city" id="edit-city" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Province</label>
                    <div class="control">
                        <input type="text" name="province" id="edit-province" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">ZIP Code</label>
                    <div class="control">
                        <input type="text" name="zip_code" id="edit-zip_code" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Telephone Number</label>
                    <div class="control">
                        <input type="text" name="telephone_num" id="edit-telephone_num" class="input">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Email Address</label>
                    <div class="control">
                        <input type="email" name="email_address" id="edit-email_address" class="input" required>
                    </div>
                </div>

                <div class="field has-text-centered">
                    <button type="submit" class="button is-success">Update</button>
                    <button type="button" class="button is-light" id="cancel-edit">Cancel</button>
                </div>
            </form>
        </section>
    </div>
</div>

<?= $this->endSection() ?>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('edit-office-modal');
        const closeEditModal = document.getElementById('close-edit-modal');
        const modalBackground = document.getElementById('modal-background');
        const cancelEdit = document.getElementById('cancel-edit');

        // Function to open modal with data
        function openEditModal(event) {
            const button = event.currentTarget;

            document.getElementById('edit-id').value = button.dataset.id || '';
            document.getElementById('edit-regional_office').value = button.dataset.regional_office || '';
            document.getElementById('edit-hon').value = button.dataset.hon || '';
            document.getElementById('edit-first_name').value = button.dataset.first_name || '';
            document.getElementById('edit-last_name').value = button.dataset.last_name || '';
            document.getElementById('edit-designation').value = button.dataset.designation || '';
            document.getElementById('edit-position').value = button.dataset.position || '';
            document.getElementById('edit-street').value = button.dataset.street || '';
            document.getElementById('edit-city').value = button.dataset.city || '';
            document.getElementById('edit-province').value = button.dataset.province || '';
            document.getElementById('edit-zip_code').value = button.dataset.zip_code || '';
            document.getElementById('edit-telephone_num').value = button.dataset.telephone_num || '';
            document.getElementById('edit-email_address').value = button.dataset.email_address || '';

            editModal.classList.add('is-active');
        }

        // Attach event listeners to edit buttons
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', openEditModal);
        });

        // Close modal
        [closeEditModal, cancelEdit, modalBackground].forEach(element => {
            element.addEventListener('click', () => {
                editModal.classList.remove('is-active');
            });
        });
    });
</script>
@endpush