<x-layout-admin title="Kelola Data Karyawan">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">

        @if(session('success'))
            <div id="flash-success" class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl p-4 mb-6 flex items-center gap-2.5">
                <i class="ph-bold ph-check-circle text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Actions & Filters -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <form method="GET" action="/admin/employees" class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-blue-500 focus:outline-none w-full">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all">
                    Cari
                </button>
            </form>

            <a href="/admin/employees/create"
                class="py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all w-full md:w-auto">
                <i class="ph ph-plus"></i> Tambah Karyawan Baru
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-4 font-semibold">Nama Karyawan</th>
                        <th class="py-4 px-4 font-semibold">Email</th>
                        <th class="py-4 px-4 font-semibold">Peran</th>
                        <th class="py-4 px-4 font-semibold">Wajah Terdaftar</th>
                        <th class="py-4 px-4 font-semibold">Total Absensi</th>
                        <th class="py-4 px-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $employee->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-500">{{ $employee->email }}</td>
                            <td class="py-4 px-4">
                                @if($employee->role === 'admin')
                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-600 rounded-full font-medium">Admin</span>
                                @else
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">Karyawan</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($employee->is_face_enrolled)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-medium flex items-center gap-1 w-fit">
                                        <i class="ph-bold ph-check"></i> Terdaftar
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-full font-medium flex items-center gap-1 w-fit">
                                        <i class="ph-bold ph-warning"></i> Belum
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-600">
                                {{ $employee->attendances_count }} kali
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="/admin/employees/{{ $employee->id }}/edit"
                                        class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
                                        <i class="ph ph-pencil-simple text-sm"></i>
                                    </a>
                                    <form action="/admin/employees/{{ $employee->id }}" method="POST"
                                        onsubmit="return confirm('Hapus karyawan {{ $employee->name }}? Tindakan ini tidak dapat dibatalkan.')">
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
                                <i class="ph ph-users text-3xl mb-2 block"></i>
                                <p class="text-xs font-medium">Belum ada karyawan terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
            <div class="mt-6 flex justify-end">
                {{ $employees->links() }}
            </div>
        @endif
    </div>

    <script>
        // Auto-dismiss flash message
        setTimeout(() => {
            const el = document.getElementById('flash-success');
            if (el) el.style.display = 'none';
        }, 4000);
    </script>
</x-layout-admin>
