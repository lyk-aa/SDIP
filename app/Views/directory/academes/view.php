<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">🏫 Academe Details</h3>
        <hr>

        <div class="columns is-multiline">
            <div class="column is-half">
                <p><strong>🔠 Abbreviation:</strong> <?= esc($academe->abbreviation ?? 'N/A') ?></p>
                <p><strong>🏛️ Name:</strong> <?= esc($academe->academe_name ?? 'N/A') ?></p>
                <p><strong>📍 Address:</strong>
                    <?= esc($academe->street ?? '') ?>,
                    <?= esc($academe->barangay ?? '') ?>,
                    <?= esc($academe->municipality ?? '') ?>,
                    <?= esc($academe->province ?? '') ?>,
                    <?= esc($academe->country ?? '') ?>,
                    <?= esc($academe->postal_code ?? '') ?>
                </p>
            </div>

            <div class="column is-half">
                <p><strong>👤 Head of Office:</strong>
                    <?= esc($academe->honorifics ?? '') ?>
                    <?= esc($academe->first_name ?? '') ?>
                    <?= esc($academe->middle_name ?? '') ?>
                    <?= esc($academe->last_name ?? '') ?>
                </p>
                <p><strong>💼 Designation:</strong> <?= esc($academe->designation ?? 'N/A') ?></p>
                <p><strong>📧 Email Address:</strong> <?= esc($academe->email_address ?? 'N/A') ?></p>
                <p><strong>☎️ Telephone Number:</strong> <?= esc($academe->telephone_num ?? 'N/A') ?></p>
            </div>
        </div>

        <div class="buttons mt-4">
            <a href="<?= base_url('/directory/academes') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>


</section>

<?= $this->endSection() ?>