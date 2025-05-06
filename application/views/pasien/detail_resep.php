<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Resep</h2>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
            <p class="text-gray-600"><?= htmlspecialchars($resep->tanggal_kunjungan); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Obat</label>
            <p class="text-gray-600"><?= htmlspecialchars($resep->nama_obat); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
            <p class="text-gray-600"><?= htmlspecialchars($resep->jumlah); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Aturan Pakai</label>
            <p class="text-gray-600"><?= htmlspecialchars($resep->aturan_pakai ?: 'Tidak ada'); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <p class="text-gray-600"><?= htmlspecialchars($resep->status_ambil); ?></p>
        </div>
        <a href="<?= base_url('pasien/resep'); ?>" class="inline-block bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>