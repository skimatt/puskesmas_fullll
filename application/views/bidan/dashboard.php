<?php
$bidan = isset($bidan) ? $bidan : null;
$antrian = isset($antrian) ? $antrian : [];
$unread_notifikasi = isset($unread_notifikasi) ? $unread_notifikasi : 0;
?>

<div class="space-y-6">
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white rounded-lg p-6 shadow-lg">
        <h1 class="text-2xl font-bold">Selamat Datang, <?php echo $bidan && $bidan->nama ? $bidan->nama : 'Bidan'; ?>!</h1>
        <p class="text-sm">Kelola antrian dan komunikasi dengan pasien di Puskesmas Digital.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center space-y-4">
            <img src="<?php echo ($bidan && $bidan->profile_picture) ? base_url('Uploads/profile/' . $bidan->profile_picture) : 'https://via.placeholder.com/100'; ?>" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
            <div class="text-center">
                <h2 class="text-xl font-bold text-gray-800"><?php echo $bidan && $bidan->nama ? $bidan->nama : 'Bidan'; ?></h2>
                <p class="text-gray-600"><?php echo $bidan && $bidan->email ? $bidan->email : 'email@contoh.com'; ?></p>
                <p class="text-gray-600"><?php echo $bidan && $bidan->no_telepon ? $bidan->no_telepon : '-'; ?></p>
                <a href="<?php echo site_url('bidan/edit_profile'); ?>" class="mt-2 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Edit Profil</a>
            </div>
        </div>
        <div class="lg:col-span-2 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-indigo-100 text-indigo-700 p-4 rounded-lg shadow text-center">
                    <p class="text-2xl font-semibold"><?php echo count($antrian); ?></p>
                    <p class="text-sm">Antrian Hari Ini</p>
                </div>
                <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg shadow text-center">
                    <p class="text-2xl font-semibold"><?php echo $unread_notifikasi; ?></p>
                    <p class="text-sm">Pesan Belum Dibaca</p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Antrian Terkini</h2>
        <?php if (empty($antrian)): ?>
            <p class="text-gray-600">Tidak ada antrian saat ini.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">No. Antrian</th>
                            <th class="p-3">Pasien</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($antrian as $item): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?php echo $item->nomor_antrian ? $item->nomor_antrian : '-'; ?></td>
                                <td class="p-3"><?php echo $item->nama_pasien ? $item->nama_pasien : '-'; ?></td>
                                <td class="p-3"><?php echo $item->tanggal ? $item->tanggal : '-'; ?></td>
                                <td class="p-3"><?php echo $item->waktu ? $item->waktu : '-'; ?></td>
                                <td class="p-3"><?php echo $item->status ? $item->status : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>