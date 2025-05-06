<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Resep: <?= htmlspecialchars($pasien->nama); ?></h2>
    <a href="<?= base_url('dokter/tambah_resep/' . $pasien->uuid); ?>" class="bg-indigo-600 text-white py-2 px-4 rounded-lg mb-4 inline-flex items-center hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i> Tambah Resep
    </a>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Obat</th>
                <th class="border p-2">Jumlah</th>
                <th class="border p-2">Aturan Pakai</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resep as $r): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($r->nama_obat); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->jumlah); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->aturan_pakai); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->status_ambil); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($r->created_at); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>