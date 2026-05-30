<x-layout-admin title="Kelola Data Karyawan">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <!-- Actions & Filters -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </span>
                    <input type="text" placeholder="Cari nama atau ID karyawan..." 
                        class="pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-blue-500 focus:outline-none w-full">
                </div>
                <select class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto">
                    <option value="">Semua Kantor</option>
                    <option value="kantor-pusat">Kantor Pusat</option>
                    <option value="cabang-b">Cabang B</option>
                </select>
            </div>
            
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
                        <th class="py-4 px-4 font-semibold">ID Karyawan</th>
                        <th class="py-4 px-4 font-semibold">Email</th>
                        <th class="py-4 px-4 font-semibold">Kantor Penugasan</th>
                        <th class="py-4 px-4 font-semibold">Peran</th>
                        <th class="py-4 px-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    <!-- Row 1 -->
                    <tr>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/100?img=11" alt="Andi Avatar" class="w-8 h-8 rounded-full object-cover">
                                <span class="font-bold text-slate-800">Andi Setiawan</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">KRP00123</td>
                        <td class="py-4 px-4">andi.setiawan@company.com</td>
                        <td class="py-4 px-4">Kantor Pusat</td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">Karyawan</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="/admin/employees/1/edit" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
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
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/100?img=12" alt="Budi Avatar" class="w-8 h-8 rounded-full object-cover">
                                <span class="font-bold text-slate-800">Budi Raharjo</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">KRP00124</td>
                        <td class="py-4 px-4">budi.raharjo@company.com</td>
                        <td class="py-4 px-4">Kantor Pusat</td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">Karyawan</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <a href="/admin/employees/2/edit" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-all">
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
