<x-layout-admin title="Kelola Lokasi & Geofencing Kantor">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
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
                        <th class="py-4 px-4 font-semibold">Jumlah Karyawan</th>
                        <th class="py-4 px-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <!-- Row 1 -->
                    <tr>
                        <td class="py-4 px-4 font-bold text-slate-800">Kantor Pusat</td>
                        <td class="py-4 px-4 font-mono">-6.20880000</td>
                        <td class="py-4 px-4 font-mono">106.84560000</td>
                        <td class="py-4 px-4">50 Meter</td>
                        <td class="py-4 px-4 font-semibold text-slate-650">92 Karyawan</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="/admin/offices/1/edit" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
                                    <i class="ph ph-pencil-simple text-sm"></i>
                                </a>
                                <button class="p-2 bg-red-50 hover:bg-red-100 rounded-lg text-red-500 transition-all">
                                    <i class="ph ph-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr>
                        <td class="py-4 px-4 font-bold text-slate-800">Kantor Cabang B</td>
                        <td class="py-4 px-4 font-mono">-6.30940000</td>
                        <td class="py-4 px-4 font-mono">106.89200000</td>
                        <td class="py-4 px-4">100 Meter</td>
                        <td class="py-4 px-4 font-semibold text-slate-650">32 Karyawan</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="/admin/offices/2/edit" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
                                    <i class="ph ph-pencil-simple text-sm"></i>
                                </a>
                                <button class="p-2 bg-red-50 hover:bg-red-100 rounded-lg text-red-500 transition-all">
                                    <i class="ph ph-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>
