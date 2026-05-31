<x-layouts>
    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center hover:bg-blue-700/50 rounded-full transition-colors">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Pusat Informasi
            </h1>
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Content Body -->
    <div class="px-4 -mt-3 pb-8">
        <!-- Announcements Timeline -->
        <div class="space-y-4 mb-8">
            @forelse($announcements as $ann)
                <div class="bg-white rounded-2xl border border-zinc-100 p-5 shadow-sm relative overflow-hidden">
                    <!-- Creator & Date -->
                    <div class="flex items-center justify-between mb-3 text-[10px] text-slate-400 font-semibold">
                        <div class="flex items-center gap-1.5">
                            <div class="w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-[9px] uppercase">
                                {{ substr($ann->creator->name ?? 'A', 0, 1) }}
                            </div>
                            <span>{{ $ann->creator->name ?? 'Administrator' }}</span>
                        </div>
                        <span>{{ $ann->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>

                    <!-- Announcement Title & Content -->
                    <div class="space-y-2">
                        <h3 class="font-bold text-slate-800 text-sm leading-tight flex items-center gap-2">
                            <i class="ph-fill ph-megaphone text-cyan-600"></i>
                            {{ $ann->title }}
                        </h3>
                        <p class="text-xs text-slate-650 leading-relaxed whitespace-pre-line font-medium">
                            {{ $ann->content }}
                        </p>
                    </div>

                    <!-- Attachment if exists -->
                    @if($ann->attachment_path)
                        <div class="mt-4 pt-3.5 border-t border-slate-50">
                            <a href="{{ $ann->attachment_path }}" target="_blank"
                                class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1.5 bg-blue-50/50 px-3 py-2 rounded-xl w-full justify-center transition-colors">
                                <i class="ph ph-download-simple"></i> Unduh Lampiran Dokumen / Foto
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-zinc-100 p-10 text-center shadow-sm">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="ph ph-megaphone text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Informasi</h4>
                    <p class="text-xs text-slate-500 mt-1">Saat ini belum ada pengumuman resmi yang dipublikasikan oleh pihak manajemen.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts>
