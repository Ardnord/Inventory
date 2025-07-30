<?php

class M_detail_keluar extends CI_Model
{
	protected $_table = 'detail_keluar';

	public function tambah($data)
	{
		return $this->db->insert_batch($this->_table, $data);
	}

	/**
	 * =================================================================
	 * PERBAIKAN UTAMA ADA DI FUNGSI INI
	 * =================================================================
	 * Kita perintahkan query untuk secara spesifik mengambil kolom
	 * 'harga' dan 'sub_total' agar bisa ditampilkan di view.
	 */
	public function lihat_no_keluar($no_keluar)
	{
		$this->db->select('nama_barang, harga, jumlah, satuan, sub_total');
		$this->db->from($this->_table);
		$this->db->where('no_keluar', $no_keluar);
		return $this->db->get()->result();
	}

	public function hapus($no_keluar)
	{
		return $this->db->delete($this->_table, ['no_keluar' => $no_keluar]);
	}
}