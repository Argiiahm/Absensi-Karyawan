<!-- Sidebar -->
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100 flex flex-col shrink-0 transition-transform duration-300 ease-in-out -translate-x-full md:relative md:translate-x-0">
    <!-- Logo -->
    <div class="h-16 px-6 border-b border-slate-50 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
            <i class="ph-fill ph-fingerprint text-lg"></i>
        </div>
        <span class="font-bold text-slate-800 tracking-tight text-sm">Absensi Karyawan</span>
        
        <!-- Sidebar Close Button (Mobile Only) -->
        <button id="sidebar-close" class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800 ml-auto transition-all">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-4 space-y-1">
        <a href="/admin/dashboard"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->is('admin/dashboard*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <i class="ph-fill ph-squares-four text-lg"></i>
            Dashboard
        </a>

        <a href="/admin/employees"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->is('admin/employees*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <i class="ph-fill ph-users text-lg"></i>
            Kelola Karyawan
        </a>

        <a href="/admin/offices"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->is('admin/offices*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <i class="ph-fill ph-map-pin text-lg"></i>
            Kelola Kantor
        </a>

        <a href="/admin/attendances"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->is('admin/attendances*') && !request()->is('admin/attendances/prayers*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <i class="ph-fill ph-clock-counter-clockwise text-lg"></i>
            Absensi Harian
        </a>

        <a href="/admin/attendances/prayers"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->is('admin/attendances/prayers*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <i class="ph-fill ph-moon text-lg"></i>
            Absensi Sholat
        </a>
    </nav>

    <!-- User Profile / Footer Sidebar -->
    <div class="p-4 border-t border-slate-50">
        <div class="flex items-center gap-3 p-2">
            <img src="https://i.pravatar.cc/100?img=33" alt="Admin Avatar" class="w-9 h-9 rounded-full object-cover">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-slate-800 truncate">Administrator</p>
                <p class="text-[10px] text-slate-400 truncate">admin@company.com</p>
            </div>
        </div>
        <a href="/profile" class="mt-2 w-full py-2 px-4 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition-all">
            <i class="ph ph-sign-out"></i>
            Keluar Dashboard
        </a>
    </div>
</aside>
