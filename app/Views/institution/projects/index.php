<?= $this->extend('layouts/header-layout') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #fff;
    }

    .section {
        padding: 40px;
    }

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
    }

    .custom-box {
        background: white;
        padding: 0px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }

    .completed {
        background-color: #28a745;
        color: white;
    }

    .pending {
        background-color: #ff8c00;
        color: white;
    }

    .ongoing {
        background-color: #ffc107;
        color: white;
    }

    .dropdown-trigger {
        margin-top: 36px;
    }

    .description-text {
        max-width: 400px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
    }
</style>

<body>
    <div class="container">
        <div class="box mt-4">
            <div class="title has-text-centered">
                <h1>Research Projects</h1>
            </div>

            <div class="buttons-container" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="control has-icons-left">
                    <input id="search-input" class="input" type="text" placeholder="Search..." />
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <a href="<?= base_url('institution/projects/create') ?>" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Create New</span>
                </a>

                <button class="button is-light">
                    <span class="icon"><i class="fas fa-download"></i></span>
                </button>
            </div>

            <div id="project-list">
                <p>Completed / Pending / Ongoing</p>

                <?php if (!empty($research_projects)): ?>
                    <?php foreach ($research_projects as $project): ?>
                        <div class="box is-flex is-justify-content-space-between is-align-items-center" style="cursor: pointer;"
                            onclick="window.location.href='<?= base_url('institution/projects/view/' . $project['id']) ?>'">
                            <div>
                                <strong><?= esc($project['name']) ?></strong>
                                <p class="description-text"><?= esc($project['description']) ?></p>
                                <?php
                                $statusClass = '';
                                $statusIcon = '';
                                if (strtolower(trim($project['status'])) == 'completed') {
                                    $statusClass = 'completed';
                                    $statusIcon = '<i class="fas fa-check-circle"></i>';
                                } elseif (strtolower(trim($project['status'])) == 'pending') {
                                    $statusClass = 'pending';
                                    $statusIcon = '<i class="fas fa-clock"></i>';
                                } elseif (strtolower(trim($project['status'])) == 'ongoing') {
                                    $statusClass = 'ongoing';
                                    $statusIcon = '<i class="fas fa-spinner"></i>';
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <?= $statusIcon ?> <?= strtoupper($project['status']) ?>
                                </span>
                            </div>
                            <div class="is-flex is-align-items-center" onclick="event.stopPropagation();">
                                <div class="dropdown is-hoverable is-right">
                                    <div class="dropdown-trigger">
                                        <button class="button is-white is-small">
                                            <span class="icon is-small">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-content">
                                            <a href="<?= base_url('institution/projects/edit/' . $project['id']) ?>"
                                                class="dropdown-item edit-button">Edit</a>
                                            <a href="<?= base_url('institution/projects/delete/' . $project['id']) ?>"
                                                class="dropdown-item has-text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No research projects found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Add event listener to search input field
        document.getElementById('search-input').addEventListener('input', function () {
            searchProjects();
        });

        function searchProjects() {
            const searchQuery = document.getElementById('search-input').value;
            if (searchQuery.length < 3) {
                // Optionally, don't search if the query is too short (e.g., less than 3 characters)
                return;
            }

            console.log('Searching for:', searchQuery);

            // Create a FormData object to send the search query
            let formData = new FormData();
            formData.append('search_query', searchQuery);

            // Make an AJAX request
            fetch('<?= base_url('institution/projects/search') ?>', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Search results:', data);

                    const projectContainer = document.getElementById('project-list');
                    projectContainer.innerHTML = ''; // Clear the container

                    if (data.projects && data.projects.length > 0) {
                        data.projects.forEach(project => {
                            const projectElement = `
                                <div class="box is-flex is-justify-content-space-between is-align-items-center" style="cursor: pointer;" onclick="window.location.href='<?= base_url('institution/projects/view/') ?>${project.id}'">
                                    <div>
                                        <strong>${project.name}</strong>
                                        <p class="description-text">${project.description}</p>
                                        <span class="status-badge ${project.statusClass}">
                                            ${project.statusIcon} ${project.status}
                                        </span>
                                    </div>
                                    <div class="is-flex is-align-items-center" onclick="event.stopPropagation();">
                                        <div class="dropdown is-hoverable is-right">
                                            <div class="dropdown-trigger">
                                                <button class="button is-white is-small">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-content">
                                                    <a href="<?= base_url('institution/projects/edit/') ?>${project.id}" class="dropdown-item edit-button">Edit</a>
                                                    <a href="<?= base_url('institution/projects/delete/') ?>${project.id}" class="dropdown-item has-text-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            projectContainer.innerHTML += projectElement;
                        });
                    } else {
                        projectContainer.innerHTML = '<p>No research projects found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while searching.');
                });
        }
    </script>
</body>

<?= $this->endSection() ?>
