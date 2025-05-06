<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Admin_model');
        // Cek login dan role admin
        if (!$this->session->userdata('email') || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Silakan login sebagai admin.');
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin';
        $data['total_pasien'] = $this->Admin_model->count_users_by_role('pasien');
        $data['total_dokter'] = $this->Admin_model->count_users_by_role('dokter');
        $data['total_bidan'] = $this->Admin_model->count_users_by_role('bidan');
        $data['total_admin'] = $this->Admin_model->count_users_by_role('admin');
        $data['total_obat'] = $this->Admin_model->count_obat();
        $data['antrian_hari_ini'] = $this->Admin_model->count_antrian_hari_ini();
        $data['riwayat_bulan_ini'] = $this->Admin_model->count_riwayat_bulan_ini();
        $data['antrian'] = $this->Admin_model->get_antrian_hari_ini();
        $data['jadwal'] = $this->Admin_model->get_jadwal_hari_ini();
        $data['obat_rendah'] = $this->Admin_model->get_obat_stok_rendah();
        $data['riwayat'] = $this->Admin_model->get_riwayat_terbaru();
        $data['total_resep_belum_diambil'] = $this->Admin_model->count_resep_belum_diambil();
        $data['resep_belum_diambil'] = $this->Admin_model->get_resep_belum_diambil();
        $data['notifikasi'] = $this->Admin_model->get_notifikasi_terbaru();
        $data['chat'] = $this->Admin_model->get_chat_terbaru();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin/footer');
    }

    // Manajemen Pasien
    public function manage_pasien() {
        $data['title'] = 'Kelola Pasien';
        $data['pasien'] = $this->Admin_model->get_all_pasien();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_pasien', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_pasien() {
        $data['title'] = 'Tambah Pasien';
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('no_kk', 'No. KK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'required|exact_length[16]|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/add_pasien', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $uuid = $this->generate_uuid();
            $user_data = array(
                'uuid' => $uuid,
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE),
                'role' => 'pasien',
                'is_active' => 1
            );
            $pasien_data = array(
                'uuid' => $uuid,
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE)
            );
            if ($this->Admin_model->insert_pasien($user_data, $pasien_data)) {
                $this->session->set_flashdata('message', 'Pasien berhasil ditambahkan.');
                redirect('admin/manage_pasien');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pasien.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/add_pasien', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function edit_pasien($uuid) {
        $data['title'] = 'Edit Pasien';
        $data['pasien'] = $this->Admin_model->get_pasien_by_uuid($uuid);
        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Pasien tidak ditemukan.');
            redirect('admin/manage_pasien');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_kk', 'No. KK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_pasien', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $pasien_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE)
            );
            $user_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE),
                'is_active' => $this->input->post('is_active', TRUE)
            );
            if ($this->Admin_model->update_pasien($uuid, $pasien_data, $user_data)) {
                $this->session->set_flashdata('message', 'Pasien berhasil diperbarui.');
                redirect('admin/manage_pasien');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui pasien.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_pasien', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function delete_pasien($uuid) {
        if ($this->Admin_model->delete_pasien($uuid)) {
            $this->session->set_flashdata('message', 'Pasien berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pasien.');
        }
        redirect('admin/manage_pasien');
    }

    // Manajemen Dokter
    public function manage_dokter() {
        $data['title'] = 'Kelola Dokter';
        $data['dokter'] = $this->Admin_model->get_all_dokter();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_dokter', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_dokter() {
        $data['title'] = 'Tambah Dokter';
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/add_dokter', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $uuid = $this->generate_uuid();
            $user_data = array(
                'uuid' => $uuid,
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => '0000000000000000',
                'no_ktp' => '0000000000000000',
                'role' => 'dokter',
                'is_active' => 1
            );
            $dokter_data = array(
                'uuid' => $uuid,
                'nama' => $this->input->post('nama', TRUE),
                'spesialisasi' => $this->input->post('spesialisasi', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            );
            if ($this->Admin_model->insert_dokter($user_data, $dokter_data)) {
                $this->session->set_flashdata('message', 'Dokter berhasil ditambahkan.');
                redirect('admin/manage_dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan dokter.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/add_dokter', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function edit_dokter($uuid) {
        $data['title'] = 'Edit Dokter';
        $data['dokter'] = $this->Admin_model->get_dokter_by_uuid($uuid);
        if (!$data['dokter']) {
            $this->session->set_flashdata('error', 'Dokter tidak ditemukan.');
            redirect('admin/manage_dokter');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_dokter', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $dokter_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'spesialisasi' => $this->input->post('spesialisasi', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            );
            $user_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'is_active' => $this->input->post('is_active', TRUE)
            );
            if ($this->Admin_model->update_dokter($uuid, $dokter_data, $user_data)) {
                $this->session->set_flashdata('message', 'Dokter berhasil diperbarui.');
                redirect('admin/manage_dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui dokter.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_dokter', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function delete_dokter($uuid) {
        if ($this->Admin_model->delete_dokter($uuid)) {
            $this->session->set_flashdata('message', 'Dokter berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus dokter.');
        }
        redirect('admin/manage_dokter');
    }

    // Manajemen Bidan
    public function manage_bidan() {
        $data['title'] = 'Kelola Bidan';
        $data['bidan'] = $this->Admin_model->get_all_bidan();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_bidan', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_bidan() {
        $data['title'] = 'Tambah Bidan';
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/add_bidan', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $uuid = $this->generate_uuid();
            $user_data = array(
                'uuid' => $uuid,
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => '0000000000000000',
                'no_ktp' => '0000000000000000',
                'role' => 'bidan',
                'is_active' => 1
            );
            $bidan_data = array(
                'uuid' => $uuid,
                'nama' => $this->input->post('nama', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            );
            if ($this->Admin_model->insert_bidan($user_data, $bidan_data)) {
                $this->session->set_flashdata('message', 'Bidan berhasil ditambahkan.');
                redirect('admin/manage_bidan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan bidan.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/add_bidan', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function edit_bidan($uuid) {
        $data['title'] = 'Edit Bidan';
        $data['bidan'] = $this->Admin_model->get_bidan_by_uuid($uuid);
        if (!$data['bidan']) {
            $this->session->set_flashdata('error', 'Bidan tidak ditemukan.');
            redirect('admin/manage_bidan');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_bidan', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $bidan_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            );
            $user_data = array(
                'nama' => $this->input->post('nama', TRUE),
                'is_active' => $this->input->post('is_active', TRUE)
            );
            if ($this->Admin_model->update_bidan($uuid, $bidan_data, $user_data)) {
                $this->session->set_flashdata('message', 'Bidan berhasil diperbarui.');
                redirect('admin/manage_bidan');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui bidan.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_bidan', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function delete_bidan($uuid) {
        if ($this->Admin_model->delete_bidan($uuid)) {
            $this->session->set_flashdata('message', 'Bidan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus bidan.');
        }
        redirect('admin/manage_bidan');
    }

    // Manajemen Obat
    public function manage_obat() {
        $data['title'] = 'Kelola Obat';
        $data['obat'] = $this->Admin_model->get_all_obat();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_obat', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_obat() {
        $data['title'] = 'Tambah Obat';
        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|trim');
        $this->form_validation->set_rules('jenis_obat', 'Jenis Obat', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/add_obat', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $obat_data = array(
                'uuid' => $this->generate_uuid(),
                'nama_obat' => $this->input->post('nama_obat', TRUE),
                'jenis_obat' => $this->input->post('jenis_obat', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'harga' => $this->input->post('harga', TRUE)
            );
            if ($this->Admin_model->insert_obat($obat_data)) {
                $this->session->set_flashdata('message', 'Obat berhasil ditambahkan.');
                redirect('admin/manage_obat');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan obat.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/add_obat', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function edit_obat($uuid) {
        $data['title'] = 'Edit Obat';
        $data['obat'] = $this->Admin_model->get_obat_by_uuid($uuid);
        if (!$data['obat']) {
            $this->session->set_flashdata('error', 'Obat tidak ditemukan.');
            redirect('admin/manage_obat');
        }
        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|trim');
        $this->form_validation->set_rules('jenis_obat', 'Jenis Obat', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_obat', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $obat_data = array(
                'nama_obat' => $this->input->post('nama_obat', TRUE),
                'jenis_obat' => $this->input->post('jenis_obat', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'harga' => $this->input->post('harga', TRUE)
            );
            if ($this->Admin_model->update_obat($uuid, $obat_data)) {
                $this->session->set_flashdata('message', 'Obat berhasil diperbarui.');
                redirect('admin/manage_obat');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui obat.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_obat', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    public function delete_obat($uuid) {
        if ($this->Admin_model->delete_obat($uuid)) {
            $this->session->set_flashdata('message', 'Obat berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus obat.');
        }
        redirect('admin/manage_obat');
    }

    // Manajemen Antrian
    public function antrian() {
        $data['title'] = 'Kelola Antrian';
        $data['antrian'] = $this->Admin_model->get_all_antrian();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_antrian', $data);
        $this->load->view('templates/admin/footer');
    }

    public function edit_antrian($uuid) {
        $data['title'] = 'Edit Antrian';
        $data['antrian'] = $this->Admin_model->get_antrian_by_uuid($uuid);
        if (!$data['antrian']) {
            $this->session->set_flashdata('error', 'Antrian tidak ditemukan.');
            redirect('admin/antrian');
        }
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[menunggu,selesai,batal]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_antrian', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $antrian_data = array(
                'status' => $this->input->post('status', TRUE)
            );
            if ($this->Admin_model->update_antrian($uuid, $antrian_data)) {
                $this->session->set_flashdata('message', 'Antrian berhasil diperbarui.');
                redirect('admin/antrian');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui antrian.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_antrian', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    // Riwayat Kunjungan
    public function riwayat() {
        $data['title'] = 'Riwayat Kunjungan';
        $data['riwayat'] = $this->Admin_model->get_all_riwayat();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/riwayat_kunjungan', $data);
        $this->load->view('templates/admin/footer');
    }

    // Manajemen Resep
    public function resep() {
        $data['title'] = 'Kelola Resep';
        $data['resep'] = $this->Admin_model->get_all_resep();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/manage_resep', $data);
        $this->load->view('templates/admin/footer');
    }

    public function edit_resep($uuid) {
        $data['title'] = 'Edit Resep';
        $data['resep'] = $this->Admin_model->get_resep_by_uuid($uuid);
        if (!$data['resep']) {
            $this->session->set_flashdata('error', 'Resep tidak ditemukan.');
            redirect('admin/resep');
        }
        $this->form_validation->set_rules('status_ambil', 'Status Ambil', 'required|in_list[belum,sudah]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('admin/edit_resep', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $resep_data = array(
                'status_ambil' => $this->input->post('status_ambil', TRUE)
            );
            if ($this->Admin_model->update_resep($uuid, $resep_data)) {
                $this->session->set_flashdata('message', 'Resep berhasil diperbarui.');
                redirect('admin/resep');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui resep.');
                $this->load->view('templates/admin/header', $data);
                $this->load->view('admin/edit_resep', $data);
                $this->load->view('templates/admin/footer');
            }
        }
    }

    // Notifikasi
    public function notifikasi() {
        $data['title'] = 'Notifikasi';
        $data['notifikasi'] = $this->Admin_model->get_all_notifikasi();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/notifikasi', $data);
        $this->load->view('templates/admin/footer');
    }

    public function mark_notifikasi_read($uuid) {
        if ($this->Admin_model->mark_notifikasi_read($uuid)) {
            $this->session->set_flashdata('message', 'Notifikasi ditandai sebagai dibaca.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menandai notifikasi.');
        }
        redirect('admin/notifikasi');
    }

    // Chat
    public function chat() {
        $data['title'] = 'Chat';
        $data['chat'] = $this->Admin_model->get_all_chat();
        $this->load->view('templates/admin/header', $data);
        $this->load->view('admin/chat', $data);
        $this->load->view('templates/admin/footer');
    }

    // Fungsi untuk generate UUID
    private function generate_uuid() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}