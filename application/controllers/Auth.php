<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $data['judul'] = "Halaman Login";

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email Tidak Boleh Kosong',
            'valid_email' => 'Email Harus Benar'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'required' => 'Password Tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->Wpu_model->login();
        }
    }

    public function registration()
    {
        $data['judul'] = "Halaman Registration";

        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            'required' => 'Nama Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => 'Email Tidak Boleh Kosong',
            'valid_email' => 'Email Harus Benar',
            'is_unique' => 'Email Sudah Terdaftar Sebelumnya'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'required' => 'Password Tidak Boleh Kosong',
            'min_length' => 'Password Minimal Berisi 3 Karakter',
            'matches' => 'Password Tidak Sama'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
            'required' => 'Password Tidak Boleh Kosong',
            'matches' => 'Password Tidak Sama'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registrasi');
            $this->load->view('templates/auth_footer');
        } else {
            $this->Wpu_model->registrationUser();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            User Berhasil Terdaftar
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->Wpu_model->logoutUser();
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        redirect('auth');
    }

    public function blocked()
    {
        echo "404";
    }
}
