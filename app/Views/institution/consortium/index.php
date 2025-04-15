<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-bottom: 10px;
        margin-top: -10px;
    }

    .title {
        font-size: 2.2rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .box {
        margin-top: 30px;
        padding: 20px;

    }

    .table-container {
        margin-top: 20px;
    }

    /* Table styling */
    .table th,
    .table td {
        padding: 12px 15px;
    }

    .table th {
        background-color: #f7f7f7;
    }

    .table .icon {
        margin-right: 5px;
    }

    .actions-btn {
        min-width: 120px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .has-text-centered {
        text-align: center;
    }
</style>

<div class="container">
    <div class="box mt-4">

        <div class="title has-text-centered">
            <h1>DOST VI Consortium</h1>
        </div>

        <!-- Buttons beside tabs -->
        <div class="buttons-container" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div class="control has-icons-left">
                <input id="search-input" class="input" type="text" placeholder="Search..." />
                <span class="icon is-left">
                    <i class="fas fa-search"></i>
                </span>
            </div>

            <a href="<?= base_url('institution/consortium/create') ?>" class="button is-primary">
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

        <!-- Table Section -->
        <div class="table-container">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Institution</th>
                        <th class="has-text-centered">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($consortiums)): ?>
                        <?php foreach ($consortiums as $consortium): ?>
                            <tr>
                                <td><?= esc($consortium->consortium_name ?? 'N/A') ?></td>
                                <td><?= esc($consortium->institution_name ?? '') ?></td>
                                <td class="has-text-centered">
                                    <div class="buttons is-flex is-justify-content-center is-align-items-center"
                                        style="gap: 10px;">
                                        <a href="<?= site_url('/institution/consortium/edit/' . $consortium->consortium_id) ?>"
                                            class="button is-info is-small actions-btn">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                            <span>Edit</span>
                                        </a>
                                        <a href="<?= site_url('institution/consortium/delete/' . $consortium->consortium_id); ?>"
                                            class="button is-danger is-small actions-btn"
                                            onclick="return confirm('Are you sure you want to delete this consortium?');">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="has-text-centered has-text-grey-light">
                                No regional offices found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this consortium?")) {
            window.location.href = "<?= base_url('institution/consortium/delete/') ?>" + id;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('search-input');
        const searchResultsContainer = document.getElementById('search-results');
        const tableBody = document.querySelector('.table tbody'); // Reference to the table body

        // Store original consortiums data in a JavaScript variable (or fetch from the server initially)
        const originalConsortiums = <?= json_encode($consortiums) ?>; // Pass PHP data to JS

        // Function to render original consortiums
        function renderOriginalTable() {
            tableBody.innerHTML = ''; // Clear the table body

            if (originalConsortiums.length > 0) {
                // Populate the table with original data
                originalConsortiums.forEach(consortium => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${consortium.consortium_name}</td>
                        <td>${consortium.institution_name}</td>
                        <td class="has-text-centered">
                            <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                <a href="/institution/consortium/edit/${consortium.consortium_id}" class="button is-info is-small actions-btn">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                    <span>Edit</span>
                                </a>
                                <a href="/institution/consortium/delete/${consortium.consortium_id}" class="button is-danger is-small actions-btn" onclick="return confirm('Are you sure you want to delete this consortium?');">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                // If no consortium data, show a message
                const noResultsRow = document.createElement('tr');
                noResultsRow.innerHTML = '<td colspan="3" class="has-text-centered">No consortiums found.</td>';
                tableBody.appendChild(noResultsRow);
            }
        }

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();

            if (query.length > 0) {
                // Show search results
                fetchSearchResults(query);
            } else {
                // Clear search results if no query
                searchResultsContainer.innerHTML = '';
                renderOriginalTable(); // Re-render the original table if search is cleared
            }
        });

        function fetchSearchResults(query) {
            // Fetch data based on search query using AJAX
            fetch("<?= base_url('institution/consortium/search') ?>?query=" + query)
                .then(response => response.json())
                .then(data => {
                    // Clear previous results in the table body
                    tableBody.innerHTML = '';

                    if (data.length > 0) {
                        // Display search results in the existing table
                        data.forEach(consortium => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${consortium.consortium_name}</td>
                                <td>${consortium.institution_name}</td>
                                <td class="has-text-centered">
                                    <div class="buttons is-flex is-justify-content-center is-align-items-center" style="gap: 10px;">
                                        <a href="/institution/consortium/edit/${consortium.consortium_id}" class="button is-info is-small actions-btn">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                            <span>Edit</span>
                                        </a>
                                        <a href="/institution/consortium/delete/${consortium.consortium_id}" class="button is-danger is-small actions-btn" onclick="return confirm('Are you sure you want to delete this consortium?');">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        // If no results, display a message
                        const noResultsRow = document.createElement('tr');
                        noResultsRow.innerHTML = '<td colspan="3" class="has-text-centered">No results found.</td>';
                        tableBody.appendChild(noResultsRow);
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        }

        // Initially render the full list of consortiums
        renderOriginalTable();
    });
</script>
</body>

<?= $this->endSection() ?>