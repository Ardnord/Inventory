<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
	<title><?= $title ?? 'Data Customer' ?></title>

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
			<div id="content" data-url="<?= base_url('customer') ?>">
				<?php $this->load->view('partials/topbar.php') ?>

				<div class="container-fluid">

					<h1 class="h3 mb-4 text-gray-800"><?= $title ?? 'Data Customer' ?></h1>

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
							<h6 class="m-0 font-weight-bold text-primary">Daftar Customer</h6>

							<?php if ($this->session->login['role'] == 'admin' || $this->session->login['role'] == 'petugas'): ?>
								<div>
									<a href="<?= base_url('customer/export') ?>" class="btn btn-secondary btn-sm">
										<i class="fas fa-file-pdf mr-2"></i>Export
									</a>
									<a href="<?= base_url('customer/tambah') ?>" class="btn btn-primary btn-sm">
										<i class="fas fa-plus mr-2"></i>Tambah
									</a>
								</div>
							<?php endif; ?>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
									<thead class="thead-light">
										<tr>
											<th>No</th>
											<th>Kode</th>
											<th>Nama Customer</th>
											<th>Telepon</th>
											<th>Email</th>
											<th>Alamat</th>

											<?php if ($this->session->login['role'] == 'admin' || $this->session->login['role'] == 'petugas'): ?>
												<th class="text-center">Aksi</th>
											<?php endif; ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($all_customer as $customer): ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $customer->kode ?></td>
												<td><?= $customer->nama ?></td>
												<td><?= $customer->telepon ?></td>
												<td><?= $customer->email ?></td>
												<td><?= $customer->alamat ?></td>

												<?php if ($this->session->login['role'] == 'admin' || $this->session->login['role'] == 'petugas'): ?>
													<td class="text-center">
														<a href="<?= base_url('customer/ubah/' . $customer->kode) ?>"
															class="btn btn-success btn-circle btn-sm" title="Ubah">
															<i class="fa fa-pen"></i>
														</a>
														<a onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
															href="<?= base_url('customer/hapus/' . $customer->kode) ?>"
															class="btn btn-danger btn-circle btn-sm" title="Hapus">
															<i class="fa fa-trash"></i>
														</a>
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
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