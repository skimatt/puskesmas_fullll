
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Informasi Akun</h2>
        <table class="w-full">
            <tr>
                <th class="p-2 text-left">Nama</th>
                <td class="p-2"><?php echo $pasien->nama; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">No. KK</th>
                <td class="p-2"><?php echo $pasien->no_kk; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">No. KTP</th>
                <td class="p-2"><?php echo $pasien->no_ktp; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Email</th>
                <td class="p-2"><?php echo $this->session->userdata('email'); ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Tanggal Lahir</th>
                <td class="p-2"><?php echo $pasien->tanggal_lahir ?: '-'; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Jenis Kelamin</th>
                <td class="p-2"><?php echo $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : ($pasien->jenis_kelamin == 'P' ? 'Perempuan' : '-'); ?></td>
            </tr>
        </table>
        <div class="mt-4">
            <a href="<?php echo site_url('pasien/edit_profile'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit Profil</a>
            <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
        </div>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>