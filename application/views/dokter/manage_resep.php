

<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Resep</h2>
        <a href="<?= base_url('dokter/add_resep'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Resep
        </a>
    </div>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3">ID Pasien</th>
                        <th class="p-3">Obat</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Status Ambil</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resep) && is_array($resep)): ?>
                        <?php foreach ($resep as $r): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= isset($r->id_pasien) ? htmlspecialchars($r->id_pasien) : '-'; ?></td>
                                <td class="p-3"><?= isset($r->nama_obat) ? htmlspecialchars($r->nama_obat) : '-'; ?></td>
                                <td class="p-3"><?= isset($r->jumlah) ? htmlspecialchars($r->jumlah) : '-'; ?></td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 rounded text-sm <?= isset($r->status_ambil) && $r->status_ambil == 'sudah' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                        <?= isset($r->status_ambil) ? ucfirst(htmlspecialchars($r->status_ambil)) : 'Tidak Diketahui'; ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="<?= base_url('dokter/edit_resep/' . (isset($r->uuid) ? $r->uuid : '')); ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">Belum ada resep.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/dokter/footer'); ?>