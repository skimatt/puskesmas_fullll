

<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Chat</h2>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3">Nama Pasien</th>
                        <th class="p-3">Penyedia</th>
                        <th class="p-3">Pesan</th>
                        <th class="p-3">Pengirim</th>
                        <th class="p-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($chat): ?>
                        <?php foreach ($chat as $c): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= $c->nama_pasien; ?></td>
                                <td class="p-3"><?= $c->nama_penyedia; ?></td>
                                <td class="p-3"><?= $c->pesan; ?></td>
                                <td class="p-3"><?= ucfirst($c->pengirim); ?></td>
                                <td class="p-3"><?= date('d-m-Y H:i', strtotime($c->created_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-3 text-gray-600 text-center">Belum ada pesan chat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>