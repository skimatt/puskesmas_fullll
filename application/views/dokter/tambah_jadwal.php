<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Jadwal Praktik</h2>
    <?= form_open('dokter/tambah_jadwal'); ?>
        <div class="mb-4">
            <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
            <select name="hari" id="hari" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                <option value="Senin" <?= set_select('hari', 'Senin'); ?>>Senin</option>
                <option value="Selasa" <?= set_select('hari', 'Selasa'); ?>>Selasa</option>
                <option value="Rabu" <?= set_select('hari', 'Rabu'); ?>>Rabu</option>
                <option value="Kamis" <?= set_select('hari', 'Kamis'); ?>>Kamis</option>
                <option value="Jumat" <?= set_select('hari', 'Jumat'); ?>>Jumat</option>
                <option value="Sabtu" <?= set_select('hari', 'Sabtu'); ?>>Sabtu</option>
                <option value="Minggu" <?= set_select('hari', 'Minggu'); ?>>Minggu</option>
            </select>
            <?= form_error('hari', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" value="<?= set_value('jam_mulai'); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            <?= form_error('jam_mulai', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <div class="mb-4">
            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" value="<?= set_value('jam_selesai'); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            <?= form_error('jam_selesai', '<p class="text-red-600 text-sm mt-1">', '</p>'); ?>
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-save mr-2"></i> Simpan
        </button>
    <?= form_close(); ?>
</div>