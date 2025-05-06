
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <?php if ($pasien): ?>
            <form method="post" enctype="multipart/form-data">
                <!-- Tambahkan CSRF Token -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control w-full p-2 border rounded" value="<?php echo set_value('nama', isset($pasien->nama) ? $pasien->nama : ''); ?>" required>
                        <?php echo form_error('nama', '<small class="text-red-500">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control w-full p-2 border rounded" value="<?php echo set_value('tanggal_lahir', isset($pasien->tanggal_lahir) ? $pasien->tanggal_lahir : ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control w-full p-2 border rounded">
                            <option value="">Pilih</option>
                            <option value="L" <?php echo set_select('jenis_kelamin', 'L', isset($pasien->jenis_kelamin) && $pasien->jenis_kelamin == 'L'); ?>>Laki-laki</option>
                            <option value="P" <?php echo set_select('jenis_kelamin', 'P', isset($pasien->jenis_kelamin) && $pasien->jenis_kelamin == 'P'); ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">No. Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control w-full p-2 border rounded" value="<?php echo set_value('no_telepon', isset($pasien->no_telepon) ? $pasien->no_telepon : ''); ?>">
                        <?php echo form_error('no_telepon', '<small class="text-red-500">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="nomor_bpjs">Nomor BPJS</label>
                        <input type="text" name="nomor_bpjs" id="nomor_bpjs" class="form-control w-full p-2 border rounded" value="<?php echo set_value('nomor_bpjs', isset($pasien->nomor_bpjs) ? $pasien->nomor_bpjs : ''); ?>">
                        <?php echo form_error('nomor_bpjs', '<small class="text-red-500">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="golongan_darah">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="form-control w-full p-2 border rounded">
                            <option value="">Pilih</option>
                            <option value="A" <?php echo set_select('golongan_darah', 'A', isset($pasien->golongan_darah) && $pasien->golongan_darah == 'A'); ?>>A</option>
                            <option value="B" <?php echo set_select('golongan_darah', 'B', isset($pasien->golongan_darah) && $pasien->golongan_darah == 'B'); ?>>B</option>
                            <option value="AB" <?php echo set_select('golongan_darah', 'AB', isset($pasien->golongan_darah) && $pasien->golongan_darah == 'AB'); ?>>AB</option>
                            <option value="O" <?php echo set_select('golongan_darah', 'O', isset($pasien->golongan_darah) && $pasien->golongan_darah == 'O'); ?>>O</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" name="agama" id="agama" class="form-control w-full p-2 border rounded" value="<?php echo set_value('agama', isset($pasien->agama) ? $pasien->agama : ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control w-full p-2 border rounded" value="<?php echo set_value('pekerjaan', isset($pasien->pekerjaan) ? $pasien->pekerjaan : ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="status_perkawinan">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control w-full p-2 border rounded">
                            <option value="">Pilih</option>
                            <option value="Belum Menikah" <?php echo set_select('status_perkawinan', 'Belum Menikah', isset($pasien->status_perkawinan) && $pasien->status_perkawinan == 'Belum Menikah'); ?>>Belum Menikah</option>
                            <option value="Menikah" <?php echo set_select('status_perkawinan', 'Menikah', isset($pasien->status_perkawinan) && $pasien->status_perkawinan == 'Menikah'); ?>>Menikah</option>
                            <option value="Duda" <?php echo set_select('status_perkawinan', 'Duda', isset($pasien->status_perkawinan) && $pasien->status_perkawinan == 'Duda'); ?>>Duda</option>
                            <option value="Janda" <?php echo set_select('status_perkawinan', 'Janda', isset($pasien->status_perkawinan) && $pasien->status_perkawinan == 'Janda'); ?>>Janda</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Foto Profil</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control-file w-full p-2">
                        <?php if (isset($pasien->profile_picture) && $pasien->profile_picture): ?>
                            <img src="<?php echo base_url('Uploads/profile/' . $pasien->profile_picture); ?>" alt="Profile Picture" class="mt-2 h-20 w-20 object-cover rounded">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control w-full p-2 border rounded"><?php echo set_value('alamat', isset($pasien->alamat) ? $pasien->alamat : ''); ?></textarea>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
                    <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
                </div>
            </form>
        <?php else: ?>
            <p class="text-red-600">Data pasien tidak ditemukan. Silakan hubungi administrator atau lengkapi profil Anda.</p>
            <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mt-4 inline-block">Kembali ke Dashboard</a>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>