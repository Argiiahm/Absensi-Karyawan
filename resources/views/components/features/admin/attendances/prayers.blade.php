<x-layout-admin title="Riwayat Absensi Sholat / Ishoma Karyawan">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <!-- Filter Controls -->
        <form method="GET" action="/admin/attendances/prayers" class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                    class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto"
                    onchange="this.form.submit()">
                <select name="prayer" class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto"
                    onchange="this.form.submit()">
                    <option value="">Semua Waktu Sholat</option>
                    <option value="subuh" {{ request('prayer') === 'subuh' ? 'selected' : '' }}>Subuh</option>
                    <option value="zuhur" {{ request('prayer') === 'zuhur' ? 'selected' : '' }}>Zuhur</option>
                    <option value="asar" {{ request('prayer') === 'asar' ? 'selected' : '' }}>Asar</option>
                    <option value="maghrib" {{ request('prayer') === 'maghrib' ? 'selected' : '' }}>Maghrib</option>
                    <option value="isya" {{ request('prayer') === 'isya' ? 'selected' : '' }}>Isya</option>
                </select>
                <div class="relative w-full sm:w-48">
                    <input type="text" name="search" placeholder="Cari nama karyawan..." value="{{ request('search') }}"
                        class="border border-slate-200 rounded-xl py-2 pl-4 pr-10 text-xs focus:outline-none w-full">
                    @if(request('search'))
                        <a href="/admin/attendances/prayers?date={{ request('date') }}&prayer={{ request('prayer') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-650">
                            <i class="ph ph-x text-xs"></i>
                        </a>
                    @endif
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2 text-xs font-bold transition-all">
                    Cari
                </button>
            </div>
            
            <a href="/admin/attendances/prayers" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all w-full md:w-auto">
                <i class="ph ph-arrow-counter-clockwise"></i> Reset Filter
            </a>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-4 font-semibold">Karyawan</th>
                        <th class="py-4 px-4 font-semibold">Tanggal</th>
                        <th class="py-4 px-4 font-semibold">Waktu Ibadah</th>
                        <th class="py-4 px-4 font-semibold">Jam Absen</th>
                        <th class="py-4 px-4 font-semibold">Jarak Geofencing</th>
                        <th class="py-4 px-4 font-semibold">Selfie Bukti</th>
                        <th class="py-4 px-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($attendances as $att)
                        <tr>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase overflow-hidden border border-slate-100">
                                        @if($att->user->face_photo_path)
                                            <img src="{{ $att->user->face_photo_path }}" alt="{{ $att->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($att->user->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $att->user->name }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $att->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">{{ \Carbon\Carbon::parse($att->date)->translatedFormat('d F Y') }}</td>
                            <td class="py-4 px-4">
                                <span class="uppercase font-bold text-blue-600">
                                    {{ $att->type }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-semibold">{{ \Carbon\Carbon::parse($att->time)->format('H:i') }} WIB</td>
                            <td class="py-4 px-4">
                                @if($att->distance_to_office !== null)
                                    {{ round($att->distance_to_office) }}m dari {{ $att->office->name ?? 'Kantor' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($att->snapshot_path)
                                    <img src="{{ $att->snapshot_path }}" alt="Selfie Bukti" class="w-8 h-8 rounded-lg object-cover border border-slate-100 hover:scale-150 transition-all cursor-pointer">
                                @else
                                    <span class="text-slate-400 italic">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-medium inline-flex items-center gap-1">
                                    <i class="ph-bold ph-check"></i> Selesai
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="ph ph-file-search text-3xl"></i>
                                    <span>Tidak ada riwayat absen sholat ditemukan untuk kriteria ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($attendances->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-150">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</x-layout-admin>
