<?php

use Dompdf\Dompdf;

class Pengeluaran extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		// if (!$this->session->login) {
		//     redirect('login');
		// }
		$this->data['aktif'] = 'pengeluaran';
		$this->load->model('M_barang', 'm_barang');
		$this->load->model('M_customer', 'm_customer');
		$this->load->model('M_pengeluaran', 'm_pengeluaran');
		$this->load->model('M_detail_keluar', 'm_detail_keluar');
	}

	public function index()
	{
		$this->data['title'] = 'Transaksi Pengeluaran';
		$this->data['all_pengeluaran'] = $this->m_pengeluaran->lihat();
		$this->data['no'] = 1;

		$this->load->view('pengeluaran/lihat', $this->data);
	}

	public function tambah()
	{
		$this->data['title'] = 'Tambah Transaksi Pengeluaran';
		$this->data['all_barang'] = $this->m_barang->lihat_stok();
		$this->data['all_customer'] = $this->m_customer->lihat_cst();

		$this->load->view('pengeluaran/tambah', $this->data);
		// PERBAIKAN 1: Baris di bawah ini dihapus karena tidak diperlukan di fungsi 'tambah'
	}

	public function proses_tambah()
	{
		$jumlah_barang_keluar = count($this->input->post('nama_barang_hidden'));

		// PERBAIKAN 2: Validasi untuk mencegah simpan transaksi dengan keranjang kosong
		if ($jumlah_barang_keluar == 0) {
			$this->session->set_flashdata('error', 'Tidak ada barang yang dipilih! Harap isi keranjang terlebih dahulu.');
			redirect('pengeluaran/tambah');
		}

		$keranjang = $this->input->post();

		$total_keluar = 0;
		for ($i = 0; $i < $jumlah_barang_keluar; $i++) {
			$sub_total = (int) preg_replace('/[^0-9]/', '', $keranjang['sub_total_hidden'][$i]);
			$total_keluar += $sub_total;
		}

		$data_keluar = [
			'no_keluar' => $keranjang['no_keluar'],
			// PERBAIKAN 3: Mengubah format tanggal agar sesuai dengan standar database (Y-m-d)
			'tgl_keluar' => date('Y-m-d', strtotime($keranjang['tgl_keluar'])),
			'jam_keluar' => $keranjang['jam_keluar'],
			'nama_customer' => $keranjang['nama_customer'],
			'nama_petugas' => $keranjang['nama_petugas'],
			'total_keluar' => $total_keluar,
		];

		$data_detail_keluar = [];
		for ($i = 0; $i < $jumlah_barang_keluar; $i++) {
			$harga = (int) preg_replace('/[^0-9]/', '', $keranjang['harga_hidden'][$i]);
			$sub_total = (int) preg_replace('/[^0-9]/', '', $keranjang['sub_total_hidden'][$i]);

			array_push($data_detail_keluar, [
				'no_keluar' => $keranjang['no_keluar'],
				'nama_barang' => $keranjang['nama_barang_hidden'][$i],
				'jumlah' => $keranjang['jumlah_hidden'][$i],
				'satuan' => $keranjang['satuan_hidden'][$i],
				'harga' => $harga,
				'sub_total' => $sub_total,
			]);
		}

		$this->db->trans_start();
		$this->m_pengeluaran->tambah($data_keluar);
		$this->m_detail_keluar->tambah($data_detail_keluar);
		for ($i = 0; $i < $jumlah_barang_keluar; $i++) {
			// PERBAIKAN UTAMA: Menggunakan kode_barang_hidden untuk min_stok
			$this->m_barang->min_stok($data_detail_keluar[$i]['jumlah'], $keranjang['kode_barang_hidden'][$i]);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Invoice <strong>Pengeluaran</strong> Berhasil Dibuat!');
			redirect('pengeluaran');
		} else {
			$this->session->set_flashdata('error', 'Invoice <strong>Pengeluaran</strong> Gagal Dibuat!');
			redirect('pengeluaran/tambah');
		}
	}

	public function detail($no_keluar)
	{
		$this->data['title'] = 'Detail Pengeluaran';
		$this->data['pengeluaran'] = $this->m_pengeluaran->lihat_no_keluar($no_keluar);
		$this->data['all_detail_keluar'] = $this->m_detail_keluar->lihat_no_keluar($no_keluar);
		$this->data['no'] = 1;

		$this->load->view('pengeluaran/detail', $this->data);
	}

	public function hapus($no_keluar)
	{
		$all_detail_keluar = $this->m_detail_keluar->lihat_no_keluar($no_keluar);

		$this->db->trans_start();
		foreach ($all_detail_keluar as $detail) {
			$this->m_barang->add_stok($detail->jumlah, $detail->nama_barang); // This should also use kode_barang
		}
		$this->m_pengeluaran->hapus($no_keluar);
		$this->m_detail_keluar->hapus($no_keluar);
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->session->set_flashdata('success', 'Invoice Pengeluaran <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Invoice Pengeluaran <strong>Gagal</strong> Dihapus!');
		}
		redirect('pengeluaran');
	}

	public function get_all_barang()
	{
		$data = $this->m_barang->lihat_nama_barang($this->input->post('nama_barang'));
		echo json_encode($data);
	}

	public function keranjang_barang()
	{
		$this->load->view('pengeluaran/keranjang');
	}

	public function export()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new Dompdf();
		$this->data['all_pengeluaran'] = $this->m_pengeluaran->lihat();
		$this->data['title'] = 'Laporan Data Pengeluaran';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('pengeluaran/report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data Pengeluaran Tanggal ' . date('d F Y'), array("Attachment" => false));
	}

	public function export_detail($no_keluar)
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new Dompdf();
		$this->data['pengeluaran'] = $this->m_pengeluaran->lihat_no_keluar($no_keluar);
		$this->data['all_detail_keluar'] = $this->m_detail_keluar->lihat_no_keluar($no_keluar);
		$this->data['title'] = 'Bukti Pengeluaran Barang';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'portrait');
		$html = $this->load->view('pengeluaran/detail_report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Bukti-Pengeluaran-' . $no_keluar . '.pdf', ["Attachment" => false]);
	}
}