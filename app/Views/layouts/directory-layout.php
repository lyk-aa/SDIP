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
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul class="breadcrumb-list">
                <li class=""><a href="<?= base_url('home') ?>">Home</a></li>
                <li><a href="<?= base_url('directory/home') ?>">Directory</a></li>
                <li><a href="<?= base_url('institution/home') ?>" aria-current="page">Institution</a></li>
            </ul>
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
