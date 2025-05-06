

<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Resep</h2>

    <?php if (validation_errors()): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= validation_errors(); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <?= form_open('admin/edit_resep/' . $resep->uuid); ?>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                    <input type="text" value="<?= $resep->nama_pasien; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Penyedia</label>
                    <input type="text" value="<?= $resep->nama_penyedia; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Obat</label>
                    <input type="text" value="<?= $resep->nama_obat; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="text" value="<?= $resep->jumlah; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Ambil</label>
                    <select name="status_ambil" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="belum" <?= $resep->status_ambil == 'belum' ? 'selected' : ''; ?>>Belum</option>
                        <option value="sudah" <?= $resep->status_ambil == 'sudah' ? 'selected' : ''; ?>>Sudah</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="<?= base_url('admin/resep'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>