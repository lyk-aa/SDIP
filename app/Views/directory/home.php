<?= $this->extend('layouts/directory-layout') ?>

<?= $this->section('content') ?>

<section class="section mt-1">
    <div class="container">

        <div class="box">
            <div class=" is-flex is-justify-content-space-between is-align-items-center mb-3">
                <h3 class="title is-4 mb-0">Stakeholders</h3>
                <a href="<?= site_url('directory/home/export') ?>" class="button is-link is-outlined">
                    <span class="icon">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    <span>Export to Excel</span>
                </a>
            </div>
            <div id="main" style="width: 100%; height: 400px;"></div>
        </div>

        <div class="table-container">
            <h3 class="title is-4">Recently Added Stakeholders</h3>
            <table id="recentTable" class="table is-striped is-hoverable is-fullwidth is-bordered">
                <thead class="has-background-link-light has-text-white">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentStakeholders as $stakeholder): ?>
                        <tr>
                            <td><?= esc($stakeholder['name']) ?></td>
                            <td><?= esc($stakeholder['category']) ?></td>
                            <td><?= esc($stakeholder['address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bulma/js/bulma.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bulma-datatables@2.1.1/dist/js/bulma-datatables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        bulmaDataTable.attach('#recentTable', {
            perPage: 10,
            perPageSelect: false,
            sortable: true
        });
    });
</script>

<style>
    .box {
        margin-top: 4px;

    }
</style>

<!-- ECharts Pie Chart -->
<script>
    var chartDom = document.getElementById('main');
    var myChart = echarts.init(chartDom);

    var option = {
        title: {
            text: 'Stakeholder Category Breakdown',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [{
            name: 'Categories',
            type: 'pie',
            radius: '70%',
            label: {
                show: true,
                position: 'inside',
                formatter: '{c}',
                fontSize: 14
            },
            data: [
                <?php foreach ($stakeholderCategories as $category): ?>
                                                                                                                                                                                                                                                                                                        { value: <?= $category['count'] ?>, name: '<?= esc($category['category']) ?>' },
                <?php endforeach; ?>
            ],
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }]
    };

    myChart.setOption(option);
</script>
<?= $this->endSection() ?>