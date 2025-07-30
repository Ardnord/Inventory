<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('partials/head.php') ?>
    <title><?= $title ?? 'Data Petugas' ?></title>
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php $this->load->view('partials/sidebar.php') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" data-url="<?= base_url('petugas') ?>">
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
                        <?php if ($this->session->login['role'] == 'admin'): ?>
                            <div>
                                <a href="<?= base_url('petugas/export') ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-file-export fa-sm text-white-50 mr-2"></i>Export PDF
                                </a>
                                <a href="<?= base_url('petugas/tambah') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Petugas
                                </a>
                            </div>
                        <?php endif ?>
                    </div>

                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php elseif($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Petugas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <?php if ($this->session->login['role'] == 'admin'): ?>
                                                <th class="text-center">Aksi</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_petugas as $petugas): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $petugas->kode ?></td>
                                                <td><?= $petugas->nama ?></td>
                                                <td><?= $petugas->username ?></td>
                                                <?php if($this->session->login['role'] == 'admin'): ?>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('petugas/ubah/' . $petugas->id) ?>" class="btn btn-success btn-circle btn-sm" title="Ubah Data">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                        <a onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" href="<?= base_url('petugas/hapus/' . $petugas->id) ?>" class="btn btn-danger btn-circle btn-sm" title="Hapus Data">
                                                            <i class="fa fa-trash"></i>
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

    <?php $this->load->view('partials/js.php') ?>
    
    <script src="<?= base_url('sb-admin/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('sb-admin/js/demo/datatables-demo.js') ?>"></script>
</body>
</html>