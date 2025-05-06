<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Kelola Janji Temu</h2>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama Pasien</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($janji_temu): ?>
                <?php foreach ($janji_temu as $jt): ?>
                    <tr>
                        <td class="border p-2"><?= htmlspecialchars($jt->nama_pasien); ?></td>
                        <td class="border p-2"><?= htmlspecialchars($jt->tanggal_antrian); ?></td>
                        <td class="border p-2"><?= htmlspecialchars($jt->status); ?></td>
                        <td class="border p-2">
                            <?= form_open('dokter/konfirmasi_janji_temu/' . $jt->uuid, ['class' => 'inline']); ?>
                                <select name="status" class="border p-1 rounded-lg">
                                    <option value="menunggu" <?= $jt->status == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                    <option value="selesai" <?= $jt->status == 'selesai' ? 'selected' : ''; ?>>Dikonfirmasi</option>
                                    <option value="batal" <?= $jt->status == 'batal' ? 'selected' : ''; ?>>Ditolak</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 text-white p-1 rounded-lg"><i class="fas fa-save mr-1"></i> Update</button>
                            <?= form_close(); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="border p-2 text-center text-gray-600">Tidak ada janji temu yang perlu dikonfirmasi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>