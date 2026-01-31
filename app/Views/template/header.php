<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oidas Boarding House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Mobile sidebar */
        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-sidebar.active {
            transform: translateX(0);
        }
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar for desktop -->
    <div class="bg-slate-800 text-white w-64 flex-shrink-0 hidden md:block">
        <!-- Logo in sidebar -->
         <a href="<?= base_url('tenants') ?>">
        <div class="p-4 flex items-center justify-center">
            <div class="w-16 h-16 mr-3 flex-shrink-0">
                <img src="\assets\logo.png" alt="logo" class="object-contain w-full h-full">
            </div>
            <div class="-ml-2 leading-tight">
                <span class="text-lg font-semibold block">Oidas</span>
                <span class="text-sm -mt-2 block">Boarding House</span>
            </div>
        </div></a>


        <!-- Navigation Links -->
        <nav class="mt-8">
            <!-- <a href="<?= base_url('dashboard') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'dashboard') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">dashboard</span>
                Dashboard
            </a> -->
            <a href="<?= base_url('tenants') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'tenants') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">person</span>
                Tenants
            </a>
            <a href="<?= base_url('rooms') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'rooms') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">hotel</span>
                Rooms & Beds
            </a>
            <a href="<?= base_url('complaints') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'complaints') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">report_problem</span>
                Complaints 
            </a>
            <a href="<?= base_url('maintenance') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'maintenance') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">build</span>
                Maintenance
            </a>
            <a href="<?= base_url('feedbacks') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'feedbacks') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">feedback</span>
                Feedback 
            </a>
            <a href="<?= base_url('announcements') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'announcements') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">campaign</span>
                Announcement
            </a>
        </nav>
        </div>

        <!-- Mobile sidebar - hidden by default -->
        <div id="mobileSidebar" class="fixed inset-0 z-50 md:hidden">
            <div class="absolute inset-0 bg-gray-800 opacity-50" id="sidebarOverlay"></div>
            <div class="mobile-sidebar absolute top-0 left-0 w-64 h-full bg-slate-800 text-white z-10">
                <!-- Logo in sidebar -->
                <div class="p-4 flex items-center">
                    <div class="w-10 h-10 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="text-blue-400">
                            <path d="M20,80 L20,50 L50,20 L80,50 L80,80 Z" fill="none" stroke="currentColor" stroke-width="5"/>
                            <rect x="35" y="55" width="15" height="15" fill="none" stroke="currentColor" stroke-width="5"/>
                            <path d="M50,20 L80,50" fill="none" stroke="currentColor" stroke-width="5"/>
                            <path d="M20,50 L50,20" fill="none" stroke="currentColor" stroke-width="5"/>
                        </svg>
                    </div>
                    <span class="text-xl font-semibold">PropManager</span>
                    <button id="closeSidebar" class="ml-auto">
                        <span class="material-icons">close</span>
                    </button>
                </div>
                
                <!-- Mobile Navigation Links -->
                <nav class="mt-8">
                    <a href="<?= base_url('dashboard') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'dashboard') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                        <span class="material-icons mr-3">dashboard</span>
                        Dashboard
                    </a>
                    <a href="<?= base_url('complaints') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'complaints') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                        <span class="material-icons mr-3">feedback</span>
                        Complaints
                    </a>
                    <a href="<?= base_url('rooms') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'rooms') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                        <span class="material-icons mr-3">hotel</span>
                        Rooms & Beds
                    </a>
                    <a href="<?= base_url('maintenance') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'maintenance') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                        <span class="material-icons mr-3">build</span>
                        Maintenance
                    </a>
                    <a href="<?= base_url('announcements') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'announcements') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                        <span class="material-icons mr-3">campaign</span>
                        Announcement
                    </a>
                </nav>
            </div>
        </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar -->
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
            <!-- Mobile menu button - at top as requested -->
            <div class="md:hidden">
                <button id="openSidebar" class="p-2 rounded-full hover:bg-gray-100">
                    <span class="material-icons">menu</span>
                </button>
            </div>
            
            <h1 class="text-xl font-semibold text-gray-800">Welcome, <?= session()->get('username') ?></h1>
            <div class="flex items-center">
                <div class="ml-4 relative">
                    <a href="<?= base_url('profile') ?>">
                        <div class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center text-white">
                        A
                        </div>
                    </a>
                 </div>
            
                <a href="<?= base_url('logout') ?>" class="flex items-center ml-4 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                    <span class="material-icons mr-1">exit_to_app</span>
                    Logout
                </a>
            </div>
        </header>
