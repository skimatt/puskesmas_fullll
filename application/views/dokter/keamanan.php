<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Keamanan</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Ganti Kata Sandi</h3>
        <?php echo form_open('dokter/keamanan'); ?>
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('current_password', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('new_password', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php echo form_error('confirm_password', '<p class="text-red-500 text-sm mt-1">', '</p>'); ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Ganti Password</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>