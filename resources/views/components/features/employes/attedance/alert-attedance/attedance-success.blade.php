<x-layout-attedance>
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between p-5 border-b border-zinc-100">
            <div>
                <h1 class="font-bold text-zinc-900">
                    Status Absensi
                </h1>
                <p class="text-xs text-zinc-500">
                    Kehadiran berhasil dicatat
                </p>
            </div>
        </div>
        <!-- Content -->
        <div class="flex-1 p-6 flex flex-col items-center">
            <!-- Success Icon -->
            <div class="w-28 h-28 rounded-full bg-emerald-100 flex items-center justify-center mb-6 mt-6">
                <i class="ph-fill ph-check-circle text-6xl text-emerald-500"></i>
            </div>
            <h2 class="text-2xl font-bold text-zinc-900 text-center">
                Absen @if($attendance && in_array($attendance->type, ['masuk', 'pulang'])) {{ ucfirst($attendance->type) }} @else Sholat {{ ucfirst($attendance?->type) }} @endif Berhasil!
            </h2>
            <p class="text-sm text-zinc-500 text-center mt-2 mb-8">
                Absen @if($attendance && in_array($attendance->type, ['masuk', 'pulang'])) {{ $attendance->type }} @else Sholat {{ $attendance?->type }} @endif Anda berhasil dicatat.
            </p>
            <!-- Detail Card -->
            <div class="w-full bg-white rounded-3xl border border-zinc-100 shadow-sm p-5 space-y-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center">
                        <i class="ph-fill ph-calendar text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">
                            Tanggal
                        </p>
                        <p class="font-semibold text-zinc-900">
                            {{ $attendance ? \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-full bg-orange-50 flex items-center justify-center">
                        <i class="ph-fill ph-clock text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">
                            Waktu
                        </p>
                        <p class="font-semibold text-zinc-900">
                            {{ $attendance ? \Carbon\Carbon::parse($attendance->time)->format('H:i') : '-' }} WIB
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-full bg-emerald-50 flex items-center justify-center">
                        <i class="ph-fill ph-map-pin text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">
                            Lokasi
                        </p>
                        <p class="font-semibold text-zinc-900">
                            {{ $office->name ?? '-' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-full bg-purple-50 flex items-center justify-center">
                        <i class="ph-fill ph-crosshair text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">
                            Jarak Presisi
                        </p>
                        <p class="font-semibold text-zinc-900">
                            {{ $distance !== null ? round($distance, 1) . ' Meter (Dalam Radius)' : '-' }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="w-full mt-auto pt-8">
                <a href="/"
                    class="w-full h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-semibold shadow-lg shadow-blue-200">

                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layout-attedance>
