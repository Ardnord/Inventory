<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
	<title><?= $title ?? 'Tambah Penerimaan' ?></title>
</head>

<body id="page-top">
	<div id="wrapper">
		<?php $this->load->view('partials/sidebar.php') ?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" data-url="<?= base_url('penerimaan') ?>">
				<?php $this->load->view('partials/topbar.php') ?>

				<div class="container-fluid">
					<div class="clearfix">
						<div class="float-left">
							<h1 class="h3 m-0 text-gray-800"><?= $title ?></h1>
						</div>
						<div class="float-right">
							<a href="<?= base_url('penerimaan') ?>" class="btn btn-secondary btn-sm"><i
									class="fa fa-reply"></i>&nbsp;&nbsp;Kembali</a>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col">
							<div class="card shadow">
								<div class="card-header"><strong>Isi Form Dibawah Ini!</strong></div>
								<div class="card-body">
									<form action="<?= base_url('penerimaan/proses_tambah') ?>" id="form-tambah"
										method="POST">
										<div class="form-row">
											<div class="form-group col-md-2">
												<label>No. Terima</label>
												<input type="text" name="no_terima" value="TR<?= time() ?>" readonly
													class="form-control">
											</div>
											<div class="form-group col-md-3">
												<label>Nama Petugas</label>
												<input type="text" value="<?= $this->session->login['nama'] ?>" readonly
													class="form-control">
											</div>
											<div class="form-group col-md-3">
												<label>Tanggal & Jam</label>
												<input type="text" value="<?= date('d/m/Y H:i:s') ?>" readonly
													class="form-control">
												<input type="hidden" name="tgl_terima" value="<?= date('d/m/Y') ?>">
												<input type="hidden" name="jam_terima" value="<?= date('H:i:s') ?>">
											</div>
											<div class="form-group col-md-4">
												<label for="kode_supplier">Nama Supplier</label>
												<select name="kode_supplier" id="kode_supplier" class="form-control"
													required>
													<option value="">-- Pilih Supplier --</option>
													<?php foreach ($all_supplier as $supplier): ?>
														<option value="<?= $supplier->kode ?>"><?= $supplier->nama ?>
														</option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<hr>
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="nama_barang">Nama Barang</label>
												<select id="nama_barang" class="form-control">
													<option value="">-- Pilih Barang --</option>
													<?php foreach ($all_barang as $barang): ?>
														<option value="<?= $barang->nama_barang ?>">
															<?= $barang->nama_barang ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<div class="form-group col-md-2">
												<label>Kode Barang</label>
												<input type="text" id="kode_barang_input" readonly class="form-control">
											</div>
											<div class="form-group col-md-2">
												<label>Satuan</label>
												<input type="text" id="satuan_input" readonly class="form-control">
											</div>
											<div class="form-group col-md-2">
												<label>Jumlah</label>
												<input type="number" id="jumlah_input" class="form-control" readonly
													min="1">
											</div>
											<div class="form-group col-md-2">
												<label>&nbsp;</label>
												<button disabled type="button" class="btn btn-primary btn-block"
													id="tambah"><i class="fa fa-plus"></i> Tambah</button>
											</div>
										</div>

										<div class="keranjang">
											<h5>Detail Penerimaan</h5>
											<hr>
											<table class="table table-bordered" id="keranjang_table">
												<thead>
													<tr>
														<td width="35%">Nama Barang</td>
														<td width="20%">Kode Barang</td>
														<td width="15%">Jumlah</td>
														<td width="15%">Satuan</td>
														<td width="15%">Aksi</td>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="5" align="center">
															<button type="submit" class="btn btn-primary"><i
																	class="fa fa-save"></i>&nbsp;&nbsp;Simpan
																Penerimaan</button>
														</td>
													</tr>
												</tfoot>
											</table>
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
			$('tfoot').hide();

			$(document).keypress(function (event) {
				if (event.which == '13') {
					event.preventDefault();
				}
			});

			// Event saat memilih barang
			$('#nama_barang').on('change', function () {
				if ($(this).val() == '') {
					reset_item_form();
				} else {
					const url_get_all_barang = $('#content').data('url') + '/get_all_barang';
					$.ajax({
						url: url_get_all_barang,
						type: 'POST',
						dataType: 'json',
						data: { nama_barang: $(this).val() },
						success: function (data) {
							// Mengisi form item dengan data dari AJAX
							$('#kode_barang_input').val(data.kode_barang);
							$('#satuan_input').val(data.satuan);
							$('#jumlah_input').val(1);
							$('#jumlah_input').prop('readonly', false);
							$('button#tambah').prop('disabled', false);
						}
					});
				}
			});

			// Event saat tombol 'Tambah' ke keranjang diklik
			$(document).on('click', '#tambah', function (e) {
				const data_keranjang = {
					nama_barang: $('select#nama_barang').val(),
					kode_barang: $('#kode_barang_input').val(),
					jumlah: $('#jumlah_input').val(),
					satuan: $('#satuan_input').val(),
				};

				// Validasi sederhana
				if (data_keranjang.jumlah < 1) {
					alert('Jumlah tidak boleh kurang dari 1');
					return;
				}

				// [PERBAIKAN] Membuat baris tabel baru untuk keranjang
				const newRow = `
				<tr class="row-keranjang">
					<td>
						${data_keranjang.nama_barang}
						<input type="hidden" name="nama_barang_hidden[]" value="${data_keranjang.nama_barang}">
						<input type="hidden" name="kode_barang_hidden[]" value="${data_keranjang.kode_barang}">
					</td>
					<td>${data_keranjang.kode_barang}</td>
					<td>
						${data_keranjang.jumlah}
						<input type="hidden" name="jumlah_hidden[]" value="${data_keranjang.jumlah}">
					</td>
					<td>
						${data_keranjang.satuan}
						<input type="hidden" name="satuan_hidden[]" value="${data_keranjang.satuan}">
					</td>
					<td>
						<button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" data-nama-barang="${data_keranjang.nama_barang}">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
			`;

				$('table#keranjang_table tbody').append(newRow);
				$('option[value="' + data_keranjang.nama_barang + '"]').hide(); // Sembunyikan barang yang sudah dipilih
				reset_item_form();

				$('tfoot').show();
			});

			// Event saat menghapus item dari keranjang
			$(document).on('click', '#tombol-hapus', function () {
				$(this).closest('.row-keranjang').remove();
				$('option[value="' + $(this).data('nama-barang') + '"]').show(); // Tampilkan kembali di dropdown
				if ($('tbody').children().length == 0) $('tfoot').hide();
			});

			// Fungsi untuk mereset form item
			function reset_item_form() {
				$('#nama_barang').val('');
				$('#kode_barang_input').val('');
				$('#satuan_input').val('');
				$('#jumlah_input').val('');
				$('#jumlah_input').prop('readonly', true);
				$('button#tambah').prop('disabled', true);
			}
		});
	</script>
</body>

</html>