<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $data['judul'] = "Halaman Login";

        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }

    public function registration()
    {
        $data['judul'] = "Halaman Registration";

        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/registrasi');
        $this->load->view('templates/auth_footer');
    }
}
