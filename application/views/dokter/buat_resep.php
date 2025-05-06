<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Buat Resep</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Detail Rekam Medis</h3>
        <div class="mb-4">
            <p><strong>Pasien:</strong> <?php echo $rekam_medis->nama_pasien; ?></p>
            <p><strong>Tanggal Kunjungan:</strong> <?php echo date('d-m-Y H:i', strtotime($rekam_medis->tanggal_kunjungan)); ?></p>
            <p><strong>Diagnosa:</strong> <?php echo $rekam_medis->diagnosa; ?></p>
        </div>
        <?php echo form_open('dokter/buat_resep/' . $rekam_medis->uuid); ?>
            <div class="mb-4">
                <label for="id_obat" class="block text-sm font-medium text-gray-700">Obat</label>
                <select id="id_obat" name="id_obat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Pilih Obat</option>
                    <?php foreach ($obat as $item): ?>
                        <option value="<?php echo $item->uuid; ?>" <?php echo set_select('id_obat', $item->uuid); ?>><?php echo $item->nama_obat; ?> (Stok: <?php echo $item->stok; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('id_obat', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo set_value('jumlah', 1); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="1">
                <?php echo form_error('jumlah', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="aturan_pakai" class="block text-sm font-medium text-gray-700">Aturan Pakai</label>
                <textarea id="aturan_pakai" name="aturan_pakai" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('aturan_pakai'); ?></textarea>
                <?php echo form_error('aturan_pakai', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Resep</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>