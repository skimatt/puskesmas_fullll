

<div class="container mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Profil Dokter</h2>

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
        <?= form_open('dokter/profil'); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="<?= isset($dokter->nama) ? htmlspecialchars($dokter->nama) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="<?= isset($dokter->email) ? htmlspecialchars($dokter->email) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="text" name="no_telepon" value="<?= isset($dokter->no_telepon) ? htmlspecialchars($dokter->no_telepon) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                    <input type="text" name="spesialisasi" value="<?= isset($dokter->spesialisasi) ? htmlspecialchars($dokter->spesialisasi) : ''; ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<?php $this->load->view('templates/dokter/footer'); ?>