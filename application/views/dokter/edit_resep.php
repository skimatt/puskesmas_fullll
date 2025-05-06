

<div class="container mx-auto">
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
        <?= form_open('dokter/edit_resep/' . (isset($resep->uuid) ? $resep->uuid : '')); ?>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ID Pasien</label>
                    <input type="text" value="<?= isset($resep->id_pasien) ? htmlspecialchars($resep->id_pasien) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Obat</label>
                    <select name="id_obat" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Obat</option>
                        <?php foreach ($obat as $o): ?>
                            <option value="<?= $o->uuid; ?>" <?= isset($resep->id_obat) && $resep->id_obat == $o->uuid ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($o->nama_obat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" value="<?= isset($resep->jumlah) ? htmlspecialchars($resep->jumlah) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Aturan Pakai</label>
                    <input type="text" name="aturan_pakai" value="<?= isset($resep->aturan_pakai) ? htmlspecialchars($resep->aturan_pakai) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Ambil</label>
                    <select name="status_ambil" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="belum" <?= isset($resep->status_ambil) && $resep->status_ambil == 'belum' ? 'selected' : ''; ?>>Belum</option>
                        <option value="sudah" <?= isset($resep->status_ambil) && $resep->status_ambil == 'sudah' ? 'selected' : ''; ?>>Sudah</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="<?= base_url('dokter/manage_resep'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<?php $this->load->view('templates/dokter/footer'); ?>