<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">📍 <?= esc($lgu['name']) ?></h3>
        <hr>

        <div class="content">
            <h4 class="title is-5 mt-5">Address</h4>
            <p>
                <strong>📫 Complete Address:</strong>
                <?= esc(
                    implode(', ', array_filter([
                        $lgu['street'] ?? '',
                        $lgu['barangay'] ?? '',
                        $lgu['municipality'] ?? '',
                        $lgu['province'] ?? '',
                        $lgu['country'] ?? '',
                        $lgu['postal_code'] ?? '',
                    ]))
                ) ?>
            </p>
        </div>

        <h4 class="title is-5 mt-5">Member</h4>
        <?php foreach ($lgu['members'] as $member): ?>
            <div class="box mb-4">
                <div class="columns">
                    <div class="column is-half">
                        <p><strong>👤 Salutation:</strong> <?= esc($member['person']['salutation'] ?? 'N/A') ?></p>
                        <p><strong>🆔 Name:</strong>
                            <?= esc(
                                trim(
                                    ($member['person']['first_name'] ?? '') . ' ' .
                                    ($member['person']['middle_name'] ?? '') . ' ' .
                                    ($member['person']['last_name'] ?? '')
                                )
                            ) ?>
                        </p>
                        <p><strong>🏢 Designation:</strong> <?= esc($member['person']['designation'] ?? 'N/A') ?></p>
                    </div>
                    <div class="column is-half">
                        <p><strong>📞 Telephone:</strong> <?= esc($member['contact']['telephone_num'] ?? 'N/A') ?></p>
                        <p><strong>📠 Fax:</strong> <?= esc($member['contact']['fax_num'] ?? 'N/A') ?></p>
                        <p><strong>✉️ Email:</strong> <?= esc($member['contact']['email_address'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="buttons">
            <a href="<?= site_url('/directory/lgus') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>