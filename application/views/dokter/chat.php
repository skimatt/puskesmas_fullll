<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Chat dengan Pasien</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Kirim Pesan</h3>
        <?php echo form_open('dokter/kirim_pesan'); ?>
            <div class="mb-4">
                <label for="id_pasien" class="block text-sm font-medium text-gray-700">Penerima</label>
                <select id="id_pasien" name="id_pasien" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Pilih Pasien</option>
                    <?php foreach ($penerima as $item): ?>
                        <option value="<?php echo $item->uuid; ?>" <?php echo set_select('id_pasien', $item->uuid); ?>><?php echo $item->nama; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('id_pasien', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('pesan'); ?></textarea>
                <?php echo form_error('pesan', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Kirim</button>
            </div>
        <?php echo form_close(); ?>
    </div>
    <div class="bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Chat</h3>
        <?php if (empty($chat)): ?>
            <p class="text-gray-500">Belum ada pesan.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($chat as $item): ?>
                    <div class="p-4 border rounded-md <?php echo $item->pengirim == 'dokter' ? 'bg-blue-50' : 'bg-gray-50'; ?>">
                        <p class="text-sm text-gray-500"><?php echo $item->nama_pasien; ?> - <?php echo date('d-m-Y H:i', strtotime($item->created_at)); ?></p>
                        <p class="mt-1"><?php echo $item->pesan; ?></p>
                        <p class="text-xs text-gray-400 mt-1"><?php echo $item->pengirim == 'dokter' ? 'Anda' : 'Pasien'; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>