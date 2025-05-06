<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil data dokter berdasarkan UUID
    public function get_dokter_by_uuid($uuid) {
        $this->db->select('tb_dokter.*, tb_users.email, tb_users.nama as nama_user, tb_users.role');
        $this->db->from('tb_dokter');
        $this->db->join('tb_users', 'tb_users.uuid = tb_dokter.uuid');
        $this->db->where('tb_dokter.uuid', $uuid);
        return $this->db->get()->row();
    }

    // Mengambil data pasien berdasarkan UUID
    public function get_pasien_by_uuid($uuid) {
        $this->db->select('tb_pasien.*, tb_users.email');
        $this->db->from('tb_pasien');
        $this->db->join('tb_users', 'tb_users.uuid = tb_pasien.uuid');
        $this->db->where('tb_pasien.uuid', $uuid);
        return $this->db->get()->row();
    }

    // Mengambil daftar antrian berdasarkan dokter
    public function get_antrian_by_dokter($id_dokter, $limit = null) {
        $this->db->select('tb_antrian.*, tb_pasien.nama as nama_pasien');
        $this->db->from('tb_antrian');
        $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_antrian.id_pasien');
        $this->db->where('tb_antrian.id_dokter', $id_dokter);
        $this->db->where('tb_antrian.status !=', 'batal');
        $this->db->order_by('tb_antrian.tanggal_antrian', 'ASC');
        $this->db->order_by('tb_antrian.jam_antrian', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }

    // Mengambil detail antrian berdasarkan UUID
    public function get_antrian_by_uuid($uuid) {
        $this->db->select('tb_antrian.*, tb_pasien.nama as nama_pasien');
        $this->db->from('tb_antrian');
        $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_antrian.id_pasien');
        $this->db->where('tb_antrian.uuid', $uuid);
        return $this->db->get()->row();
    }

    // Memperbarui data antrian
    public function update_antrian($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_antrian', $data);
    }

    // Mengambil rekam medis pasien
    public function get_rekam_medis_by_pasien($id_pasien) {
        $this->db->select('tb_rekam_medis.*, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter');
        $this->db->from('tb_rekam_medis');
        $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_rekam_medis.id_pasien');
        $this->db->join('tb_dokter', 'tb_dokter.uuid = tb_rekam_medis.id_dokter', 'left');
        $this->db->where('tb_rekam_medis.id_pasien', $id_pasien);
        $this->db->order_by('tb_rekam_medis.tanggal_kunjungan', 'DESC');
        return $this->db->get()->result();
    }

    // Menambahkan rekam medis baru
    public function insert_rekam_medis($data) {
        return $this->db->insert('tb_rekam_medis', $data);
    }

    // Mengambil daftar obat
    public function get_all_obat() {
        $this->db->where('stok >', 0);
        $this->db->order_by('nama_obat', 'ASC');
        return $this->db->get('tb_obat')->result();
    }

    // Menambahkan resep baru
    public function insert_resep($data) {
        return $this->db->insert('tb_resep', $data);
    }

    // Mengambil riwayat chat dengan pasien
    public function get_chat_history($id_dokter) {
        $this->db->select('tb_chat.*, tb_pasien.nama as nama_pasien');
        $this->db->from('tb_chat');
        $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_chat.id_pasien');
        $this->db->where('tb_chat.id_dokter', $id_dokter);
        $this->db->order_by('tb_chat.created_at', 'ASC');
        return $this->db->get()->result();
    }

    // Mengambil daftar pasien untuk chat
    public function get_penerima_chat($id_dokter) {
        $this->db->select('tb_pasien.uuid, tb_pasien.nama');
        $this->db->from('tb_pasien');
        $this->db->join('tb_antrian', 'tb_antrian.id_pasien = tb_pasien.uuid');
        $this->db->where('tb_antrian.id_dokter', $id_dokter);
        $this->db->group_by('tb_pasien.uuid');
        return $this->db->get()->result();
    }

    // Menyimpan pesan chat
    public function save_chat($data) {
        return $this->db->insert('tb_chat', $data);
    }

    // Mengambil notifikasi dokter
// Di Dokter_model.php
public function get_notifikasi_by_dokter($id_dokter, $limit = null) {
    $this->db->select('tb_notifikasi.*, tb_pasien.nama as nama_pasien');
    $this->db->from('tb_notifikasi');
    $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_notifikasi.id_pasien', 'left');
    $this->db->where('tb_notifikasi.id_dokter', $id_dokter);
    $this->db->order_by('tb_notifikasi.created_at', 'DESC');
    if ($limit) {
        $this->db->limit($limit);
    }
    return $this->db->get()->result();
}

public function count_unread_notifikasi($id_dokter) {
    $this->db->where('id_dokter', $id_dokter);
    $this->db->where('status', 'belum_dibaca');
    return $this->db->count_all_results('tb_notifikasi');
}

    // Menandai notifikasi sebagai dibaca
    public function mark_notifikasi_as_read($uuid, $id_dokter) {
        $this->db->where('uuid', $uuid);
        $this->db->where('id_dokter', $id_dokter);
        return $this->db->update('tb_notifikasi', ['status' => 'dibaca']);
    }

    // Menandai semua notifikasi sebagai dibaca
    public function mark_all_notifikasi_as_read($id_dokter) {
        $this->db->where('id_dokter', $id_dokter);
        return $this->db->update('tb_notifikasi', ['status' => 'dibaca']);
    }

    // Menambahkan notifikasi
    public function insert_notifikasi($data) {
        return $this->db->insert('tb_notifikasi', $data);
    }

    // Mengambil jadwal praktik dokter
    public function get_jadwal_by_dokter($id_dokter, $limit = null) {
        $this->db->where('id_dokter', $id_dokter);
        $this->db->order_by('hari', 'ASC');
        $this->db->order_by('jam_mulai', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('tb_jadwal_praktik')->result();
    }

    // Menambahkan atau memperbarui jadwal praktik
    public function insert_jadwal($data) {
        return $this->db->insert('tb_jadwal_praktik', $data);
    }

    public function update_jadwal($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_jadwal_praktik', $data);
    }

    // Memperbarui profil dokter
    public function update_dokter($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_dokter', $data);
    }

    // Memperbarui kata sandi
    public function update_password($uuid, $new_password) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_users', ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
    }

    // Mengambil dokumen medis pasien
    public function get_dokumen_medis_by_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('tanggal_upload', 'DESC');
        return $this->db->get('tb_dokumen_medis')->result();
    }

    // Mengambil tagihan pasien untuk dokter
    public function get_tagihan_by_dokter($id_dokter) {
        $this->db->select('tb_tagihan.*, tb_pasien.nama as nama_pasien');
        $this->db->from('tb_tagihan');
        $this->db->join('tb_pasien', 'tb_pasien.uuid = tb_tagihan.id_pasien');
        $this->db->join('tb_rekam_medis', 'tb_rekam_medis.uuid = tb_tagihan.id_rekam_medis');
        $this->db->where('tb_rekam_medis.id_dokter', $id_dokter);
        $this->db->order_by('tb_tagihan.tanggal_tagihan', 'DESC');
        return $this->db->get()->result();
    }

    // Mengkonfirmasi pembayaran
    public function konfirmasi_pembayaran($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_pembayaran', $data);
    }

    private function generate_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}