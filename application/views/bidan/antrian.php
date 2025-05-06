<?php
$antrian = isset($antrian) ? $antrian : [];
?>

<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <div class="bg-white shadow rounded-lg p-6 mt-4">
        <h2 class="text-xl font-semibold mb-4">Daftar Antrian</h2>
        <?php if (empty($antrian)): ?>
            <p class="text-gray-600">Tidak ada antrian saat ini.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">No. Antrian</th>
                            <th class="p-3">Pasien</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($antrian as $item): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?php echo $item->nomor_antrian ? $item->nomor_antrian : '-'; ?></td>
                                <td class="p-3"><?php echo $item->nama_pasien ? $item->nama_pasien : '-'; ?></td>
                                <td class="p-3"><?php echo $item->tanggal ? $item->tanggal : '-'; ?></td>
                                <td class="p-3"><?php echo $item->waktu ? $item->waktu : '-'; ?></td>
                                <td class="p-3"><?php echo $item->status ? $item->status : '-'; ?></td>
                                <td class="p-3">
                                    <form method="post" action="<?php echo site_url('bidan/antrian'); ?>">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <input type="hidden" name="id_antrian" value="<?php echo $item->id_antrian; ?>">
                                        <select name="status" class="form-control inline-block w-32 p-1 border rounded">
                                            <option value="Menunggu" <?php echo $item->status == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                            <option value="Diproses" <?php echo $item->status == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                            <option value="Selesai" <?php echo $item->status == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                        </select>
                                        <button type="submit" class="bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700 ml-2">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>