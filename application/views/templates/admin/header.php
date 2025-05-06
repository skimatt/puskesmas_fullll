<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Puskesmas Digital - Admin'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10;
        }
        #sidebar.open + #overlay {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <header class="bg-white shadow fixed top-0 left-0 right-0 z-30">
        <div class="flex items-center justify-between p-4 lg:pl-72">
            <div class="flex items-center">
                <button id="toggleSidebar" class="text-gray-600 focus:outline-none lg:hidden">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <h2 class="ml-4 text-xl font-semibold text-gray-800"><?= isset($title) ? $title : 'Dashboard Admin'; ?></h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600"><?= $this->session->userdata('nama'); ?></span>
                <a href="<?= base_url('auth/logout'); ?>" class="text-red-600 hover:text-red-800 flex items-center">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Overlay untuk sidebar di mobile -->
    <div id="overlay"></div>

    <!-- Load Sidebar -->
    <?php $this->load->view('templates/admin/sidebar'); ?>

    <!-- Konten Utama -->
    <main class="pt-20 lg:pl-64 min-h-screen">