
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Detail Tagihan</h2>
        <table class="w-full mb-6">
            <tr>
                <th class="p-2 text-left">Tanggal Tagihan</th>
                <td class="p-2"><?php echo $tagihan->tanggal_tagihan; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Tanggal Kunjungan</th>
                <td class="p-2"><?php echo $tagihan->tanggal_kunjungan; ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Jumlah</th>
                <td class="p-2">Rp <?php echo number_format($tagihan->jumlah, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="p-2 text-left">Keterangan</th>
                <td class="p-2"><?php echo $tagihan->keterangan ?: '-'; ?></td>
            </tr>
        </table>
        <h2 class="text-xl font-semibold mb-4">Form Pembayaran</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-control w-full p-2 border rounded" required>
                    <option value="">Pilih metode</option>
                    <option value="tunai">Tunai</option>
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="kartu_kredit">Kartu Kredit</option>
                    <option value="kartu_debit">Kartu Debit</option>
                    <option value="bpjs">BPJS</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <?php echo form_error('metode_pembayaran', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="form-group mt-4">
                <label for="bukti_pembayaran">Bukti Pembayaran (JPG, JPEG, PNG, PDF)</label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file w-full p-2">
            </div>
            <div class="form-group mt-4">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control w-full p-2 border rounded"><?php echo set_value('keterangan'); ?></textarea>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Ajukan Pembayaran</button>
                <a href="<?php echo site_url('pasien/tagihan'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>