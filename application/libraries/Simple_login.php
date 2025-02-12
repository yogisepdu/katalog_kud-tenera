<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple_login
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
        // load user model
        $this->CI->load->model('user_model');
	}

	// Fungsi login
	public function login($username, $password)
{
    // Cek apakah username dan password valid
    $user_login = $this->CI->user_model->login($username, $password);
    if ($user_login) {
        // Menyimpan data user ke dalam session
        $this->CI->session->set_userdata([
            'id_user' => $user_login->id_user,
            'id_bagian' => $user_login->id_bagian,
            'nama_bagian' => $user_login->nama_bagian,
            'username' => $username,
            'nama' => $user_login->nama,
            'akses_level' => $user_login->akses_level
        ]);

        // Cek apakah ada pengalihan halaman sebelumnya
        if ($this->CI->session->userdata('pengalihan')) {
            $pengalihan = $this->CI->session->userdata('pengalihan');
            $this->CI->session->unset_userdata('pengalihan'); // pastikan session pengalihan dihapus setelah digunakan
            redirect($pengalihan, 'refresh');
        } else {
            // Jika tidak ada, alihkan ke halaman dashboard
            redirect(base_url('admin/dasbor'), 'refresh');
        }
    } else {
        // Jika login gagal, alihkan langsung ke login tanpa flashdata
        redirect(base_url('login'), 'refresh');
    }
}


	public function logout()
{
    // Menghapus semua data session
    $this->CI->session->unset_userdata([
        'id_user', 'id_bagian', 'nama_bagian', 'username', 'nama', 'akses_level', 'pengalihan'
    ]);
    
    // Redirect ke halaman login tanpa flashdata
    redirect(base_url('login'), 'refresh');
}

	// Fungsi check login: seseorang sudah login atau belum
	public function check_login($pengalihan)
	{
		// Check status login (kita ambil status username dan akses level)
		if($this->CI->session->userdata('username') == "" && 
			$this->CI->session->userdata('akses_level') == "")
		{
			$this->CI->session->set_flashdata('warning', 'Anda belum login');
			redirect(base_url('login'),'refresh');
		}
	}

	// Fungsi check login: seseorang sudah login atau belum
	public function cek_login($pengalihan)
	{
		// Check status login (kita ambil status username dan akses level)
		if($this->CI->session->userdata('username') == "" && 
			$this->CI->session->userdata('akses_level') == "")
		{
			$this->CI->session->set_flashdata('warning', 'Anda belum login');
			redirect(base_url('login'),'refresh');
		}
	}
}

/* End of file Simple_login.php */
/* Location: ./application/libraries/Simple_login.php */
