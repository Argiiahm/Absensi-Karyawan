<x-layout-admin title="Kelola Informasi & Pengumuman">
    <!-- Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm rounded-2xl p-4 mb-6 flex items-center gap-2">
            <i class="ph-fill ph-check-circle text-emerald-600 text-xl"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <h4 class="font-bold text-slate-700 text-sm">Daftar Pengumuman Aktif</h4>
        <a href="/admin/informations/create"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2.5 text-xs font-bold shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
            <i class="ph ph-plus"></i> Buat Informasi Baru
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Judul Pengumuman</th>
                        <th class="px-6 py-4">Konten / Isi</th>
                        <th class="px-6 py-4">Dibuat Oleh</th>
                        <th class="px-6 py-4">Tanggal Rilis</th>
                        <th class="px-6 py-4">Lampiran</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                    @forelse($announcements as $ann)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Judul -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-slate-800">{{ $ann->title }}</span>
                            </td>

                            <!-- Konten -->
                            <td class="px-6 py-4 max-w-sm">
                                <p class="text-xs line-clamp-2 text-slate-605" title="{{ $ann->content }}">{{ $ann->content }}</p>
                            </td>

                            <!-- Pembuat -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2 text-xs">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-650 flex items-center justify-center font-bold uppercase shrink-0">
                                        {{ substr($ann->creator->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span>{{ $ann->creator->name ?? 'Administrator' }}</span>
                                </div>
                            </td>

                            <!-- Tanggal Rilis -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs text-slate-500">{{ $ann->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                            </td>

                            <!-- Lampiran -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ann->attachment_path)
                                    <a href="{{ $ann->attachment_path }}" target="_blank"
                                        class="text-xs text-blue-600 hover:text-blue-700 font-bold inline-flex items-center gap-1">
                                        <i class="ph ph-file-text text-base"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">-</span>
                                @endif
                            </td>

                            <!-- Aksi hapus -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <form action="/admin/informations/{{ $ann->id }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-50 hover:bg-red-100 text-red-600 rounded-lg p-2 text-xs font-bold transition-all inline-flex items-center gap-1 cursor-pointer">
                                        <i class="ph ph-trash text-base"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <i class="ph ph-megaphone text-2xl"></i>
                                </div>
                                <p class="font-bold text-slate-700 text-sm">Tidak Ada Informasi</p>
                                <p class="text-xs text-slate-400 mt-1">Belum ada pengumuman resmi yang dipublikasikan saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination footer -->
        @if($announcements->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-layout-admin>
