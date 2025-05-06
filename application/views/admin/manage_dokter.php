<div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Kelola Dokter</h2>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6"><?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="mb-6">
        <a href="<?= site_url('admin/add_dokter'); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Dokter</a>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <?php if ($dokter): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Spesialisasi</th>
                            <th class="p-3">No. Telepon</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dokter as $d): ?>
                            <tr class="border-b">
                                <td class="p-3"><?= $d->nama; ?></td>
                                <td class="p-3"><?= $d->email; ?></td>
                                <td class="p-3"><?= $d->spesialisasi; ?></td>
                                <td class="p-3"><?= $d->no_telepon ?: '-'; ?></td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 rounded <?= $d->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                        <?= $d->is_active ? 'Aktif' : 'Non-Aktif'; ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="<?= site_url('admin/edit_dokter/' . $d->uuid); ?>" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="<?= site_url('admin/delete_dokter/' . $d->uuid); ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin ingin menghapus akun ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Belum ada dokter terdaftar.</p>
        <?php endif; ?>
    </div>
</div>