<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partials/head.php') ?>
    <title><?= $title ?? 'Dashboard' ?></title>
    <style>
        /* Memberi sedikit ruang agar chart tidak terlalu mepet */
        #chart-container {
            position: relative;
            margin: auto;
            height: 350px;
            width: 100%;
            max-width: 350px;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php $this->load->view('partials/sidebar.php') ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php $this->load->view('partials/topbar.php') ?>
                <div class="container-fluid">

                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title ?? '' ?></h1>
                        </div>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i><?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                    <?php elseif ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i><?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <?php
                        $role = $this->session->login['role'];

                        // Kartu Omset (selalu ada)
                        $omset_card = [
                            'title' => 'Total Omset', // Mengubah teks
                            'value' => 'Rp ' . number_format($omset_bulanan ?? 0, 0, ',', '.'),
                            'icon' => 'dollar-sign',
                            'color' => 'primary'
                        ];

                        // Kartu lain berdasarkan role
                        if ($role == 'admin') {
                            $cards = [
                                ['title' => 'Total Pengeluaran', 'value' => $jumlah_pengeluaran ?? 0, 'icon' => 'file-invoice', 'color' => 'success'], // Mengubah teks
                                ['title' => 'Total Penerimaan', 'value' => $jumlah_penerimaan ?? 0, 'icon' => 'dolly-flatbed', 'color' => 'info'], // Mengubah teks
                                ['title' => 'Total Jenis Barang', 'value' => $jumlah_barang ?? 0, 'icon' => 'box', 'color' => 'warning'],
                            ];
                        } else { // Kartu untuk petugas
                            $cards = [
                                ['title' => 'Total Pengeluaran', 'value' => $jumlah_pengeluaran ?? 0, 'icon' => 'file-invoice', 'color' => 'success'], // Mengubah teks
                                ['title' => 'Total Jenis Barang', 'value' => $jumlah_barang ?? 0, 'icon' => 'box', 'color' => 'warning'],
                                ['title' => 'Total Customer', 'value' => $jumlah_customer ?? 0, 'icon' => 'users', 'color' => 'info'],
                            ];
                        }
                        // Menambahkan kartu Omset ke paling depan
                        array_unshift($cards, $omset_card);

                        // Loop untuk menampilkan semua kartu
                        foreach ($cards as $card): ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-<?= $card['color'] ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div
                                                    class="text-xs font-weight-bold text-<?= $card['color'] ?> text-uppercase mb-1">
                                                    <?= $card['title'] ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $card['value'] ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-<?= $card['icon'] ?> fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($this->session->login['role'] == 'admin'): ?>
                        <div class="row">
                            <div class="col-lg-7 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Barang Terlaris</h6> </div>
                                    <div class="card-body">
                                        <div id="chart-container">
                                            <canvas id="barangTerlarisChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Info Login</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $user = $this->session->login;
                                        $user_fields = [
                                            'Nama' => $user['nama'],
                                            'Username' => $user['username'],
                                            'Role' => ucwords($user['role']),
                                            'Jam Login' => $user['jam_masuk'],
                                        ];
                                        foreach ($user_fields as $label => $value): ?>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted small"><?= $label ?></span>
                                                <span class="font-weight-bold"><?= $value ?></span>
                                            </div>
                                            <hr class="mt-1 mb-2">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php $this->load->view('partials/footer.php') ?>
        </div>
    </div>

    <?php $this->load->view('partials/js.php') ?>

    <?php if ($this->session->login['role'] == 'admin'): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            Chart.register(ChartDataLabels);
            const chartData = JSON.parse('<?= $pie_chart_data ?? '{"labels":[],"data":[]}' ?>');
            const ctx = document.getElementById('barangTerlarisChart');

            if (ctx) {
                if (chartData.data.length > 0) {
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                label: 'Jumlah Keluar', data: chartData.data,
                                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 20, boxWidth: 12, font: { size: 11 } } },
                                tooltip: { callbacks: { label: (c) => `${c.label}: ${c.parsed} unit` } },
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                                        return percentage;
                                    },
                                    color: '#fff', font: { weight: 'bold', size: 12 }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('chart-container').innerHTML = '<div class="text-center text-muted my-5"><i class="fas fa-chart-pie fa-3x mb-3"></i><p>Tidak ada data transaksi.</p></div>'; // Mengubah teks
                }
            }
        </script>
    <?php endif; ?>
</body>

</html>