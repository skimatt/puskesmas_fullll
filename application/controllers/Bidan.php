<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->model('Bidan_model');
        if (!$this->session->userdata('email') || $this->session->userdata('role') != 'bidan') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai bidan.');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Bidan';
        $data['bidan'] = $this->Bidan_model->get_bidan_by_uuid($this->session->userdata('uuid'));
        $data['antrian'] = $this->Bidan_model->get_antrian_by_bidan($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Bidan_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/bidan/header', $data);
        $this->load->view('bidan/dashboard', $data);
        $this->load->view('templates/bidan/footer');
    }

    public function antrian() {
        $data['title'] = 'Kelola Antrian';
        $data['unread_notifikasi'] = $this->Bidan_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['antrian'] = $this->Bidan_model->get_antrian_by_bidan($this->session->userdata('uuid'), 10);

        if ($this->input->post('id_antrian') && $this->input->post('status')) {
            $id_antrian = $this->input->post('id_antrian', TRUE);
            $status = $this->input->post('status', TRUE);
            if (in_array($status, array('Menunggu', 'Diproses', 'Selesai'))) {
                if ($this->Bidan_model->update_antrian_status($id_antrian, $status)) {
                    $this->session->set_flashdata('message', 'Status antrian berhasil diperbarui.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui status antrian.');
                }
            } else {
                $this->session->set_flashdata('error', 'Status tidak valid.');
            }
            redirect('bidan/antrian');
        }

        $this->load->view('templates/bidan/header', $data);
        $this->load->view('bidan/antrian', $data);
        $this->load->view('templates/bidan/footer');
    }

    public function chat() {
        $data['title'] = 'Chat';
        $data['unread_notifikasi'] = $this->Bidan_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['penerima'] = $this->Bidan_model->get_penerima_chat($this->session->userdata('uuid'));
        $data['chat'] = $this->Bidan_model->get_chat_history($this->session->userdata('uuid'));

        $this->load->view('templates/bidan/header', $data);
        $this->load->view('bidan/chat', $data);
        $this->load->view('templates/bidan/footer');
    }

    public function kirim_pesan() {
        $this->form_validation->set_rules('uuid_penerima', 'Penerima', 'required|trim');
        $this->form_validation->set_rules('role_penerima', 'Role Penerima', 'required|trim|in_list[pasien]');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Chat';
            $data['unread_notifikasi'] = $this->Bidan_model->count_unread_notifikasi($this->session->userdata('uuid'));
            $data['penerima'] = $this->Bidan_model->get_penerima_chat($this->session->userdata('uuid'));
            $data['chat'] = $this->Bidan_model->get_chat_history($this->session->userdata('uuid'));
            $this->load->view('templates/bidan/header', $data);
            $this->load->view('bidan/chat', $data);
            $this->load->view('templates/bidan/footer');
        } else {
            $chat_data = array(
                'uuid_pasien' => $this->input->post('uuid_penerima', TRUE),
                'uuid_penerima' => $this->session->userdata('uuid'),
                'role_penerima' => 'pasien',
                'pesan' => $this->input->post('pesan', TRUE),
                'pengirim' => 'bidan',
                'created_at' => date('Y-m-d H:i:s'),
                'is_read' => 0
            );

            if ($this->Bidan_model->save_chat($chat_data)) {
                $this->session->set_flashdata('message', 'Pesan berhasil dikirim.');
                redirect('bidan/chat');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim pesan.');
                redirect('bidan/chat');
            }
        }
    }

    public function edit_profile() {
        $data['title'] = 'Edit Profil';
        $data['unread_notifikasi'] = $this->Bidan_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['bidan'] = $this->Bidan_model->get_bidan_by_uuid($this->session->userdata('uuid'));

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('no_telepon', 'No Telepon', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/bidan/header', $data);
            $this->load->view('bidan/edit_profile', $data);
            $this->load->view('templates/bidan/footer');
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            );

            // Handle profile picture upload
            if (!empty($_FILES['profile_picture']['name'])) {
                $config['upload_path'] = './Uploads/profile/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = $this->session->userdata('uuid') . '_' . time();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_picture')) {
                    $upload_data = $this->upload->data();
                    $update_data['profile_picture'] = $upload_data['file_name'];
                    // Update session
                    $this->session->set_userdata('profile_picture', $update_data['profile_picture']);
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('templates/bidan/header', $data);
                    $this->load->view('bidan/edit_profile', $data);
                    $this->load->view('templates/bidan/footer');
                    return;
                }
            }

            if ($this->Bidan_model->update_profile($this->session->userdata('uuid'), $update_data)) {
                $this->session->set_userdata(array(
                    'nama' => $update_data['nama'],
                    'email' => $update_data['email']
                ));
                $this->session->set_flashdata('message', 'Profil berhasil diperbarui.');
                redirect('bidan');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                $this->load->view('templates/bidan/header', $data);
                $this->load->view('bidan/edit_profile', $data);
                $this->load->view('templates/bidan/footer');
            }
        }
    }
}