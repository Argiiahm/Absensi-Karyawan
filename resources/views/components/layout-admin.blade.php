<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - Absensi Karyawan' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex">
    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay"
        class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 ease-in-out md:hidden">
    </div>

    <!-- Sidebar Component -->
    <x-sidebar-admin />

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-100 px-4 md:px-8 flex items-center justify-between shrink-0">
            <div class="flex items-center">
                <!-- Hamburger Menu Button (Mobile Only) -->
                <button id="sidebar-toggle"
                    class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800 mr-2 transition-all">
                    <i class="ph ph-list text-xl"></i>
                </button>
                <h2 class="font-bold text-slate-800 text-base md:text-lg">
                    {{ $title ?? 'Dashboard' }}
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <!-- Time/Date Display -->
                <span class="text-xs text-slate-500 font-medium">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
                <div class="w-px h-6 bg-slate-150"></div>
                <!-- Notifications -->
                <button
                    class="relative w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100">
                    <i class="ph ph-bell"></i>
                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </header>

        <!-- Content Body -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 20);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>

</html>
