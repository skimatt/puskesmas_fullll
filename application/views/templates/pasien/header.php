<?php
// Ambil data sesi untuk foto profil dan nama
$profile_picture = $this->session->userdata('profile_picture');
$nama = $this->session->userdata('nama');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .nav-link.active {
            background-color: #e0e7ff;
            color: #4f46e5;
            font-weight: bold;
            border-left: 4px solid #4f46e5;
        }
        .notification-badge {
            top: 50%;
            transform: translateY(-50%);
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
            }
        }
    </style>
</head>
<body class="flex bg-gray-100">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar w-64 bg-white shadow-xl min-h-screen flex flex-col">
        <!-- Toggle Button -->
        <div class="flex justify-end p-4 lg:hidden">
            <button id="toggleSidebar" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Profile Section -->
        <div class="p-6 flex items-center space-x-4 border-b border-gray-200">
            <img src="<?php echo ($profile_picture != null && $profile_picture != '') ? base_url('Uploads/profile/' . $profile_picture) : 'https://via.placeholder.com/100'; ?>" alt="Profile Picture" class="w-12 h-12 rounded-full object-cover ring-2 ring-indigo-100">
            <div>
                <h2 class="text-lg font-semibold text-gray-800"><?php echo $nama ? $nama : 'Pengguna'; ?></h2>
                <p class="text-xs text-gray-500">Puskesmas Digital</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-4 flex-1 overflow-y-auto">
            <a href="<?php echo base_url('pasien'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(1) == 'pasien' && !$this->uri->segment(2) ? 'active' : ''; ?>">
                <i class="fas fa-home mr-3 w-5 text-center"></i> Dashboard
            </a>
            <a href="<?php echo base_url('pasien/buat_janji_temu'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'buat_janji_temu' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check mr-3 w-5 text-center"></i> Buat Janji Temu
            </a>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-4 pl-6">Data Kesehatan</p>
            <a href="<?php echo base_url('pasien/riwayat'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'riwayat' ? 'active' : ''; ?>">
                <i class="fas fa-history mr-3 w-5 text-center"></i> Riwayat Kunjungan
            </a>
            <a href="<?php echo base_url('pasien/resep'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'resep' ? 'active' : ''; ?>">
                <i class="fas fa-prescription mr-3 w-5 text-center"></i> Resep
            </a>
            <a href="<?php echo base_url('pasien/rekam_medis'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'rekam_medis' ? 'active' : ''; ?>">
                <i class="fas fa-file-medical mr-3 w-5 text-center"></i> Rekam Medis
            </a>
            <a href="<?php echo base_url('pasien/dokumen_medis'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'dokumen_medis' ? 'active' : ''; ?>">
                <i class="fas fa-folder-open mr-3 w-5 text-center"></i> Dokumen Medis
            </a>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-4 pl-6">Pembayaran</p>
            <a href="<?php echo base_url('pasien/tagihan'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'tagihan' ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice mr-3 w-5 text-center"></i> Tagihan
            </a>
            <a href="<?php echo base_url('pasien/riwayat_pembayaran'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'riwayat_pembayaran' ? 'active' : ''; ?>">
                <i class="fas fa-money-check-alt mr-3 w-5 text-center"></i> Riwayat Pembayaran
            </a>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-4 pl-6">Komunikasi</p>
            <a href="<?php echo base_url('pasien/chat'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'chat' ? 'active' : ''; ?>">
                <i class="fas fa-comments mr-3 w-5 text-center"></i> Chat
            </a>
            <a href="<?php echo base_url('pasien/notifikasi'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 relative <?php echo $this->uri->segment(2) == 'notifikasi' ? 'active' : ''; ?>">
                <i class="fas fa-bell mr-3 w-5 text-center"></i> Notifikasi
                <?php if (isset($unread_notifikasi) && $unread_notifikasi > 0): ?>
                    <span id="notifikasi-badge" class="notification-badge absolute right-6 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo $unread_notifikasi; ?></span>
                <?php endif; ?>
            </a>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-4 pl-6">Pengaturan</p>
            <a href="<?php echo base_url('pasien/edit_profile'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'edit_profile' ? 'active' : ''; ?>">
                <i class="fas fa-user-edit mr-3 w-5 text-center"></i> Edit Profil
            </a>
            <a href="<?php echo base_url('pasien/akun'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'akun' ? 'active' : ''; ?>">
                <i class="fas fa-user mr-3 w-5 text-center"></i> Akun
            </a>
            <a href="<?php echo base_url('pasien/keamanan'); ?>" class="nav-link flex items-center px-6 py-3 mb-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 <?php echo $this->uri->segment(2) == 'keamanan' ? 'active' : ''; ?>">
                <i class="fas fa-shield-alt mr-3 w-5 text-center"></i> Keamanan
            </a>
            <div class="border-b border-gray-200 my-6"></div>
            <a href="<?php echo base_url('auth/logout'); ?>" class="nav-link flex items-center px-6 py-3 text-red-500 hover:bg-red-50 hover:text-red-600">
                <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <!-- Toggle Button for Mobile -->
        <div class="lg:hidden mb-4">
            <button id="openSidebar" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <div class="container mx-auto">
            <!-- Content will be injected here -->
        </div>
    </main>

    <script>
        $(document).ready(function() {
            // Toggle Sidebar
            $('#toggleSidebar, #openSidebar').click(function() {
                $('#sidebar').toggleClass('sidebar-hidden');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(event) {
                if ($(window).width() < 768 && !$(event.target).closest('#sidebar, #openSidebar, #toggleSidebar').length) {
                    $('#sidebar').addClass('sidebar-hidden');
                }
            });

            // Ensure sidebar is visible on desktop
            $(window).resize(function() {
                if ($(window).width() >= 768) {
                    $('#sidebar').removeClass('sidebar-hidden');
                }
            });
        });
    </script>
</body>
</html>