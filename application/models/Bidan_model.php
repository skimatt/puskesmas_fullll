<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidan_model extends CI_Model {
    public function get_bidan_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->get('tb_bidan')->row();
    }

    public function count_unread_notifikasi($uuid) {
        $this->db->where('uuid_penerima', $uuid);
        $this->db->where('role_penerima', 'bidan');
        $this->db->where('pengirim', 'pasien');
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('tb_chat');
    }

    public function get_antrian_by_bidan($uuid, $limit = 5) {
        $this->db->select('tb_antrian.id_antrian, tb_antrian.nomor_antrian, tb_antrian.tanggal, tb_antrian.waktu, tb_antrian.status, tb_pasien.nama as nama_pasien');
        $this->db->from('tb_antrian');
        $this->db->join('tb_pasien', 'tb_antrian.uuid_pasien = tb_pasien.uuid', 'left');
        $this->db->where('tb_antrian.uuid_bidan', $uuid);
        $this->db->where('tb_antrian.tanggal >=', date('Y-m-d'));
        $this->db->order_by('tb_antrian.tanggal', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function update_antrian_status($id_antrian, $status) {
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->update('tb_antrian', array('status' => $status));
    }

    public function get_penerima_chat($uuid_bidan) {
        return $this->db->select('uuid, nama, "pasien" as role')
                       ->get('tb_pasien')
                       ->result();
    }

    public function get_chat_history($uuid_bidan) {
        $this->db->where('uuid_penerima', $uuid_bidan);
        $this->db->where('role_penerima', 'bidan');
        $this->db->or_where('uuid_pasien', $uuid_bidan);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('tb_chat')->result();
    }

    public function save_chat($data) {
        return $this->db->insert('tb_chat', $data);
    }

    public function get_dokumen_by_pasien($uuid_pasien, $limit = 5) {
        $this->db->where('uuid_pasien', $uuid_pasien);
        $this->db->order_by('upload_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('tb_dokumen')->result();
    }

    public function update_profile($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_bidan', $data);
    }
}