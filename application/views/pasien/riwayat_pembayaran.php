
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <?php if ($pembayaran): ?>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Tanggal Pembayaran</th>
                        <th class="p-3 text-left">Jumlah</th>
                        <th class="p-3 text-left">Metode</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pembayaran as $item): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $item->tanggal_pembayaran; ?></td>
                            <td class="p-3">Rp <?php echo number_format($item->jumlah, 0, ',', '.'); ?></td>
                            <td class="p-3"><?php echo ucfirst(str_replace('_', ' ', $item->metode_pembayaran)); ?></td>
                            <td class="p-3"><?php echo ucfirst($item->status); ?></td>
                            <td class="p-3">
                                <?php if ($item->bukti_pembayaran): ?>
                                    <a href="<?php echo base_url('Uploads/bukti_pembayaran/' . $item->bukti_pembayaran); ?>" class="text-indigo-600 hover:text-indigo-800" target="_blank">Lihat</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">Belum ada riwayat pembayaran.</p>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>