<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Jadwal Praktik</h2>
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Tambah Jadwal Praktik</h3>
        <?php echo form_open('dokter/jadwal_praktik'); ?>
            <div class="mb-4">
                <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                <select id="hari" name="hari" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Pilih Hari</option>
                    <?php $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'); ?>
                    <?php foreach ($hari as $h): ?>
                        <option value="<?php echo $h; ?>" <?php echo set_select('hari', $h); ?>><?php echo $h; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('hari', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" value="<?php echo set_value('jam_mulai'); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('jam_mulai', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                <input type="time" id="jam_selesai" name="jam_selesai" value="<?php echo set_value('jam_selesai'); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('jam_selesai', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Tambah Jadwal</button>
            </div>
        <?php echo form_close(); ?>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Jadwal Praktik</h3>
        <?php if (empty($jadwal)): ?>
            <p class="text-gray-500">Belum ada jadwal praktik.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Hari</th>
                        <th class="px-4 py-2 text-left">Jam Mulai</th>
                        <th class="px-4 py-2 text-left">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item->hari; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->jam_mulai; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->jam_selesai; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>