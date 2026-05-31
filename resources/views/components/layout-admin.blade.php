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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
                <div class="relative">
                    <button id="notification-toggle"
                        class="relative w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                        <i class="ph ph-bell"></i>
                        @if(($totalPendingNotificationsCount ?? 0) > 0)
                            <span id="notif-ping" class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-ping hidden"></span>
                            <span id="notif-badge" class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                        @endif
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl border border-slate-100 shadow-xl py-2 z-50 hidden opacity-0 translate-y-1 transition-all duration-205">
                        <div class="px-4 py-2 border-b border-slate-50 flex justify-between items-center">
                            <span class="font-bold text-xs text-slate-800">Pemberitahuan</span>
                            @if(($totalPendingNotificationsCount ?? 0) > 0)
                                <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    {{ $totalPendingNotificationsCount }} Baru
                                </span>
                            @endif
                        </div>
                        <div class="divide-y divide-slate-50 max-h-60 overflow-y-auto">
                            <!-- Pending Leaves -->
                            <a href="/admin/leaves?status=pending" class="px-4 py-3 hover:bg-slate-50/50 flex items-start gap-3 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <i class="ph-fill ph-calendar-blank text-base"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Persetujuan Izin/Cuti</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5 leading-normal font-semibold">
                                        @if(($pendingLeavesCount ?? 0) > 0)
                                            Ada {{ $pendingLeavesCount }} pengajuan izin baru menunggu persetujuan.
                                        @else
                                            Tidak ada pengajuan izin baru.
                                        @endif
                                    </p>
                                </div>
                            </a>
                            <!-- Pending Submissions -->
                            <a href="/admin/submissions?status=pending" class="px-4 py-3 hover:bg-slate-50/50 flex items-start gap-3 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="ph-fill ph-chat-centered-text text-base"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Pengajuan & Laporan</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5 leading-normal font-semibold">
                                        @if(($pendingSubmissionsCount ?? 0) > 0)
                                            Ada {{ $pendingSubmissionsCount }} pengajuan baru menunggu peninjauan.
                                        @else
                                            Tidak ada pengajuan baru.
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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

            // Notification Dropdown Toggle & Read Status Check
            const notifToggle = document.getElementById('notification-toggle');
            const notifDropdown = document.getElementById('notification-dropdown');
            const ping = document.getElementById('notif-ping');
            const badge = document.getElementById('notif-badge');
            const totalCount = {{ $totalPendingNotificationsCount ?? 0 }};

            // Check read status on load using localStorage
            if (totalCount > 0) {
                const lastSeenCount = parseInt(localStorage.getItem('admin_last_seen_notif_count') || '0');
                if (totalCount > lastSeenCount) {
                    if (ping) ping.classList.remove('hidden');
                    if (badge) badge.classList.remove('hidden');
                } else if (totalCount < lastSeenCount) {
                    // Update storage if counts decreased
                    localStorage.setItem('admin_last_seen_notif_count', totalCount);
                }
            } else {
                localStorage.setItem('admin_last_seen_notif_count', '0');
            }

            if (notifToggle && notifDropdown) {
                notifToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Hide the red badge immediately on click (user read/seen the notification)
                    if (ping) ping.classList.add('hidden');
                    if (badge) badge.classList.add('hidden');
                    localStorage.setItem('admin_last_seen_notif_count', totalCount);

                    if (notifDropdown.classList.contains('hidden')) {
                        notifDropdown.classList.remove('hidden');
                        setTimeout(() => {
                            notifDropdown.classList.remove('opacity-0', 'translate-y-1');
                            notifDropdown.classList.add('opacity-100', 'translate-y-0');
                        }, 20);
                    } else {
                        hideDropdown();
                    }
                });

                document.addEventListener('click', function() {
                    hideDropdown();
                });

                notifDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                function hideDropdown() {
                    notifDropdown.classList.remove('opacity-100', 'translate-y-0');
                    notifDropdown.classList.add('opacity-0', 'translate-y-1');
                    setTimeout(() => {
                        notifDropdown.classList.add('hidden');
                    }, 200);
                }
            }
        });
    </script>
</body>

</html>
