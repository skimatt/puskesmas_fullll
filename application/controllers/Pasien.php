<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->model('Pasien_model');
        if (!$this->session->userdata('email') || $this->session->userdata('role') != 'pasien') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai pasien.');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['antrian'] = $this->Pasien_model->get_antrian_by_pasien($this->session->userdata('uuid'));
        $data['notifikasi'] = $this->Pasien_model->get_notifikasi_by_pasien($this->session->userdata('uuid'), 5);
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['riwayat'] = $this->Pasien_model->get_riwayat_by_pasien($this->session->userdata('uuid'), 5);
        $data['resep'] = $this->Pasien_model->get_resep_by_pasien($this->session->userdata('uuid'), 5);
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/dashboard', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function edit_profile() {
        $data['title'] = 'Edit Profil';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'numeric|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('nomor_bpjs', 'Nomor BPJS', 'numeric|exact_length[13]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/edit_profile', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            $pasien_data = [
                'nama' => $this->input->post('nama', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'nomor_bpjs' => $this->input->post('nomor_bpjs', TRUE),
                'golongan_darah' => $this->input->post('golongan_darah', TRUE),
                'agama' => $this->input->post('agama', TRUE),
                'pekerjaan' => $this->input->post('pekerjaan', TRUE),
                'status_perkawinan' => $this->input->post('status_perkawinan', TRUE)
            ];

            // Handle Profile Picture Upload
            if (!empty($_FILES['profile_picture']['name'])) {
                $config['upload_path'] = './uploads/profile/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = $this->session->userdata('uuid') . '_' . time();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_picture')) {
                    $upload_data = $this->upload->data();
                    $pasien_data['profile_picture'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('templates/pasien/header', $data);
                    $this->load->view('pasien/edit_profile', $data);
                    $this->load->view('templates/pasien/footer');
                    return;
                }
            }

            if ($this->Pasien_model->update_pasien($this->session->userdata('uuid'), $pasien_data)) {
                $this->session->set_userdata('nama', $pasien_data['nama']);
                if (isset($pasien_data['profile_picture'])) {
                    $this->session->set_userdata('profile_picture', $pasien_data['profile_picture']);
                }
                $this->session->set_flashdata('message', 'Profil berhasil diperbarui.');
                redirect('pasien');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
                $this->load->view('templates/pasien/header', $data);
                $this->load->view('pasien/edit_profile', $data);
                $this->load->view('templates/pasien/footer');
            }
        }
    }

    public function buat_janji_temu() {
        $data['title'] = 'Buat Janji Temu';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['dokter'] = $this->Pasien_model->get_all_dokter();
        $data['bidan'] = $this->Pasien_model->get_all_bidan();
        $data['jadwal'] = $this->Pasien_model->get_jadwal_praktik();

        $this->form_validation->set_rules('tanggal_antrian', 'Tanggal Antrian', 'required');
        $this->form_validation->set_rules('jam_antrian', 'Jam Antrian', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'callback_check_dokter_bidan');
        $this->form_validation->set_rules('id_bidan', 'Bidan', 'callback_check_dokter_bidan');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/buat_janji_temu', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            $antrian_data = [
                'uuid' => $this->generate_uuid(),
                'id_pasien' => $this->session->userdata('uuid'),
                'id_dokter' => $this->input->post('id_dokter', TRUE) ?: NULL,
                'id_bidan' => $this->input->post('id_bidan', TRUE) ?: NULL,
                'tanggal_antrian' => $this->input->post('tanggal_antrian', TRUE),
                'jam_antrian' => $this->input->post('jam_antrian', TRUE),
                'status' => 'menunggu',
                'status_konfirmasi' => 'pending',
                'keterangan' => $this->input->post('keterangan', TRUE)
            ];
            if ($this->Pasien_model->insert_antrian($antrian_data)) {
                $this->session->set_flashdata('message', 'Janji temu berhasil diajukan. Menunggu konfirmasi.');
                redirect('pasien');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat janji temu.');
                $this->load->view('templates/pasien/header', $data);
                $this->load->view('pasien/buat_janji_temu', $data);
                $this->load->view('templates/pasien/footer');
            }
        }
    }

    public function get_time_slots() {
        $id_dokter = $this->input->post('id_dokter', TRUE);
        $id_bidan = $this->input->post('id_bidan', TRUE);
        $tanggal = $this->input->post('tanggal', TRUE);
        $hari = date('l', strtotime($tanggal));
        $slots = $this->Pasien_model->get_available_time_slots($id_dokter, $id_bidan, $tanggal, $hari);
        echo json_encode(['slots' => $slots, 'csrfHash' => $this->security->get_csrf_hash()]);
    }

    public function batalkan_janji_temu($uuid) {
        $antrian = $this->Pasien_model->get_antrian_by_uuid($uuid);
        if ($antrian && $antrian->id_pasien == $this->session->userdata('uuid') && $antrian->status_konfirmasi == 'pending') {
            $this->Pasien_model->update_antrian($uuid, ['status' => 'batal', 'status_konfirmasi' => 'ditolak']);
            $this->session->set_flashdata('message', 'Janji temu berhasil dibatalkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membatalkan janji temu.');
        }
        redirect('pasien');
    }

    public function riwayat() {
        $data['title'] = 'Riwayat Kunjungan';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['riwayat'] = $this->Pasien_model->get_riwayat_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/riwayat', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function resep() {
        $data['title'] = 'Resep';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['resep'] = $this->Pasien_model->get_resep_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/resep', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function detail_resep($uuid) {
        $data['title'] = 'Detail Resep';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['resep'] = $this->Pasien_model->get_resep_by_uuid($uuid);
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        if (!$data['resep'] || $data['resep']->id_pasien != $this->session->userdata('uuid')) {
            $this->session->set_flashdata('error', 'Resep tidak ditemukan.');
            redirect('pasien/resep');
        }
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/detail_resep', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function rekam_medis() {
        $data['title'] = 'Rekam Medis';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['rekam_medis'] = $this->Pasien_model->get_rekam_medis_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/rekam_medis', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function dokumen_medis() {
        $data['title'] = 'Dokumen Medis';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['dokumen'] = $this->Pasien_model->get_dokumen_medis_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/dokumen_medis', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            if (!empty($_FILES['file_dokumen']['name'])) {
                $config['upload_path'] = './uploads/dokumen/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB
                $config['file_name'] = $this->session->userdata('uuid') . '_' . time();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_dokumen')) {
                    $upload_data = $this->upload->data();
                    $dokumen_data = [
                        'uuid' => $this->generate_uuid(),
                        'id_pasien' => $this->session->userdata('uuid'),
                        'nama_dokumen' => $this->input->post('nama_dokumen', TRUE),
                        'file_path' => $upload_data['file_name'],
                        'keterangan' => $this->input->post('keterangan', TRUE),
                        'tanggal_upload' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->Pasien_model->insert_dokumen_medis($dokumen_data)) {
                        $this->session->set_flashdata('message', 'Dokumen berhasil diunggah.');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menyimpan dokumen.');
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }
            } else {
                $this->session->set_flashdata('error', 'Harap pilih file dokumen.');
            }
            redirect('pasien/dokumen_medis');
        }
    }

    public function tagihan() {
        $data['title'] = 'Tagihan';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['tagihan'] = $this->Pasien_model->get_tagihan_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/tagihan', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function bayar_tagihan($uuid) {
        $data['title'] = 'Bayar Tagihan';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['tagihan'] = $this->Pasien_model->get_tagihan_by_uuid($uuid);
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));

        if (!$data['tagihan'] || $data['tagihan']->id_pasien != $this->session->userdata('uuid')) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan.');
            redirect('pasien/tagihan');
        }

        if ($data['tagihan']->status != 'belum_dibayar') {
            $this->session->set_flashdata('error', 'Tagihan sudah dibayar atau kadaluarsa.');
            redirect('pasien/tagihan');
        }

        $this->form_validation->set_rules('metode_pembayaran', 'Metode Pembayaran', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/bayar_tagihan', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            $pembayaran_data = [
                'uuid' => $this->generate_uuid(),
                'id_tagihan' => $uuid,
                'id_pasien' => $this->session->userdata('uuid'),
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'jumlah' => $data['tagihan']->jumlah,
                'metode_pembayaran' => $this->input->post('metode_pembayaran', TRUE),
                'status' => 'pending',
                'keterangan' => $this->input->post('keterangan', TRUE)
            ];

            if (!empty($_FILES['bukti_pembayaran']['name'])) {
                $config['upload_path'] = './uploads/bukti_pembayaran/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 5120; // 5MB
                $config['file_name'] = $this->session->userdata('uuid') . '_' . time();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('bukti_pembayaran')) {
                    $upload_data = $this->upload->data();
                    $pembayaran_data['bukti_pembayaran'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('templates/pasien/header', $data);
                    $this->load->view('pasien/bayar_tagihan', $data);
                    $this->load->view('templates/pasien/footer');
                    return;
                }
            }

            if ($this->Pasien_model->insert_pembayaran($pembayaran_data)) {
                $this->session->set_flashdata('message', 'Pembayaran berhasil diajukan. Menunggu konfirmasi.');
                redirect('pasien/tagihan');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengajukan pembayaran.');
                $this->load->view('templates/pasien/header', $data);
                $this->load->view('pasien/bayar_tagihan', $data);
                $this->load->view('templates/pasien/footer');
            }
        }
    }

    public function riwayat_pembayaran() {
        $data['title'] = 'Riwayat Pembayaran';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['pembayaran'] = $this->Pasien_model->get_pembayaran_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/riwayat_pembayaran', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function chat() {
        $data['title'] = 'Chat';
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $data['penerima'] = $this->Pasien_model->get_penerima_chat($this->session->userdata('uuid'));
        $data['chat'] = $this->Pasien_model->get_chat_history($this->session->userdata('uuid'));
    
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/chat', $data);
        $this->load->view('templates/pasien/footer');
    }
    
    public function kirim_pesan() {
        $this->form_validation->set_rules('uuid_penerima', 'Penerima', 'required|trim');
        $this->form_validation->set_rules('role_penerima', 'Role Penerima', 'required|trim|in_list[dokter,bidan]');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');
    
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Chat';
            $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
            $data['penerima'] = $this->Pasien_model->get_penerima_chat($this->session->userdata('uuid'));
            $data['chat'] = $this->Pasien_model->get_chat_history($this->session->userdata('uuid'));
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/chat', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            $chat_data = array(
                'uuid_pasien' => $this->session->userdata('uuid'),
                'uuid_penerima' => $this->input->post('uuid_penerima', TRUE),
                'role_penerima' => $this->input->post('role_penerima', TRUE),
                'pesan' => $this->input->post('pesan', TRUE),
                'pengirim' => 'pasien',
                'created_at' => date('Y-m-d H:i:s')
            );
    
            if ($this->Pasien_model->save_chat($chat_data)) {
                $this->session->set_flashdata('message', 'Pesan berhasil dikirim.');
                redirect('pasien/chat');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim pesan. Silakan coba lagi.');
                redirect('pasien/chat');
            }
        }
    }

    public function notifikasi() {
        $data['title'] = 'Notifikasi';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['notifikasi'] = $this->Pasien_model->get_notifikasi_by_pasien($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/notifikasi', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function mark_notifikasi_read($uuid) {
        if ($this->Pasien_model->mark_notifikasi_as_read($uuid, $this->session->userdata('uuid'))) {
            $this->session->set_flashdata('message', 'Notifikasi ditandai sebagai dibaca.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menandai notifikasi.');
        }
        redirect('pasien/notifikasi');
    }

    public function mark_all_notifikasi_read() {
        if ($this->Pasien_model->mark_all_notifikasi_as_read($this->session->userdata('uuid'))) {
            $this->session->set_flashdata('message', 'Semua notifikasi ditandai sebagai dibaca.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menandai semua notifikasi.');
        }
        redirect('pasien/notifikasi');
    }

    public function get_new_notifikasi() {
        $last_check = $this->input->post('last_check', TRUE) ?: date('Y-m-d H:i:s', strtotime('-1 minute'));
        $notifikasi = $this->Pasien_model->get_new_notifikasi($this->session->userdata('uuid'), $last_check);
        $response = [
            'notifikasi' => $notifikasi,
            'csrfHash' => $this->security->get_csrf_hash()
        ];
        echo json_encode($response);
    }

    public function get_unread_count() {
        echo json_encode(['count' => $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'))]);
    }

    public function akun() {
        $data['title'] = 'Pengaturan Akun';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));
        $this->load->view('templates/pasien/header', $data);
        $this->load->view('pasien/akun', $data);
        $this->load->view('templates/pasien/footer');
    }

    public function keamanan() {
        $data['title'] = 'Keamanan';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_uuid($this->session->userdata('uuid'));
        $data['unread_notifikasi'] = $this->Pasien_model->count_unread_notifikasi($this->session->userdata('uuid'));

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/keamanan', $data);
            $this->load->view('templates/pasien/footer');
        } else {
            $user = $this->db->get_where('tb_users', ['uuid' => $this->session->userdata('uuid')])->row();
            if ($user && password_verify($this->input->post('current_password', TRUE), $user->password)) {
                if ($this->Pasien_model->update_password($this->session->userdata('uuid'), $this->input->post('new_password', TRUE))) {
                    $this->session->set_flashdata('message', 'Password berhasil diperbarui.');
                    redirect('pasien/keamanan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui password.');
                }
            } else {
                $this->session->set_flashdata('error', 'Password saat ini salah.');
            }
            $this->load->view('templates/pasien/header', $data);
            $this->load->view('pasien/keamanan', $data);
            $this->load->view('templates/pasien/footer');
        }
    }

    public function check_dokter_bidan() {
        $id_dokter = $this->input->post('id_dokter', TRUE);
        $id_bidan = $this->input->post('id_bidan', TRUE);
        if (empty($id_dokter) && empty($id_bidan)) {
            $this->form_validation->set_message('check_dokter_bidan', 'Pilih dokter atau bidan.');
            return FALSE;
        }
        return TRUE;
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