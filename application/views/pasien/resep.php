
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <?php if ($resep): ?>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Tanggal Kunjungan</th>
                        <th class="p-3 text-left">Obat</th>
                        <th class="p-3 text-left">Jumlah</th>
                        <th class="p-3 text-left">Status Ambil</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resep as $item): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $item->tanggal_kunjungan; ?></td>
                            <td class="p-3"><?php echo $item->id_obat; ?></td>
                            <td class="p-3"><?php echo $item->jumlah; ?></td>
                            <td class="p-3"><?php echo ucfirst($item->status_ambil); ?></td>
                            <td class="p-3">
                                <a href="<?php echo site_url('pasien/detail_resep/' . $item->uuid); ?>" class="text-indigo-600 hover:text-indigo-800">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600">Belum ada resep.</p>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>