<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Sistem Manajemen Kesehatan'; ?></title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Custom styles for sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        @media (max-width: 640px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar fixed inset-y-0 left-0 w-64 bg-blue-800 text-white flex flex-col shadow-lg sm:relative sm:transform-none">
            <div class="p-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">Dokter Dashboard</h1>
                <button id="toggleSidebar" class="sm:hidden focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <nav class="mt-4">
                    <a href="<?php echo base_url('dokter'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Dashboard Dokter' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                    <a href="<?php echo base_url('dokter/kelola_janji_temu'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Kelola Janji Temu' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-calendar-check mr-3"></i> Janji Temu
                    </a>
                    <a href="<?php echo base_url('dokter/rekam_medis'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Rekam Medis Pasien' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-file-medical mr-3"></i> Rekam Medis
                    </a>
                    <a href="<?php echo base_url('dokter/chat'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Chat' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-comments mr-3"></i> Chat
                    </a>
                    <a href="<?php echo base_url('dokter/notifikasi'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Notifikasi' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-bell mr-3"></i> Notifikasi
                        <?php if ($unread_notifikasi > 0): ?>
                            <span class="ml-2 bg-red-500 text-xs rounded-full px-2 py-1"><?php echo $unread_notifikasi; ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo base_url('dokter/jadwal_praktik'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Jadwal Praktik' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-clock mr-3"></i> Jadwal Praktik
                    </a>
                    <a href="<?php echo base_url('dokter/dokumen_medis'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Dokumen Medis Pasien' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-folder-open mr-3"></i> Dokumen Medis
                    </a>
                    <a href="<?php echo base_url('dokter/tagihan'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Tagihan' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-file-invoice mr-3"></i> Tagihan
                    </a>
                    <a href="<?php echo base_url('dokter/edit_profile'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Edit Profil' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-user mr-3"></i> Profil
                    </a>
                    <a href="<?php echo base_url('dokter/keamanan'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700 <?php echo $title == 'Keamanan' ? 'bg-blue-700' : ''; ?>">
                        <i class="fas fa-lock mr-3"></i> Keamanan
                    </a>
                    <a href="<?php echo base_url('auth/logout'); ?>" class="flex items-center px-4 py-2 hover:bg-blue-700">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-blue-700">
                <div class="flex items-center">
                    <img src="<?php echo base_url('uploads/profile/' . (isset($dokter->profile_picture) && $dokter->profile_picture ? $dokter->profile_picture : 'default.jpg')); ?>" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold"><?php echo $dokter->nama; ?></p>
                        <p class="text-sm"><?php echo $dokter->spesialisasi; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar with Hamburger Menu for Mobile -->
            <div class="bg-white shadow p-4 flex items-center justify-between sm:hidden">
                <button id="openSidebar" class="focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h2 class="text-lg font-semibold"><?php echo $title; ?></h2>
            </div>

            <!-- Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p><?php echo $this->session->flashdata('message'); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Content from individual views will be loaded here -->