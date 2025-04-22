<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOST SDIP Web System</title>

    <!-- Bulma CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/styles.css">

    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="breadcrumb is-flex is-justify-content-space-between is-align-items-center" aria-label="breadcrumbs">
            <!-- Breadcrumb Links -->
            <ul class="breadcrumb-list mb-0">
                <?php if (!isset($child_page)): ?>
                    <!-- Main directory page -->
                    <li><a href="<?= base_url('directory/home') ?>" aria-current="page">Directory</a></li>
                <?php else: ?>
                    <!-- Subpages -->
                    <li><a href="<?= base_url('directory/home') ?>">Directory</a></li>
                    <li><a href="<?= current_url() ?>" aria-current="page"><?= esc($child_page) ?></a></li>
                <?php endif; ?>
            </ul>

            <!-- Back to Home Button -->
            <div>
                <a href="<?= base_url('home') ?>" class="button is-link is-small is-primary">
                    <span class="icon mr-1"><i class="fas fa-circle-left"></i></span>
                    <span>Back to Home</span>
                </a>
            </div>
        </nav>

        <div class="columns is-vcentered is-mobile px-4 py-3">
            <!-- Dropdown -->
            <div class="field mr-4">
                <label class="label has-text-weight-semibold">Select Category</label>
                <div class="control">
                    <div class="select is-semi-medium is-fullwidth">
                        <select id="categoryDropdown" onchange="navigateToCategory()">
                            <option value="<?= base_url('directory/home') ?>">All</option>
                            <option value="<?= base_url('directory/regional_offices') ?>">Regional Offices</option>
                            <option value="<?= base_url('directory/nga') ?>">NGA</option>
                            <option value="<?= base_url('directory/academes') ?>">Academes</option>
                            <option value="<?= base_url('directory/lgus') ?>">LGUs</option>
                            <option value="<?= base_url('directory/business_sector') ?>">NGO Business Sector</option>
                            <option value="<?= base_url('directory/wide_contacts') ?>">DOST Wide-Contacts</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Buttons and Search -->
            <div class="column is-flex is-justify-content-flex-end is-align-items-center">
                <div class="control has-icons-left mx-2">
                    <input class="input" type="text" placeholder="Search">
                    <span class="icon is-small is-left no-bg">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <button class="button is-outlined">Filter</button>
            </div>
        </div> <!-- Properly closed main layout div -->
    </div>
    <!-- Main Content Section -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        function navigateToCategory() {
            var categoryUrl = document.getElementById("categoryDropdown").value;
            if (categoryUrl) {
                window.location.href = categoryUrl;
            }
        }
    </script>

</body>

</html>