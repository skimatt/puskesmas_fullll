<?php
class Admin_model extends CI_Model {
    // Statistik Umum
    public function count_users_by_role($role) {
        return $this->db->where('role', $role)->count_all_results('tb_users');
    }

    public function count_obat() {
        return $this->db->count_all_results('tb_obat');
    }

    public function count_antrian_hari_ini() {
        $this->db->where('tanggal_antrian', date('Y-m-d'));
        $this->db->where('status !=', 'batal');
        return $this->db->count_all_results('tb_antrian');
    }

    public function count_riwayat_bulan_ini() {
        $this->db->where('YEAR(tanggal_kunjungan)', date('Y'));
        $this->db->where('MONTH(tanggal_kunjungan)', date('m'));
        return $this->db->count_all_results('tb_riwayat');
    }

    // Antrian Hari Ini
    public function get_antrian_hari_ini() {
        $this->db->select('a.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia');
        $this->db->select('CASE WHEN d.nama IS NOT NULL THEN "dokter" ELSE "bidan" END as penyedia_role', FALSE);
        $this->db->from('tb_antrian a');
        $this->db->join('tb_users p', 'p.uuid = a.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = a.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = a.id_bidan', 'left');
        $this->db->where('a.tanggal_antrian', date('Y-m-d'));
        $this->db->where('a.status !=', 'batal');
        return $this->db->get()->result();
    }

    // Jadwal Praktik Hari Ini
    public function get_jadwal_hari_ini($hari = null) {
        if (!$hari) {
            $hari = date('l');
            $hari_map = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            ];
            $hari = $hari_map[$hari];
        }
        $this->db->select('j.*, COALESCE(d.nama, b.nama) as nama_penyedia, 
                          CASE WHEN d.nama IS NOT NULL THEN "dokter" ELSE "bidan" END as role', FALSE);
        $this->db->from('tb_jadwal_praktik j');
        $this->db->join('tb_users d', 'd.uuid = j.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = j.id_bidan', 'left');
        $this->db->where('j.hari', $hari);
        return $this->db->get()->result();
    }

    // Stok Obat Rendah
    public function get_obat_stok_rendah($threshold = 10) {
        $this->db->where('stok <=', $threshold);
        return $this->db->get('tb_obat')->result();
    }

