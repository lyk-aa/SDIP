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
    <link rel="stylesheet" href="/css/style.css">



    <!-- Style for the map container -->
    <style>
        #map {
            height: max-content;
            width: max-content;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>


<body>


    <!-- Header Section -->
    <!-- <header class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="#">
                    <img src="<?= base_url('images/logo.png') ?>" alt="Logo">


                </a>
                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div> -->


    <!-- Navbar Menu -->
    <!-- <div id="navbarMenu" class="navbar-menu">
                <div class="navbar-end">
                    <a href="#" class="navbar-item has-tooltip" data-tooltip="Notifications">
                        <span class="icon icon-circle">
                            <i class="fa-regular fa-bell"></i>
                        </span>
                    </a>
                    <a href="#" class="navbar-item has-tooltip" data-tooltip="Profile">
                        <span class="icon icon-circle">
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </a>
                </div>
            </div>
    </header> -->


    <!-- Breadcrumb -->
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul class="breadcrumb-list">
                <li class=""><a href="<?= base_url('home') ?>">Home</a></li>
                <li><a href="<?= base_url('directory/home') ?>">Directory</a></li>
                <li><a href="<?= base_url('institution/home') ?>" aria-current="page">Institution</a></li>
            </ul>
        </nav>


        <!-- <div class="columns is-vcentered is-mobile">
            <div class="tags are-medium is-flex is-flex-wrap-wrap is-justify-content-center">
                <a href="<?= base_url('directory/home') ?>" class="tag category-tag">Dashboard</a>
                <a href="<?= base_url('directory/regional_offices') ?>" class="tag category-tag">Regional Offices</a>
                <a href="<?= base_url('directory/nga') ?>" class="tag category-tag">NGA</a>
                <a href="<?= base_url('directory/academes') ?>" class="tag category-tag">Academes</a>
                <a href="<?= base_url('directory/lgus') ?>" class="tag category-tag">LGUs</a>
                <a href="<?= base_url('directory/business_sector') ?>" class="tag category-tag">NGO Business Sector</a>
                <a href="<?= base_url(relativePath: 'directory/wide_contacts') ?>" class="tag category-tag">DOST Wide-Contacts</a>
                <a href="<?= base_url('directory/table') ?>" class="tag category-tag">Table</a>
            </div> -->

        <div class="tabs is-boxed">
            <ul id="tabs">
                <li>
                    <a href="<?= base_url('directory/home') ?>">
                        <span class="icon is-small"><i class="fas fa-home"></i></span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/regional_offices') ?>">
                        <span class="icon is-small"><i class="fas fa-map-marked-alt"></i></span>
                        <span>Regional Offices</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/nga') ?>">
                        <span class="icon is-small"><i class="fas fa-landmark"></i></span>
                        <span>NGAs</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/academes') ?>">
                        <span class="icon is-small"><i class="fas fa-graduation-cap"></i></span>
                        <span>Academes</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/lgus') ?>">
                        <span class="icon is-small"><i class="fas fa-city"></i></span>
                        <span>LGUs</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/business_sector') ?>">
                        <span class="icon is-small"><i class="fas fa-handshake"></i></span>
                        <span>NGOs</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('directory/wide_contacts') ?>">
                        <span class="icon is-small"><i class="fas fa-address-book"></i></span>
                        <span>DOST Wide-Contacts</span>
                    </a>
                </li>
            </ul>
        </div>


        <!-- </div> -->


        <style>
            .tabs-container {
                display: flex;
                flex-direction: column;
            }

            .tab-content {
                padding: 50px;
                border-top: 2px solid #dbdbdb;
                margin-top: 12px;
            }

            .tabs {
                margin-top: 25px;
                margin-bottom: 10px;
            }

            .tabs ul {
                margin-top: 15px;
            }

            .buttons-container {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-bottom: 10px;
            }

            .title {
                font-size: 2rem;
                margin-top: 60px;
                margin-bottom: 30px;
            }
        </style>


        <!-- Buttons and Search -->
        <div class="column is-flex is-justify-content-flex-end is-align-items-center">
            <!-- <a href="<?= base_url('directory/regional_offices/create') ?>">
                    <button class="button is-primary is-outlined">
                        <span class="icon no-bg">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Create New</span>
                    </button>
                </a> -->


            <!-- <div class="control has-icons-left mx-2">
                    <input class="input" type="text" placeholder="Search">
                    <span class="icon is-small is-left no-bg">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <button class="button is-outlined">Filter</button> -->
        </div>
    </div>


    <main>
        <?= $this->renderSection('content') ?>
    </main>
    </div>



    <script>
        function navigateToCategory() {
            var categoryUrl = document.getElementById("categoryDropdown").value;
            if (categoryUrl) {
                window.location.href = categoryUrl;
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const currentUrl = window.location.href;
            const tabs = document.querySelectorAll("#tabs li");

            tabs.forEach(tab => {
                const link = tab.querySelector("a");
                if (link && currentUrl.includes(link.getAttribute("href"))) {
                    tab.classList.add("is-active");
                } else {
                    tab.classList.remove("is-active");
                }
            });
        });
    </script>
</body>


</html>