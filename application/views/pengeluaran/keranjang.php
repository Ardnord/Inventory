<?php
// 1. Ambil semua data yang dikirim oleh AJAX ke dalam variabel agar lebih rapi
$nama_barang = $this->input->post('nama_barang');
$kode_barang = $this->input->post('kode_barang'); // Kita simpan di hidden input, tidak perlu ditampilkan
$harga = $this->input->post('harga');
$jumlah = $this->input->post('jumlah');
$satuan = $this->input->post('satuan');
$sub_total = $this->input->post('sub_total');
?>

<tr class="row-keranjang" data-subtotal="<?= $sub_total ?>">
	<td>
		<?= $nama_barang ?>
		<input type="hidden" name="nama_barang_hidden[]" value="<?= $nama_barang ?>">
		<input type="hidden" name="kode_barang_hidden[]" value="<?= $kode_barang ?>">
		<input type="hidden" name="harga_hidden[]" value="<?= $harga ?>">
		<input type="hidden" name="jumlah_hidden[]" value="<?= $jumlah ?>">
		<input type="hidden" name="satuan_hidden[]" value="<?= $satuan ?>">
		<input type="hidden" name="sub_total_hidden[]" value="<?= $sub_total ?>">
	</td>
	<td class="text-right">
		<?= 'Rp ' . number_format($harga, 0, ',', '.') ?>
	</td>
	<td class="text-center">
		<?= $jumlah ?>
	</td>
	<td>
		<?= strtoupper($satuan) ?>
	</td>
	<td class="text-right">
		<?= 'Rp ' . number_format($sub_total, 0, ',', '.') ?>
	</td>
	<td class="text-center">
		<button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" data-nama-barang="<?= $nama_barang ?>">
			<i class="fa fa-trash"></i>
		</button>
	</td>
</tr>