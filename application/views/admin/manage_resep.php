

<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Resep</h2>
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
                        <th class="p-3">Nama Pasien</th>
                        <th class="p-3">Penyedia</th>
                        <th class="p-3">Obat</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Status Ambil</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resep): ?>
                        <?php foreach ($resep as $r): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= $r->nama_pasien; ?></td>
                                <td class="p-3"><?= $r->nama_penyedia; ?></td>
                                <td class="p-3"><?= $r->nama_obat; ?></td>
                                <td class="p-3"><?= $r->jumlah; ?></td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 rounded text-sm <?= $r->status_ambil == 'sudah' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                        <?= ucfirst($r->status_ambil); ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="<?= base_url('admin/edit_resep/' . $r->uuid); ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-3 text-gray-600 text-center">Belum ada resep.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>