<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function index()
    {
        $data['judul'] = 'Menu Management';
        $data['user'] = $this->Wpu_model->userLogin();
        $data['menu'] = $this->Wpu_model->getMenu();

        $this->form_validation->set_rules('menu', 'Menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => htmlspecialchars($this->input->post('menu'), true)]);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">New Menu Added</div>');
            redirect('menu');
        }
    }

    public function hapusMenu($id)
    {
        $this->Wpu_model->hapusMenu($id);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">New Menu Deleted</div>');
        redirect('menu');
    }

    public function ubahMenu($id)
    {
        $data['judul'] = 'Change Menu Management';
        $data['user'] = $this->Wpu_model->userLogin();
        $data['menu'] = $this->Wpu_model->getMenuById($id);

        $this->form_validation->set_rules('menu', 'Menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Wpu_model->ubahMenu();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Menu Changed</div>');
            redirect('menu');
        }
    }

    public function subMenu()
    {
        $data['judul'] = 'Submenu Management';
        $data['user'] = $this->Wpu_model->userLogin();
        $data['menu'] = $this->Wpu_model->getMenu();
        $data['subMenu'] = $this->Wpu_model->getSubMenu();

        $this->form_validation->set_rules('title', 'Title', 'required|trim', [
            'required' => 'Judul Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required|trim', [
            'required' => 'Url Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim', [
            'required' => 'Icon Tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/subMenu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Wpu_model->insertSubMenu();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">New Menu Added</div>');
            redirect('menu/subMenu');
        }
    }
}
