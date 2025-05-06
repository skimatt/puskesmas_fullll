<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Selamat Datang, <?php echo $dokter->nama; ?></h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Antrian Hari Ini</h3>
            <p class="text-3xl font-bold"><?php echo count($antrian); ?></p>
            <a href="<?php echo base_url('dokter/kelola_janji_temu'); ?>" class="text-blue-600 hover:underline">Lihat Detail</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Notifikasi Belum Dibaca</h3>
            <p class="text-3xl font-bold"><?php echo $unread_notifikasi; ?></p>
            <a href="<?php echo base_url('dokter/notifikasi'); ?>" class="text-blue-600 hover:underline">Lihat Notifikasi</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Jadwal Praktik</h3>
            <p class="text-3xl font-bold"><?php echo count($jadwal); ?></p>
            <a href="<?php echo base_url('dokter/jadwal_praktik'); ?>" class="text-blue-600 hover:underline">Lihat Jadwal</a>
        </div>
    </div>

    <!-- Recent Antrian -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Antrian Terbaru</h3>
        <?php if (empty($antrian)): ?>
            <p class="text-gray-500">Belum ada antrian.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Pasien</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Jam</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($antrian as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item->nama_pasien; ?></td>
                            <td class="border px-4 py-2"><?php echo date('d-m-Y', strtotime($item->tanggal_antrian)); ?></td>
                            <td class="border px-4 py-2"><?php echo $item->jam_antrian; ?></td>
                            <td class="border px-4 py-2"><?php echo ucfirst($item->status_konfirmasi); ?></td>
                            <td class="border px-4 py-2">
                                <a href="<?php echo base_url('dokter/konfirmasi_janji_temu/' . $item->uuid); ?>" class="text-blue-600 hover:underline">Konfirmasi</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Recent Jadwal -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Jadwal Praktik Terbaru</h3>
        <?php if (empty($jadwal)): ?>
            <p class="text-gray-500">Belum ada jadwal praktik.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Hari</th>
                        <th class="px-4 py-2 text-left">Jam Mulai</th>
                        <th class="px-4 py-2 text-left">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item->hari; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->jam_mulai; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->jam_selesai; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>