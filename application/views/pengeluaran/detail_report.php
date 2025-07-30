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
			padding: 15px;
		}

		.report-header {
			text-align: center;
			margin-bottom: 20px;
			border-bottom: 2px solid #333;
			padding-bottom: 10px;
		}

		.report-header h4,
		.report-header h5 {
			margin: 0;
		}

		.info-section {
			margin-top: 20px;
			margin-bottom: 20px;
			font-size: 10pt;
		}

		.info-section table {
			width: 100%;
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
			<h4>BUKTI TRANSAKSI PENGELUARAN</h4>
		</div>

		<div class="info-section">
			<table>
				<tr>
					<td width="50%">
						<strong>No. Transaksi:</strong> <?= $pengeluaran->no_keluar ?><br>
						<strong>Customer:</strong> <?= $pengeluaran->nama_customer ?>
					</td>
					<td width="50%" style="text-align: right;">
						<strong>Tanggal:</strong> <?= date('d F Y', strtotime($pengeluaran->tgl_keluar)) ?><br>
						<strong>Petugas:</strong> <?= $pengeluaran->nama_petugas ?>
					</td>
				</tr>
			</table>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th>Nama Barang</th>
					<th class="text-right">Harga Satuan</th>
					<th class="text-center">Jumlah</th>
					<th class="text-right">Sub Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($all_detail_keluar as $detail_keluar): ?>
					<tr>
						<td class="text-center"><?= $no++ ?></td>
						<td><?= $detail_keluar->nama_barang ?></td>
						<td class="text-right">Rp <?= number_format($detail_keluar->harga, 0, ',', '.') ?></td>
						<td class="text-center"><?= $detail_keluar->jumlah ?> 	<?= strtoupper($detail_keluar->satuan) ?></td>
						<td class="text-right">Rp <?= number_format($detail_keluar->sub_total, 0, ',', '.') ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr class="grand-total">
					<td colspan="4" class="text-right"><strong>GRAND TOTAL</strong></td>
					<td class="text-right"><strong>Rp
							<?= number_format($pengeluaran->total_keluar, 0, ',', '.') ?></strong></td>
				</tr>
			</tfoot>
		</table>

		<div class="info-section" style="margin-top: 40px; text-align: right;">
			Hormat Kami,<br><br><br><br>
			( <?= $pengeluaran->nama_petugas ?> )
		</div>
	</div>
</body>

</html>