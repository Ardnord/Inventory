<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partials/head.php') ?>
    <title><?= $title ?? 'Ubah Data Barang' ?></title>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php $this->load->view('partials/sidebar.php') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" data-url="<?= base_url('barang') ?>">
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
                    </div>

                    <?= $this->session->flashdata('success') ? '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $this->session->flashdata('success') . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>' : '' ?>
                    <?= $this->session->flashdata('error') ? '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->session->flashdata('error') . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>' : '' ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data Barang</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('barang/proses_ubah/' . $barang->kode_barang) ?>" id="form-ubah" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <label for="image"><strong>Foto Barang</strong></label>
                                        <br>
                                        <img src="<?= base_url('assets/img/upload/') . ($barang->image ?: 'no-image.png') ?>" class="img-thumbnail" id="preview-image" alt="Foto Barang">
                                        <br><br>
                                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="kode_barang"><strong>Kode Barang</strong></label>
                                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $barang->kode_barang ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_barang"><strong>Nama Barang</strong></label>
                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" value="<?= $barang->nama_barang ?? '' ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="stok"><strong>Stok</strong></label>
                                            <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan Stok" value="<?= $barang->stok ?? 0 ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="harga"><strong>Harga Satuan</strong></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga per Satuan" value="<?= $barang->harga ?? 0 ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="satuan"><strong>Satuan</strong></label>
                                            <select name="satuan" id="satuan" class="form-control" required>
                                                <option value="">-- Silahkan Pilih --</option>
                                                <?php 
                                                $satuans = [
                                                    'pcs', 'buah', 'unit', 'set', 'pack',
                                                    'meter', 'cm',
                                                    'kg', 'gram', 'ton', 'zak', 'karung',
                                                    'liter', 'kaleng', 'drum', 'botol',
                                                    'batang', 'lembar', 'rol', 'coil', 'box'
                                                ]; 
                                                sort($satuans);
                                                foreach ($satuans as $s): ?>
                                                    <option value="<?= $s ?>" <?= $barang->satuan == $s ? 'selected' : '' ?>><?= strtoupper($s) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group text-right">
                                    <a href="<?= base_url('barang') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times mr-1"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
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