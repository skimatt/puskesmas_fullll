<?php
// Pastikan variabel $title, $dokter, $bidan, dan lainnya tersedia dari controller
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight"><?php echo $title; ?></h1>
        <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300 transition-all duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-50 text-green-800 p-4 rounded-xl mb-6 shadow-md flex items-center transform transition-all duration-500">
            <i class="fas fa-check-circle mr-3 text-green-600"></i>
            <span><?php echo $this->session->flashdata('message'); ?></span>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-50 text-red-800 p-4 rounded-xl mb-6 shadow-md flex items-center transform transition-all duration-500">
            <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
            <span><?php echo $this->session->flashdata('error'); ?></span>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white shadow-xl rounded-2xl p-8 transform transition-all duration-500">
        <form method="post" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dokter -->
                <div class="form-group">
                    <label for="id_dokter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-md mr-2"></i> Dokter
                    </label>
                    <select name="id_dokter" id="id_dokter" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50">
                        <option value="">Pilih Dokter</option>
                        <?php foreach ($dokter as $d): ?>
                            <option value="<?php echo $d->uuid; ?>" <?php echo set_select('id_dokter', $d->uuid); ?>><?php echo $d->nama; ?> (<?php echo $d->spesialisasi; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('id_dokter', '<small class="text-red-500 mt-1 block">', '</small>'); ?>
                </div>

                <!-- Bidan -->
                <div class="form-group">
                    <label for="id_bidan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-nurse mr-2"></i> Bidan
                    </label>
                    <select name="id_bidan" id="id_bidan" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50">
                        <option value="">Pilih Bidan</option>
                        <?php foreach ($bidan as $b): ?>
                            <option value="<?php echo $b->uuid; ?>" <?php echo set_select('id_bidan', $b->uuid); ?>><?php echo $b->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('id_bidan', '<small class="text-red-500 mt-1 block">', '</small>'); ?>
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal_antrian" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2"></i> Tanggal
                    </label>
                    <input type="date" name="tanggal_antrian" id="tanggal_antrian" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50" value="<?php echo set_value('tanggal_antrian'); ?>" required>
                    <?php echo form_error('tanggal_antrian', '<small class="text-red-500 mt-1 block">', '</small>'); ?>
                </div>

                <!-- Jam -->
                <div class="form-group">
                    <label for="jam_antrian" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock mr-2"></i> Jam
                    </label>
                    <select name="jam_antrian" id="jam_antrian" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50" required>
                        <option value="">Pilih Jam</option>
                    </select>
                    <?php echo form_error('jam_antrian', '<small class="text-red-500 mt-1 block">', '</small>'); ?>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="form-group">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-comment-medical mr-2"></i> Keterangan
                </label>
                <textarea name="keterangan" id="keterangan" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50 resize-y" rows="4" required><?php echo set_value('keterangan'); ?></textarea>
                <?php echo form_error('keterangan', '<small class="text-red-500 mt-1 block">', '</small>'); ?>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition-all duration-300 flex items-center">
                    <i class="fas fa-check mr-2"></i> Ajukan
                </button>
                <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full hover:bg-gray-300 transition-all duration-300 flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
