<x-layouts>
    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Riwayat Absensi
            </h1>
            <div class="w-10"></div>
        </div>
    </div>
    <!-- Content -->
    <div class="px-4 -mt-3">
        <!-- Filter Bulan (Static reference placeholder matching UI design) -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-4 flex items-center justify-between mb-5">
            <button>
                <i class="ph ph-caret-left text-zinc-600"></i>
            </button>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-zinc-800">
                    {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </span>
                <i class="ph ph-caret-down text-zinc-500"></i>
            </div>
            <button>
                <i class="ph ph-calendar text-zinc-600"></i>
            </button>
        </div>
        
        <!-- Attendance logs timeline -->
        <div class="space-y-5 mb-8">
            @forelse($attendances as $dateStr => $dayRecords)
                <div>
                    <h3 class="font-semibold text-zinc-800 mb-3 text-xs uppercase tracking-wider">
                        {{ $dateStr }}
                    </h3>
                    <div class="bg-white rounded-2xl border border-zinc-100 divide-y divide-zinc-50 overflow-hidden shadow-sm">
                        @foreach($dayRecords as $record)
                            <!-- Record Row -->
                            <div class="p-4 flex justify-between items-center">
                                <div class="flex gap-3">
                                    @if($record->type === 'masuk')
                                        <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                            <i class="ph-fill ph-sign-in text-lg"></i>
                                        </div>
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-orange-50 text-orange-655 flex items-center justify-center shrink-0">
                                            <i class="ph-fill ph-sign-out text-lg"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-sm text-slate-800">
                                            Absen {{ $record->type === 'masuk' ? 'Masuk' : 'Pulang' }}
                                        </p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $record->created_at->format('H:i') }} WIB
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-semibold flex items-center gap-1">
                                            <i class="ph ph-buildings"></i>
                                            {{ $record->office ? $record->office->name : 'Kantor tidak diketahui' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] bg-emerald-50 text-emerald-650 px-2 py-0.5 rounded-full font-bold">
                                        Sukses
                                    </span>
                                    <p class="text-[10px] text-slate-400 mt-2 font-mono">
                                        Dist: {{ round($record->matching_score, 3) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-zinc-100 p-10 text-center shadow-sm">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="ph ph-calendar-blank text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Absensi</h4>
                    <p class="text-xs text-slate-500 mt-1">Riwayat kehadiran Anda pada bulan ini akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts>
