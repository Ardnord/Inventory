<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partials/head.php') ?>
    <title><?= $title ?? 'Data Barang' ?></title>

    <style>
        .table td,
        .table th {
            vertical-align: middle;
            /* Memastikan semua konten di dalam sel tabel berada di tengah secara vertikal */
        }

        .img-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            /* Membuat gambar mengisi area tanpa distorsi */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php $this->load->view('partials/sidebar.php') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" data-url="<?= base_url('barang') ?>">
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>


                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 font-weight-bold text-primary"><?= $title ?? 'Data Barang' ?></h5>
                            <?php if ($this->session->login['role'] == 'admin'): ?>
                                <div>
                                    <a href="<?= base_url('barang/export') ?>" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-file-export fa-sm text-white-50 mr-2"></i>Export PDF
                                    </a>
                                    <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Barang
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th class="text-right">Harga Satuan</th> <th>Stok</th>
                                            <?php if ($this->session->login['role'] == 'admin'): ?>
                                                <th class="text-center">Aksi</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_barang as $key => $b): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <img src="<?= base_url('assets/img/upload/') . ($b->image ?: 'no-image.png') ?>"
                                                        alt="<?= $b->nama_barang ?>" class="img-thumbnail rounded">
                                                </td>
                                                <td><span class="font-weight-bold"><?= $b->kode_barang ?? '-' ?></span></td>
                                                <td><?= $b->nama_barang ?? 'Tidak ada nama' ?></td>
                                                <td class="text-right">Rp <?= number_format($b->harga ?? 0, 0, ',', '.') ?></td>
                                                <td><?= $b->stok ?? 0 ?>  <?= strtoupper($b->satuan ?? 'PCS') ?></td>
                                                <?php if ($this->session->login['role'] == 'admin'): ?>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('barang/ubah/' . $b->kode_barang) ?>"
                                                            class="btn btn-success btn-circle btn-sm" title="Edit Data">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <a href="<?= base_url('barang/hapus/' . $b->kode_barang) ?>"
                                                            onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                                                            class="btn btn-danger btn-circle btn-sm" title="Hapus Data">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php $this->load->view('partials/footer.php') ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php $this->load->view('partials/js.php') ?>
    <script src="<?= base_url('sb-admin/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('sb-admin/js/demo/datatables-demo.js') ?>"></script>
</body>

</html>