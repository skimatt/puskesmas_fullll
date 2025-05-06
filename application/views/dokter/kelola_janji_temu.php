<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Kelola Janji Temu</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Janji Temu</h3>
        <?php if (empty($antrian)): ?>
            <p class="text-gray-500">Belum ada janji temu.</p>
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
</div>