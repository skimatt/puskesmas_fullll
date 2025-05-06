<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Obat</h2>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama Obat</th>
                <th class="border p-2">Jenis Obat</th>
                <th class="border p-2">Stok</th>
                <th class="border p-2">Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($obat as $o): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($o->nama_obat); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($o->jenis_obat); ?></td>
                    <td class="border p-2"><?= htmlspecialchars($o->stok); ?></td>
                    <td class="border p-2"><?= number_format($o->harga, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>