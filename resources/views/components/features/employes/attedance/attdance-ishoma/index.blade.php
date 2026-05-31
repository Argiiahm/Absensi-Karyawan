<x-layout-attedance>

    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Absen Solat & Ishoma
            </h1>
            <div class="w-10"></div>
        </div>
    </div>

    <div class="px-4 -mt-5">
        <!-- Info Lokasi -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-4 mb-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-zinc-500 font-medium">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                    <div class="flex items-center gap-2 mt-1">
                        <i class="ph-fill ph-map-pin text-blue-600"></i>
                        <span class="font-semibold text-sm text-slate-800">
                            {{ $office ? $office->name : 'Tidak Terdaftar' }}
                        </span>
                    </div>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 text-xs font-semibold rounded-xl p-4 mb-4 flex items-center gap-2.5">
                <i class="ph-bold ph-warning-circle text-lg"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Jadwal Solat -->
        <div class="space-y-3 mb-8">
            @php
                $prayers = [
                    ['key' => 'subuh', 'name' => 'Subuh', 'time' => '04:38 WIB', 'bg' => 'bg-indigo-50 border-indigo-100', 'iconBg' => 'bg-indigo-100', 'iconColor' => 'text-indigo-650', 'icon' => 'ph-sun-horizon'],
                    ['key' => 'zuhur', 'name' => 'Zuhur', 'time' => '12:05 WIB', 'bg' => 'bg-amber-50 border-amber-100', 'iconBg' => 'bg-amber-100', 'iconColor' => 'text-amber-600', 'icon' => 'ph-sun'],
                    ['key' => 'asar', 'name' => 'Asar', 'time' => '15:28 WIB', 'bg' => 'bg-orange-50 border-orange-100', 'iconBg' => 'bg-orange-100', 'iconColor' => 'text-orange-600', 'icon' => 'ph-sun-dim'],
                    ['key' => 'maghrib', 'name' => 'Maghrib', 'time' => '18:10 WIB', 'bg' => 'bg-emerald-50 border-emerald-100', 'iconBg' => 'bg-emerald-100', 'iconColor' => 'text-emerald-600', 'icon' => 'ph-sunset'],
                    ['key' => 'isya', 'name' => 'Isya', 'time' => '19:20 WIB', 'bg' => 'bg-slate-50 border-slate-200', 'iconBg' => 'bg-slate-900', 'iconColor' => 'text-blue-300', 'icon' => 'ph-moon'],
                ];
            @endphp

            @foreach($prayers as $p)
                @php
                    $hasChecked = isset($todayPrayers[$p['key']]);
                    $pTime = \Carbon\Carbon::createFromFormat('H:i', substr($p['time'], 0, 5));
                    $isTimeYet = now()->greaterThanOrEqualTo($pTime);
                @endphp
                
                @if($hasChecked)
                    <!-- Selesai Absen -->
                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-4 flex items-center justify-between transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full {{ $p['iconBg'] }} flex items-center justify-center">
                                <i class="ph-fill {{ $p['icon'] }} {{ $p['iconColor'] }} text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">
                                    {{ $p['name'] }}
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold">
                                    Absen: {{ \Carbon\Carbon::parse($todayPrayers[$p['key']]->time)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1 text-xs bg-emerald-100 text-emerald-700 font-bold px-3.5 py-1.5 rounded-full">
                            <i class="ph-bold ph-check"></i>
                            Selesai
                        </span>
                    </div>
                @else
                    <!-- Belum Absen / Tombol Absen -->
                    <div class="bg-white border border-zinc-100 rounded-2xl p-4 flex items-center justify-between hover:border-blue-200 transition-all shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <i class="ph-fill {{ $p['icon'] }} text-slate-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">
                                    {{ $p['name'] }}
                                </h3>
                                <p class="text-xs text-slate-400">
                                    Estimasi: {{ $p['time'] }}
                                </p>
                            </div>
                        </div>
                        @if($isTimeYet)
                            <a href="/attedance/ishoma?type={{ $p['key'] }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-full shadow-sm transition-all active:scale-95">
                                Absen
                            </a>
                        @else
                            <button disabled class="bg-slate-100 text-slate-400 text-xs font-bold px-4 py-2.5 rounded-full cursor-not-allowed border border-slate-200">
                                Belum Waktunya
                            </button>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layout-attedance>
