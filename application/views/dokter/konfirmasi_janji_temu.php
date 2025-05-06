<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Konfirmasi Janji Temu</h2>
    <div class="bg-white SIX rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Detail Janji Temu</h3>
        <div class="mb-4">
            <p><strong>Pasien:</strong> <?php echo $antrian->nama_pasien; ?></p>
            <p><strong>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($antrian->tanggal_antrian)); ?></p>
            <p><strong>Jam:</strong> <?php echo $antrian->jam_antrian; ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($antrian->status_konfirmasi); ?></p>
        </div>
        <?php echo form_open('dokter/konfirmasi_janji_temu/' . $antrian->uuid); ?>
            <div class="mb-4">
                <label for="status_konfirmasi" class="block text-sm font-medium text-gray-700">Status Konfirmasi</label>
                <select id="status_konfirmasi" name="status_konfirmasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="dikonfirmasi" <?php echo $antrian->status_konfirmasi == 'dikonfirmasi' ? 'selected' : ''; ?>>Dikonfirmasi</option>
                    <option value="ditolak" <?php echo $antrian->status_konfirmasi == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                </select>
                <?php echo form_error('status_konfirmasi', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo set_value('catatan', $antrian->catatan); ?></textarea>
                <?php echo form_error('catatan', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>