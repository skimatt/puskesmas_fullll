
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Unggah Dokumen</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_dokumen">Nama Dokumen</label>
                <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control w-full p-2 border rounded" value="<?php echo set_value('nama_dokumen'); ?>" required>
                <?php echo form_error('nama_dokumen', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="form-group mt-4">
                <label for="file_dokumen">File Dokumen (PDF, JPG, PNG)</label>
                <input type="file" name="file_dokumen" id="file_dokumen" class="form-control-file w-full p-2" required>
            </div>
            <div class="form-group mt-4">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control w-full p-2 border rounded"><?php echo set_value('keterangan'); ?></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Unggah</button>
            </div>
        </form>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Daftar Dokumen</h2>
        <?php if ($dokumen): ?>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Nama Dokumen</th>
                        <th class="p-3 text-left">Tanggal Upload</th>
                        <th class="p-3 text-left">Keterangan</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dokumen as $item): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $item->nama_dokumen; ?></td>
                            <td class="p-3"><?php echo $item->tanggal_upload; ?></td>
                            <td class="p-3"><?php echo $item->keterangan ?: '-'; ?></td>
                            <td class="p-3">
                                <a href="<?php echo base_url('Uploads/dokumen/' . $item->file_path); ?>" class="text-indigo-600 hover:text-indigo-800" target="_blank">Unduh</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">Belum ada dokumen medis.</p>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>