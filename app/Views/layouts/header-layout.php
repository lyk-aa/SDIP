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

    <!-- Add Tom Select CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>


    <style>
        .tabs-container {
            display: flex;
            flex-direction: column;
        }

        .tab-content {
            padding: 24px;
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

</head>

<body>
    <div class="container">
        <nav class="breadcrumb is-flex is-justify-content-space-between is-align-items-center" aria-label="breadcrumbs">
            <div class="is-flex is-align-items-center">
                <ul class="breadcrumb-list mb-0">
                    <?php if (!isset($child_page)): ?>
                        <!-- Only Institution shown on the main page -->
                        <li><a href="<?= base_url('institution/home') ?>" aria-current="page">Institution</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('institution/home') ?>">Institution</a></li>
                        <li><a href="<?= current_url() ?>" aria-current="page"><?= esc($child_page) ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Back to Home Button on the right -->
            <div>
                <a href="<?= base_url('home') ?>" class="button is-link is-small is-primary">
                    <span class="icon mr-1"><i class="fas fa-circle-left"></i></span>
                    <span>Back to Home</span>
                </a>
            </div>
        </nav>


        <!-- Tabs Navigation -->
        <div class="tabs is-boxed">
            <ul id="tabs">
                <li>
                    <a href="<?= base_url('institution/home') ?>">
                        <span class="icon is-small"><i class="fas fa-list"></i></span>
                        <span>All</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('institution/research_centers/index') ?>">
                        <span class="icon is-small"><i class="fas fa-flask"></i></span>
                        <span>Research Centers</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('institution/consortium/index') ?>">
                        <span class="icon is-small"><i class="fas fa-users"></i></span>
                        <span>Consortium</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('institution/projects/index') ?>">
                        <span class="icon is-small"><i class="fas fa-project-diagram"></i></span>
                        <span>R&D Projects</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('institution/balik_scientist/index') ?>">
                        <span class="icon is-small"><i class="fas fa-user-tie"></i></span>
                        <span>Balik Scientists</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('institution/nrcp_members/index') ?>">
                        <span class="icon is-small"><i class="fas fa-address-book"></i></span>
                        <span>NRCP Members</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

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

    <main>
        <?= $this->renderSection('content') ?>
    </main>

</body>

</html>