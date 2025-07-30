<ul class="nav flex-column bg-white border-end vh-100 sidebar" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center py-4 border-bottom text-decoration-none"
		href="index.html">
		<div class="fs-4 fw-bold text-primary">SIAP</div>
	</a>

	<li class="nav-item <?= $aktif == 'dashboard' ? 'active' : '' ?>">
		<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'dashboard' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
			href="<?= base_url('dashboard') ?>">
			<i class="fas fa-tachometer-alt text-primary"></i>
			<span>Dashboard</span>
		</a>
	</li>

	<div class="px-3 mt-4 mb-2 text-muted text-uppercase small">Master</div>

	<li class="nav-item">
		<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'barang' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
			href="<?= base_url('barang') ?>">
			<i class="fas fa-box text-primary"></i>
			<span>Master Barang</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'customer' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
			href="<?= base_url('customer') ?>">
			<i class="fas fa-user text-primary"></i>
			<span>Master Customer</span>
		</a>
	</li>

	<?php if ($this->session->login['role'] == 'admin'): ?>
		<li class="nav-item">
			<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'supplier' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
				href="<?= base_url('supplier') ?>">
				<i class="fas fa-user text-primary"></i>
				<span>Master Supplier</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'petugas' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
				href="<?= base_url('petugas') ?>">
				<i class="fas fa-users text-primary"></i>
				<span>Master Petugas</span>
			</a>
		</li>
	<?php endif; ?>

	<div class="px-3 mt-4 mb-2 text-muted text-uppercase small">Transaksi</div>

	<?php if ($this->session->login['role'] == 'admin'): ?>
		<li class="nav-item">
			<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'penerimaan' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
				href="<?= base_url('penerimaan') ?>">
				<i class="fas fa-file-invoice text-primary"></i>
				<span>Transaksi Penerimaan</span>
			</a>
		</li>
	<?php endif; ?>

	<li class="nav-item">
		<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'pengeluaran' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
			href="<?= base_url('pengeluaran') ?>">
			<i class="fas fa-file-invoice text-primary"></i>
			<span>Transaksi Pengeluaran</span>
		</a>
	</li>

	<?php if ($this->session->login['role'] == 'admin'): ?>
		<div class="px-3 mt-4 mb-2 text-muted text-uppercase small">Pengaturan</div>

		<li class="nav-item">
			<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'pengguna' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
				href="<?= base_url('pengguna') ?>">
				<i class="fas fa-users text-primary"></i>
				<span>Manajemen Pengguna</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link d-flex align-items-center gap-2 px-3 py-2 <?= $aktif == 'toko' ? 'bg-light fw-semibold rounded' : 'text-dark' ?>"
				href="<?= base_url('toko') ?>">
				<i class="fas fa-building text-primary"></i>
				<span>Profil Toko</span>
			</a>
		</li>
	<?php endif; ?>

</ul>