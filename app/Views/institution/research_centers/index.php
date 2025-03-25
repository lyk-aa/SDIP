<?= $this->extend('layouts/header-layout') ?>

<?= $this->section('content') ?>

<section>
    <div class="control">
        <div class="select is-smaller" style="width: 200px;">
            <select id="categoryDropdown" onchange="navigateToCategory()">
                <option value="<?= base_url('institution/home') ?>">All</option>
                <option value="<?= base_url('/institution/research_centers') ?>">Research,
                    Development
                    and Innovation Centers</option>
                <option value="<?= base_url('/institution/consortium') ?>">Consortium Membership
                </option>
                <option value="<?= base_url('/institution/projects') ?>">R&D Projects</option>
                <option value="<?= base_url('/institution/balik_scientist') ?>">Balik Scientists
                </option>
                <option value="<?= base_url('/institution/ncrp_members') ?>">NCRP Members</option>
            </select>
        </div>
    </div>
    <script>

        function navigateToCategory() {
            let dropdown = document.getElementById('categoryDropdown');
            let selectedUrl = dropdown.value;
            if (selectedUrl) {
                window.location.href = selectedUrl;
            }
        }
        let currentEditingCard = null;

        function redirectToDetails(event, url) {
            window.location.href = url;
        }

        function openEditModal(element) {
            currentEditingCard = element.closest('.card');
            const title = currentEditingCard.querySelector('.card-title').innerText;
            const description = currentEditingCard.querySelector('.card-description').innerText;
            const imageSrc = currentEditingCard.querySelector('.preview-image').src;

            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;
            document.getElementById('modal-image-preview').src = imageSrc;

            document.getElementById('edit-modal').classList.add('is-active');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.remove('is-active');
        }

        function previewModalImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('modal-image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function saveCardEdit() {
            if (currentEditingCard) {
                currentEditingCard.querySelector('.card-title').innerText = document.getElementById('edit-title').value;
                currentEditingCard.querySelector('.card-description').innerText = document.getElementById('edit-description').value;
                currentEditingCard.querySelector('.preview-image').src = document.getElementById('modal-image-preview').src;
            }
            closeEditModal();
        }

        function previewImage(event, input) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    input.closest('.card-image').querySelector('.preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function deleteCard(element) {
            const card = element.closest('.column');
            card.remove();
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('is-active'));
                    trigger.closest('.dropdown').classList.toggle('is-active');
                });
            });

            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('is-active'));
            });
        });
    </script>

</section>
<?= $this->endSection() ?>