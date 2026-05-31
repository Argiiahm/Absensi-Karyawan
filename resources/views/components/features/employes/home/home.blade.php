<x-layouts>
    <div class="relative">
        <!-- Header -->
        <div class="bg-blue-600 text-white rounded-b-3xl px-6 pt-10 pb-20 relative">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold flex items-center gap-2">
                        Halo, {{ $user->name }} <span class="text-2xl">👋</span>
                    </h1>
                    <p class="text-blue-100 text-sm mt-1">
                        Selamat pagi! Semangat bekerja hari ini.
                    </p>
                </div>
                <button class="bg-blue-500/50 p-2 rounded-full relative">
                    <i class="ph-fill ph-bell text-lg"></i>
                    <span class="absolute top-1.5 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </div>
        <!-- Clock Card -->
        <div class="px-5 -mt-14 relative z-10">
            <div class="bg-white rounded-2xl p-5 border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                    <h2 id="realtime-clock" class="text-4xl font-bold text-slate-800 mt-1 font-mono">
                        {{ \Carbon\Carbon::now()->format('H:i:s') }}
                    </h2>
                    @if($todayLeave)
                        <p class="text-xs font-semibold text-indigo-600 mt-2 bg-indigo-50 inline-block px-2.5 py-1 rounded-md animate-pulse">
                            Status: {{ ucfirst($todayLeave->type) }} (Disetujui)
                        </p>
                    @elseif($hasCheckedIn)
                        <p class="text-xs font-semibold text-emerald-650 mt-2 bg-emerald-50 inline-block px-2.5 py-1 rounded-md">
                            Sudah Absen Masuk
                        </p>
                    @else
                        <p class="text-xs font-semibold text-amber-650 mt-2 bg-amber-50 inline-block px-2.5 py-1 rounded-md">
                            Belum Absen Masuk
                        </p>
                    @endif
                </div>
                <div class="w-24 h-24 {{ $todayLeave ? 'bg-indigo-50' : 'bg-blue-50' }} rounded-full flex items-center justify-center">
                    @if($todayLeave)
                        <i class="ph-fill ph-calendar-blank text-4xl text-indigo-500"></i>
                    @else
                        <i class="ph-fill ph-laptop text-4xl text-blue-500"></i>
                    @endif
                </div>
            </div>

            <!-- Ketentuan Jam Kerja -->
            <div class="bg-blue-50/70 border border-blue-100 rounded-xl px-4 py-2.5 mt-3 flex items-center gap-2 text-xs text-blue-800 font-medium">
                <i class="ph-fill ph-info text-blue-600 text-base"></i>
                <span>Ket: Absen masuk pkl {{ $office ? \Carbon\Carbon::parse($office->start_time)->format('H.i') : '07.00' }}, absen pulang pkl {{ $office ? \Carbon\Carbon::parse($office->end_time)->format('H.i') : '17.00' }}</span>
            </div>
        </div>
        <!-- Ringkasan -->
        <div class="px-5 mt-6">
            <h3 class="font-bold text-slate-800 mb-3">
                Ringkasan Hari Ini
            </h3>
            <div class="space-y-3">
                <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                            <i class="ph-fill ph-sign-in"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">
                                Absen Masuk
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $hasCheckedIn ? \Carbon\Carbon::parse($hasCheckedIn->time)->format('H:i') . ' WIB' : 'Belum absen masuk' }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5 font-semibold">
                                Jam Masuk: {{ $office ? substr($office->start_time, 0, 5) : '07:00' }} WIB
                            </p>
                        </div>
                    </div>
                    @if($hasCheckedIn)
                        @php
                            $officeStartTime = $hasCheckedIn->office ? $hasCheckedIn->office->start_time : '07:00:00';
                            $isLate = \Carbon\Carbon::parse($hasCheckedIn->time)->gt(\Carbon\Carbon::parse($officeStartTime));
                        @endphp
                        @if($isLate)
                            <span class="text-xs font-bold text-amber-650 bg-amber-50 px-2.5 py-1 rounded-full">
                                Terlambat
                            </span>
                        @else
                            <span class="text-xs font-bold text-emerald-650 bg-emerald-50 px-2.5 py-1 rounded-full">
                                Tepat Waktu
                            </span>
                        @endif
                    @else
                        <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                            Belum Absen
                        </span>
                    @endif
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center">
                            <i class="ph-fill ph-sign-out"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">
                                Absen Pulang
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $hasCheckedOut ? \Carbon\Carbon::parse($hasCheckedOut->time)->format('H:i') . ' WIB' : 'Belum absen pulang' }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5 font-semibold">
                                Jam Pulang: {{ $office ? substr($office->end_time, 0, 5) : '17:00' }} WIB
                            </p>
                        </div>
                    </div>
                    @if($hasCheckedOut)
                        <span class="text-xs font-medium text-emerald-650 bg-emerald-50 px-2.5 py-1 rounded-full">
                            Sudah Absen
                        </span>
                    @else
                        <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                            Belum Absen
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Menu -->
        <div class="px-5 mt-6 mb-8">
            <h3 class="font-bold text-slate-800 mb-3">
                Menu Utama
            </h3>
            <div class="grid grid-cols-3 gap-3">
                <a href="/attedance"
                    class="flex flex-col items-center justify-center bg-white p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors">
                    <div class="w-11 h-11 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-fingerprint text-xl"></i>
                    </div>

                    <span class="text-[11px] font-medium text-slate-700">
                        Absen
                    </span>
                </a>
                <a href="/history"
                    class="flex flex-col items-center justify-center bg-white p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors">
                    <div
                        class="w-11 h-11 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
                    </div>
                    <span class="text-[11px] font-medium text-slate-700">
                        Riwayat
                    </span>
                </a>
                <a href="/statistik"
                    class="flex flex-col items-center justify-center bg-white p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors">
                    <div
                        class="w-11 h-11 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-chart-bar text-xl"></i>
                    </div>
                    <span class="text-[11px] font-medium text-slate-700">
                        Statistik
                    </span>
                </a>
                <a href="/leaves"
                    class="flex flex-col items-center justify-center bg-white p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors">
                    <div
                        class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-envelope-open text-xl"></i>
                    </div>
                    <span class="text-[11px] font-medium text-slate-700">
                        Izin / Cuti
                    </span>
                </a>
            </div>
        </div>
    </div>

    <script>
        setInterval(() => {
            const clockEl = document.getElementById('realtime-clock');
            if (clockEl) {
                const now = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                clockEl.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
            }
        }, 1000);
    </script>
</x-layouts>
