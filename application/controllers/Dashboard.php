<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Memeriksa sesi login, hanya 'petugas' dan 'admin' yang diizinkan
		if ($this->session->login['role'] != 'petugas' && $this->session->login['role'] != 'admin') {
			redirect();
		}

		date_default_timezone_set('Asia/Jakarta');
		$this->data['aktif'] = 'dashboard';
		$this->load->model('M_barang', 'm_barang');
		$this->load->model('M_customer', 'm_customer');
		$this->load->model('M_supplier', 'm_supplier');
		$this->load->model('M_petugas', 'm_petugas');
		$this->load->model('M_pengeluaran', 'm_pengeluaran');
		$this->load->model('M_penerimaan', 'm_penerimaan');
		$this->load->model('M_pengguna', 'm_pengguna');
		$this->load->model('M_toko', 'm_toko');
	}

	public function index()
	{
		// --- 1. PERSIAPAN FILTER ---
		$filter = $this->input->get('filter') ?? 'semua'; // Default diubah ke 'semua'
		$this->data['filter_terpilih'] = $filter;

		$this->data['title'] = 'Halaman Dashboard';
		$role = $this->session->login['role'];

		// --- 2. PENGAMBILAN DATA BERDASARKAN FILTER ---
		if ($filter == 'semua') {
			// Jika filter 'Semua Waktu', panggil method untuk mengambil total data
			$this->data['periode'] = 'Semua Waktu';
			$this->data['omset_bulanan'] = $this->m_pengeluaran->total_omset(); // Memanggil method total omset
			$this->data['jumlah_pengeluaran'] = $this->m_pengeluaran->jumlah();
			$this->data['jumlah_penerimaan'] = $this->m_penerimaan->jumlah();
			$barang_terlaris = $this->m_pengeluaran->get_barang_terlaris(5); // Panggil tanpa tanggal untuk data sepanjang waktu

		} else {
			// Logika yang sudah ada untuk filter 'Bulan Ini' dan 'Bulan Lalu'
			if ($filter == 'bulan_lalu') {
				$tanggal = new DateTime('first day of last month');
			} else { // 'bulan_ini'
				$tanggal = new DateTime('now');
			}
			$tahun = $tanggal->format('Y');
			$bulan = $tanggal->format('m');
			$nama_bulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
			$this->data['periode'] = $nama_bulan[$bulan] . ' ' . $tahun;

			// Panggil method per bulan
			$this->data['omset_bulanan'] = $this->m_pengeluaran->omset_per_bulan($tahun, $bulan);
			$this->data['jumlah_pengeluaran'] = $this->m_pengeluaran->jumlah_per_bulan($tahun, $bulan);
			$this->data['jumlah_penerimaan'] = $this->m_penerimaan->jumlah_per_bulan($tahun, $bulan);
			$barang_terlaris = $this->m_pengeluaran->get_barang_terlaris(5, $tahun, $bulan);
		}

		// --- Data yang tidak terpengaruh oleh filter ---
		$this->data['jumlah_barang'] = $this->m_barang->jumlah();
		$this->data['jumlah_customer'] = $this->m_customer->jumlah();

		if ($role == 'admin') {
			// Data lain yang hanya untuk admin
			$this->data['jumlah_supplier'] = $this->m_supplier->jumlah();
			$this->data['jumlah_petugas'] = $this->m_petugas->jumlah();
			$this->data['jumlah_pengguna'] = $this->m_pengguna->jumlah();
			$this->data['toko'] = $this->m_toko->lihat();

			// Siapkan data untuk pie chart
			$data_chart = ['labels' => [], 'data' => []];
			if (!empty($barang_terlaris)) {
				foreach ($barang_terlaris as $barang) {
					$data_chart['labels'][] = $barang->nama_barang;
					$data_chart['data'][] = (int) $barang->total_keluar;
				}
			}
			$this->data['pie_chart_data'] = json_encode($data_chart);
		}

		// --- 3. TAMPILKAN VIEW ---
		$this->load->view('dashboard', $this->data);
	}
}