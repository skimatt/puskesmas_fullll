<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Resep untuk <?= htmlspecialchars($pasien->nama); ?></h2>
    <?= form_open('dokter/tambah_resep/' . $pasien->uuid); ?>
        <div class="mb-4">
            <label for="uuid_rekam_medis" class="block text-sm font-medium text-gray-700">Rekam Medis</label>
            <select name="uuid_rekam_medis" id="uuid_rekam_medis" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                <?php foreach ($rekam_medis as $rm): ?>
                    <option value="<?= htmlspecialchars($rm->uuid); ?>"><?= htmlspecialchars($rm->diagnosa . ' - ' . $rm->tanggal_kunjungan); ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('uuid_rekam_medis', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="uuid_obat" class="block text-sm font-medium text-gray-700">Obat</label>
            <select name="uuid_obat" id="uuid_obat" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                <?php foreach ($obat as $o): ?>
                    <option value="<?= htmlspecialchars($o->uuid); ?>"><?= htmlspecialchars($o->nama_obat); ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('uuid_obat', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" value="<?= set_value('jumlah'); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            <?= form_error('jumlah', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="aturan_pakai" class="block text-sm font-medium text-gray-700">Aturan Pakai</label>
            <textarea name="aturan_pakai" id="aturan_pakai" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"><?= set_value('aturan_pakai'); ?></textarea>
            <?= form_error('aturan_pakai', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-save mr-2"></i> Simpan
        </button>
    <?= form_close(); ?>
</div>