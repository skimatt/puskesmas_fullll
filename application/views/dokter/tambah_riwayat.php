<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Riwayat Kunjungan untuk <?= htmlspecialchars($pasien->nama); ?></h2>
    <?= form_open('dokter/tambah_riwayat/' . $pasien->uuid); ?>
        <div class="mb-4">
            <label for="jenis_pelayanan" class="block text-sm font-medium text-gray-700">Jenis Pelayanan</label>
            <input type="text" name="jenis_pelayanan" id="jenis_pelayanan" value="<?= set_value('jenis_pelayanan'); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            <?= form_error('jenis_pelayanan', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status Kunjungan</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                <option value="selesai" <?= set_select('status', 'selesai'); ?>>Selesai</option>
                <option value="dirujuk" <?= set_select('status', 'dirujuk'); ?>>Dirujuk</option>
            </select>
            <?= form_error('status', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="<?= set_value('tanggal_kunjungan'); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            <?= form_error('tanggal_kunjungan', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-save mr-2"></i> Simpan
        </button>
    <?= form_close(); ?>
</div>