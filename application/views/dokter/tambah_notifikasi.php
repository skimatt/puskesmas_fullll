<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Notifikasi untuk <?= htmlspecialchars($pasien->nama); ?></h2>
    <?= form_open('dokter/tambah_notifikasi/' . $pasien->uuid); ?>
        <div class="mb-4">
            <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan</label>
            <textarea name="pesan" id="pesan" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"><?= set_value('pesan'); ?></textarea>
            <?= form_error('pesan', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-save mr-2"></i> Kirim
        </button>
    <?= form_close(); ?>
</div>