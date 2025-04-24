<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">📍 <?= esc($office->regional_office) ?></h3>
        <hr>
        <div class="content">
            <div class="columns">
                <div class="column is-half">
                    <p><strong>👤 Honorifics:</strong> <?= esc($office->hon ?? 'N/A') ?></p>
                    <p><strong>🆔 First Name:</strong> <?= esc($office->first_name) ?></p>
                    <p><strong>🆔 Last Name:</strong> <?= esc($office->last_name) ?></p>
                    <!-- <p><strong>🏢 Designation:</strong> <?= esc($office->designation ?? 'N/A') ?></p> -->
                    <p><strong>💼 Position:</strong> <?= esc($office->position ?? 'N/A') ?></p>
                </div>
                <div class="column is-half">
                    <p><strong>📍 Office Address:</strong> <?= esc($office->office_address ?? 'N/A') ?></p>
                    <p><strong>📞 Telephone:</strong> <?= esc($office->telephone_num ?? 'N/A') ?></p>
                    <p><strong>✉️ Email:</strong> <?= esc($office->email_address ?? 'N/A') ?></p>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="<?= site_url('/directory/regional_offices') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>
</section>


<?= $this->endSection() ?>