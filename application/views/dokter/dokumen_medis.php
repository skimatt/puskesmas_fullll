<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Dokumen Medis Pasien: <?php echo $pasien->nama; ?></h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Dokumen Medis</h3>
        <?php if (empty($dokumen)): ?>
            <p class="text-gray-500">Belum ada dokumen medis.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Nama Dokumen</th>
                        <th class="px-4 py-2 text-left">Tanggal Upload</th>
                        <th class="px-4 py-2 text-left">Keterangan</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dokumen as $item): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $item->nama_dokumen; ?></td>
                            <td class="border px-4 py-2"><?php echo date('d-m-Y H:i', strtotime($item->tanggal_upload)); ?></td>
                            <td class="border px-4 py-2"><?php echo $item->keterangan; ?></td>
                            <td class="border px-4 py-2">
                                <a href="<?php echo base_url($item->file_path); ?>" class="text-blue-600 hover:underline" target="_blank">Lihat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>