<x-layout-attedance>
    <div class="bg-white min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-5 py-4 flex items-center gap-3">
            <a href="/" class="p-1">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h2 class="text-lg font-semibold">
                Absen Masuk
            </h2>
        </div>

        <div class="p-5 flex-1 flex flex-col">
            <h3 class="text-2xl font-bold text-slate-800 mb-2">
                Absen Masuk
            </h3>
            <p class="text-sm text-slate-500 mb-6">
                Pastikan Anda berada di lokasi kantor dalam radius yang ditentukan
                (Maksimal 50 meter).
            </p>
            <!-- Map -->
            <div
                class="bg-slate-200 rounded-2xl h-64 w-full relative overflow-hidden mb-6 flex items-center justify-center border border-slate-300">
                <div
                    class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cartographer.png')]">
                </div>
                <div
                    class="w-48 h-48 bg-blue-500/20 rounded-full absolute flex items-center justify-center border border-blue-500/30">
                    <div class="relative flex flex-col items-center">
                        <div class="bg-blue-600 text-white p-2 rounded-full shadow-lg z-10">
                            <i class="ph-fill ph-map-pin text-lg"></i>
                        </div>
                        <div class="w-2 h-2 bg-blue-800 rounded-full mt-1"></div>
                    </div>
                </div>
                <div
                    class="absolute top-3 right-3 bg-white/90 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold text-slate-700">
                    Titik Pusat
                    <br>
                    <span class="text-slate-500 font-normal">
                        Radius 50 meter
                    </span>
                </div>
            </div>
            <!-- Status -->
            <div class="border border-emerald-200 bg-emerald-50 rounded-xl p-4 flex items-center justify-between mb-6">
                <div class="flex items-start gap-3">
                    <i class="ph-fill ph-map-pin text-emerald-600 mt-1"></i>
                    <div>
                        <h4 class="font-bold text-sm text-emerald-800">
                            Lokasi Anda
                        </h4>
                        <p class="text-xs mt-1 text-emerald-600">
                            Dalam Radius
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            Jarak ke lokasi:
                            <strong>25 meter</strong>
                        </p>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-700 flex items-center justify-center">
                    <i class="ph-bold ph-check"></i>
                </div>
            </div>
            <!-- Action -->
            <div class="mt-auto space-y-3">
                <button
                    class="w-full py-3 bg-slate-100 text-slate-600 font-semibold rounded-xl text-sm border border-slate-200">
                    <i class="ph ph-arrow-clockwise mr-1"></i>
                    Refresh Lokasi
                </button>
                <button onclick="window.location='/attedance/action'"
                    class="w-full py-3.5 rounded-xl font-bold text-white bg-blue-600 flex items-center justify-center gap-2 shadow-md">
                    <i class="ph-fill ph-camera"></i>
                    Lanjutkan ke Selfie
                </button>
                <p class="text-xs text-center text-slate-500 flex items-center justify-center gap-1">
                    <i class="ph ph-info"></i>
                    Pastikan GPS aktif untuk akurasi lokasi
                </p>
            </div>
        </div>
    </div>
</x-layout-attedance>
