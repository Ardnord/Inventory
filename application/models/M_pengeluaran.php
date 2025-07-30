<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengeluaran extends CI_Model
{
	protected $_table = 'pengeluaran';
	protected $_table_detail = 'detail_keluar';

	public function jumlah()
	{
		return $this->db->count_all($this->_table);
	}

	public function lihat()
	{
		$this->db->select('no_keluar, nama_customer, tgl_keluar, jam_keluar, total_keluar, nama_petugas');
		$this->db->from($this->_table);
		$this->db->order_by('tgl_keluar', 'DESC');
		$this->db->order_by('jam_keluar', 'DESC');
		return $this->db->get()->result();
	}

	public function lihat_no_keluar($no_keluar)
	{
		return $this->db->get_where($this->_table, ['no_keluar' => $no_keluar])->row();
	}

	public function tambah($data)
	{
		return $this->db->insert($this->_table, $data);
	}

	public function hapus($no_keluar)
	{
		return $this->db->delete($this->_table, ['no_keluar' => $no_keluar]);
	}

	/**
	 * [FIXED] Menghitung total omset dari seluruh transaksi pengeluaran.
	 */
	public function total_omset()
	{
		$this->db->select_sum('total_keluar', 'total');
		$result = $this->db->get($this->_table)->row();
		return $result->total ?? 0;
	}

	/**
	 * [FIXED] Pastikan menggunakan kolom 'tgl_keluar'.
	 */
	public function jumlah_per_bulan($tahun, $bulan)
	{
		$this->db->where("YEAR(STR_TO_DATE(tgl_keluar, '%d/%m/%Y')) =", $tahun);
		$this->db->where("MONTH(STR_TO_DATE(tgl_keluar, '%d/%m/%Y')) =", $bulan);
		return $this->db->get($this->_table)->num_rows();
	}

	/**
	 * [FIXED] Pastikan menggunakan kolom 'tgl_keluar'.
	 */
	public function omset_per_bulan($tahun, $bulan)
	{
		$this->db->select_sum('total_keluar', 'total');
		$this->db->where("YEAR(STR_TO_DATE(tgl_keluar, '%d/%m/%Y')) =", $tahun);
		$this->db->where("MONTH(STR_TO_DATE(tgl_keluar, '%d/%m/%Y')) =", $bulan);
		$result = $this->db->get($this->_table)->row();
		return $result->total ?? 0;
	}

	/**
	 * [FIXED] Pastikan menggunakan kolom 'p.tgl_keluar' untuk join.
	 */
	public function get_barang_terlaris($limit = 5, $tahun = null, $bulan = null)
	{
		$this->db->select('d.nama_barang, SUM(d.jumlah) as total_keluar');
		$this->db->from($this->_table_detail . ' d');
		$this->db->join($this->_table . ' p', 'd.no_keluar = p.no_keluar');

		if ($tahun !== null && $bulan !== null) {
			// Menggunakan p.tgl_keluar karena tgl_keluar ada di tabel pengeluaran (p)
			$this->db->where("YEAR(STR_TO_DATE(p.tgl_keluar, '%d/%m/%Y')) =", $tahun);
			$this->db->where("MONTH(STR_TO_DATE(p.tgl_keluar, '%d/%m/%Y')) =", $bulan);
		}

		$this->db->group_by('d.nama_barang');
		$this->db->order_by('total_keluar', 'DESC');
		$this->db->limit($limit);

		return $this->db->get()->result();
	}
}