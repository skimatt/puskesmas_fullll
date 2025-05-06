<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Kunjungan: <?= htmlspecialchars($pasien->nama); ?></h2>
    <a href="<?= base_url('dokter/tambah_riwayat/' . $pasien->uuid); ?>" class="bg-indigo-600 text-white py-2 px-4 rounded-lg mb-4 inline-flex items-center hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i> Tambah Riwayat
    </a>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Jenis Pelayanan</th>
                <th class="border p-2">Tanggal Kunjungan</th>
                <th class="border p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($riwayat as $r): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($r->jenis_pelayanan); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->tanggal_kunjungan); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>