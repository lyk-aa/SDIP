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
    .table th, .table td {
      border: 1px solid #000;
      text-align: center;
      vertical-align: middle;
    }
    @media print {
      .no-print { display: none; }
      .page-break { page-break-before: always; }
    }
  </style>
</head>
<body class="p-5">

  <div class="box">
    <div class="has-text-centered mb-4">
      <h1 class="title is-4"><strong><?= esc($institution['name']) ?></strong></h1>
    </div>

    <!-- Institution Details -->
    <div>
      <h2>Institution: <?= esc($institution['name']) ?></h2>
      <div class="columns">
        <div class="column is-6">
          <p><strong>Type:</strong> <?= esc($institution['type']) ?></p>
          <p><strong>Person Name:</strong> <?= esc($institution['person_name']) ?></p>
          <p><strong>Designation:</strong> <?= esc($institution['designation']) ?></p>
        </div>
        <div class="column is-6">
          <p><strong>Address:</strong>
            <?= esc($institution['street']) ?>,
            <?= esc($institution['barangay']) ?>,
            <?= esc($institution['municipality']) ?>,
            <?= esc($institution['province']) ?>,
            <?= esc($institution['country']) ?>
          </p>
          <p><strong>Telephone:</strong> <?= esc($institution['telephone_num']) ?></p>
          <p><strong>Email:</strong> <?= esc($institution['email_address']) ?></p>
        </div>
      </div>
    </div>

    <!-- Consortium Membership -->
    <div class="section-title">Consortium Membership</div>
    <ul class="ml-4 mt-2">
      <?php foreach ($consortiums as $c): ?>
        <li><?= esc($c['name']) ?></li>
      <?php endforeach; ?>
    </ul>

    <!-- Balik Scientist Engaged -->
    <div class="section-title">Balik Scientist Engaged</div>
    <ul class="ml-4 mt-2">
      <?php foreach ($balik_scientists as $bs): ?>
        <li><?= esc($bs['name']) ?></li>
      <?php endforeach; ?>
    </ul>

    <!-- Ongoing Research Projects -->
    <div class="section-title">Ongoing Research Projects</div>
    <table class="table is-bordered is-fullwidth is-size-7">
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
      <tbody>
        <?php foreach ($ongoing_projects as $proj): ?>
          <tr>
            <td><?= esc($proj['sector']) ?></td>
            <td><?= esc($proj['title']) ?></td>
            <td><?= esc($proj['project_objectives']) ?></td>
            <td><?= esc($proj['duration']) ?></td>
            <td><?= esc($proj['project_leader']) ?></td>
            <td><?= esc($proj['approved_amount']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Completed Research Projects -->
    <div class="section-title">Completed Research Projects</div>
    <table class="table is-bordered is-fullwidth is-size-7">
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
      <tbody>
        <?php foreach ($completed_projects as $proj): ?>
          <tr>
            <td><?= esc($proj['sector']) ?></td>
            <td><?= esc($proj['title']) ?></td>
            <td><?= esc($proj['project_objectives']) ?></td>
            <td><?= esc($proj['duration']) ?></td>
            <td><?= esc($proj['project_leader']) ?></td>
            <td><?= esc($proj['approved_amount']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="has-text-centered mt-4 no-print">
      <button class="button is-primary" onclick="window.print()">Print</button>
    </div>

    <div class="has-text-centered mt-4 no-print">
      <a class="button is-light" href="<?= base_url('institution') ?>">Go Back</a>
    </div>

  </div>
</body>
</html>
