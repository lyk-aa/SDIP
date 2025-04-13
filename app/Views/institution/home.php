<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-bottom: 10px;
        margin-top: -10px;
        flex-wrap: wrap;
    }

    .title {
        font-size: 2.2rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .box {
        margin-top: 30px;
    }

    .card {
        border-radius: 8px;
        margin-top: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-image {
        width: 100%;
        height: 220px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        overflow: hidden;
        border-bottom: 1px solid #eee;
        padding: 15px;
    }

    .card-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #000;
        margin-bottom: 6px;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .card-title:hover {
        color: #3273dc;
    }

    .card-description {
        font-size: 0.95rem;
        color: #4a4a4a;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .columns.is-multiline {
        align-items: stretch;
    }

    .kebab-menu {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }

    .button.is-white {
        background: none;
        border: none;
        box-shadow: none;
    }

    .button.is-white:hover {
        background: rgba(0, 0, 0, 0.05);
    }

    @media screen and (max-width: 768px) {

        .card-title,
        .card-description {
            font-size: 0.95rem;
        }

        .buttons-container {
            justify-content: center;
        }
    }
</style>

<body>
    <div class="container">
        <div class="box mt-4">

            <div class="title has-text-centered">
                <h1>Institutions</h1>
            </div>

            <!-- 🔔 Flash message for duplicate institution -->
            <?php if (session()->has('error')): ?>
                <div class="notification is-danger is-light">
                    <button class="delete"></button>
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <div class="buttons-container" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                
                <a href="<?= base_url('institution/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div id="search-results" style="margin-top: 20px;">
                <!-- Search results will be shown here -->
            </div>

            <div class="columns is-multiline" id="card-container">
                <?php foreach ($institutions as $institution): ?>
                    <div class="column is-one-fifth-desktop is-half-tablet is-full-mobile">
                        <div class="card">
                            <div class="card-image">
                                <img src="<?= !empty($institution['image']) ? base_url($institution['image']) : 'https://via.placeholder.com/200x150?text=No+Image' ?>"
                                    alt="Institution Image" class="preview-image">
                            </div>

                            <div class="dropdown is-right kebab-menu">
                                <div class="dropdown-trigger">
                                    <button class="button is-white is-small">
                                        <span class="icon is-small">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a href="<?= base_url('institution/edit/' . $institution['id']) ?>"
                                            class="dropdown-item">✏️ Edit</a>
                                        <a href="<?= base_url('institution/delete/' . $institution['id']) ?>"
                                            class="dropdown-item has-text-danger" onclick="confirmDelete(this)">🗑️
                                            Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content">
                                <p class="card-title">
                                    <a href="<?= base_url('institution/view/' . $institution['id']) ?>">
                                        <?= esc($institution['name']) ?> (<?= esc($institution['abbreviation']) ?>)
                                    </a>
                                </p>
                                <p class="card-description">
                                    <?= esc($institution['street']) ?>, <?= esc($institution['barangay']) ?>,
                                    <?= esc($institution['municipality']) ?>, <?= esc($institution['province']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

<script>
    function confirmDelete(index) {
        if (confirm("Are you sure you want to delete?")) {
            window.location.href = index.getAttribute("href");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Dropdown toggle
        document.querySelectorAll('.dropdown-trigger button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('is-active');
            });
        });

        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('is-active'));
        });

        // Flash message close
        document.querySelectorAll('.notification .delete').forEach(($delete) => {
            const $notification = $delete.parentNode;
            $delete.addEventListener('click', () => {
                $notification.remove();
            });
        });
    });

    // 🔍 Dynamic Search
    const searchInput = document.getElementById('search-input');
    const cardContainer = document.getElementById('card-container');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length > 0) {
            fetch(`<?= base_url('institution/search') ?>?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    let resultsHtml = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            resultsHtml += `
                                <div class="column is-one-fifth-desktop is-half-tablet is-full-mobile">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="${item.image ? `<?= base_url() ?>/${item.image}` : 'https://via.placeholder.com/200x150?text=No+Image'}"
                                                 alt="Institution Image" class="preview-image">
                                        </div>
                                        <div class="card-content">
                                            <p class="card-title">
                                                <a href="<?= base_url('institution/view/') ?>${item.id}">
                                                    ${item.name} (${item.abbreviation})
                                                </a>
                                            </p>
                                            <p class="card-description">
                                                ${item.street}, ${item.barangay}, ${item.municipality}, ${item.province}
                                            </p>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        resultsHtml = '<p>No results found</p>';
                    }

                    searchResults.innerHTML = `<div class="columns is-multiline">${resultsHtml}</div>`;
                    cardContainer.style.display = 'none'; // hide original cards
                })
                .catch(error => {
                    console.error('Search Error:', error);
                });
        } else {
            searchResults.innerHTML = '';
            cardContainer.style.display = 'flex'; // show original cards again
        }
    });
</script>


<?= $this->endSection() ?>