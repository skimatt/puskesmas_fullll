
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <?php if ($riwayat): ?>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Tanggal Kunjungan</th>
                        <th class="p-3 text-left">Jenis Pelayanan</th>
                        <th class="p-3 text-left">Diagnosa</th>
                        <th class="p-3 text-left">Tindakan</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat as $item): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $item->tanggal_kunjungan; ?></td>
                            <td class="p-3"><?php echo $item->jenis_pelayanan; ?></td>
                            <td class="p-3"><?php echo $item->diagnosa ?: '-'; ?></td>
                            <td class="p-3"><?php echo $item->tindakan ?: '-'; ?></td>
                            <td class="p-3"><?php echo ucfirst($item->status); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">Belum ada riwayat kunjungan.</p>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>