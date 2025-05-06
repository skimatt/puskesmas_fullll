<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Pasien</h2>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Tanggal Lahir</th>
                <th class="border p-2">No. BPJS</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pasien as $p): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($p->nama); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($p->tanggal_lahir); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($p->nomor_bpjs); ?></td>
                    <td class="border p-2 space-x-2">
                        <a href="<?= base_url('dokter/riwayat_kunjungan/' . $p->uuid); ?>" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-history mr-1"></i> Riwayat</a>
                        <a href="<?= base_url('dokter/rekam_medis/' . $p->uuid); ?>" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-file-medical mr-1"></i> Rekam Medis</a>
                        <a href="<?= base_url('dokter/resep/' . $p->uuid); ?>" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-prescription mr-1"></i> Resep</a>
                        <a href="<?= base_url('dokter/notifikasi/' . $p->uuid); ?>" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-bell mr-1"></i> Notifikasi</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>