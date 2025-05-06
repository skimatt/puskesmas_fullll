<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tagihan</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Tagihan</h3>
        <?php if (empty($tagihan)): ?>
            <p class="text-gray-500">Belum ada tagihan.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Pasien</th>
                        <th class="px-4 py-2 text-left">Tanggal Tagihan</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagihan as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item->nama_pasien; ?></td>
                            <td class="border px-4 py-2"><?php echo date('d-m-Y', strtotime($item->tanggal_tagihan)); ?></td>
                            <td class="border px-4 py-2">Rp <?php echo number_format($item->jumlah, 2, ',', '.'); ?></td>
                            <td class="border px-4 py-2"><?php echo ucfirst($item->status); ?></td>
                            <td class="border px-4 py-2"><?php echo $item->keterangan; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>