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

		.report-header h4,
		.report-header h5 {
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
			<h4>LAPORAN DATA PENGELUARAN</h4>
			<span>Tanggal Cetak: <?= date('d F Y') ?></span>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>No. Keluar</th>
					<th>Customer</th>
					<th>Tanggal</th>
					<th>Petugas</th>
					<th class="text-right">Total Transaksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$grand_total = 0; // Inisialisasi grand total
				foreach ($all_pengeluaran as $pengeluaran):
					$grand_total += $pengeluaran->total_keluar; // Tambahkan total transaksi ke grand total
					?>
					<tr>
						<td class="text-center"><?= $no++ ?></td>
						<td><?= $pengeluaran->no_keluar ?></td>
						<td><?= $pengeluaran->nama_customer ?></td>
						<td><?= date('d-m-Y', strtotime($pengeluaran->tgl_keluar)) ?></td>
						<td><?= $pengeluaran->nama_petugas ?></td>
						<td class="text-right">Rp <?= number_format($pengeluaran->total_keluar, 0, ',', '.') ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr class="grand-total">
					<td colspan="5" class="text-right"><strong>GRAND TOTAL</strong></td>
					<td class="text-right"><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>

</html>