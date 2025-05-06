<?php if ($this->session->userdata('email') && $this->session->userdata('role') == 'dokter'): ?>
    <aside class="w-64 bg-white shadow-md h-screen">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Puskesmas Digital</h2>
            <p class="text-sm text-gray-600">Dokter: <?= htmlspecialchars($this->session->userdata('nama')); ?></p>
        </div>
        <nav class="mt-2">
        <a href="<?= base_url('dokter'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(1) == 'dokter' && !$this->uri->segment(2) ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>
            <a href="<?= base_url('dokter/pasien'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'pasien' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-users mr-3"></i> Data Pasien
            </a>
            <a href="<?= base_url('dokter/antrian'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'antrian' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-list mr-3"></i> Kelola Antrian
            </a>
            <a href="<?= base_url('dokter/janji_temu'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'janji_temu' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-calendar-check mr-3"></i> Janji Temu
            </a>
            <a href="<?= base_url('dokter/jadwal_praktik'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'jadwal_praktik' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-calendar mr-3"></i> Jadwal Praktik
            </a>
            <a href="<?= base_url('dokter/obat'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'obat' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-capsules mr-3"></i> Data Obat
            </a>
            <a href="<?= base_url('dokter/chat'); ?>" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200 <?= $this->uri->segment(2) == 'chat' ? 'bg-indigo-100 text-indigo-600 font-semibold' : ''; ?>">
                <i class="fas fa-comments mr-3"></i> Chat
            </a>
            <a href="<?= base_url('auth/logout'); ?>" 
               class="flex items-center px-6 py-3 text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200 mt-4">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>
        </nav>
    </aside>
<?php else: ?>
    <?php redirect('auth/login'); ?>
<?php endif; ?>
