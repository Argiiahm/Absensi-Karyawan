<x-layout-admin title="Dashboard Overview">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card: Total Employees -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Karyawan</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalEmployees }}</h3>
                <span class="text-xs text-slate-400 font-medium mt-1 inline-flex items-center gap-1">
                    Terdaftar di sistem
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
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $presentToday }}</h3>
                <span class="text-xs text-slate-400 font-medium mt-1 inline-flex items-center gap-1">
                    Dari total {{ $totalEmployees }} karyawan
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
                <h3 class="text-3xl font-bold {{ $lateToday > 0 ? 'text-red-600' : 'text-slate-800' }} mt-2">{{ $lateToday }}</h3>
                @if($lateToday > 0)
                    <span class="text-xs text-red-500 font-medium mt-1 inline-flex items-center gap-1">
                        <i class="ph ph-warning"></i> Perlu perhatian
                    </span>
                @else
                    <span class="text-xs text-emerald-500 font-medium mt-1 inline-flex items-center gap-1">
                        <i class="ph ph-check"></i> Semua tepat waktu
                    </span>
                @endif
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-clock"></i>
            </div>
        </div>

        <!-- Card: Attendance Rate -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kehadiran Bulan Ini</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $presentPercent }}%</h3>
                <span class="text-xs text-slate-400 font-medium mt-1 inline-flex items-center gap-1">
                    Rata-rata kehadiran
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="ph-fill ph-chart-bar"></i>
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
                @forelse($recentAttendances as $a)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($a->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $a->user->name ?? '-' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $a->office->name ?? 'Kantor Tidak Diketahui' }}</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-xs font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($a->time)->format('H:i') }} WIB
                            </span>
                            @php
                                $isLate = \Carbon\Carbon::parse($a->time)->gt(\Carbon\Carbon::parse('09:00:00'));
                                $typeLabel = $a->type === 'masuk' ? 'Absen Masuk' : 'Absen Pulang';
                            @endphp
                            <p class="text-[10px] {{ $a->type === 'masuk' && $isLate ? 'text-red-500' : 'text-emerald-500' }} font-medium mt-0.5">
                                {{ $typeLabel }}{{ ($a->type === 'masuk' && $isLate) ? ' (Terlambat)' : ' (Tepat Waktu)' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400">
                        <i class="ph ph-calendar-blank text-3xl mb-2 block"></i>
                        <p class="text-xs font-medium">Belum ada aktivitas absensi hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Summary / Statistics -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            <h4 class="font-bold text-slate-800 mb-6">Statistik Bulan Ini</h4>
            <div class="flex flex-col items-center justify-center py-4">
                <!-- Circular Indicator -->
                <div class="relative w-32 h-32 mb-6">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#e2e8f0" stroke-width="3"/>
                        <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#3b82f6" stroke-width="3"
                            stroke-dasharray="{{ $presentPercent }}, 100"
                            stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-slate-800">{{ $presentPercent }}%</span>
                    </div>
                </div>
                <div class="w-full space-y-3">
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Tepat Waktu
                        </span>
                        <span class="font-bold text-slate-800">{{ $onTimeDays }} Absen</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span> Terlambat
                        </span>
                        <span class="font-bold text-slate-800">{{ $lateDays }} Absen</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-2 text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Total Hadir Hari Ini
                        </span>
                        <span class="font-bold text-slate-800">{{ $presentToday }} Orang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>
