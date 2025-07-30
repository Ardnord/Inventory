<?php

use Dompdf\Dompdf;

class Penerimaan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->data['aktif'] = 'penerimaan';
		$this->load->model('M_barang', 'm_barang');
		$this->load->model('M_supplier', 'm_supplier');
		$this->load->model('M_penerimaan', 'm_penerimaan');
		$this->load->model('M_detail_terima', 'm_detail_terima');
	}

	public function index()
	{
		$this->data['title'] = 'Transaksi Penerimaan';
		$this->data['all_penerimaan'] = $this->m_penerimaan->lihat();
		$this->data['no'] = 1;

		$this->load->view('penerimaan/lihat', $this->data);
	}

	public function tambah()
	{
		$this->data['title'] = 'Tambah Transaksi';
		$this->data['all_barang'] = $this->m_barang->lihat();
		$this->data['all_supplier'] = $this->m_supplier->lihat(); // Asumsi method ini ada

		$this->load->view('penerimaan/tambah', $this->data);
	}

	/**
	 * [FIXED & IMPROVED] Method ini dirombak total
	 */
	public function proses_tambah()
	{
		// Pastikan Anda sudah menambahkan input 'kode_barang_hidden' di view tambah.php
		$jumlah_barang_diterima = count($this->input->post('kode_barang_hidden'));

		if ($jumlah_barang_diterima == 0) {
			$this->session->set_flashdata('error', 'Tidak ada barang yang ditambahkan!');
			redirect('penerimaan/tambah');
		}

		// Memulai Database Transaction untuk keamanan
		$this->db->trans_start();

		// Di dalam Penerimaan.php -> proses_tambah()
		$data_terima = [
			'no_terima' => $this->input->post('no_terima'),
			// [PERBAIKAN] Simpan dalam format Y-m-d
			'tgl_terima' => date('Y-m-d'),
			'jam_terima' => $this->input->post('jam_terima'),
			'kode_supplier' => $this->input->post('kode_supplier'),
			'nama_petugas' => $this->session->login['nama'],
		];

		// 1. Insert data master penerimaan
		$this->m_penerimaan->tambah($data_terima);

		$data_detail_terima = [];
		for ($i = 0; $i < $jumlah_barang_diterima; $i++) {
			$item = [
				'no_terima' => $this->input->post('no_terima'),
				'kode_barang' => $this->input->post('kode_barang_hidden')[$i],
				'nama_barang' => $this->input->post('nama_barang_hidden')[$i],
				'jumlah' => $this->input->post('jumlah_hidden')[$i],
				'satuan' => $this->input->post('satuan_hidden')[$i],
			];
			array_push($data_detail_terima, $item);

			// 2. Update stok barang menggunakan method yang benar (add_stok) dan kunci yang benar (kode_barang)
			// INILAH PERBAIKAN UNTUK ERROR ANDA
			$this->m_barang->add_stok($item['jumlah'], $item['kode_barang']);
		}

		// 3. Insert semua data detail dengan insert_batch
		$this->m_detail_terima->tambah($data_detail_terima);

		// Menyelesaikan Database Transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Invoice Penerimaan <strong>Gagal</strong> Dibuat!');
		} else {
			$this->session->set_flashdata('success', 'Invoice <strong>Penerimaan</strong> Berhasil Dibuat!');
		}
		redirect('penerimaan');
	}

	public function detail($no_terima)
	{
		$this->data['title'] = 'Detail Penerimaan';
		$this->data['penerimaan'] = $this->m_penerimaan->lihat_no_terima($no_terima);
		$this->data['all_detail_terima'] = $this->m_detail_terima->lihat_no_terima($no_terima);
		$this->data['no'] = 1;

		$this->load->view('penerimaan/detail', $this->data);
	}

	/**
	 * [FIXED] Disederhanakan karena semua logika sudah ada di model M_penerimaan
	 */
	public function hapus($no_terima)
	{
		if ($this->m_penerimaan->hapus($no_terima)) {
			$this->session->set_flashdata('success', 'Invoice Penerimaan <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Invoice Penerimaan <strong>Gagal</strong> Dihapus!');
		}
		redirect('penerimaan');
	}

	public function get_all_barang()
	{
		$data = $this->m_barang->lihat_nama_barang($_POST['nama_barang']);
		echo json_encode($data);
	}

	public function keranjang_barang()
	{
		$this->load->view('penerimaan/keranjang');
	}

	// ... (Fungsi export Anda, tidak perlu diubah) ...
	public function export()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new Dompdf();
		$this->data['all_penerimaan'] = $this->m_penerimaan->lihat();
		$this->data['title'] = 'Laporan Data Penerimaan';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('penerimaan/report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data Penerimaan Tanggal ' . date('d F Y'), array("Attachment" => false));
	}

	public function export_detail($no_terima)
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new Dompdf();
		$this->data['penerimaan'] = $this->m_penerimaan->lihat_no_terima($no_terima);
		$this->data['all_detail_terima'] = $this->m_detail_terima->lihat_no_terima($no_terima);
		$this->data['title'] = 'Laporan Detail Penerimaan';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('penerimaan/detail_report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Detail Penerimaan Tanggal ' . date('d F Y'), array("Attachment" => false));
	}

}