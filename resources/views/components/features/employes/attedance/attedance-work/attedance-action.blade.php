<x-layout-attedance>
    <!-- Header -->
    <div class="flex items-center gap-3 p-5 border-b border-zinc-100">
        <a href="/" class="w-10 h-10 flex items-center justify-center rounded-full bg-zinc-100 text-zinc-700">
            <i class="ph ph-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="font-bold text-zinc-900">
                Selfie Kehadiran
            </h1>
            <p class="text-xs text-zinc-500">
                Verifikasi kehadiran karyawan
            </p>
        </div>
    </div>
    <div class="p-5 flex flex-col items-center">
        <p class="text-slate-600 text-sm text-center mb-4 mt-2">
            Ambil selfie Anda untuk verifikasi kehadiran
        </p>
        <!-- Camera Preview -->
        <div class="relative w-64 h-64 rounded-full border-4 border-dashed border-emerald-500 p-2 mb-6">
            <div class="w-full h-full bg-slate-200 rounded-full overflow-hidden relative">
                <img src="https://i.pravatar.cc/300?img=11" alt="Selfie" class="w-full h-full object-cover">
                <div class="absolute inset-0 border-[8px] border-white/20 rounded-full">
                </div>
            </div>
        </div>
        <!-- Tips -->
        <div class="space-y-2 w-full max-w-xs mb-8">
            <p class="text-sm text-slate-600 flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-emerald-500"></i>
                Pastikan wajah terlihat jelas
            </p>
            <p class="text-sm text-slate-600 flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-emerald-500"></i>
                Jangan memakai kacamata hitam
            </p>
            <p class="text-sm text-slate-600 flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-emerald-500"></i>
                Pastikan pencahayaan cukup
            </p>
        </div>
        <!-- Camera Controls -->
        <div class="w-full flex items-center justify-between px-6 mt-8">
            <button class="p-3 bg-slate-100 rounded-full text-slate-600">
                <i class="ph ph-image text-2xl"></i>
            </button>
            <button
                class="w-20 h-20 bg-blue-600 rounded-full border-4 border-blue-100 flex items-center justify-center shadow-lg shadow-blue-200">
                <div class="w-16 h-16 rounded-full border-2 border-white">
                </div>
            </button>
            <button class="p-3 bg-slate-100 rounded-full text-slate-600">
                <i class="ph ph-camera-rotate text-2xl"></i>
            </button>
        </div>
    </div>
</x-layout-attedance>
