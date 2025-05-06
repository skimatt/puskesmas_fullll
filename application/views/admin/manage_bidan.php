


<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Bidan</h2>
        <a href="<?= base_url('admin/add_bidan'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Bidan
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
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">No. Telepon</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bidan): ?>
                        <?php foreach ($bidan as $b): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= $b->nama; ?></td>
                                <td class="p-3"><?= $b->email; ?></td>
                                <td class="p-3"><?= $b->no_telepon; ?></td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 rounded text-sm <?= $b->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                        <?= $b->is_active ? 'Aktif' : 'Nonaktif'; ?>
                                    </span>
                                </td>
                                <td class="p-3 flex space-x-2">
                                    <a href="<?= base_url('admin/edit_bidan/' . $b->uuid); ?>" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/delete_bidan/' . $b->uuid); ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus bidan ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">Belum ada bidan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>