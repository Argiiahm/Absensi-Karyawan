<x-layout-admin title="Riwayat Absensi Harian Karyawan">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <!-- Filter Controls -->
        <form method="GET" action="/admin/attendances">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}"
                        class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 w-full sm:w-auto">
                    <select name="status" class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto bg-white">
                        <option value="">Semua Status</option>
                        <option value="tepat_waktu" {{ request('status') === 'tepat_waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="tidak_masuk" {{ request('status') === 'tidak_masuk' ? 'selected' : '' }}>Tidak Masuk</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama karyawan..."
                        class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-48">
                    <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-4 font-semibold">Karyawan</th>
                        <th class="py-4 px-4 font-semibold">Tanggal</th>
                        <th class="py-4 px-4 font-semibold">Jam Masuk</th>
                        <th class="py-4 px-4 font-semibold">Jam Pulang</th>
                        <th class="py-4 px-4 font-semibold">Kantor</th>
                        <th class="py-4 px-4 font-semibold">Status</th>
                        <th class="py-4 px-4 font-semibold">Selfie</th>
                        <th class="py-4 px-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($users as $user)
                        @php
                            $comp = $user->computed_attendance;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0 uppercase">
                                        @if($user->face_photo_path)
                                            <img src="{{ $user->face_photo_path }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            {{ substr($user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $user->name ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $user->email ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                {{ \Carbon\Carbon::parse(request('date', date('Y-m-d')))->locale('id')->isoFormat('D MMM Y') }}
                            </td>
                            <td class="py-4 px-4 font-semibold font-mono text-slate-700">
                                {{ $comp->time_masuk }}
                            </td>
                            <td class="py-4 px-4 font-semibold font-mono text-slate-700">
                                {{ $comp->time_pulang }}
                            </td>
                            <td class="py-4 px-4 text-slate-500">{{ $comp->office_name }}</td>
                            <td class="py-4 px-4">
                                @if($comp->status === 'tidak_masuk')
                                    <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-full font-bold">Tidak Masuk</span>
                                @elseif($comp->status === 'terlambat')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full font-bold">Terlambat</span>
                                @else
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-bold">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($comp->snapshot_path)
                                    <img src="{{ $comp->snapshot_path }}" alt="Selfie"
                                        class="w-8 h-8 rounded-lg object-cover border border-slate-100 hover:scale-150 transition-all cursor-pointer">
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($comp->attendance_id)
                                    <a href="/admin/attendances/{{ $comp->attendance_id }}" class="text-blue-600 hover:underline font-bold">Detail</a>
                                @else
                                    <span class="text-slate-300 font-medium">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="ph ph-calendar-blank text-3xl mb-2 block"></i>
                                <p class="text-xs font-medium">Tidak ada data karyawan ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="mt-6 flex justify-end">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layout-admin>
