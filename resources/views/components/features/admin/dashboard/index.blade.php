<x-layout-admin title="Dashboard Overview">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card: Total Employees -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Karyawan</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">124</h3>
                <span class="text-xs text-emerald-500 font-medium mt-1 inline-flex items-center gap-1">
                    <i class="ph ph-trend-up"></i> +12 bulan ini
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-users"></i>
            </div>
        </div>

        <!-- Card: Present Today -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hadir Hari Ini</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">108</h3>
                <span class="text-xs text-slate-400 font-medium mt-1 inline-flex items-center gap-1">
                    Dari total 124 karyawan
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-check-circle"></i>
            </div>
        </div>

        <!-- Card: Late Today -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terlambat Hari Ini</p>
                <h3 class="text-3xl font-bold text-red-600 mt-2">6</h3>
                <span class="text-xs text-red-500 font-medium mt-1 inline-flex items-center gap-1">
                    <i class="ph ph-warning"></i> Perlu perhatian
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-clock"></i>
            </div>
        </div>

        <!-- Card: Break Active -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sedang Istirahat / Sholat</p>
                <h3 class="text-3xl font-bold text-orange-600 mt-2">10</h3>
                <span class="text-xs text-slate-400 font-medium mt-1 inline-flex items-center gap-1">
                    Monitoring Ishoma
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-moon"></i>
            </div>
        </div>
    </div>

    <!-- Live Feed and Quick Map -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Live Attendance Feed -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h4 class="font-bold text-slate-800">Aktivitas Absensi Terbaru</h4>
                <a href="/admin/attendances" class="text-xs font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                <!-- Row 1 -->
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/100?img=11" alt="Employee Photo" class="w-9 h-9 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Andi Setiawan</p>
                            <p class="text-[10px] text-slate-400">ID: KRP00123 • Kantor Pusat</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-xs font-bold text-slate-800">09:41 WIB</span>
                        <p class="text-[10px] text-emerald-500 font-medium mt-0.5">Absen Masuk (Tepat Waktu)</p>
                    </div>
                </div>
                <!-- Row 2 -->
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/100?img=12" alt="Employee Photo" class="w-9 h-9 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Budi Raharjo</p>
                            <p class="text-[10px] text-slate-400">ID: KRP00124 • Kantor Pusat</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-xs font-bold text-slate-800">09:12 WIB</span>
                        <p class="text-[10px] text-emerald-500 font-medium mt-0.5">Absen Masuk (Tepat Waktu)</p>
                    </div>
                </div>
                <!-- Row 3 -->
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/100?img=15" alt="Employee Photo" class="w-9 h-9 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Citra Kirana</p>
                            <p class="text-[10px] text-slate-400">ID: KRP00125 • Kantor Cabang B</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-xs font-bold text-slate-800">08:45 WIB</span>
                        <p class="text-[10px] text-red-500 font-medium mt-0.5">Absen Masuk (Terlambat 45 Menit)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary / Statistics pie -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            <h4 class="font-bold text-slate-800 mb-6">Persentase Kehadiran Bulan Ini</h4>
            <div class="flex flex-col items-center justify-center py-6">
                <!-- Circular Indicator Mockup -->
                <div class="w-32 h-32 rounded-full border-8 border-blue-500 border-t-slate-100 flex items-center justify-center mb-6">
                    <span class="text-2xl font-bold text-slate-800">91%</span>
                </div>
                <div class="w-full space-y-3">
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Tepat Waktu
                        </span>
                        <span class="font-bold text-slate-800">82 Hari Kerja</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span> Terlambat
                        </span>
                        <span class="font-bold text-slate-800">9 Hari Kerja</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Mangkir / Absen
                        </span>
                        <span class="font-bold text-slate-800">3 Hari Kerja</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>
