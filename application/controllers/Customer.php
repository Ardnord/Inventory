<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Pengecekan ini sudah benar, memastikan hanya admin dan petugas yang bisa akses
		if ($this->session->login['role'] != 'petugas' && $this->session->login['role'] != 'admin') {
			redirect();
		}
		$this->load->model('M_customer', 'm_customer');
		$this->data['aktif'] = 'customer';
	}

	public function index()
	{
		$this->data['title'] = 'Data Customer';
		$this->data['all_customer'] = $this->m_customer->lihat();
		$this->data['no'] = 1;

		$this->load->view('customer/lihat', $this->data);
	}

	public function tambah()
	{
		// Blok if yang melarang petugas sudah DIHAPUS dari sini
		$this->data['title'] = 'Tambah Customer';
		$this->load->view('customer/tambah', $this->data);
	}

	public function proses_tambah()
	{
		// Blok if yang melarang petugas sudah DIHAPUS dari sini
		$data = [
			'kode' => $this->input->post('kode'),
			'nama' => $this->input->post('nama'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat'),
		];

		if ($this->m_customer->tambah($data)) {
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Ditambahkan!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Ditambahkan!');
			redirect('customer');
		}
	}

	public function ubah($kode)
	{
		// Blok if yang melarang petugas sudah DIHAPUS dari sini
		$this->data['title'] = 'Ubah Customer';
		$this->data['customer'] = $this->m_customer->lihat_id($kode);

		$this->load->view('customer/ubah', $this->data);
	}

	public function proses_ubah($kode)
	{
		// Blok if yang melarang petugas sudah DIHAPUS dari sini
		$data = [
			'kode' => $this->input->post('kode'),
			'nama' => $this->input->post('nama'),
			'email' => $this->input->post('email'),
			'telepon' => $this->input->post('telepon'),
			'alamat' => $this->input->post('alamat'),
		];

		if ($this->m_customer->ubah($data, $kode)) {
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Diubah!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Diubah!');
			redirect('customer');
		}
	}

	public function hapus($kode)
	{
		// Blok if yang melarang petugas sudah DIHAPUS dari sini
		if ($this->m_customer->hapus($kode)) {
			$this->session->set_flashdata('success', 'Data Customer <strong>Berhasil</strong> Dihapus!');
			redirect('customer');
		} else {
			$this->session->set_flashdata('error', 'Data Customer <strong>Gagal</strong> Dihapus!');
			redirect('customer');
		}
	}

	public function export()
	{
		// Fungsi export tidak memiliki pembatas, jadi tidak perlu diubah.
		// Baik admin maupun petugas bisa mengaksesnya.
		require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
		$dompdf = new \Dompdf\Dompdf();
		$this->data['all_customer'] = $this->m_customer->lihat();
		$this->data['title'] = 'Laporan Data Customer';
		$this->data['no'] = 1;

		$dompdf->setPaper('A4', 'Landscape');
		$html = $this->load->view('customer/report', $this->data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data Customer Tanggal ' . date('d F Y'), array("Attachment" => false));
	}
}