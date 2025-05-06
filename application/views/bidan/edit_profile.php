<?php
$bidan = isset($bidan) ? $bidan : null;
?>

<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <div class="bg-white shadow rounded-lg p-6 mt-4">
        <form method="post" action="<?php echo site_url('bidan/edit_profile'); ?>" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control w-full p-2 border rounded" value="<?php echo set_value('nama', $bidan && $bidan->nama ? $bidan->nama : ''); ?>" required>
                    <?php echo form_error('nama', '<small class="text-red-500">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control w-full p-2 border rounded" value="<?php echo set_value('email', $bidan && $bidan->email ? $bidan->email : ''); ?>" required>
                    <?php echo form_error('email', '<small class="text-red-500">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="no_telepon">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control w-full p-2 border rounded" value="<?php echo set_value('no_telepon', $bidan && $bidan->no_telepon ? $bidan->no_telepon : ''); ?>" required>
                    <?php echo form_error('no_telepon', '<small class="text-red-500">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Foto Profil</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-control-file w-full p-2">
                    <?php if ($bidan && $bidan->profile_picture): ?>
                        <img src="<?php echo base_url('Uploads/profile/' . $bidan->profile_picture); ?>" alt="Current Profile Picture" class="mt-2 w-24 h-24 rounded-full object-cover">
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
                <a href="<?php echo site_url('bidan'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
            </div>
        </form>
    </div>
</div>