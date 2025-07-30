<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
	<title><?= $title ?? 'Tambah Transaksi Pengeluaran' ?></title>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
						<a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary btn-sm">
							<i class="fa fa-reply mr-2"></i>Kembali
						</a>
					</div>

					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Form Transaksi</h6>
						</div>
						<div class="card-body">
							<form action="<?= base_url('pengeluaran/proses_tambah') ?>" id="form-tambah" method="POST">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
									value="<?= $this->security->get_csrf_hash() ?>">

								<div class="form-row">
									<div class="form-group col-md-2">
										<label>No. Keluar</label>
										<input type="text" name="no_keluar" value="KL-<?= time() ?>" readonly
											class="form-control">
									</div>
									<div class="form-group col-md-3">
										<label>Nama Customer</label>
										<select name="nama_customer" id="nama_customer" class="form-control select2"
											required>
											<option value="" selected disabled>Pilih Customer</option>
											<?php foreach ($all_customer as $customer): ?>
												<option value="<?= $customer->nama ?>"><?= $customer->nama ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label>Tanggal</label>
										<input type="text" name="tgl_keluar" value="<?= date('d-m-Y') ?>" readonly
											class="form-control">
									</div>
									<div class="form-group col-md-2">
										<label>Jam</label>
										<input type="text" name="jam_keluar" value="<?= date('H:i:s') ?>" readonly
											class="form-control">
									</div>
									<div class="form-group col-md-3">
										<label>Petugas</label>
										<input type="text" name="nama_petugas"
											value="<?= $this->session->login['nama'] ?>" readonly class="form-control">
									</div>
								</div>
								<hr>

								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="nama_barang">Nama Barang</label>
										<select id="nama_barang" class="form-control select2" style="width:100%;">
											<option value="" selected disabled>Pilih Barang</option>
											<?php foreach ($all_barang as $barang): ?>
												<option value="<?= $barang->nama_barang ?>" data-kode="<?= $barang->kode_barang ?>"
													data-harga="<?= $barang->harga ?>" data-stok="<?= $barang->stok ?>"
													data-satuan="<?= $barang->satuan ?>">
													<?= $barang->nama_barang ?> (Stok: <?= $barang->stok ?>)
												</option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label>Harga Satuan</label>
										<input type="text" id="harga_barang" readonly class="form-control">
									</div>
									<div class="form-group col-md-2">
										<label>Jumlah</label>
										<input type="number" id="jumlah" readonly class="form-control" min="1">
									</div>
									<div class="form-group col-md-2">
										<label>Sub Total</label>
										<input type="text" id="sub_total" readonly class="form-control">
									</div>
									<div class="form-group col-md-1">
										<label>&nbsp;</label>
										<button disabled type="button" class="btn btn-primary btn-block" id="tambah"><i
												class="fa fa-plus"></i></button>
									</div>
									<input type="hidden" id="kode_barang">
									<input type="hidden" id="satuan">
									<input type="hidden" id="max_stok">
								</div>

								<div class="keranjang">
									<h5>Detail Pengeluaran</h5>
									<hr>
									<table class="table table-bordered" id="keranjang">
										<thead class="thead-light">
											<tr>
												<th width="30%">Nama Barang</th>
												<th width="15%" class="text-right">Harga</th>
												<th width="15%" class="text-center">Jumlah</th>
												<th width="10%">Satuan</th>
												<th width="20%" class="text-right">Sub Total</th>
												<th width="10%" class="text-center">Aksi</th>
											</tr>
										</thead>
										<tbody></tbody>
										<tfoot>
											<tr class="bg-light">
												<td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
												<td id="grand_total" class="text-right"><strong>Rp 0</strong></td>
												<td></td>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="mt-4 text-right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan
										Transaksi</button>
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		$(document).ready(function () {
			// Mengaktifkan Select2 pada dropdown
			$('.select2').select2({
				theme: 'bootstrap-5'
			});

			$('tfoot').hide();

			// Fungsi untuk mengubah angka menjadi format Rupiah
			function formatRupiah(angka) {
				if (isNaN(angka) || angka === null) return 'Rp 0';
				let reverse = angka.toString().split('').reverse().join('');
				let ribuan = reverse.match(/\d{1,3}/g);
				return 'Rp ' + ribuan.join('.').split('').reverse().join('');
			}

			// Event saat barang dipilih dari dropdown
			$('#nama_barang').on('change', function () {
				if ($(this).val() == '') {
					reset();
				} else {
					const selected_option = $(this).find('option:selected');
					const kode_barang_val = selected_option.data('kode');
					const harga_val = selected_option.data('harga');
					const stok_val = selected_option.data('stok');
					const satuan_val = selected_option.data('satuan');

					// Mengisi form dengan data dari data-attribute
					$('#kode_barang').val(kode_barang_val);
					$('#harga_barang').val(formatRupiah(harga_val));
					$('#jumlah').val(1);
					$('#satuan').val(satuan_val);
					$('#max_stok').val(stok_val);
					$('#jumlah').prop('readonly', false); // Aktifkan input jumlah
					$('button#tambah').prop('disabled', false); // Aktifkan tombol tambah
					let sub_total = 1 * parseInt(harga_val);
					$('#sub_total').val(formatRupiah(sub_total));
				}
			});

			// Event saat jumlah barang diubah
			$(document).on('keyup keydown change blur', '#jumlah', function () {
				let jumlah_input = $(this).val();
				let jumlah = parseInt(jumlah_input);
				let max_stok = parseInt($('#max_stok').val());

				if (jumlah_input === '' || isNaN(jumlah)) { // Handle empty or non-numeric input
					$('#sub_total').val('');
					$('button#tambah').prop('disabled', true);
					return;
				}

				if (jumlah > max_stok) {
					alert('Jumlah melebihi stok tersedia! Stok: ' + max_stok);
					$(this).val(max_stok); // Set nilai jumlah ke max_stok
					jumlah = max_stok; // Update jumlah untuk perhitungan
				} else if (jumlah < 1) {
					alert('Jumlah tidak boleh kurang dari 1!');
					$(this).val(1);
					jumlah = 1;
				}

				let harga_text = $('#harga_barang').val().replace(/[^0-9]/g, ''); // Ambil angka saja dari harga
				let harga = parseInt(harga_text);

				let sub_total = jumlah * harga;
				$('#sub_total').val(formatRupiah(sub_total)); // Tampilkan subtotal yang diformat
				$('button#tambah').prop('disabled', false); // Pastikan tombol tambah aktif jika jumlah valid
			});


			// Event saat tombol "Tambah" ke keranjang di-klik
			$(document).on('click', '#tambah', function (e) {
				const current_kode_barang = $('#kode_barang').val();
				const current_nama_barang = $('#nama_barang').val();
				let current_jumlah = parseInt($('#jumlah').val());
				let current_harga = parseInt($('#harga_barang').val().replace(/[^0-9]/g, ''));
				let current_satuan = $('#satuan').val();
				let current_sub_total = current_jumlah * current_harga; // Subtotal untuk penambahan ini

				const max_stok_tersedia = parseInt($('#max_stok').val());

				// Validasi input sebelum menambah ke keranjang
				if (current_nama_barang === null || current_nama_barang === '' || isNaN(current_jumlah) || current_jumlah <= 0) {
					alert('Pilih barang dan masukkan jumlah yang valid!');
					return;
				}

				// ----- LOGIKA PERBAIKAN: CEK BARANG SUDAH ADA DI KERANJANG -----
				let barang_sudah_ada = false;
				$('table#keranjang tbody tr').each(function () {
					const hidden_kode_barang = $(this).find('input[name="kode_barang_hidden[]"]').val();

					if (hidden_kode_barang === current_kode_barang) {
						barang_sudah_ada = true;

						// Ambil jumlah lama dan hitung jumlah baru
						let jumlah_lama = parseInt($(this).find('input[name="jumlah_hidden[]"]').val());
						let jumlah_baru_total = jumlah_lama + current_jumlah;

						// Validasi stok gabungan
						if (jumlah_baru_total > max_stok_tersedia) {
							alert('Stok tidak mencukupi untuk penambahan! Stok tersedia: ' + max_stok_tersedia + '. Jumlah di keranjang: ' + jumlah_lama);
							return false; // Hentikan proses penambahan
						}

						// Hitung sub_total baru
						let sub_total_baru = jumlah_baru_total * current_harga;

						// Update hidden input
						$(this).find('input[name="jumlah_hidden[]"]').val(jumlah_baru_total);
						$(this).find('input[name="sub_total_hidden[]"]').val(sub_total_baru);

						// Update tampilan di tabel
						$(this).find('td:nth-child(3)').text(jumlah_baru_total); // Kolom Jumlah
						$(this).find('td:nth-child(5)').text(formatRupiah(sub_total_baru)); // Kolom Sub Total
						$(this).data('subtotal', sub_total_baru); // Update data-subtotal attribute

						reset();
						hitung_total();
						return false; // Hentikan loop .each
					}
				});

				if (barang_sudah_ada) {
					return; // Jika barang sudah diupdate, keluar dari fungsi click
				}

				// --- Jika barang belum ada, lanjutkan proses penambahan baris baru ---
				// Validasi stok untuk penambahan item baru
				if (current_jumlah > max_stok_tersedia) {
					alert('Stok tidak mencukupi! Stok tersedia: ' + max_stok_tersedia);
					return;
				}

				// Menyiapkan data untuk ditambahkan ke keranjang (langsung di DOM)
				const newRow = `
                    <tr class="row-keranjang" data-subtotal="${current_sub_total}">
                        <td>
                            ${current_nama_barang}
                            <input type="hidden" name="nama_barang_hidden[]" value="${current_nama_barang}">
                            <input type="hidden" name="kode_barang_hidden[]" value="${current_kode_barang}">
                            <input type="hidden" name="harga_hidden[]" value="${current_harga}">
                            <input type="hidden" name="jumlah_hidden[]" value="${current_jumlah}">
                            <input type="hidden" name="satuan_hidden[]" value="${current_satuan}">
                            <input type="hidden" name="sub_total_hidden[]" value="${current_sub_total}">
                        </td>
                        <td class="text-right">
                            ${formatRupiah(current_harga)}
                        </td>
                        <td class="text-center">
                            ${current_jumlah}
                        </td>
                        <td>
                            ${current_satuan.toUpperCase()}
                        </td>
                        <td class="text-right">
                            ${formatRupiah(current_sub_total)}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" data-nama-barang="${current_nama_barang}" data-kode-barang="${current_kode_barang}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

				$('table#keranjang tbody').append(newRow);
				$('tfoot').show(); // Tampilkan footer total
				hitung_total(); // Hitung ulang grand total
				reset(); // Kosongkan form input barang

				// Sembunyikan item yang sudah dipilih dari dropdown
				$('option[value="' + current_nama_barang + '"]').hide();
			});

			// Event saat tombol hapus di keranjang di-klik
			$(document).on('click', '#tombol-hapus', function () {
				const namaBarangHapus = $(this).data('nama-barang');
				const kodeBarangHapus = $(this).data('kode-barang');

				// Tampilkan kembali item yang dihapus ke dropdown berdasarkan nama barang
				$('option[value="' + namaBarangHapus + '"]').show();
				
				// Hapus baris dari tabel
				$(this).closest('.row-keranjang').remove();

				hitung_total(); // Hitung ulang grand total
				if ($('tbody').children().length == 0) $('tfoot').hide();
			});


			// Fungsi untuk menghitung grand total
			function hitung_total() {
				let total = 0;
				// Loop setiap baris keranjang dan ambil nilai dari data-subtotal
				$('.row-keranjang').each(function () {
					total += parseFloat($(this).data('subtotal'));
				});
				$('#grand_total').html('<strong>' + formatRupiah(total) + '</strong>');
			}

			// Fungsi untuk mengosongkan form input barang
			function reset() {
				$('#nama_barang').val('').trigger('change'); // Reset Select2
				$('#kode_barang').val('');
				$('#harga_barang').val('');
				$('#jumlah').val('');
				$('#sub_total').val('');
				$('#max_stok').val(''); // Reset max_stok
				$('#jumlah').prop('readonly', true);
				$('button#tambah').prop('disabled', true);
			}
		});
	</script>
</body>

</html>