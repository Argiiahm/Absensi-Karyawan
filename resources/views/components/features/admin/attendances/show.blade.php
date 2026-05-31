<x-layout-admin title="Detail Absensi">
    <div class="">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 md:p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <a href="/admin/attendances" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                    <i class="ph ph-arrow-left text-lg"></i>
                </a>
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Detail Absensi</h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ $attendance->user->name ?? '-' }} —
                        {{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                </div>
            </div>

            <!-- Employee Info -->
            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl mb-6">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl shrink-0">
                    {{ strtoupper(substr($attendance->user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-800">{{ $attendance->user->name ?? '-' }}</p>
                    <p class="text-xs text-slate-500">{{ $attendance->user->email ?? '' }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-semibold">
                        {{ $attendance->user->role === 'admin' ? 'Administrator' : 'Karyawan' }}
                    </span>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe Absen</span>
                    @if($attendance->type === 'masuk')
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">Absen Masuk</span>
                    @else
                        <span class="px-2.5 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-bold">Absen Pulang</span>
                    @endif
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal</span>
                    <span class="text-sm font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jam</span>
                    <span class="text-sm font-semibold text-slate-800 font-mono">
                        {{ \Carbon\Carbon::parse($attendance->time)->format('H:i:s') }} WIB
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Ketepatan</span>
                    @php
                        $isLate = $attendance->type === 'masuk' && \Carbon\Carbon::parse($attendance->time)->gt(\Carbon\Carbon::parse('09:00:00'));
                    @endphp
                    @if($attendance->type !== 'masuk')
                        <span class="text-xs text-slate-400">-</span>
                    @elseif($isLate)
                        <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">Terlambat</span>
                    @else
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold">Tepat Waktu</span>
                    @endif
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kantor</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $attendance->office->name ?? '-' }}</span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Koordinat GPS</span>
                    <span class="text-xs font-mono text-slate-600">
                        {{ number_format($attendance->latitude, 6) }}, {{ number_format($attendance->longitude, 6) }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Skor Pencocokan Wajah</span>
                    <span class="text-sm font-bold {{ $attendance->matching_score >= 0.85 ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ number_format($attendance->matching_score * 100, 1) }}%
                    </span>
                </div>

                @if($attendance->snapshot_path)
                    <div class="py-3">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Foto Selfie Absensi</p>
                        <img src="{{ $attendance->snapshot_path }}" alt="Selfie"
                            class="w-full max-w-xs rounded-xl border border-slate-100 shadow-sm">
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout-admin>
