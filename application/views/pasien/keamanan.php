
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Ganti Password</h2>
        <form method="post" action="<?php echo site_url('pasien/keamanan'); ?>">
            <!-- Tambahkan CSRF Token -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            
            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password" class="form-control w-full p-2 border rounded" required>
                <?php echo form_error('current_password', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="form-group mt-4">
                <label for="new_password">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control w-full p-2 border rounded" required>
                <?php echo form_error('new_password', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="form-group mt-4">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control w-full p-2 border rounded" required>
                <?php echo form_error('confirm_password', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
                <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
            </div>
        </form>
    </div>
</div>
