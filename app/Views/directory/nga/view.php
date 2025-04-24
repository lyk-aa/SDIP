<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">🏢 <?= esc($nga->office_name) ?></h3>
        <hr>

        <div class="columns is-multiline">
            <div class="column is-half">
                <p><strong>👤 Head of Office:</strong>
                    <?= esc($nga->salutation) . ' ' . esc($nga->full_name) ?>
                </p>
                <p><strong>📍 Address:</strong>
                    <?= esc($nga->office_address ?? 'N/A') ?>
                </p>
                <p><strong>📞 Telephone:</strong> <?= esc($nga->telephone_num) ?: 'N/A' ?></p>

            </div>

            <div class="column is-half">
                <p><strong>📠 Fax:</strong> <?= esc($nga->fax_num) ?: 'N/A' ?></p>
                <p><strong>✉️ Email Address:</strong> <?= esc($nga->email_address) ?: 'N/A' ?></p>
                <p><strong>🕒 Last Update:</strong>
                    <?= isset($nga->updated_at) ? date('Y-m-d H:i:s', strtotime($nga->updated_at)) : 'Not Updated' ?>
                </p>
            </div>
        </div>
        <div class="buttons">
            <a href="<?= site_url('/directory/nga') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>