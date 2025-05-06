<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Puskesmas Digital'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?php echo site_url('bidan'); ?>" class="text-2xl font-bold">Puskesmas Digital</a>
            <?php
                $profile_picture = $this->session->userdata('profile_picture');
                $nama = $this->session->userdata('nama');
                $email = $this->session->userdata('email');
            ?>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <img src="<?php echo ($profile_picture != null && $profile_picture != '') ? base_url('Uploads/profile/' . $profile_picture) : 'https://via.placeholder.com/40'; ?>" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-semibold"><?php echo $nama ? $nama : 'Bidan'; ?></p>
                        <p class="text-xs"><?php echo $email ? $email : 'email@contoh.com'; ?></p>
                    </div>
                </div>
                <a href="<?php echo site_url('auth/logout'); ?>" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</a>
            </div>
            <button id="toggleSidebar" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>
    <nav id="sidebar" class="sidebar sidebar-hidden md:sidebar md:translate-x-0 fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-50">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Menu Bidan</h2>
        </div>
        <ul class="mt-4">
            <li><a href="<?php echo site_url('bidan'); ?>" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Dashboard</a></li>
            <li><a href="<?php echo site_url('bidan/antrian'); ?>" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Kelola Antrian</a></li>
            <li><a href="<?php echo site_url('bidan/chat'); ?>" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Chat</a></li>
            <li><a href="<?php echo site_url('bidan/edit_profile'); ?>" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Edit Profil</a></li>
        </ul>
    </nav>
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden md:hidden"></div>
    <main class="container mx-auto px-4 py-6 md:ml-64"></main>