    // Riwayat Kunjungan Terbaru
    public function get_riwayat_terbaru($limit = 10) {
        $this->db->select('r.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia');
        $this->db->from('tb_riwayat r');
        $this->db->join('tb_users p', 'p.uuid = r.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = r.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = r.id_bidan', 'left');
        $this->db->order_by('r.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Resep Belum Diambil
    public function count_resep_belum_diambil() {
        $this->db->where('status_ambil', 'belum');
        return $this->db->count_all_results('tb_resep');
    }

    public function get_resep_belum_diambil() {
        $this->db->select('r.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia, o.nama_obat');
        $this->db->from('tb_resep r');
        $this->db->join('tb_rekam_medis rm', 'rm.uuid = r.id_rekam_medis');
        $this->db->join('tb_users p', 'p.uuid = rm.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = rm.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = rm.id_bidan', 'left');
        $this->db->join('tb_obat o', 'o.uuid = r.id_obat');
        $this->db->where('r.status_ambil', 'belum');
        return $this->db->get()->result();
    }

    // Notifikasi Terbaru
    public function get_notifikasi_terbaru($limit = 10) {
        $this->db->select('n.*, p.nama as nama_pasien');
        $this->db->from('tb_notifikasi n');
        $this->db->join('tb_users p', 'p.uuid = n.id_pasien');
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Pesan/Chat Terbaru
    public function get_chat_terbaru($limit = 10) {
        $this->db->select('c.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia, c.pengirim');
        $this->db->from('tb_chat c');
        $this->db->join('tb_users p', 'p.uuid = c.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = c.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = c.id_bidan', 'left');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Manajemen Pasien
    public function get_all_pasien() {
        $this->db->select('p.*, u.email, u.is_active');
        $this->db->from('tb_pasien p');
        $this->db->join('tb_users u', 'u.uuid = p.uuid');
        return $this->db->get()->result();
    }

    public function get_pasien_by_uuid($uuid) {
        $this->db->select('p.*, u.email, u.is_active');
        $this->db->from('tb_pasien p');
        $this->db->join('tb_users u', 'u.uuid = p.uuid');
        $this->db->where('p.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function insert_pasien($user_data, $pasien_data) {
        $this->db->trans_start();
        $this->db->insert('tb_users', $user_data);
        $this->db->insert('tb_pasien', $pasien_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_pasien($uuid, $pasien_data, $user_data) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_pasien', $pasien_data);
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_users', $user_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_pasien($uuid) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_pasien');
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_users');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Manajemen Dokter
    public function get_all_dokter() {
        $this->db->select('d.*, u.email, u.is_active');
        $this->db->from('tb_dokter d');
        $this->db->join('tb_users u', 'u.uuid = d.uuid');
        return $this->db->get()->result();
    }

    public function get_dokter_by_uuid($uuid) {
        $this->db->select('d.*, u.email, u.is_active');
        $this->db->from('tb_dokter d');
        $this->db->join('tb_users u', 'u.uuid = d.uuid');
        $this->db->where('d.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function insert_dokter($user_data, $dokter_data) {
        $this->db->trans_start();
        $this->db->insert('tb_users', $user_data);
        $this->db->insert('tb_dokter', $dokter_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_dokter($uuid, $dokter_data, $user_data) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_dokter', $dokter_data);
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_users', $user_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_dokter($uuid) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_dokter');
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_users');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Manajemen Bidan
    public function get_all_bidan() {
        $this->db->select('b.*, u.email, u.is_active');
        $this->db->from('tb_bidan b');
        $this->db->join('tb_users u', 'u.uuid = b.uuid');
        return $this->db->get()->result();
    }

    public function get_bidan_by_uuid($uuid) {
        $this->db->select('b.*, u.email, u.is_active');
        $this->db->from('tb_bidan b');
        $this->db->join('tb_users u', 'u.uuid = b.uuid');
        $this->db->where('b.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function insert_bidan($user_data, $bidan_data) {
        $this->db->trans_start();
        $this->db->insert('tb_users', $user_data);
        $this->db->insert('tb_bidan', $bidan_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_bidan($uuid, $bidan_data, $user_data) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_bidan', $bidan_data);
        $this->db->where('uuid', $uuid);
        $this->db->update('tb_users', $user_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_bidan($uuid) {
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_bidan');
        $this->db->where('uuid', $uuid);
        $this->db->delete('tb_users');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Manajemen Obat
    public function get_all_obat() {
        return $this->db->get('tb_obat')->result();
    }

    public function get_obat_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->get('tb_obat')->row();
    }

    public function insert_obat($obat_data) {
        return $this->db->insert('tb_obat', $obat_data);
    }

    public function update_obat($uuid, $obat_data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_obat', $obat_data);
    }

    public function delete_obat($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->delete('tb_obat');
    }

    // Manajemen Antrian
    public function get_all_antrian() {
        $this->db->select('a.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia');
        $this->db->select('CASE WHEN d.nama IS NOT NULL THEN "dokter" ELSE "bidan" END as penyedia_role', FALSE);
        $this->db->from('tb_antrian a');
        $this->db->join('tb_users p', 'p.uuid = a.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = a.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = a.id_bidan', 'left');
        $this->db->order_by('a.tanggal_antrian', 'DESC');
        return $this->db->get()->result();
    }

    public function get_antrian_by_uuid($uuid) {
        $this->db->select('a.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia');
        $this->db->select('CASE WHEN d.nama IS NOT NULL THEN "dokter" ELSE "bidan" END as penyedia_role', FALSE);
        $this->db->from('tb_antrian a');
        $this->db->join('tb_users p', 'p.uuid = a.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = a.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = a.id_bidan', 'left');
        $this->db->where('a.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function update_antrian($uuid, $antrian_data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_antrian', $antrian_data);
    }

    // Riwayat Kunjungan
    public function get_all_riwayat() {
        $this->db->select('r.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia');
        $this->db->from('tb_riwayat r');
        $this->db->join('tb_users p', 'p.uuid = r.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = r.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = r.id_bidan', 'left');
        $this->db->order_by('r.tanggal_kunjungan', 'DESC');
        return $this->db->get()->result();
    }

    // Manajemen Resep
    public function get_all_resep() {
        $this->db->select('r.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia, o.nama_obat');
        $this->db->from('tb_resep r');
        $this->db->join('tb_rekam_medis rm', 'rm.uuid = r.id_rekam_medis');
        $this->db->join('tb_users p', 'p.uuid = rm.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = rm.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = rm.id_bidan', 'left');
        $this->db->join('tb_obat o', 'o.uuid = r.id_obat');
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_resep_by_uuid($uuid) {
        $this->db->select('r.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia, o.nama_obat');
        $this->db->from('tb_resep r');
        $this->db->join('tb_rekam_medis rm', 'rm.uuid = r.id_rekam_medis');
        $this->db->join('tb_users p', 'p.uuid = rm.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = rm.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = rm.id_bidan', 'left');
        $this->db->join('tb_obat o', 'o.uuid = r.id_obat');
        $this->db->where('r.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function update_resep($uuid, $resep_data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_resep', $resep_data);
    }

    // Notifikasi
    public function get_all_notifikasi() {
        $this->db->select('n.*, p.nama as nama_pasien');
        $this->db->from('tb_notifikasi n');
        $this->db->join('tb_users p', 'p.uuid = n.id_pasien');
        $this->db->order_by('n.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function mark_notifikasi_read($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_notifikasi', array('status' => 'dibaca'));
    }

    // Chat
    public function get_all_chat() {
        $this->db->select('c.*, p.nama as nama_pasien, COALESCE(d.nama, b.nama) as nama_penyedia, c.pengirim');
        $this->db->from('tb_chat c');
        $this->db->join('tb_users p', 'p.uuid = c.id_pasien');
        $this->db->join('tb_users d', 'd.uuid = c.id_dokter', 'left');
        $this->db->join('tb_users b', 'b.uuid = c.id_bidan', 'left');
        $this->db->order_by('c.created_at', 'DESC');
        return $this->db->get()->result();
    }
}