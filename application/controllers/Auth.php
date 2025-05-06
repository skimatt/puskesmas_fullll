<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation', 'MY_Email' => 'email']);
        $this->load->model('User_model');
    }

    public function register() {
        $data['title'] = 'Registrasi';
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tb_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('no_kk', 'No. KK', 'required|exact_length[16]|numeric');
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'required|exact_length[16]|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register', $data);
        } else {
            $uuid = $this->generate_uuid();
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user_data = [
                'uuid' => $uuid,
                'email' => $this->input->post('email', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                'nama' => $this->input->post('nama', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE),
                'role' => 'pasien',
                'verification_token' => $token
            ];
            $pasien_data = [
                'uuid' => $uuid,
                'nama' => $this->input->post('nama', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'no_ktp' => $this->input->post('no_ktp', TRUE),
                'nomor_bpjs' => $this->input->post('nomor_bpjs', TRUE),
                'golongan_darah' => $this->input->post('golongan_darah', TRUE),
                'agama' => $this->input->post('agama', TRUE),
                'pekerjaan' => $this->input->post('pekerjaan', TRUE),
                'status_perkawinan' => $this->input->post('status_perkawinan', TRUE)
            ];

            if ($this->User_model->insert_user($user_data) && $this->User_model->insert_pasien($pasien_data)) {
                if ($this->send_verification_email($user_data['email'], $token)) {
                    $this->session->set_flashdata('message', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
                    redirect('auth/login');
                } else {
                    log_message('error', 'Failed to send verification email to ' . $user_data['email']);
                    $this->session->set_flashdata('error', 'Registrasi berhasil, tetapi gagal mengirim email verifikasi. Hubungi admin.');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal. Silakan coba lagi.');
                $this->load->view('auth/register', $data);
            }
        }
    }

    public function login() {
        // Jika sudah login, redirect sesuai role
        if ($this->session->userdata('email')) {
            $role = $this->session->userdata('role');
            switch ($role) {
                case 'admin':
                    redirect('admin/dashboard');
                    break;
                case 'dokter':
                    redirect('dokter');
                    break;
                case 'bidan':
                    redirect('bidan');
                    break;
                case 'pasien':
                    redirect('pasien');
                    break;
                default:
                    log_message('error', 'Unknown role in session: ' . $role);
                    $this->session->set_flashdata('error', 'Role tidak dikenal. Silakan login ulang.');
                    redirect('auth/login');
            }
        }

        $data['title'] = 'Login';
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login', $data);
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $user = $this->db->get_where('tb_users', ['email' => $email, 'is_active' => 1])->row();

            if ($user && password_verify($password, $user->password)) {
                $session_data = [
                    'uuid' => $user->uuid,
                    'email' => $user->email,
                    'nama' => $user->nama,
                    'role' => $user->role
                ];
                $this->session->set_userdata($session_data);
                log_message('info', 'User logged in: ' . $user->email . ' with role: ' . $user->role);

                // Redirect berdasarkan role
                switch ($role) {
                    case 'admin':
                        redirect('admin/dashboard');
                        break;
                    case 'dokter':
                        redirect('dokter/dashboard');
                        break;
                    case 'bidan':
                        redirect('bidan/dashboard');
                        break;
                    case 'pasien':
                        redirect('pasien/dashboard');
                        break;
                    default:
                        log_message('error', 'Unknown role after login: ' . $user->role);
                        $this->session->set_flashdata('error', 'Role tidak dikenal. Silakan hubungi admin.');
                        redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Email, password salah, atau akun tidak aktif.');
                $this->load->view('auth/login', $data);
            }
        }
    }

    public function verify($token) {
        if ($this->User_model->verify_user($token)) {
            $this->session->set_flashdata('message', 'Akun berhasil diverifikasi! Silakan login.');
        } else {
            $this->session->set_flashdata('error', 'Token tidak valid.');
        }
        redirect('auth/login');
    }

    public function forgot_password() {
        $data['title'] = 'Lupa Password';
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/forgot_password', $data);
        } else {
            $email = $this->input->post('email', TRUE);
            $user = $this->User_model->get_user_by_email($email);
            if ($user) {
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                $this->User_model->set_reset_token($email, $token);
                if ($this->send_reset_email($email, $token)) {
                    $this->session->set_flashdata('message', 'Link reset password telah dikirim ke email Anda.');
                } else {
                    log_message('error', 'Failed to send reset email to ' . $email);
                    $this->session->set_flashdata('error', 'Gagal mengirim email reset. Hubungi admin.');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan.');
            }
            redirect('auth/forgot_password');
        }
    }

    public function reset_password($token) {
        $data['title'] = 'Reset Password';
        $user = $this->User_model->get_user_by_reset_token($token);
        if (!$user) {
            $this->session->set_flashdata('error', 'Token tidak valid atau telah kedaluwarsa.');
            redirect('auth/login');
        }

        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[8]');
        if ($this->form_validation->run() === FALSE) {
            $data['token'] = $token;
            $this->load->view('auth/reset_password', $data);
        } else {
            $password = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT);
            if ($this->User_model->update_password($user->email, $password)) {
                $this->User_model->clear_reset_token($user->email);
                $this->session->set_flashdata('message', 'Password berhasil direset. Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal mereset password.');
                $data['token'] = $token;
                $this->load->view('auth/reset_password', $data);
            }
        }
    }

    public function check_email() {
        $email = $this->input->post('email', TRUE);
        $user = $this->User_model->get_user_by_email($email);
        echo json_encode([
            'exists' => $user ? true : false,
            'csrfHash' => $this->security->get_csrf_hash()
        ]);
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

    private function send_verification_email($email, $token) {
        $this->email->ClearAllRecipients();
        $this->email->Subject = 'Verifikasi Akun Puskesmas Digital';
        $this->email->Body = 'Klik link berikut untuk verifikasi akun Anda: ' . site_url('auth/verify/' . $token);
        $this->email->AddAddress($email);

        try {
            if ($this->email->Send()) {
                log_message('info', 'Verification email sent to ' . $email);
                return true;
            } else {
                log_message('error', 'PHPMailer Error: ' . $this->email->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'PHPMailer Exception: ' . $e->getMessage());
            return false;
        }
    }

    private function send_reset_email($email, $token) {
        $this->email->ClearAllRecipients();
        $this->email->Subject = 'Reset Password Puskesmas Digital';
        $this->email->Body = 'Klik link berikut untuk reset password Anda: ' . site_url('auth/reset_password/' . $token) . '<br>Link ini berlaku selama 15 menit.';
        $this->email->AddAddress($email);

        try {
            if ($this->email->Send()) {
                return true;
            } else {
                log_message('error', 'PHPMailer Error: ' . $this->email->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'PHPMailer Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        $this->session->unset_userdata(['uuid', 'email', 'nama', 'role']);
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', 'Anda telah logout.');
        redirect('auth/login');
    }
}