<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Rekam Medis Pasien: <?php echo $pasien->nama; ?></h2>
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Tambah Rekam Medis</h3>
        <?php echo form_open('dokter/rekam_medis/' . $pasien->uuid); ?>
            <div class="mb-4">
                <label for="diagnosa" class="block text-sm font-medium text-gray-700">Diagnosa</label>
                <textarea id="diagnosa" name="diagnosa" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('diagnosa'); ?></textarea>
                <?php echo form_error('diagnosa', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
                <textarea id="tindakan" name="tindakan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('tindakan'); ?></textarea>
                <?php echo form_error('tindakan', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="obat" class="block text-sm font-medium text-gray-700">Obat</label>
                <textarea id="obat" name="obat" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('obat'); ?></textarea>
                <?php echo form_error('obat', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('catatan'); ?></textarea>
                <?php echo form_error('catatan', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        <?php echo form_close(); ?>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Riwayat Rekam Medis</h3>
        <?php if (empty($rekam_medis)): ?>
            <p class="text-gray-500">Belum ada rekam medis.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Diagnosa</th>
                        <th class="px-4 py-2 text-left">Tindakan</th>
                        <th class="px-4 py-2 text-left">Obat</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekam_medis as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo date('d-m-Y H:i', strtotime($item->tanggal_kunjungan)); ?></td>
                            <td class="border px-4 py-2"><?php echo $item->diagnosa; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->tindakan; ?></td>
                            <td class="border px-4 py-2"><?php echo $item->obat; ?></td>
                            <td class="border px-4 py-2">
                                <a href="<?php echo base_url('dokter/buat_resep/' . $item->uuid); ?>" class="text-blue-600 hover:underline">Buat Resep</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>