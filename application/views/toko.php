<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
	<title><?= $title ?? 'Profil Toko' ?></title>
</head>

<body id="page-top">
	<div id="wrapper">
		<?php $this->load->view('partials/sidebar.php') ?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" data-url="<?= base_url('kasir') ?>">
				<?php $this->load->view('partials/topbar.php') ?>

				<div class="container-fluid">

					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
						<a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
							<i class="fa fa-reply mr-2"></i>Kembali
						</a>
					</div>

					<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php elseif ($this->session->flashdata('error')): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('error') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif ?>

					<div class="row">
						<div class="col-lg-8">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Informasi Toko</h6>
								</div>
								<div class="card-body">
									<form action="<?= base_url('toko/proses_ubah') ?>" id="form-toko" method="POST">
										<div class="form-group">
											<label for="nama_toko">Nama Toko</label>
											<input type="text" name="nama_toko" id="nama_toko"
												value="<?= $toko->nama_toko ?>" class="form-control" readonly>
										</div>
										<div class="form-group">
											<label for="nama_pemilik">Nama Pemilik</label>
											<input type="text" name="nama_pemilik" id="nama_pemilik"
												value="<?= $toko->nama_pemilik ?>" class="form-control" readonly>
										</div>
										<div class="form-group">
											<label for="no_telepon">No. Telepon</label>
											<input type="text" name="no_telepon" id="no_telepon"
												value="<?= $toko->no_telepon ?>" class="form-control" readonly>
										</div>
										<div class="form-group">
											<label for="alamat">Alamat</label>
											<textarea name="alamat" id="alamat" class="form-control"
												style="resize: none;" readonly><?= $toko->alamat ?></textarea>
										</div>

										<div class="form-group mt-4">
											<button type="submit" class="btn btn-primary" id="btn-simpan"
												style="display: none;">
												<i class="fa fa-save mr-2"></i>Simpan Perubahan
											</button>
											<button type="reset" class="btn btn-secondary" id="btn-batal"
												style="display: none;">
												<i class="fa fa-times mr-2"></i>Batal
											</button>
											<button type="button" class="btn btn-warning" id="btn-ubah">
												<i class="fa fa-pen mr-2"></i>Ubah Data
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('partials/footer.php') ?>
		</div>
	</div>

	<?php $this->load->view('partials/js.php') ?>
	<script>
		$(document).ready(function () {
			const form = $('#form-toko');
			const inputs = form.find('input, textarea');
			const btnUbah = $('#btn-ubah');
			const btnSimpan = $('#btn-simpan');
			const btnBatal = $('#btn-batal');

			// Fungsi untuk masuk ke mode edit
			btnUbah.on('click', function () {
				inputs.prop('readonly', false); // Aktifkan semua input
				btnUbah.hide(); // Sembunyikan tombol "Ubah"
				btnSimpan.show(); // Tampilkan tombol "Simpan"
				btnBatal.show(); // Tampilkan tombol "Batal"
				$('#nama_toko').focus(); // Fokus ke input pertama
			});

			// Fungsi untuk membatalkan (reset form dan tombol)
			btnBatal.on('click', function () {
				// Reset nilai form ke nilai awal dari server (efek dari type="reset")
				// Lalu kembalikan state tombol dan input
				setTimeout(function () {
					inputs.prop('readonly', true); // Jadikan readonly lagi
					btnSimpan.hide();
					btnBatal.hide();
					btnUbah.show();
				}, 1);
			});
		});
	</script>
</body>

</html>