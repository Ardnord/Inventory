<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login - Sistem Inventaris Perusahaan</title>

	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
		integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">

	<style>
		:root {
			--primary-color: #4e73df;
			--primary-color-rgb: 78, 115, 223;
			--light-gray: #f8f9fa;
			--dark-text: #212529;
			--gray-text: #6c757d;
		}

		body {
			font-family: 'Poppins', sans-serif;
			background-color: var(--light-gray);
		}

		.login-wrapper {
			min-height: 100vh;
			width: 100%;
			margin: 0;
		}

		.branding-panel {
			background-color: var(--primary-color);
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			padding: 3rem;
			color: #ffffff;
			text-align: center;
		}

		.branding-panel .logo {
			font-size: 4rem;
			margin-bottom: 1.5rem;
			line-height: 1;
		}

		.branding-panel h2 {
			font-weight: 700;
			margin-bottom: 0.5rem;
		}

		.branding-panel p {
			font-size: 1rem;
			opacity: 0.8;
			max-width: 350px;
		}

		.form-panel {
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 3rem;
			background-color: #ffffff;
		}

		.form-box {
			width: 100%;
			max-width: 400px;
		}

		.form-box h3 {
			color: var(--dark-text);
			font-weight: 600;
		}

		.form-box .text-muted {
			color: var(--gray-text) !important;
		}

		.form-control-corporate {
			border-radius: 0.5rem;
			padding: 0.9rem 1rem;
			border: 1px solid #ced4da;
			height: calc(1.5em + 1.8rem + 2px);
			/* Menyamakan tinggi semua input */
		}

		.form-control-corporate:focus {
			border-color: var(--primary-color);
			box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
		}

		/* ========================================================== */
		/* [PERBAIKAN] Gaya khusus untuk dropdown <select>            */
		/* ========================================================== */
		select.form-control-corporate {
			/* Menghapus padding vertikal bawaan yang bermasalah */
			padding-top: 0;
			padding-bottom: 0;
			line-height: 1.5;
			/* Memastikan teks di tengah secara vertikal */

			/* Menghilangkan panah default browser */
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;

			/* Menambahkan panah kustom menggunakan SVG */
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
			background-repeat: no-repeat;
			background-position: right 1rem center;
			background-size: 16px 12px;
		}

		.btn-corporate {
			background-color: var(--primary-color);
			border-color: var(--primary-color);
			padding: 0.8rem 1rem;
			font-weight: 600;
			letter-spacing: 0.5px;
			border-radius: 0.5rem;
		}

		.g-0>.col,
		.g-0>[class*="col-"] {
			padding-right: 0;
			padding-left: 0;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="row login-wrapper g-0">
			<div class="col-lg-6 d-none d-lg-flex branding-panel">
				<div class="logo">
					<i class="fas fa-cubes"></i>
				</div>
				<h2>SIAP (SOLUSI ISTANA ANDA PRIMA) </h2>
				<p>Sistem inventaris untuk manajemen bahan dan peralatan bangunan Anda secara akurat dan efisien.</p>
			</div>

			<div class="col-lg-6 form-panel">
				<div class="form-box">
					<h3 class="mb-2">Selamat Datang Kembali</h3>
					<p class="text-muted mb-4">Silakan masuk ke akun Anda.</p>

					<?php if ($this->session->flashdata('error')): ?>
						<div class="alert alert-danger small p-2 text-center">
							<?= $this->session->flashdata('error') ?>
						</div>
					<?php endif; ?>

					<form method="POST" action="<?= base_url('login/proses_login') ?>">
						<div class="form-group">
							<label for="username" class="small font-weight-bold text-gray-700">USERNAME</label>
							<input type="text" class="form-control form-control-corporate" id="username" name="username"
								required>
						</div>
						<div class="form-group">
							<label for="password" class="small font-weight-bold text-gray-700">PASSWORD</label>
							<input type="password" class="form-control form-control-corporate" id="password"
								name="password" required>
						</div>
						<div class="form-group">
							<label for="role" class="small font-weight-bold text-gray-700">PERAN</label>
							<select name="role" id="role" class="form-control form-control-corporate" required>
								<option value="" disabled selected>Pilih peran Anda...</option>
								<option value="petugas">Petugas</option>
								<option value="admin">Admin</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary btn-corporate btn-block mt-4" name="login">
							LOGIN
						</button>
						<div class="text-center mt-4">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>