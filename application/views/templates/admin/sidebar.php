<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-indigo-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-20">
    <div class="p-4 border-b border-indigo-800">
        <h1 class="text-2xl font-bold">Puskesmas Digital</h1>
        <p class="text-sm opacity-75">Admin Dashboard</p>
    </div>
    <nav class="flex-1 p-4">
        <ul class="space-y-1">
            <li>
                <a href="<?= base_url('admin/dashboard'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/dashboard' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-home w-5 mr-3"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/manage_pasien'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/manage_pasien' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-users w-5 mr-3"></i> Manajemen Pasien
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/manage_dokter'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/manage_dokter' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-user-md w-5 mr-3"></i> Manajemen Dokter
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/manage_bidan'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/manage_bidan' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-female w-5 mr-3"></i> Manajemen Bidan
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/manage_obat'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/manage_obat' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-pills w-5 mr-3"></i> Manajemen Obat
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/antrian'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/antrian' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-list-ol w-5 mr-3"></i> Manajemen Antrian
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/riwayat'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/riwayat' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-history w-5 mr-3"></i> Riwayat Kunjungan
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/resep'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/resep' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-prescription-bottle w-5 mr-3"></i> Manajemen Resep
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/notifikasi'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/notifikasi' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-bell w-5 mr-3"></i> Notifikasi
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/chat'); ?>" class="flex items-center p-3 rounded-lg hover:bg-indigo-800 <?= uri_string() == 'admin/chat' ? 'bg-indigo-800' : ''; ?>">
                    <i class="fas fa-comments w-5 mr-3"></i> Chat
                </a>
            </li>
        </ul>
    </nav>
</aside>