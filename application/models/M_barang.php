<?php

class M_barang extends CI_Model
{
	protected $_table = 'barang';

	public function lihat()
	{
		$this->db->select('kode_barang, nama_barang, stok, satuan, harga, image');
		$this->db->from($this->_table);
		$this->db->order_by('kode_barang', 'ASC');
		return $this->db->get()->result();
	}

	public function jumlah()
	{
		return $this->db->get($this->_table)->num_rows();
	}

	public function lihat_stok($min_stok = 1)
	{
		$this->db->select('kode_barang, nama_barang, stok, satuan, harga');
		$this->db->from($this->_table);
		$this->db->where('stok >=', $min_stok);
		return $this->db->get()->result();
	}

	public function lihat_id($kode_barang)
	{
		$this->db->select('kode_barang, nama_barang, stok, satuan, harga, image');
		$this->db->from($this->_table);
		$this->db->where('kode_barang', $kode_barang);
		return $this->db->get()->row();
	}

	public function lihat_nama_barang($nama_barang)
	{
		$this->db->select('kode_barang, nama_barang, stok, satuan, harga');
		$this->db->from($this->_table);
		$this->db->where('nama_barang', $nama_barang);
		return $this->db->get()->row();
	}

	public function cari_nama_barang($nama_barang)
	{
		$this->db->select('kode_barang, nama_barang, stok, satuan, harga');
		$this->db->like('nama_barang', $nama_barang, 'both');
		return $this->db->get($this->_table)->result();
	}

	public function tambah($data)
	{
		return $this->db->insert($this->_table, $data);
	}

	/**
	 * [FIXED] Menggunakan kode_barang (Primary Key) untuk menjamin akurasi data.
	 */
	public function add_stok($jumlah, $kode_barang)
    {
        $this->db->where('kode_barang', $kode_barang);
        $this->db->set('stok', 'stok + ' . (int) $jumlah, FALSE);
        return $this->db->update($this->_table);
    }

    /**
     * [FIXED] Menggunakan kode_barang (Primary Key) untuk menjamin akurasi data.
     */
    public function min_stok($jumlah, $kode_barang)
    {
        $barang = $this->lihat_id($kode_barang);
        if (!$barang || $barang->stok < $jumlah) {
            return false; // Mengembalikan false jika stok tidak cukup
        }

        $this->db->where('kode_barang', $kode_barang);
        $this->db->set('stok', 'stok - ' . (int) $jumlah, FALSE);
        return $this->db->update($this->_table);
    }

	public function ubah($data, $kode_barang)
	{
		$this->db->where('kode_barang', $kode_barang);
		return $this->db->update($this->_table, $data);
	}

	public function hapus($kode_barang)
	{
		return $this->db->delete($this->_table, ['kode_barang' => $kode_barang]);
	}
}