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
        <!-- Filter Bulan -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-4 flex items-center justify-between mb-5">
            <button>
                <i class="ph ph-caret-left text-zinc-600"></i>
            </button>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-zinc-800">
                    Mei 2026
                </span>
                <i class="ph ph-caret-down text-zinc-500"></i>
            </div>
            <button>
                <i class="ph ph-calendar text-zinc-600"></i>
            </button>
        </div>
        <!-- Tanggal -->
        <div class="mb-5">
            <h3 class="font-semibold text-zinc-800 mb-3">
                Kamis, 29 Mei 2026
            </h3>
            <div class="bg-white rounded-2xl border border-zinc-100">
                <!-- Masuk -->
                <div class="p-4 flex justify-between">
                    <div class="flex gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="ph-fill ph-sign-in text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">
                                Absen Masuk
                            </p>
                            <p class="text-xs text-zinc-500">
                                09:41 WIB
                            </p>
                            <p class="text-xs text-zinc-400">
                                Kantor Pusat
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded-full">
                            Tepat Waktu
                        </span>
                        <p class="text-xs text-zinc-400 mt-2">
                            25 meter
                        </p>
                    </div>
                </div>
                <div class="border-t border-zinc-100"></div>
                <!-- Pulang -->
                <div class="p-4 flex justify-between">
                    <div class="flex gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center">
                            <i class="ph-fill ph-sign-out text-orange-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">
                                Absen Pulang
                            </p>
                            <p class="text-xs text-zinc-500">
                                18:02 WIB
                            </p>
                            <p class="text-xs text-zinc-400">
                                Kantor Pusat
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded-full">
                            Tepat Waktu
                        </span>
                        <p class="text-xs text-zinc-400 mt-2">
                            30 meter
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts>
