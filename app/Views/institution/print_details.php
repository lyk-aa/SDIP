<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Preview - R&D</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .header {
      background-color: #1f1f6f;
      color: white;
      padding: 10px;
      font-weight: bold;
      font-size: 1.2rem;
    }
    .section-title {
      margin-top: 1.5rem;
      font-weight: bold;
      background-color: #1f1f6f;
      color: white;
      padding: 5px 10px;
    }
    .table th,
    .table td {
      border: 1px solid #000;
      text-align: center;
      vertical-align: middle;
    }
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<<<<<<< HEAD
<body class="p-5">

  <div class="box">
    <div class="has-text-centered mb-4">
      <h1 class="title is-4"><strong id="institution-name">Institution Name</strong></h1>
    </div>

    <!-- Content Sections -->
    <div class="section-title">R&D Agenda/Flagship Program/Specialization</div>
    <ul id="rd-agenda" class="ml-4 mt-2"></ul>

    <div class="section-title">Consortium Membership</div>
    <ul id="consortium" class="ml-4 mt-2"></ul>

    <div class="section-title">Research, Development, and Innovation Centers</div>
    <ul id="rd-centers" class="ml-4 mt-2"></ul>

    <div class="section-title">R&D PROJECTS</div>

    <h2 class="subtitle is-6 mt-4"><strong>ONGOING PROJECTS</strong></h2>
    <table id="ongoing-projects" class="table is-bordered is-fullwidth is-size-7">
      <thead>
        <tr>
          <th>Sector</th>
          <th>Title</th>
          <th>Project Objectives</th>
          <th>Duration</th>
          <th>Project Leader</th>
          <th>Approved Amount</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <h2 class="subtitle is-6 mt-4"><strong>COMPLETED PROJECTS</strong></h2>
    <table id="completed-projects" class="table is-bordered is-fullwidth is-size-7">
      <thead>
        <tr>
          <th>Sector</th>
          <th>Title</th>
          <th>Project Objectives</th>
          <th>Duration</th>
          <th>Project Leader</th>
          <th>Approved Amount</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <div class="section-title">SCIENCE FOR CHANGE PROGRAMS AVAILED</div>
    <ul id="science-programs" class="ml-4 mt-2"></ul>
  </div>

  <div class="has-text-centered mt-4 no-print">
    <button class="button is-primary" onclick="window.print()">Print</button>
  </div>

  <div class="has-text-centered mt-4 no-print">
    <button onclick="window.location.href='index.html'">Go Back to Select Institution</button>
  </div>

  <script>
    const institutions = {
      1: {
        name: 'WEST VISAYAS STATE UNIVERSITY',
        rdAgenda: ['ICT', 'Health'],
        consortium: ['Western Visayas Health Research and Development Consortium'],
        rdCenters: [
          'Center for Chemical Biology and Biotechnology (C2B2)',
          'Center for Natural Drug Discovery and Development (CND3)',
          'Center for Advance New Materials, Engineering and Emerging Technologies (CANMEET)',
          'Nuclear Magnetic Resonance (NMR) Laboratory',
          'Center for Informatics (CFI)'
        ],
        ongoingProjects: [
          { sector: 'Health', title: 'Health Project 1', objectives: 'Objective 1', duration: '2024-2026', leader: 'Leader A', amount: '$100,000' },
          { sector: 'IEET', title: 'IEET Project', objectives: 'Objective 2', duration: '2023-2025', leader: 'Leader B', amount: '$200,000' }
        ],
        completedProjects: [
          { sector: 'AANR', title: 'AANR Project 1', objectives: 'Objective 1', duration: '2021-2023', leader: 'Leader C', amount: '$150,000' }
        ],
        sciencePrograms: ['CRADLE', 'NICER', 'BIST', 'RDLEAD']
      },
      2: {
        name: 'SOME OTHER UNIVERSITY',
        rdAgenda: ['Technology', 'Agriculture'],
        consortium: ['Some Consortium'],
        rdCenters: ['Agricultural Research Center', 'Technology Innovation Center'],
        ongoingProjects: [
          { sector: 'Agriculture', title: 'AgriTech Project', objectives: 'Objective 1', duration: '2024-2027', leader: 'Leader X', amount: '$300,000' }
        ],
        completedProjects: [
          { sector: 'Technology', title: 'Tech Innovate', objectives: 'Objective 2', duration: '2022-2024', leader: 'Leader Y', amount: '$250,000' }
        ],
        sciencePrograms: ['SIPAG', 'BIST', 'RDLEAD']
      }
    };

    function loadInstitutionData() {
      const urlParams = new URLSearchParams(window.location.search);
      const institutionId = urlParams.get('institution');
      const institution = institutions[institutionId];

      document.getElementById('institution-name').innerText = institution.name;

      // Reset and Load R&D Agenda
      const rdAgendaList = document.getElementById('rd-agenda');
      rdAgendaList.innerHTML = '';
      institution.rdAgenda.forEach(item => {
        const li = document.createElement('li');
        li.innerText = item;
        rdAgendaList.appendChild(li);
      });

      // Reset and Load Consortium
      const consortiumList = document.getElementById('consortium');
      consortiumList.innerHTML = '';
      institution.consortium.forEach(item => {
        const li = document.createElement('li');
        li.innerText = item;
        consortiumList.appendChild(li);
      });

      // Reset and Load Research Centers
      const rdCentersList = document.getElementById('rd-centers');
      rdCentersList.innerHTML = '';
      institution.rdCenters.forEach(item => {
        const li = document.createElement('li');
        li.innerText = item;
        rdCentersList.appendChild(li);
      });

      // Reset and Load Ongoing Projects
      const ongoingTableBody = document.getElementById('ongoing-projects').getElementsByTagName('tbody')[0];
      ongoingTableBody.innerHTML = '';
      institution.ongoingProjects.forEach(project => {
        const row = ongoingTableBody.insertRow();
        row.innerHTML = `
          <td>${project.sector}</td>
          <td>${project.title}</td>
          <td>${project.objectives}</td>
          <td>${project.duration}</td>
          <td>${project.leader}</td>
          <td>${project.amount}</td>
        `;
      });

      // Reset and Load Completed Projects
      const completedTableBody = document.getElementById('completed-projects').getElementsByTagName('tbody')[0];
      completedTableBody.innerHTML = '';
      institution.completedProjects.forEach(project => {
        const row = completedTableBody.insertRow();
        row.innerHTML = `
          <td>${project.sector}</td>
          <td>${project.title}</td>
          <td>${project.objectives}</td>
          <td>${project.duration}</td>
          <td>${project.leader}</td>
          <td>${project.amount}</td>
        `;
      });

      // Reset and Load Science Programs
      const scienceProgramsList = document.getElementById('science-programs');
      scienceProgramsList.innerHTML = '';
      institution.sciencePrograms.forEach(item => {
        const li = document.createElement('li');
        li.innerText = item;
        scienceProgramsList.appendChild(li);
      });
    }

    window.onload = loadInstitutionData;
  </script>
