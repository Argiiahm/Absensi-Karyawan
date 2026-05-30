<x-layout-admin title="Riwayat Absensi Sholat / Ishoma Karyawan">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <!-- Filter Controls -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
                <input type="date" value="{{ date('Y-m-d') }}" 
                    class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto">
                <select class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-auto">
                    <option value="">Semua Waktu Sholat</option>
                    <option value="subuh">Subuh</option>
                    <option value="zuhur">Zuhur</option>
                    <option value="asar">Asar</option>
                    <option value="maghrib">Maghrib</option>
                    <option value="isya">Isya</option>
                </select>
                <input type="text" placeholder="Cari nama karyawan..." 
                    class="border border-slate-200 rounded-xl py-2 px-4 text-xs focus:outline-none w-full sm:w-48">
            </div>
            
            <button class="py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all w-full md:w-auto">
                <i class="ph ph-file-xls"></i> Export Rekap Sholat
            </button>
        </div>

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
                    <!-- Row 1 -->
                    <tr>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/100?img=11" alt="Andi Avatar" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <span class="font-bold text-slate-800 block">Andi Setiawan</span>
                                    <span class="text-[10px] text-slate-400">ID: KRP00123</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">29 Mei 2026</td>
                        <td class="py-4 px-4 uppercase font-bold text-blue-600">Zuhur</td>
                        <td class="py-4 px-4 font-semibold">12:10 WIB</td>
                        <td class="py-4 px-4">25m dari Titik Pusat</td>
                        <td class="py-4 px-4">
                            <img src="https://i.pravatar.cc/100?img=11" alt="Selfie Sholat" class="w-8 h-8 rounded-lg object-cover border border-slate-100 hover:scale-150 transition-all cursor-pointer">
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-medium inline-flex items-center gap-1">
                                <i class="ph-bold ph-check"></i> Selesai
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>
