<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Rekam Medis untuk <?= htmlspecialchars($pasien->nama); ?></h2>
    <?= form_open('dokter/tambah_rekam_medis/' . $pasien->uuid); ?>
        <div class="mb-4">
            <label for="uuid_riwayat" class="block text-sm font-medium text-gray-700">Riwayat Kunjungan</label>
            <select name="uuid_riwayat" id="uuid_riwayat" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                <?php foreach ($riwayat as $r): ?>
                    <option value="<?= htmlspecialchars($r->uuid); ?>"><?= htmlspecialchars($r->jenis_pelayanan . ' - ' . $r->tanggal_kunjungan); ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('uuid_riwayat', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="diagnosa" class="block text-sm font-medium text-gray-700">Diagnosa</label>
            <textarea name="diagnosa" id="diagnosa" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"><?= set_value('diagnosa'); ?></textarea>
            <?= form_error('diagnosa', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
            <textarea name="tindakan" id="tindakan" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"><?= set_value('tindakan'); ?></textarea>
            <?= form_error('tindakan', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="obat" class="block text-sm font-medium text-gray-700">Obat</label>
            <textarea name="obat" id="obat" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"><?= set_value('obat'); ?></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-save mr-2"></i> Simpan
        </button>
    <?= form_close(); ?>
</div>