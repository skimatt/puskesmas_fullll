<?php
// Ambil data dari controller
$pasien = isset($pasien) ? $pasien : null;
$antrian = isset($antrian) ? $antrian : [];
$notifikasi = isset($notifikasi) ? $notifikasi : [];
$unread_notifikasi = isset($unread_notifikasi) ? $unread_notifikasi : 0;
$riwayat = isset($riwayat) ? $riwayat : [];
$resep = isset($resep) ? $resep : [];

// Ambil data sesi secara aman untuk PHP 5.6
$profile_picture = $this->session->userdata('profile_picture');
$nama = $this->session->userdata('nama');
$email = $this->session->userdata('email');
?>

<div class="container mx-auto px-1 py-5 space-y-5">
    <!-- Welcome Section -->
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl p-8 shadow-2xl overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <h1 class="text-3xl font-extrabold tracking-tight">Selamat Datang, <?php echo $nama ? $nama : 'Pengguna'; ?>!</h1>
        <p class="mt-2 text-sm opacity-90">Kelola kesehatan Anda dengan mudah di Puskesmas Digital.</p>
    </div>

    <!-- Profil dan Statistik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Pengguna -->
        <div class="bg-white shadow-xl rounded-2xl p-8 flex flex-col items-center space-y-6 transform hover:scale-105 transition-transform duration-300">
            <div class="relative">
                <img src="<?php echo ($profile_picture != null && $profile_picture != '') ? base_url('Uploads/profile/' . $profile_picture) : 'https://via.placeholder.com/100'; ?>" alt="Profile Picture" class="w-28 h-28 rounded-full object-cover ring-4 ring-indigo-100">
                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900"><?php echo $nama ? $nama : 'Pengguna'; ?></h2>
                <p class="text-gray-500"><?php echo $email ? $email : 'email@contoh.com'; ?></p>
                <p class="text-gray-500"><?php echo ($pasien && isset($pasien->no_telepon)) ? $pasien->no_telepon : '-'; ?></p>
                <a href="<?php echo site_url('pasien/edit_profile'); ?>" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition-all duration-300">Edit Profil</a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Statistik Kesehatan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-indigo-50 text-indigo-800 p-6 rounded-xl shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <p class="text-3xl font-bold"><?php echo count($riwayat); ?></p>
                    <p class="text-sm mt-2">Kunjungan Bulan Ini</p>
                </div>
                <div class="bg-green-50 text-green-800 p-6 rounded-xl shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <p class="text-3xl font-bold"><?php echo count($resep); ?></p>
                    <p class="text-sm mt-2">Resep Aktif</p>
                </div>
                <div class="bg-yellow-50 text-yellow-800 p-6 rounded-xl shadow-md text-center transform hover:scale-105 transition-transform duration-300">
                    <p class="text-3xl font-bold"><?php echo $unread_notifikasi; ?></p>
                    <p class="text-sm mt-2">Notifikasi Belum Dibaca</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrian Terkini -->
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Antrian Terkini</h2>
        <?php if (empty($antrian)): ?>
            <p class="text-gray-500">Tidak ada antrian saat ini.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700">
                            <th class="p-4 font-semibold">No. Antrian</th>
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Dokter</th>
                            <th class="p-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($antrian as $item): ?>
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-4"><?php echo isset($item->nomor_antrian) ? $item->nomor_antrian : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->tanggal) ? $item->tanggal : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->nama_dokter) ? $item->nama_dokter : '-'; ?></td>
                                <td class="p-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm <?php echo isset($item->status) && $item->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                        <?php echo isset($item->status) ? $item->status : '-'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Shortcut Fitur -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="<?php echo site_url('pasien/buat_janji_temu'); ?>" class="bg-indigo-50 text-indigo-800 p-6 rounded-xl shadow-md hover:bg-indigo-100 hover:shadow-lg transition-all duration-300">
            <h3 class="text-lg font-semibold">Buat Janji Temu</h3>
            <p class="text-sm mt-2">Jadwalkan kunjungan Anda</p>
        </a>
        <a href="<?php echo site_url('pasien/dokumen_medis'); ?>" class="bg-green-50 text-green-800 p-6 rounded-xl shadow-md hover:bg-green-100 hover:shadow-lg transition-all duration-300">
            <h3 class="text-lg font-semibold">Dokumen Medis</h3>
            <p class="text-sm mt-2">Lihat rekam medis Anda</p>
        </a>
        <a href="<?php echo site_url('pasien/bayar_tagihan'); ?>" class="bg-yellow-50 text-yellow-800 p-6 rounded-xl shadow-md hover:bg-yellow-100 hover:shadow-lg transition-all duration-300">
            <h3 class="text-lg font-semibold">Bayar Tagihan</h3>
            <p class="text-sm mt-2">Kelola pembayaran Anda</p>
        </a>
        <a href="<?php echo site_url('pasien/chat'); ?>" class="bg-blue-50 text-blue-800 p-6 rounded-xl shadow-md hover:bg-blue-100 hover:shadow-lg transition-all duration-300">
            <h3 class="text-lg font-semibold">Chat</h3>
            <p class="text-sm mt-2">Hubungi dokter Anda</p>
        </a>
    </div>

    <!-- Riwayat Kunjungan -->
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Kunjungan</h2>
        <?php if (empty($riwayat)): ?>
            <p class="text-gray-500">Belum ada riwayat kunjungan.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700">
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Diagnosa</th>
                            <th class="p-4 font-semibold">Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $item): ?>
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-4"><?php echo isset($item->tanggal_kunjungan) ? $item->tanggal_kunjungan : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->diagnosa) ? $item->diagnosa : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->nama_dokter) ? $item->nama_dokter : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Riwayat Resep -->
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Resep</h2>
        <?php if (empty($resep)): ?>
            <p class="text-gray-500">Belum ada resep yang tersedia.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700">
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Nama Obat</th>
                            <th class="p-4 font-semibold">Dosis</th>
                            <th class="p-4 font-semibold">Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resep as $item): ?>
                            <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-4"><?php echo isset($item->tanggal_resep) ? $item->tanggal_resep : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->nama_obat) ? $item->nama_obat : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->dosis) ? $item->dosis : '-'; ?></td>
                                <td class="p-4"><?php echo isset($item->nama_dokter) ? $item->nama_dokter : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Notifikasi Terbaru -->
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Notifikasi Terbaru</h2>
        <?php if (empty($notifikasi)): ?>
            <p class="text-gray-500">Belum ada notifikasi.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($notifikasi as $notif): ?>
                    <li class="p-4 bg-gray-50 rounded-xl flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                        <div>
                            <p class="text-gray-800 font-medium"><?php echo isset($notif->pesan) ? $notif->pesan : '-'; ?></p>
                            <p class="text-sm text-gray-500"><?php echo isset($notif->tanggal) ? $notif->tanggal : '-'; ?></p>
                        </div>
                        <span class="text-sm px-3 py-1 rounded-full <?php echo isset($notif->is_read) && $notif->is_read ? 'bg-gray-200 text-gray-600' : 'bg-indigo-100 text-indigo-600'; ?>">
                            <?php echo isset($notif->is_read) && $notif->is_read ? 'Dibaca' : 'Belum Dibaca'; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<style>
    .bg-pattern {
        background-image: radial-gradient(circle, rgba(255,255,255,0.2) 2px, transparent 2px);
        background-size: 20px 20px;
    }
</style>

<script>
    // Animasi saat scroll menggunakan IntersectionObserver
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.bg-white, .bg-gradient-to-r, .bg-indigo-50, .bg-green-50, .bg-yellow-50, .bg-blue-50');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(element => {
            element.classList.add('opacity-0', 'translate-y-10', 'transition', 'duration-500', 'ease-in-out');
            observer.observe(element);
        });
    });
</script>