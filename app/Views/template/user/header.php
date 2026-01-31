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
        /* Responsive table styles */
        @media (max-width: 768px) {
            .responsive-table thead {
                display: none;
            }
            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            }
            .responsive-table td {
                display: flex;
                text-align: right;
                justify-content: space-between;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #e5e7eb;
            }
            .responsive-table td:last-child {
                border-bottom: none;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 500;
                text-align: left;
                color: #6b7280;
            }
            .responsive-table td.action-cell {
                flex-direction: row;
                justify-content: space-around;
            }
            .responsive-table td.action-cell::before {
                content: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar for desktop -->
    <div class="bg-slate-800 text-white w-64 flex-shrink-0 hidden md:block">
        <!-- Logo in sidebar -->
        <a href="<?= base_url('User/Dashboard') ?>">
            <div class="p-4 flex items-center justify-center">
                <div class="w-16 h-16 mr-3 flex-shrink-0">
                    <img src="/assets/logo.png" alt="logo" class="object-contain w-full h-full">
                </div>
                <div class="-ml-2 leading-tight">
                    <span class="text-lg font-semibold block">Oida's</span>
                    <span class="text-sm -mt-2 block">Boarding House</span>
                </div>
            </div>
        </a>

        <!-- Navigation Links -->
        <nav class="mt-8">
            <a href="<?= base_url('User/Dashboard') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/Dashboard') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">dashboard</span>
                Dashboard
            </a>
            <a href="<?= base_url('User/tenants') ?>" class="flex items-center hidden px-6 py-3 <?= strpos(uri_string(), 'User/tenants') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">person</span>
                Tenants
            </a>
            <a href="<?= base_url('User/complaints') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/complaints') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">report_problem</span>
                Complaints 
            </a>
            <a href="<?= base_url('User/feedbacks') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/feedbacks') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">feedback</span>
                Feedback 
            </a>
            <!-- <a href="<?= base_url('User/rooms') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/rooms') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">hotel</span>
                Rooms & Beds
            </a> -->
            <a href="<?= base_url('User/maintenance') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/maintenance') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">build</span>
                Maintenance
            </a>
            <a href="<?= base_url('User/announcements') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/announcements') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                <span class="material-icons mr-3">campaign</span>
                Announcement
            </a>
        </nav>
    </div>

    <!-- Mobile sidebar - hidden by default -->
    <div id="mobileSidebar" class="fixed inset-0 z-50 md:hidden hidden">
        <div class="absolute inset-0 bg-gray-800 opacity-50" id="sidebarOverlay"></div>
        <div class="mobile-sidebar absolute top-0 left-0 w-64 h-full bg-slate-800 text-white z-10">
            <!-- Logo in sidebar -->
            <div class="p-4 flex items-center">
                <div class="w-10 h-10 mr-3">
                    <img src="\assets\logo.png" alt="logo" class="object-contain w-full h-full">
                </div>
                <div class="-ml-2 leading-tight">
                    <span class="text-lg font-semibold block">Oida's</span>
                    <span class="text-sm -mt-2 block">Boarding House</span>
                </div>
                <button id="closeSidebar" class="ml-auto">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <!-- Mobile Navigation Links -->
            <nav class="mt-8">
                <a href="<?= base_url('User/Dashboard') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/Dashboard') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                    <span class="material-icons mr-3">dashboard</span>
                    Dashboard
                </a>
                <a href="<?= base_url('User/tenants') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/tenants') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                    <span class="material-icons mr-3">person</span>
                    Tenants
                </a>
                <a href="<?= base_url('User/complaints') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/complaints') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                    <span class="material-icons mr-3">report_problem</span>
                    Complaints 
                </a>
                <a href="<?= base_url('User/feedbacks') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/feedbacks') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                    <span class="material-icons mr-3">feedback</span>
                    Feedback 
                </a>
                <a href="<?= base_url('User/maintenance') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/maintenance') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
                    <span class="material-icons mr-3">build</span>
                    Maintenance
                </a>
                <a href="<?= base_url('User/announcements') ?>" class="flex items-center px-6 py-3 <?= strpos(uri_string(), 'User/announcements') === 0 ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' ?>">
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
                    <a href="<?= base_url('User/tenants') ?>">
                        <div class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center text-white">
                            <span class="material-icons text-white text-xl">person</span>
                        </div>
                    </a>
                 </div>
            
                <a href="<?= base_url('logout') ?>" class="flex items-center ml-4 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                    <span class="material-icons mr-1">exit_to_app</span>
                    Logout
                </a>
            </div>
        </header>
