<x-layout-admin title="Kelola Lokasi & Geofencing Kantor">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">

        @if(session('success'))
            <div id="flash-success" class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl p-4 mb-6 flex items-center gap-2.5">
                <i class="ph-bold ph-check-circle text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h4 class="font-bold text-slate-800">Daftar Titik Kantor Geofencing</h4>
            <a href="/admin/offices/create"
                class="py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all w-full sm:w-auto">
                <i class="ph ph-plus"></i> Tambah Lokasi Kantor
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-4 font-semibold">Nama Kantor</th>
                        <th class="py-4 px-4 font-semibold">Latitude</th>
                        <th class="py-4 px-4 font-semibold">Longitude</th>
                        <th class="py-4 px-4 font-semibold">Radius Toleransi</th>
                        <th class="py-4 px-4 font-semibold">Jam Kerja</th>
                        <th class="py-4 px-4 font-semibold">Total Absensi</th>
                        <th class="py-4 px-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($offices as $office)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-4 font-bold text-slate-800">{{ $office->name }}</td>
                            <td class="py-4 px-4 font-mono text-slate-500">{{ number_format($office->latitude, 8) }}</td>
                            <td class="py-4 px-4 font-mono text-slate-500">{{ number_format($office->longitude, 8) }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full font-semibold">
                                    {{ $office->radius }} Meter
                                </span>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-700">
                                {{ substr($office->start_time, 0, 5) }} - {{ substr($office->end_time, 0, 5) }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-600">{{ $office->attendances_count }} absensi</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="/admin/offices/{{ $office->id }}/edit"
                                        class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
                                        <i class="ph ph-pencil-simple text-sm"></i>
                                    </a>
                                    <form action="/admin/offices/{{ $office->id }}" method="POST"
                                        onsubmit="return confirm('Hapus kantor {{ $office->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 rounded-lg text-red-500 transition-all">
                                            <i class="ph ph-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="ph ph-map-pin text-3xl mb-2 block"></i>
                                <p class="text-xs font-medium">Belum ada kantor terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($offices->hasPages())
            <div class="mt-6 flex justify-end">
                {{ $offices->links() }}
            </div>
        @endif
    </div>

    <script>
        setTimeout(() => {
            const el = document.getElementById('flash-success');
            if (el) el.style.display = 'none';
        }, 4000);
    </script>
</x-layout-admin>
