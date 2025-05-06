<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Notifikasi</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Daftar Notifikasi</h3>
            <a href="<?php echo base_url('dokter/mark_all_notifikasi_read'); ?>" class="text-blue-600 hover:underline">Tandai Semua Dibaca</a>
        </div>
        <?php if (empty($notifikasi)): ?>
            <p class="text-gray-500">Belum ada notifikasi.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($notifikasi as $item): ?>
                    <div class="p-4 border rounded-md <?php echo $item->status == 'belum_dibaca' ? 'bg-blue-50' : 'bg-gray-50'; ?>">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500"><?php echo date('d-m-Y H:i', strtotime($item->created_at)); ?></p>
                                <p class="mt-1"><?php echo $item->pesan; ?></p>
                            </div>
                            <?php if ($item->status == 'belum_dibaca'): ?>
                                <a href="<?php echo base_url('dokter/mark_notifikasi_read/' . $item->uuid); ?>" class="text-blue-600 hover:underline">Tandai Dibaca</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>