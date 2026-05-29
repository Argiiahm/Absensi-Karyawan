<x-layouts>
    <div class="relative">
        <!-- Header -->
        <div class="bg-blue-600 text-white rounded-b-3xl px-6 pt-10 pb-20 relative">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-bold flex items-center gap-2">
                        Halo, Andi Setiawan <span class="text-2xl">👋</span>
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
                        Kamis, 16 Mei 2024
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800 mt-1 font-mono">
                        09:41:20
                    </h2>

                    <p
                        class="text-xs font-semibold text-emerald-600 mt-2 bg-emerald-50 inline-block px-2 py-1 rounded-md">
                        Sudah Absen Masuk
                    </p>
                </div>

                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-laptop text-4xl text-blue-500"></i>
                </div>
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
                                09:41 WIB
                            </p>
                        </div>
                    </div>
                    <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                        Tepat Waktu
                    </span>
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
                                Belum absen pulang
                            </p>
                        </div>
                    </div>
                    <i class="ph ph-caret-right text-slate-400"></i>
                </div>
            </div>
        </div>
        <!-- Menu -->
        <div class="px-5 mt-6 mb-8">
            <h3 class="font-bold text-slate-800 mb-3">
                Menu Utama
            </h3>
            <div class="grid grid-cols-3 gap-4">
                <a href="/attedance"
                    class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-fingerprint text-xl"></i>
                    </div>

                    <span class="text-xs font-medium text-slate-700">
                        Absen
                    </span>
                </a>
                <a href="/history"
                    class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100">
                    <div
                        class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-700">
                        Riwayat
                    </span>
                </a>
                <a href="/statistik"
                    class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100">
                    <div
                        class="w-12 h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-2">
                        <i class="ph-fill ph-chart-bar text-xl"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-700">
                        Statistik
                    </span>
                </a>
            </div>
        </div>
    </div>
</x-layouts>
