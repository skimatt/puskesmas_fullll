<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {
    public function get_pasien_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->get('tb_pasien')->row();
    }

    public function update_pasien($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_pasien', $data);
    }

    public function get_antrian_by_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->where('status !=', 'batal');
        $this->db->order_by('tanggal_antrian', 'ASC');
        $this->db->order_by('jam_antrian', 'ASC');
        return $this->db->get('tb_antrian')->result();
    }

    public function get_antrian_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->get('tb_antrian')->row();
    }

    public function update_antrian($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_antrian', $data);
    }

    public function insert_antrian($data) {
        return $this->db->insert('tb_antrian', $data);
    }

    public function get_all_dokter() {
        return $this->db->get('tb_dokter')->result();
    }

    public function get_all_bidan() {
        return $this->db->get('tb_bidan')->result();
    }

    public function get_jadwal_praktik() {
        return $this->db->get('tb_jadwal_praktik')->result();
    }

    public function get_available_time_slots($id_dokter, $id_bidan, $tanggal, $hari) {
        $this->db->select('jam_mulai, jam_selesai');
        if ($id_dokter) {
            $this->db->where('id_dokter', $id_dokter);
        } elseif ($id_bidan) {
            $this->db->where('id_bidan', $id_bidan);
        }
        $this->db->where('hari', $hari);
        $jadwal = $this->db->get('tb_jadwal_praktik')->row();

        $slots = [];
        if ($jadwal) {
            $start = strtotime($jadwal->jam_mulai);
            $end = strtotime($jadwal->jam_selesai);
            while ($start < $end) {
                $slot_time = date('H:i:s', $start);
                // Cek apakah slot sudah dipesan
                $this->db->where('tanggal_antrian', $tanggal);
                $this->db->where('jam_antrian', $slot_time);
                if ($id_dokter) {
                    $this->db->where('id_dokter', $id_dokter);
                } elseif ($id_bidan) {
                    $this->db->where('id_bidan', $id_bidan);
                }
                $this->db->where('status !=', 'batal');
                $booked = $this->db->get('tb_antrian')->num_rows();
                if ($booked == 0) {
                    $slots[] = $slot_time;
                }
                $start += 30 * 60; // Slot setiap 30 menit
            }
        }
        return $slots;
    }

    public function get_riwayat_by_pasien($id_pasien, $limit = NULL) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('tanggal_kunjungan', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('tb_riwayat')->result();
    }

    public function get_rekam_medis_by_pasien($id_pasien) {
        $this->db->select('tb_rekam_medis.*, tb_dokter.nama as nama_dokter, tb_bidan.nama as nama_bidan');
        $this->db->from('tb_rekam_medis');
        $this->db->where('tb_rekam_medis.id_pasien', $id_pasien);
        $this->db->join('tb_dokter', 'tb_dokter.uuid = tb_rekam_medis.id_dokter', 'left');
        $this->db->join('tb_bidan', 'tb_bidan.uuid = tb_rekam_medis.id_bidan', 'left');
        $this->db->order_by('tb_rekam_medis.tanggal_kunjungan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_dokumen_medis_by_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('tanggal_upload', 'DESC');
        return $this->db->get('tb_dokumen_medis')->result();
    }

    public function insert_dokumen_medis($data) {
        return $this->db->insert('tb_dokumen_medis', $data);
    }

    public function get_tagihan_by_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('tanggal_tagihan', 'DESC');
        return $this->db->get('tb_tagihan')->result();
    }

    public function get_tagihan_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        return $this->db->get('tb_tagihan')->row();
    }

    public function update_tagihan($uuid, $data) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_tagihan', $data);
    }

    public function get_pembayaran_by_pasien($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('tanggal_pembayaran', 'DESC');
        return $this->db->get('tb_pembayaran')->result();
    }

    public function insert_pembayaran($data) {
        return $this->db->insert('tb_pembayaran', $data);
    }

    public function get_resep_by_pasien($id_pasien, $limit = NULL) {
        $this->db->select('tb_resep.*, tb_rekam_medis.tanggal_kunjungan');
        $this->db->from('tb_resep');
        $this->db->join('tb_rekam_medis', 'tb_rekam_medis.uuid = tb_resep.id_rekam_medis');
        $this->db->where('tb_rekam_medis.id_pasien', $id_pasien);
        $this->db->order_by('tb_rekam_medis.tanggal_kunjungan', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }

    public function get_resep_by_uuid($uuid) {
        $this->db->select('tb_resep.*, tb_rekam_medis.tanggal_kunjungan, tb_obat.nama_obat, tb_obat.jenis_obat');
        $this->db->from('tb_resep');
        $this->db->join('tb_rekam_medis', 'tb_rekam_medis.uuid = tb_resep.id_rekam_medis');
        $this->db->join('tb_obat', 'tb_obat.uuid = tb_resep.id_obat');
        $this->db->where('tb_resep.uuid', $uuid);
        return $this->db->get()->row();
    }

    public function get_chat($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('tb_chat')->result();
    }

    public function get_all_penerima() {
        $dokter = $this->db->select('uuid, nama, "dokter" as role')->get('tb_dokter')->result();
        $bidan = $this->db->select('uuid, nama, "bidan" as role')->get('tb_bidan')->result();
        return array_merge($dokter, $bidan);
    }

    public function kirim_pesan($id_pengirim, $data) {
        return $this->db->insert('tb_chat', $data);
    }

    public function get_notifikasi_by_pasien($id_pasien, $limit = NULL) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->order_by('created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('tb_notifikasi')->result();
    }

    public function count_unread_notifikasi($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->where('status', 'belum_dibaca');
        return $this->db->count_all_results('tb_notifikasi');
    }

    public function mark_notifikasi_as_read($uuid, $id_pasien) {
        $this->db->where('uuid', $uuid);
        $this->db->where('id_pasien', $id_pasien);
        return $this->db->update('tb_notifikasi', ['status' => 'dibaca']);
    }

    public function mark_all_notifikasi_as_read($id_pasien) {
        $this->db->where('id_pasien', $id_pasien);
        return $this->db->update('tb_notifikasi', ['status' => 'dibaca']);
    }

    public function get_new_notifikasi($id_pasien, $last_check) {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->where('created_at >', $last_check);
        return $this->db->get('tb_notifikasi')->result();
    }

    public function update_password($uuid, $new_password) {
        $this->db->where('uuid', $uuid);
        return $this->db->update('tb_users', ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
    }
    
    
}