=======
<body>
    <!-- Institution Details -->
    <div id="details">
        <h2>Institution: <?= esc($institution['name']) ?></h2>
        <div class="columns">
            <div class="column is-6">
                <p><strong>Type:</strong> <?= esc($institution['type']) ?></p>
                <p><strong>Person Name:</strong> <?= esc($institution['person_name']) ?></p>
                <p><strong>Designation:</strong> <?= esc($institution['designation']) ?></p>
            </div>
            <div class="column is-6">
                <p><strong>Address:</strong> <?= esc($institution['street']) ?>,
                    <?= esc($institution['barangay']) ?>, <?= esc($institution['municipality']) ?>,
                    <?= esc($institution['province']) ?>, <?= esc($institution['country']) ?>
                </p>
                <p><strong>Telephone:</strong> <?= esc($institution['telephone_num']) ?></p>
                <p><strong>Email:</strong> <?= esc($institution['email_address']) ?></p>
            </div>
        </div>
    </div>

    <!-- Ongoing Projects -->
    <div id="projects" class="section-content">
        <h3 class="title is-5"><i class="fas fa-project-diagram mr-2"></i> Ongoing Research Projects
        </h3>
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th class="narrow-column">Sector</th>
                    <th class="title-column">Title</th>
                    <th class="wide-column">Research Objectives</th>
                    <th class="small-column">Duration</th>
                    <th class="narrow-column">Project Leader</th>
                    <th class="narrow-column">Approved Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ongoing_research_projects)): ?>
                    <?php foreach ($ongoing_research_projects as $project): ?>
                        <tr>
                            <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                            <td><?= esc($project['research_project_name'] ?? 'N/A') ?></td>
                            <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                            <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                            <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                            <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="has-text-centered has-text-grey-light">
                            No ongoing projects
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Completed Projects -->
    <div id="completed_projects" class="section-content">
        <h3 class="title is-5"><i class="fas fa-project-diagram mr-2"></i> Completed Research
            Projects</h3>
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th class="narrow-column">Sector</th>
                    <th class="title-column">Title</th>
                    <th class="wide-column">Research Objectives</th>
                    <th class="small-column">Duration</th>
                    <th class="narrow-column">Project Leader</th>
                    <th class="narrow-column">Approved Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($completed_research_projects)): ?>
                    <?php foreach ($completed_research_projects as $project): ?>
                        <tr>
                            <td><?= esc($project['sector'] ?? 'N/A') ?></td>
                            <td><?= esc($project['research_project_name'] ?? 'N/A') ?></td>
                            <td><?= nl2br(esc($project['project_objectives'] ?? 'N/A')) ?></td>
                            <td><?= esc($project['duration'] ?? 'N/A') ?></td>
                            <td><?= esc($project['project_leader'] ?? 'N/A') ?></td>
                            <td>₱<?= esc($project['approved_amount'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="has-text-centered has-text-grey-light">
                            No completed projects
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
>>>>>>> eacbc26ec0f37f99d182cba930a5f65fdac7e06f
</body>
</html>
