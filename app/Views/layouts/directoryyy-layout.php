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

    <!-- /* Style for the map container */ -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bulma-list@0.1.5/dist/bulma-list.min.js"></script>

</head>

<body>

    <!-- Header Section -->
    <header class="navbar is-light">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="#">
                    <img src="/images/logo.png" alt="Logo">
                </a>
                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <!-- Adjusted Navbar Icons -->
            <div id="navbarMenu" class="navbar-menu">
                <div class="navbar-end">
                    <a href="#" class="navbar-item">
                        <span class="icon icon-circle">
                            <i class="fa-regular fa-bell"></i>
                        </span>
                    </a>
                    <a href="#" class="navbar-item">
                        <span class="icon icon-circle">
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Button and Search Section -->
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul class="breadcrumb-list">
                    <li class=""><a href="<?= base_url('home') ?>">Home</a></li>
                    <li><a href="<?= base_url('directory/home') ?>">Directory</a></li>
                    <li><a href="<?= base_url('institution/home') ?>" aria-current="page">Institution</a></li>
                </ul>
            </nav>
        </div>
        <div class="container">
            <div class="button-container">
                <button class="custom-button">+ Create New</button>
                <button class="custom-button">+ Add New</button>
                <input class="custom-search" type="text" placeholder="Search...">
                <button class="custom-button custom-search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <main>
        <section class="section">
            <!-- category -->
            <div class="field">
                <label class="label">Select Category</label>
                <div class="control">
                    <div class="select">
                        <select id="categoryDropdown" onchange="navigateToCategory()">
                            <option value="">Select Category</option>
                            <option value="<?= base_url('directory/regional_offices') ?>">Regional Offices</option>
                            <option value="<?= base_url('directory/nga') ?>">NGA</option>
                            <option value="<?= base_url('directory/academes') ?>">Academes</option>
                            <option value="<?= base_url('directory/lgus') ?>">LGUs</option>
                            <option value="<?= base_url('directory/sucs') ?>">SUCs</option>
                            <option value="<?= base_url('directory/business_sector') ?>">Business Sector</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>
        <?= $this->renderSection('content') ?>
    </main>

    <script src="    https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bulma.js"></script>

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