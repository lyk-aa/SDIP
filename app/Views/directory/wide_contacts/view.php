<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">📇 Contact Details</h3>
        <hr>

        <div class="content">
            <div class="columns">
                <div class="column is-half">
                    <p><strong>👤 Name:</strong> <?= esc($contact->first_name) ?> <?= esc($contact->middle_name) ?>
                        <?= esc($contact->last_name) ?>
                    </p>
                    <p><strong>💼 Position:</strong> <?= esc($contact->position ?? 'N/A') ?></p>
                    <p><strong>📧 Email Address:</strong> <?= esc($contact->email_address ?? 'N/A') ?></p>
                </div>
                <div class="column is-half">
                    <p><strong>📱 Contact Number:</strong> <?= esc($contact->mobile_num ?? 'N/A') ?></p>
                    <p><strong>🚘 Plate Number:</strong> <?= esc($contact->plate_number ?? 'N/A') ?></p>
                    <p><strong>🆔 Driver Number:</strong> <?= esc($contact->driver_num ?? 'N/A') ?></p>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="<?= base_url('directory/wide_contacts') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>