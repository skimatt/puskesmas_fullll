<?php
class User_model extends CI_Model {
    public function insert_user($data) {
        return $this->db->insert('tb_users', $data);
    }

    public function insert_pasien($data) {
        return $this->db->insert('tb_pasien', $data);
    }

    public function get_user_by_email($email) {
        return $this->db->get_where('tb_users', array('email' => $email))->row();
    }

    public function verify_user($token) {
        $user = $this->db->get_where('tb_users', array('verification_token' => $token))->row();
        if ($user) {
            $this->db->update('tb_users', array('is_active' => 1, 'verification_token' => NULL), array('id' => $user->id));
            return true;
        }
        return false;
    }

    public function set_reset_token($email, $token) {
        $this->db->update('tb_users', array('reset_token' => $token), array('email' => $email));
    }

    public function get_user_by_reset_token($token) {
        return $this->db->get_where('tb_users', array('reset_token' => $token))->row();
    }

    public function update_password($email, $password) {
        return $this->db->update('tb_users', array('password' => $password), array('email' => $email));
    }

    public function clear_reset_token($email) {
        $this->db->update('tb_users', array('reset_token' => NULL), array('email' => $email));
    }
}