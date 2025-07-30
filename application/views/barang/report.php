<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<style>
		body {
			font-family: 'Helvetica', sans-serif;
			font-size: 11pt;
			color: #333;
		}

		.container {
			width: 100%;
			margin: 0 auto;
		}

		.report-header {
			text-align: center;
			margin-bottom: 20px;
			border-bottom: 2px solid #333;
			padding-bottom: 10px;
		}

		.report-header h4 {
			margin: 0;
		}

		.table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		.table th,
		.table td {
			border: 1px solid #ccc;
			padding: 8px;
			text-align: left;
			vertical-align: middle;
		}

		.table th {
			background-color: #f2f2f2;
			font-weight: bold;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.grand-total {
			font-weight: bold;
			background-color: #f2f2f2;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="report-header">
			<h4>LAPORAN DATA BARANG</h4>
			<span>Tanggal Cetak: <?= date('d F Y') ?></span>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th class="text-center" width="5%">No</th>
					<th width="15%">Kode Barang</th>
					<th>Nama Barang</th>
					<th class="text-center" width="10%">Stok</th>
					<th class="text-right" width="15%">Harga Satuan</th>
					<th class="text-right" width="20%">Total Nilai</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total_asset_value = 0; // Inisialisasi total nilai aset
				foreach ($all_barang as $barang):
					// Hitung nilai per barang (stok * harga)
					$item_value = ($barang->stok ?? 0) * ($barang->harga ?? 0);
					// Tambahkan ke total nilai aset
					$total_asset_value += $item_value;
					?>
					<tr>
						<td class="text-center"><?= $no++ ?></td>
						<td><?= $barang->kode_barang ?></td>
						<td><?= $barang->nama_barang ?></td>
						<td class="text-center"><?= $barang->stok ?> 	<?= strtoupper($barang->satuan) ?></td>
						<td class="text-right">Rp <?= number_format($barang->harga ?? 0, 0, ',', '.') ?></td>
						<td class="text-right">Rp <?= number_format($item_value, 0, ',', '.') ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr class="grand-total">
					<td colspan="5" class="text-right"><strong>TOTAL NILAI INVENTARIS</strong></td>
					<td class="text-right"><strong>Rp <?= number_format($total_asset_value, 0, ',', '.') ?></strong>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>

</html>