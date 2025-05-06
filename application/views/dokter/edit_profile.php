<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Profil</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <?php echo form_open_multipart('dokter/edit_profile'); ?>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?php echo set_value('nama', $dokter->nama); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('nama', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                <input type="text" id="spesialisasi" name="spesialisasi" value="<?php echo set_value('spesialisasi', $dokter->spesialisasi); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('spesialisasi', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" value="<?php echo set_value('no_telepon', $dokter->no_telepon); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('no_telepon', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-sm text-gray-500 mt-1">Maks. 2MB, format: JPG, JPEG, PNG</p>
                <?php if (isset($dokter->profile_picture) && $dokter->profile_picture): ?>
                    <img src="<?php echo base_url('uploads/profile/' . $dokter->profile_picture); ?>" alt="Profile" class="mt-2 w-24 h-24 rounded-full">
                <?php endif; ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>