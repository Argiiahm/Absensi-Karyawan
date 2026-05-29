<x-layout-attedance>

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

    <div class="px-4 -mt-5">
        <!-- Info Lokasi -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-4 mb-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-zinc-500">
                        Kamis, 29 Mei 2026
                    </p>
                    <div class="flex items-center gap-2 mt-1">
                        <i class="ph-fill ph-map-pin text-blue-600"></i>
                        <span class="font-medium text-sm">
                            Kantor Pusat
                        </span>
                    </div>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </div>
        </div>

        <!-- Jadwal Solat -->
        <div class="space-y-3">
            <!-- Subuh -->
            <div class="bg-white border border-zinc-100 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="ph-fill ph-sun-horizon text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Subuh
                        </h3>
                        <p class="text-xs text-zinc-500">
                            04:38 WIB
                        </p>
                    </div>
                </div>
                <span class="text-xs bg-zinc-100 text-zinc-500 px-3 py-1 rounded-full">
                    Belum Absen
                </span>
            </div>
            <!-- Zuhur Aktif -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="ph-fill ph-sun text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Zuhur
                        </h3>
                        <p class="text-xs text-zinc-500">
                            12:05 WIB
                        </p>
                    </div>
                </div>
                <a href="/attedance/ishoma" class="bg-blue-600 text-white text-xs font-medium px-4 py-2 rounded-full">
                    Absen
                </a>
            </div>

            <!-- Asar -->
            <div class="bg-white border border-zinc-100 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="ph-fill ph-sun-dim text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Asar
                        </h3>
                        <p class="text-xs text-zinc-500">
                            15:28 WIB
                        </p>
                    </div>
                </div>
                <span class="text-xs bg-zinc-100 text-zinc-500 px-3 py-1 rounded-full">
                    Belum Absen
                </span>
            </div>

            <!-- Maghrib -->
            <div class="bg-white border border-emerald-200 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="ph-fill ph-sunset text-emerald-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Maghrib
                        </h3>
                        <p class="text-xs text-zinc-500">
                            18:10 WIB
                        </p>
                    </div>
                </div>
                <span class="flex items-center gap-1 text-xs bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full">
                    <i class="ph-bold ph-check"></i>
                    Selesai
                </span>
            </div>

            <!-- Isya -->
            <div class="bg-white border border-zinc-100 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-slate-900 flex items-center justify-center">
                        <i class="ph-fill ph-moon text-blue-300"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            Isya
                        </h3>
                        <p class="text-xs text-zinc-500">
                            19:20 WIB
                        </p>
                    </div>
                </div>
                <span class="text-xs bg-zinc-100 text-zinc-500 px-3 py-1 rounded-full">
                    Belum Absen
                </span>
            </div>
        </div>
    </div>
</x-layout-attedance>
