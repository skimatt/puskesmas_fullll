<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->model('Dokter_model');
        if (!$this->session->userdata('email') || $this->session->userdata('role') != 'dokter') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai dokter.');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Dokter';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['antrian'] = $this->Dokter_model->get_antrian_by_dokter($this->session->userdata('uuid'), 5);
        $data['notifikasi'] = $this->Dokter_model->get_notifikasi_by_dokter($this->session->userdata('uuid'), 5);
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['jadwal'] = $this->Dokter_model->get_jadwal_by_dokter($this->session->userdata('uuid'), 5);
        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/dashboard', $data);
        $this->load->view('templates/dokter/footer');
    }

    public function kelola_janji_temu() {
        $data['title'] = 'Kelola Janji Temu';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['antrian'] = $this->Dokter_model->get_antrian_by_dokter($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/kelola_janji_temu', $data);
        $this->load->view('templates/dokter/footer');
    }

    public function konfirmasi_janji_temu($uuid) {
        $antrian = $this->Dokter_model->get_antrian_by_uuid($uuid);
        if (!$antrian || $antrian->id_dokter != $this->session->userdata('uuid')) {
            $this->session->set_flashdata('error', 'Janji temu tidak ditemukan atau bukan milik Anda.');
            redirect('dokter/kelola_janji_temu');
        }

        $data['title'] = 'Konfirmasi Janji Temu';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['antrian'] = $antrian;
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('status_konfirmasi', 'Status Konfirmasi', 'required|in_list[dikonfirmasi,ditolak]');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/konfirmasi_janji_temu', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $update_data = [
                'status_konfirmasi' => $this->input->post('status_konfirmasi', TRUE),
                'catatan' => $this->input->post('catatan', TRUE),
                'status' => $this->input->post('status_konfirmasi') == 'dikonfirmasi' ? 'dikonfirmasi' : 'batal'
            ];

            if ($this->Dokter_model->update_antrian($uuid, $update_data)) {
                $this->Dokter_model->insert_notifikasi([
                    'uuid' => $this->generate_uuid(),
                    'id_pasien' => $antrian->id_pasien,
                    'pesan' => 'Janji temu Anda telah ' . $update_data['status_konfirmasi'] . '. Catatan: ' . $update_data['catatan'],
                    'status' => 'belum_dibaca',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('message', 'Janji temu berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui janji temu.');
            }
            redirect('dokter/kelola_janji_temu');
        }
    }

    public function rekam_medis($id_pasien) {
        $data['title'] = 'Rekam Medis Pasien';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['pasien'] = $this->Dokter_model->get_pasien_by_uuid($id_pasien);
        $data['rekam_medis'] = $this->Dokter_model->get_rekam_medis_by_pasien($id_pasien);
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Pasien tidak ditemukan.');
            redirect('dokter');
        }

        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required|trim');
        $this->form_validation->set_rules('tindakan', 'Tindakan', 'required|trim');
        $this->form_validation->set_rules('obat', 'Obat', 'trim');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/rekam_medis', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $rekam_medis_data = [
                'uuid' => $this->generate_uuid(),
                'id_pasien' => $id_pasien,
                'id_dokter' => $this->session->userdata('uuid'),
                'diagnosa' => $this->input->post('diagnosa', TRUE),
                'tindakan' => $this->input->post('tindakan', TRUE),
                'obat' => $this->input->post('obat', TRUE),
                'catatan' => $this->input->post('catatan', TRUE),
                'tanggal_kunjungan' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Dokter_model->insert_rekam_medis($rekam_medis_data)) {
                $this->session->set_flashdata('message', 'Rekam medis berhasil ditambahkan.');
                redirect('dokter/rekam_medis/' . $id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan rekam medis.');
                $this->load->view('templates/dokter/header', $data);
                $this->load->view('dokter/rekam_medis', $data);
                $this->load->view('templates/dokter/footer');
            }
        }
    }

    public function buat_resep($id_rekam_medis) {
        $rekam_medis = $this->Dokter_model->get_rekam_medis_by_uuid($id_rekam_medis);
        if (!$rekam_medis || $rekam_medis->id_dokter != $this->session->userdata('uuid')) {
            $this->session->set_flashdata('error', 'Rekam medis tidak ditemukan atau bukan milik Anda.');
            redirect('dokter');
        }

        $data['title'] = 'Buat Resep';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['rekam_medis'] = $rekam_medis;
        $data['obat'] = $this->Dokter_model->get_all_obat();
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('id_obat', 'Obat', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('aturan_pakai', 'Aturan Pakai', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/buat_resep', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $resep_data = [
                'uuid' => $this->generate_uuid(),
                'id_rekam_medis' => $id_rekam_medis,
                'id_obat' => $this->input->post('id_obat', TRUE),
                'jumlah' => $this->input->post('jumlah', TRUE),
                'aturan_pakai' => $this->input->post('aturan_pakai', TRUE),
                'status_ambil' => 'belum',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Dokter_model->insert_resep($resep_data)) {
                $this->session->set_flashdata('message', 'Resep berhasil dibuat.');
                redirect('dokter/rekam_medis/' . $rekam_medis->id_pasien);
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat resep.');
                $this->load->view('templates/dokter/header', $data);
                $this->load->view('dokter/buat_resep', $data);
                $this->load->view('templates/dokter/footer');
            }
        }
    }

    public function chat() {
        $data['title'] = 'Chat';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['penerima'] = $this->Dokter_model->get_penerima_chat($this->session->userdata('uuid'));
        $data['chat'] = $this->Dokter_model->get_chat_history($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/chat', $data);
        $this->load->view('templates/dokter/footer');
    }

    public function kirim_pesan() {
        $this->form_validation->set_rules('id_pasien', 'Penerima', 'required|trim');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->chat();
        } else {
            $chat_data = [
                'uuid' => $this->generate_uuid(),
                'id_pasien' => $this->input->post('id_pasien', TRUE),
                'id_dokter' => $this->session->userdata('uuid'),
                'pesan' => $this->input->post('pesan', TRUE),
                'pengirim' => 'dokter',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Dokter_model->save_chat($chat_data)) {
                $this->session->set_flashdata('message', 'Pesan berhasil dikirim.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim pesan.');
            }
            redirect('dokter/chat');
        }
    }

    public function notifikasi() {
        $data['title'] = 'Notifikasi';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['notifikasi'] = $this->Dokter_model->get_notifikasi_by_dokter($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/notifikasi', $data);
        $this->load->view('templates/dokter/footer');
    }

    public function mark_notifikasi_read($uuid) {
        if ($this->Dokter_model->mark_notifikasi_as_read($uuid, $this->session->userdata('uuid'))) {
            $this->session->set_flashdata('message', 'Notifikasi ditandai sebagai dibaca.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menandai notifikasi.');
        }
        redirect('dokter/notifikasi');
    }

    public function mark_all_notifikasi_read() {
        if ($this->Dokter_model->mark_all_notifikasi_as_read($this->session->userdata('uuid'))) {
            $this->session->set_flashdata('message', 'Semua notifikasi ditandai sebagai dibaca.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menandai semua notifikasi.');
        }
        redirect('dokter/notifikasi');
    }

    public function jadwal_praktik() {
        $data['title'] = 'Jadwal Praktik';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['jadwal'] = $this->Dokter_model->get_jadwal_by_dokter($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('hari', 'Hari', 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu]');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/jadwal_praktik', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $jadwal_data = [
                'uuid' => $this->generate_uuid(),
                'id_dokter' => $this->session->userdata('uuid'),
                'hari' => $this->input->post('hari', TRUE),
                'jam_mulai' => $this->input->post('jam_mulai', TRUE),
                'jam_selesai' => $this->input->post('jam_selesai', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Dokter_model->insert_jadwal($jadwal_data)) {
                $this->session->set_flashdata('message', 'Jadwal praktik berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan jadwal praktik.');
            }
            redirect('dokter/jadwal_praktik');
        }
    }

    public function edit_profile() {
        $data['title'] = 'Edit Profil';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'numeric|min_length[10]|max_length[13]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/edit_profile', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $dokter_data = [
                'nama' => $this->input->post('nama', TRUE),
                'spesialisasi' => $this->input->post('spesialisasi', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE)
            ];

            if (!empty($_FILES['profile_picture']['name'])) {
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = $this->session->userdata('uuid') . '_' . time();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_picture')) {
                    $upload_data = $this->upload->data();
                    $dokter_data['profile_picture'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('templates/dokter/header', $data);
                    $this->load->view('dokter/edit_profile', $data);
                    $this->load->view('templates/dokter/footer');
                    return;
                }
            }

            if ($this->Dokter_model->update_dokter($this->session->userdata('uuid'), $dokter_data)) {
                $this->session->set_userdata('nama', $dokter_data['nama']);
                if (isset($dokter_data['profile_picture'])) {
                    $this->session->set_userdata('profile_picture', $dokter_data['profile_picture']);
                }
                $this->session->set_flashdata('message', 'Profil berhasil diperbarui.');
                redirect('dokter');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                $this->load->view('templates/dokter/header', $data);
                $this->load->view('dokter/edit_profile', $data);
                $this->load->view('templates/dokter/footer');
            }
        }
    }

    public function keamanan() {
        $data['title'] = 'Keamanan';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/keamanan', $data);
            $this->load->view('templates/dokter/footer');
        } else {
            $user = $this->db->get_where('tb_users', ['uuid' => $this->session->userdata('uuid')])->row();
            if ($user && password_verify($this->input->post('current_password', TRUE), $user->password)) {
                if ($this->Dokter_model->update_password($this->session->userdata('uuid'), $this->input->post('new_password', TRUE))) {
                    $this->session->set_flashdata('message', 'Password berhasil diperbarui.');
                    redirect('dokter/keamanan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui password.');
                }
            } else {
                $this->session->set_flashdata('error', 'Password saat ini salah.');
            }
            $this->load->view('templates/dokter/header', $data);
            $this->load->view('dokter/keamanan', $data);
            $this->load->view('templates/dokter/footer');
        }
    }

    public function dokumen_medis($id_pasien) {
        $data['title'] = 'Dokumen Medis Pasien';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['pasien'] = $this->Dokter_model->get_pasien_by_uuid($id_pasien);
        $data['dokumen'] = $this->Dokter_model->get_dokumen_medis_by_pasien($id_pasien);
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));

        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Pasien tidak ditemukan.');
            redirect('dokter');
        }

        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/dokumen_medis', $data);
        $this->load->view('templates/dokter/footer');
    }

    public function tagihan() {
        $data['title'] = 'Tagihan';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_uuid($this->session->userdata('uuid'));
        $data['tagihan'] = $this->Dokter_model->get_tagihan_by_dokter($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Dokter_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/dokter/header', $data);
        $this->load->view('dokter/tagihan', $data);
        $this->load->view('templates/dokter/footer');
    }

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