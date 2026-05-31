<x-layouts>
    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Statistik
            </h1>
            <div class="w-10"></div>
        </div>
    </div>
    <div class="px-4 -mt-3">
        <!-- Filter Bulan -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-4 shadow-sm flex items-center justify-between mb-5">
            @if(!$isThisMonth || $month > 1)
                <a href="/statistik?month={{ $prevMonth->month }}&year={{ $prevMonth->year }}"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-all">
                    <i class="ph ph-caret-left"></i>
                </a>
            @else
                <span class="w-8"></span>
            @endif
            <div class="flex items-center gap-2">
                <span class="font-semibold">{{ $monthLabel }}</span>
            </div>
            @if(!$isThisMonth)
                <a href="/statistik?month={{ $nextMonth->month }}&year={{ $nextMonth->year }}"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-all">
                    <i class="ph ph-caret-right"></i>
                </a>
            @else
                <span class="w-8"></span>
            @endif
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-3 gap-3 mb-5">
            <div class="bg-blue-50 rounded-2xl p-4 text-center">
                <p class="text-xs text-blue-600 font-medium">Hadir</p>
                <h2 class="text-2xl font-bold text-blue-700">{{ $hadir }}</h2>
            </div>
            <div class="bg-emerald-50 rounded-2xl p-4 text-center">
                <p class="text-xs text-emerald-600 font-medium">Tepat</p>
                <h2 class="text-2xl font-bold text-emerald-700">{{ $tepat }}</h2>
            </div>
            <div class="bg-orange-50 rounded-2xl p-4 text-center">
                <p class="text-xs text-orange-600 font-medium">Telat</p>
                <h2 class="text-2xl font-bold text-orange-700">{{ $telat }}</h2>
            </div>
        </div>

        <!-- Progress Kehadiran -->
        <div class="bg-white rounded-3xl border border-zinc-100 shadow-sm p-5 mb-5">
            <div class="flex justify-between mb-3">
                <h3 class="font-semibold">Kehadiran {{ $monthLabel }}</h3>
                <span class="text-blue-600 font-bold">{{ $persentase }}%</span>
            </div>
            <div class="w-full h-3 bg-zinc-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width:{{ $persentase }}%"></div>
            </div>
            <p class="text-xs text-zinc-500 mt-3">
                {{ $hadir }} dari {{ $workingDays }} hari kerja hadir
            </p>
        </div>

        <!-- Detail Statistik -->
        <div class="bg-white rounded-3xl border border-zinc-100 shadow-sm p-5">
            <h3 class="font-semibold mb-4">Ringkasan</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-zinc-500">Total Kehadiran</span>
                    <span class="font-semibold">{{ $hadir }} Hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Hari Kerja Bulan Ini</span>
                    <span class="font-semibold">{{ $workingDays }} Hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Tepat Waktu</span>
                    <span class="font-semibold text-emerald-600">{{ $tepat }} Hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Terlambat</span>
                    <span class="font-semibold text-orange-600">{{ $telat }} Hari</span>
                </div>
                <div class="border-t border-zinc-100 pt-4 flex justify-between">
                    <span class="text-zinc-500">Persentase Kehadiran</span>
                    <span class="font-bold text-blue-600">{{ $persentase }}%</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts>
