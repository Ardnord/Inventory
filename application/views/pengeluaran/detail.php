<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partials/head.php') ?>
    <title><?= $title ?? 'Detail Pengeluaran' ?></title>
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .table-borderless th,
        .table-borderless td {
            border: 0;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php $this->load->view('partials/sidebar.php') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" data-url="<?= base_url('pengeluaran') ?>">
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
                        <div>
                            <a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i>Kembali
                            </a>
                            <a href="<?= base_url('pengeluaran/export_detail/' . $pengeluaran->no_keluar) ?>" class="btn btn-primary btn-sm" target="_blank">
                                <i class="fas fa-file-pdf fa-sm text-white-50 mr-2"></i>Export PDF
                            </a>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                             <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi - <?= $pengeluaran->no_keluar ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">No. Keluar</th>
                                            <th width="5%">:</th>
                                            <td><?= $pengeluaran->no_keluar ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Customer</th>
                                            <th>:</th>
                                            <td><?= $pengeluaran->nama_customer ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                     <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Waktu</th>
                                            <th width="5%">:</th>
                                            <td><?= $pengeluaran->tgl_keluar ?> - <?= $pengeluaran->jam_keluar ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Petugas</th>
                                            <th>:</th>
                                            <td><?= $pengeluaran->nama_petugas ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Barang</th>
                                            <th class="text-right">Harga Satuan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-right">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_detail_keluar as $detail_keluar): ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $detail_keluar->nama_barang ?></td>
                                                <td class="text-right">Rp <?= number_format($detail_keluar->harga, 0, ',', '.') ?></td>
                                                <td class="text-center"><?= $detail_keluar->jumlah ?> <?= strtoupper($detail_keluar->satuan) ?></td>
                                                <td class="text-right">Rp <?= number_format($detail_keluar->sub_total, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <th colspan="4" class="text-right">Grand Total</th>
                                            <th class="text-right">Rp <?= number_format($pengeluaran->total_keluar, 0, ',', '.') ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('partials/footer.php') ?>
        </div>
    </div>

    <?php $this->load->view('partials/js.php') ?>
    </body>
</html>