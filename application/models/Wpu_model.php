<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wpu_model extends CI_Model
{
  public function registrationUser()
  {
    $data = [
      'name' => htmlspecialchars($this->input->post('name', true)),
      'email' => htmlspecialchars($this->input->post('email', true)),
      'image' => 'default.jpg',
      'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
      'role_id' => 2,
      'is_active' => 1,
      'date_created' => time()
    ];

    $this->db->insert('user', $data);
  }

  public function login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      if ($user['is_active'] == 1) {
        if (password_verify($password, $user['password'])) {
          $data = [
            'email' => $user['email'],
            'role_id' => $user['role_id']
          ];

          $this->session->set_userdata($data);
          if ($user['role_id'] == 1) {
            redirect('admin');
          } else {
            redirect('user');
          }
        } else {
          $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password Salah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            User Belum Aktif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
            User Belum Registrasi
            <button type="button" class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
          </div>');
      redirect('auth');
    }
  }

  public function logoutUser()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');
    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
    redirect('auth');
  }

  public function userLogin()
  {
    return $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
  }

  public function getMenu()
  {
    return $this->db->get('user_menu')->result_array();
  }

  public function getMenuById($id)
  {
    return $this->db->get_where('user_menu', ['id' => $id])->row_array();
  }

  public function hapusMenu($id)
  {
    $this->db->delete('user_menu', ['id' => $id]);
  }

  public function ubahMenu()
  {
    $data = [
      'menu' => htmlspecialchars($this->input->post('menu', true))
    ];

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('user_menu', $data);
  }

  public function getSubMenu()
  {
    $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
              FROM `user_sub_menu` JOIN `user_menu`
              ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
  ";
    return $this->db->query($query)->result_array();
  }

  public function insertSubMenu()
  {
    $data = [
      'title' => htmlspecialchars($this->input->post('title', true)),
      'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
      'url' => htmlspecialchars($this->input->post('url', true)),
      'icon' => htmlspecialchars($this->input->post('icon', true)),
      'is_active' => $this->input->post('is_active')
    ];

    $this->db->insert('user_sub_menu', $data);
  }
}
