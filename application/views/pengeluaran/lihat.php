<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
	<title><?= $title ?? 'Daftar Pengeluaran' ?></title>
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
			<div id="content" data-url="<?= base_url('pengeluaran') ?>">
				<?php $this->load->view('partials/topbar.php') ?>

				<div class="container-fluid">
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
						<div>
							<a href="<?= base_url('pengeluaran/export') ?>" class="btn btn-secondary btn-sm">
								<i class="fas fa-file-pdf fa-sm text-white-50 mr-2"></i>Export PDF
							</a>
							<a href="<?= base_url('pengeluaran/tambah') ?>" class="btn btn-primary btn-sm">
								<i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Pengeluaran
							</a>
						</div>
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

					<div class="card shadow">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Pengeluaran</h6>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
									<thead class="thead-light">
										<tr>
											<th>No</th>
											<th>No. Keluar</th>
											<th>Nama Customer</th>
											<th>Tanggal & Waktu</th>
											<th class="text-right">Total</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($all_pengeluaran as $pengeluaran): ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $pengeluaran->no_keluar ?></td>
												<td><?= $pengeluaran->nama_customer ?></td>
												<td><?= $pengeluaran->tgl_keluar ?> 	<?= $pengeluaran->jam_keluar ?></td>
												<td class="text-right">Rp
													<?= number_format($pengeluaran->total_keluar, 0, ',', '.') ?></td>
												<td class="text-center">
													<a href="<?= base_url('pengeluaran/detail/' . $pengeluaran->no_keluar) ?>"
														class="btn btn-info btn-circle btn-sm" title="Lihat Detail">
														<i class="fa fa-eye"></i>
													</a>
													<a onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
														href="<?= base_url('pengeluaran/hapus/' . $pengeluaran->no_keluar) ?>"
														class="btn btn-danger btn-circle btn-sm" title="Hapus">
														<i class="fa fa-trash"></i>
													</a>
												</td>
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
	<script src="<?= base_url('sb-admin') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url('sb-admin/js/demo/datatables-demo.js') ?>"></script>
</body>

</html>