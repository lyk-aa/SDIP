<?= $this->extend('layouts/header-layout') ?>

<?= $this->section('content') ?>

<style>
    .title {
        font-size: 2.2rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }
</style>

<div class="container">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="notification is-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if ($project): ?>
        <div class="card">
            <div class="card-content">
                <div class="title has-text-centered">
                    <h1>Research Project</h1>
                </div>
                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <th class="is-half">Field</th>
                            <th class="is-half">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Research Name</strong></td>
                            <td><?= esc($project['research_name']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td><span
                                    class="tag is-medium <?= getStatusClass($project['status']) ?>"><?= esc($project['status']) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Description</strong></td>
                            <td><?= esc($project['description']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Sector</strong></td>
                            <td><?= esc($project['sector']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Duration</strong></td>
                            <td><?= esc($project['duration']) ?> months</td>
                        </tr>
                        <tr>
                            <td><strong>Project Leader</strong></td>
                            <td><?= esc($project['project_leader']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Objectives</strong></td>
                            <td>
                                <?php
                                // Automatically break lines on periods
                                $objectives = esc($project['project_objectives']);
                                $objectives = nl2br(implode('.<br>', explode('.', $objectives)));
                                echo $objectives;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Approved Amount</strong></td>
                            <td>$<?= number_format($project['approved_amount'], 2) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Stakeholder Name</strong></td>
                            <td><?= esc($project['stakeholder_name']) ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Back Button aligned to the right -->
                <!-- Back Button aligned to the right with icon gap -->
                <div class="has-text-right" style="margin-top: 20px;">
                    <a href="<?= site_url('/institution/projects/index') ?>" class="button is-link is-small">
                        <span class="icon mr-1"><i class="fas fa-arrow-left"></i></span>
                        <span>Back to Projects</span>
                    </a>
                </div>


            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?php
// Helper function to assign a class based on status
function getStatusClass($status)
{
    switch (strtolower(trim($status))) {
        case 'completed':
            return 'is-success';
        case 'pending':
            return 'is-warning';
        case 'ongoing':
            return 'is-info';
        default:
            return '';
    }
}
?>