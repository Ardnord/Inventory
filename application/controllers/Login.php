<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct(); // PENTING: Memanggil konstruktor parent untuk inisialisasi CI_Controller

        // --- Perbaikan Utama: Memuat Library dan Helper ---
        $this->load->library('session'); // Memuat Library Session untuk `$this->session`
        $this->load->helper('url');     // Memuat URL Helper untuk fungsi `redirect()`
        // Input library secara otomatis dimuat oleh CI_Controller, jadi tidak perlu di sini
        // Namun, jika Anda ingin eksplisit atau ada kasus aneh: $this->load->library('input');
        // --- Akhir Perbaikan ---

        date_default_timezone_set('Asia/Jakarta');

        // Cek jika sudah login, alihkan ke dashboard.
        // Pastikan 'login' adalah nama session key yang benar.
        if($this->session->userdata('login')) { // Gunakan userdata() untuk mengecek session
            redirect('dashboard');
        }

        // Memuat model dengan alias
        $this->load->model('M_petugas', 'm_petugas');
        $this->load->model('M_pengguna', 'm_pengguna');
    }

    public function index(){
        // Menampilkan view login
        $this->load->view('login');
    }

    public function proses_login(){
        // Memastikan request adalah POST agar lebih aman
        if($this->input->method() !== 'post'){
            show_404(); // Atau redirect ke halaman login dengan pesan error
            return;
        }

        $role = $this->input->post('role');
        $username = $this->input->post('username');

        if($role === 'petugas'){
            $this->_proses_login_petugas($username);
        } elseif($role === 'admin'){
            $this->_proses_login_admin($username);
        } else {
            // Menggunakan flashdata untuk pesan error lebih baik daripada alert JS langsung
            $this->session->set_flashdata('error', 'Role tidak tersedia!');
            redirect('login'); // Kembali ke halaman login
        }
    }

    protected function _proses_login_petugas($username){
        $get_petugas = $this->m_petugas->lihat_username($username);

        if($get_petugas){
            // Sangat disarankan menggunakan password hashing (misal: password_verify)
            // if(password_verify($this->input->post('password'), $get_petugas->password)) {
            if($get_petugas->password == $this->input->post('password')){ // Contoh perbandingan sederhana
                $session_data = [
                    'kode'       => $get_petugas->kode,
                    'nama'       => $get_petugas->nama,
                    'username'   => $get_petugas->username,
                    // HINDARI menyimpan password di session demi keamanan!
                    // 'password' => $get_petugas->password,
                    'role'       => $this->input->post('role'),
                    'jam_masuk'  => date('H:i:s')
                ];

                $this->session->set_userdata('login', $session_data);
                $this->session->set_flashdata('success', '<strong>Login</strong> Berhasil!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password Salah!');
                redirect('login'); // Redirect ke halaman login
            }
        } else {
            $this->session->set_flashdata('error', 'Username Salah!');
            redirect('login'); // Redirect ke halaman login
        }
    }

    protected function _proses_login_admin($username){
        $get_pengguna = $this->m_pengguna->lihat_username($username);

        if($get_pengguna){
            // Sangat disarankan menggunakan password hashing (misal: password_verify)
            // if(password_verify($this->input->post('password'), $get_pengguna->password)) {
            if($get_pengguna->password == $this->input->post('password')){ // Contoh perbandingan sederhana
                $session_data = [
                    'kode'       => $get_pengguna->kode,
                    'nama'       => $get_pengguna->nama,
                    'username'   => $get_pengguna->username,
                    // HINDARI menyimpan password di session demi keamanan!
                    // 'password' => $get_pengguna->password,
                    'role'       => $this->input->post('role'),
                    'jam_masuk'  => date('H:i:s')
                ];

                $this->session->set_userdata('login', $session_data);
                $this->session->set_flashdata('success', '<strong>Login</strong> Berhasil!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password Salah!');
                redirect('login'); // Redirect ke halaman login
            }
        } else {
            $this->session->set_flashdata('error', 'Username Salah!');
            redirect('login'); // Redirect ke halaman login
        }
    }
}