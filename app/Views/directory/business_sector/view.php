<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="box">
        <h3 class="title is-4 has-text-primary">📍 NGO Details</h3>
        <hr>

        <div class="content">
            <div class="columns">
                <div class="column is-half">
                    <p><strong>🏢 Name:</strong> <?= esc($ngo['name']) ?></p>
                    <p><strong>🏷️ Classification:</strong> <?= esc($ngo['classification']) ?></p>
                    <p><strong>📄 Source Agency:</strong> <?= esc($ngo['source_agency']) ?></p>
                </div>
                <div class="column is-half">
                    <p><strong>📍 Address:</strong>
                        <?= esc($ngo['street'] ?? '') ?>,
                        <?= esc($ngo['barangay'] ?? '') ?>,
                        <?= esc($ngo['municipality'] ?? '') ?>,
                        <?= esc($ngo['province'] ?? '') ?>,
                        <?= esc($ngo['country'] ?? '') ?> <?= esc($ngo['postal_code'] ?? '') ?>
                    </p>
                </div>
            </div>
        </div>

        <h4 class="title is-5 mt-5">Member</h4>
        <?php foreach ($ngo['members'] as $member): ?>
            <div class="box mb-4">
                <div class="columns">
                    <div class="column is-half">
                        <p><strong>👤 Name:</strong>
                            <?= esc($member['person']['salutation'] ?? '') ?>
                            <?= esc($member['person']['first_name'] ?? '') ?>
                            <?= esc($member['person']['middle_name'] ?? '') ?>
                            <?= esc($member['person']['last_name'] ?? '') ?>
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
            <a href="<?= site_url('/directory/business_sector') ?>" class="button is-primary">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>