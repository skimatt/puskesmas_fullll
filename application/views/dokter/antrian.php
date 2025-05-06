<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Kelola Antrian (<?= htmlspecialchars($tanggal); ?>)</h2>
    <?= form_open('dokter/antrian', ['method' => 'get', 'class' => 'mb-4']); ?>
        <label for="tanggal" class="text-gray-600">Pilih Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" value="<?= htmlspecialchars($tanggal); ?>" class="border p-2 rounded-lg">
        <button type="submit" class="bg-indigo-600 text-white p-2 rounded-lg"><i class="fas fa-search mr-1"></i> Cari</button>
    <?= form_close(); ?>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama Pasien</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($antrian as $a): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($a->nama); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($a->status); ?></td>
                    <td class="border p-2">
                        <?= form_open('dokter/update_status_antrian/' . $a->uuid, ['class' => 'inline']); ?>
                            <select name="status" class="border p-1 rounded-lg">
                                <option value="menunggu" <?= $a->status == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="selesai" <?= $a->status == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="batal" <?= $a->status == 'batal' ? 'selected' : ''; ?>>Batal</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white p-1 rounded-lg"><i class="fas fa-save mr-1"></i> Update</button>
                        <?= form_close(); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>