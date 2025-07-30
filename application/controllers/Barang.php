<?php

use Dompdf\Dompdf;

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Cek login dan role, arahkan jika tidak sesuai
		if (!$this->session->login || !in_array($this->session->login['role'], ['admin', 'petugas'])) {
			redirect();
		}

		$this->data['aktif'] = 'barang';
		$this->load->model('M_barang', 'm_barang');
	}

	public function index()
	{
		$this->data['title'] = 'Data Barang';
		$this->data['all_barang'] = $this->m_barang->lihat();
		$this->data['no'] = 1;

		$this->load->view('barang/lihat', $this->data);
	}

	public function tambah()
	{
		// Hanya admin yang bisa mengakses halaman tambah
		if ($this->session->login['role'] != 'admin') {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('barang');
		}

		$this->data['title'] = 'Tambah Barang';
		$this->load->view('barang/tambah', $this->data);
	}

	/**
	 * PERBAIKAN: 
	 * 1. Menambahkan validasi dan pengambilan data 'harga'.
	 * 2. Logika upload gambar dibuat lebih fleksibel (opsional).
	 * 3. Menggunakan helper method untuk validasi agar tidak duplikat kode.
	 */
	public function proses_tambah()
	{
		if ($this->session->login['role'] != 'admin') {
			$this->session->set_flashdata('error', 'Akses ditolak!');
			redirect('barang');
		}

		// Jalankan validasi
		$this->_validation_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('barang/tambah');
		}

		$data = [
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'harga' => $this->input->post('harga'), // Mengambil data harga
			'stok' => $this->input->post('stok'),
			'satuan' => $this->input->post('satuan'),
			'image' => null, // Default value
		];

		// Logika upload gambar
		if (!empty($_FILES['image']['name'])) {
			$upload = $this->_upload_image();
			if ($upload['status']) {
				$data['image'] = $upload['data']['file_name'];
			} else {
				$this->session->set_flashdata('error', $upload['error']);
				redirect('barang/tambah');
			}
		}

		if ($this->m_barang->tambah($data)) {
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
			redirect('barang');
		} else {
			$this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Ditambahkan!');
			redirect('barang/tambah');
		}
	}

	public function ubah($kode_barang)
	{
		if ($this->session->login['role'] != 'admin') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('barang');
		}

		$this->data['title'] = 'Ubah Barang';
		$this->data['barang'] = $this->m_barang->lihat_id($kode_barang);

		if (!$this->data['barang']) {
			$this->session->set_flashdata('error', 'Data barang tidak ditemukan!');
			redirect('barang');
		}

		$this->load->view('barang/ubah', $this->data);
	}

	/**
	 * PERBAIKAN: 
	 * 1. Menambahkan validasi dan pengambilan data 'harga'.
	 * 2. Logika upload gambar yang lebih rapi saat update.
	 */
	public function proses_ubah($kode_barang)
	{
		if ($this->session->login['role'] != 'admin') {
			$this->session->set_flashdata('error', 'Akses ditolak!');
			redirect('barang');
		}

		$this->_validation_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('barang/ubah/' . $kode_barang);
		}

		$data = [
			'nama_barang' => $this->input->post('nama_barang'),
			'harga' => $this->input->post('harga'), // Mengambil data harga
			'stok' => $this->input->post('stok'),
			'satuan' => $this->input->post('satuan'),
		];

		// Logika upload gambar jika ada file baru yang diupload
		if (!empty($_FILES['image']['name'])) {
			$upload = $this->_upload_image();
			if ($upload['status']) {
				// Ambil data barang lama untuk menghapus gambar lama
				$barang_lama = $this->m_barang->lihat_id($kode_barang);
				if ($barang_lama->image && file_exists(FCPATH . 'assets/img/upload/' . $barang_lama->image)) {
					unlink(FCPATH . 'assets/img/upload/' . $barang_lama->image);
				}
				$data['image'] = $upload['data']['file_name'];
			} else {
				$this->session->set_flashdata('error', $upload['error']);
				redirect('barang/ubah/' . $kode_barang);
			}
		}

		if ($this->m_barang->ubah($data, $kode_barang)) {
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Diubah!');
			redirect('barang');
		} else {
			$this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Diubah!');
			redirect('barang/ubah/' . $kode_barang);
		}
	}

	public function hapus($kode_barang)
	{
		if ($this->session->login['role'] != 'admin') {
			$this->session->set_flashdata('error', 'Hapus data hanya untuk admin!');
			redirect('barang');
		}

		$barang = $this->m_barang->lihat_id($kode_barang);
		if ($barang->image && file_exists(FCPATH . 'assets/img/upload/' . $barang->image)) {
			unlink(FCPATH . 'assets/img/upload/' . $barang->image);
		}

		if ($this->m_barang->hapus($kode_barang)) {
			$this->session->set_flashdata('success', 'Data Barang <strong>Berhasil</strong> Dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
		}
		redirect('barang');
	}

	/**
	 * HELPER METHOD: untuk menampung aturan validasi form
	 */
	private function _validation_rules()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
		$this->form_validation->set_rules('satuan', 'Satuan', 'required');
	}

	/**
	 * HELPER METHOD: untuk proses upload gambar
	 */
	private function _upload_image()
	{
		$this->load->library('upload');
		$upload_path = FCPATH . 'assets/img/upload/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0775, true);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['encrypt_name'] = TRUE;

		$this->upload->initialize($config);

		if ($this->upload->do_upload('image')) {
			return ['status' => true, 'data' => $this->upload->data()];
		} else {
			return ['status' => false, 'error' => $this->upload->display_errors()];
		}
	}

	public function export()
	{
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new Dompdf(); // Menggunakan namespace global
		$this->data['all_barang'] = $this->m_barang->lihat();
		$this->data['title'] = 'Laporan Data Barang';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('barang/report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data Barang Tanggal ' . date('d F Y'), ["Attachment" => false]);
	}
}
