<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penerimaan extends CI_Model
{
	protected $_table = 'penerimaan';
	protected $_table_detail = 'detail_terima';

	/**
	 * [IMPROVED] Mengambil data dengan JOIN ke tabel supplier untuk mendapatkan nama supplier.
	 * Kondisi JOIN sudah disesuaikan dengan struktur tabel Anda.
	 */
	public function lihat()
	{
		$this->db->select('p.*, s.nama AS nama_supplier');
		$this->db->from($this->_table . ' p');
		$this->db->join('supplier s', 'p.kode_supplier = s.kode');
		$this->db->order_by('p.tgl_terima', 'DESC');
		return $this->db->get()->result();
	}

	public function jumlah()
	{
		$query = $this->db->get($this->_table);
		return $query->num_rows();
	}

	public function lihat_no_terima($no_terima)
	{
		return $this->db->get_where($this->_table, ['no_terima' => $no_terima])->row();
	}

	/**
	 * Mengambil semua item detail dari sebuah transaksi penerimaan.
	 */
	public function lihat_detail($no_terima)
	{
		return $this->db->get_where($this->_table_detail, ['no_terima' => $no_terima])->result();
	}

	public function tambah($data)
	{
		return $this->db->insert($this->_table, $data);
	}

	/**
	 * [IMPROVED] Menghapus data transaksi penerimaan beserta detailnya,
	 * dan mengembalikan (mengurangi) stok barang yang bersangkutan.
	 * Menggunakan Database Transaction untuk keamanan data.
	 */
	public function hapus($no_terima)
	{
		$this->db->trans_start(); // Memulai transaction

		// 1. Ambil semua item detail dari transaksi yang akan dihapus
		$detail_items = $this->lihat_detail($no_terima);

		// Load model barang untuk memanggil method minus_stok
		$this->load->model('M_barang', 'm_barang');

		// 2. Loop setiap item dan kurangi stoknya
		if (!empty($detail_items)) {
			foreach ($detail_items as $item) {
				// Pastikan method minus_stok ada di M_barang
				$this->m_barang->minus_stok($item->jumlah, $item->kode_barang);
			}
		}

		// 3. Hapus data dari tabel detail
		$this->db->delete($this->_table_detail, ['no_terima' => $no_terima]);

		// 4. Hapus data dari tabel master
		$this->db->delete($this->_table, ['no_terima' => $no_terima]);

		$this->db->trans_complete(); // Menyelesaikan transaction

		return $this->db->trans_status(); // Mengembalikan status transaksi (true jika berhasil)
	}

	/**
	 * [FIXED] Menghitung jumlah penerimaan per bulan dengan sintaks yang benar.
	 * Mengatasi format tanggal 'dd/mm/yyyy' dan error sintaks 1064.
	 */
	public function jumlah_per_bulan($tahun, $bulan)
	{
		$this->db->where('YEAR(tgl_terima)', $tahun);
		$this->db->where('MONTH(tgl_terima)', $bulan);
		return $this->db->get($this->_table)->num_rows();
	}
}