
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard Admin</h2>
        <span class="text-sm text-gray-500">Tanggal: <?= date('d M Y'); ?></span>
    </div>

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

    <!-- Statistik Umum -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-users text-blue-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Pasien</p>
            <p class="text-2xl font-bold text-blue-600"><?= $total_pasien; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-user-md text-blue-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Dokter</p>
            <p class="text-2xl font-bold text-blue-600"><?= $total_dokter; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-female text-blue-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Bidan</p>
            <p class="text-2xl font-bold text-blue-600"><?= $total_bidan; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-user-shield text-blue-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Admin</p>
            <p class="text-2xl font-bold text-blue-600"><?= $total_admin; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-pills text-green-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Obat Tersedia</p>
            <p class="text-2xl font-bold text-green-600"><?= $total_obat; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-list-ol text-green-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Kunjungan Hari Ini</p>
            <p class="text-2xl font-bold text-green-600"><?= $antrian_hari_ini; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-history text-green-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Kunjungan Bulan Ini</p>
            <p class="text-2xl font-bold text-green-600"><?= $riwayat_bulan_ini; ?></p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-prescription-bottle text-red-500 text-2xl mb-2"></i>
            <p class="text-sm text-gray-600">Resep Belum Diambil</p>
            <p class="text-2xl font-bold text-red-600"><?= $total_resep_belum_diambil; ?></p>
        </div>
    </div>

    <!-- Antrian dan Jadwal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Antrian Hari Ini -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-list-ol mr-2"></i> Antrian Hari Ini
            </h3>
            <?php if ($antrian): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3">Nama Pasien</th>
                                <th class="p-3">Penyedia</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($antrian as $a): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><?= $a->nama_pasien; ?></td>
                                    <td class="p-3"><?= $a->nama_penyedia . ' (' . ucfirst($a->penyedia_role) . ')'; ?></td>
                                    <td class="p-3">
                                        <span class="inline-block px-2 py-1 rounded text-sm <?php
                                            if ($a->status == 'menunggu') echo 'bg-yellow-100 text-yellow-700';
                                            elseif ($a->status == 'selesai') echo 'bg-green-100 text-green-700';
                                            else echo 'bg-red-100 text-red-700';
                                        ?>">
                                            <?= ucfirst($a->status); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Tidak ada antrian hari ini.</p>
            <?php endif; ?>
        </div>

        <!-- Jadwal Praktik Hari Ini -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i> Jadwal Praktik Hari Ini
            </h3>
            <?php if ($jadwal): ?>
                <div class="space-y-4">
                    <?php foreach ($jadwal as $j): ?>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700"><strong><?= ucfirst($j->role); ?>:</strong> <?= $j->nama_penyedia; ?></p>
                            <p class="text-gray-700"><strong>Jam:</strong> <?= substr($j->jam_mulai, 0, 5); ?> - <?= substr($j->jam_selesai, 0, 5); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Tidak ada jadwal praktik hari ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Obat Rendah dan Resep -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Stok Obat Rendah -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i> Stok Obat Rendah
            </h3>
            <?php if ($obat_rendah): ?>
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    <?php foreach ($obat_rendah as $o): ?>
                        <div class="p-4 bg-red-50 rounded-lg">
                            <p class="text-red-700"><strong>Obat:</strong> <?= $o->nama_obat; ?></p>
                            <p class="text-red-700"><strong>Stok:</strong> <?= $o->stok; ?> unit</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Tidak ada obat dengan stok rendah.</p>
            <?php endif; ?>
        </div>

        <!-- Resep Belum Diambil -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-prescription-bottle mr-2"></i> Resep Belum Diambil
                <span class="ml-2 text-red-600 text-sm">(<?= $total_resep_belum_diambil; ?>)</span>
            </h3>
            <?php if ($resep_belum_diambil): ?>
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    <?php foreach ($resep_belum_diambil as $r): ?>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700"><strong>Pasien:</strong> <?= $r->nama_pasien; ?></p>
                            <p class="text-gray-700"><strong>Obat:</strong> <?= $r->nama_obat; ?> (<?= $r->jumlah; ?>)</p>
                            <p class="text-gray-700"><strong>Penyedia:</strong> <?= $r->nama_penyedia; ?></p>
                            <p class="text-sm text-gray-500"><?= date('d M Y H:i', strtotime($r->created_at)); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Tidak ada resep yang belum diambil.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Riwayat dan Notifikasi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Riwayat Kunjungan Terbaru -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-history mr-2"></i> Riwayat Kunjungan Terbaru
            </h3>
            <?php if ($riwayat): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3">Pasien</th>
                                <th class="p-3">Pelayanan</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $r): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><?= $r->nama_pasien; ?></td>
                                    <td class="p-3"><?= $r->jenis_pelayanan; ?></td>
                                    <td class="p-3"><?= date('d M Y H:i', strtotime($r->tanggal_kunjungan)); ?></td>
                                    <td class="p-3">
                                        <span class="inline-block px-2 py-1 rounded text-sm <?= $r->status == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'; ?>">
                                            <?= ucfirst($r->status); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <pとう. class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Belum ada riwayat kunjungan.</p>
            <?php endif; ?>
        </div>

        <!-- Notifikasi Terbaru -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bell mr-2"></i> Notifikasi Terbaru
            </h3>
            <?php if ($notifikasi): ?>
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    <?php foreach ($notifikasi as $n): ?>
                        <div class="p-4 bg-gray-50 rounded-lg <?= $n->status == 'belum_dibaca' ? 'border-l-4 border-blue-600' : ''; ?>">
                            <p class="text-gray-700"><strong>Pasien:</strong> <?= $n->nama_pasien; ?></p>
                            <p class="text-gray-700"><?= $n->pesan; ?></p>
                            <p class="text-sm text-gray-500"><?= date('d M Y H:i', strtotime($n->created_at)); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Belum ada notifikasi.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pesan Terakhir -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-comments mr-2"></i> Pesan Terakhir
        </h3>
        <?php if ($chat): ?>
            <div class="space-y-4 max-h-64 overflow-y-auto">
                <?php foreach ($chat as $c): ?>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700"><strong>Pengirim:</strong> <?= $c->pengirim == 'pasien' ? $c->nama_pasien : $c->nama_penyedia; ?> (<?= ucfirst($c->pengirim); ?>)</p>
                        <p class="text-gray-700"><strong>Penerima:</strong> <?= $c->pengirim == 'pasien' ? $c->nama_penyedia : $c->nama_pasien; ?></p>
                        <p class="text-gray-700"><?= $c->pesan; ?></p>
                        <p class="text-sm text-gray-500"><?= date('d M Y H:i', strtotime($c->created_at)); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 flex items-center"><i class="fas fa-info-circle mr-2"></i> Belum ada pesan.</p>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>