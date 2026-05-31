<x-layouts>
    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center hover:bg-blue-700/50 rounded-full transition-colors">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Pengajuan / Laporan
            </h1>
            <div class="w-10"></div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-4 -mt-3 pb-8">
        <!-- Status Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs rounded-xl p-3.5 mb-4 flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-emerald-600 text-lg"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-100 text-rose-800 text-xs rounded-xl p-3.5 mb-4 space-y-1">
                <div class="flex items-center gap-2 font-bold text-rose-900">
                    <i class="ph-fill ph-warning-circle text-rose-600 text-lg"></i>
                    <span>Kirim Gagal:</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-rose-700 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-zinc-100 p-5 shadow-sm mb-6">
            <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                <i class="ph-fill ph-paper-plane text-blue-600"></i>
                Form Kirim Pengajuan / Laporan
            </h3>

            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-500 mb-1.5">Judul / Perihal</label>
                    <input type="text" name="title" id="title" required placeholder="Contoh: Terkait gaji..., Laporan Kerusakan..."
                        class="w-full bg-slate-50 border border-zinc-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                        value="{{ old('title') }}">
                </div>

                <!-- Tipe -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2">Tipe</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="pengajuan" class="peer hidden" checked>
                            <div class="border border-zinc-200 peer-checked:border-blue-500 peer-checked:bg-blue-50/55 rounded-xl py-2.5 px-1 text-center text-xs font-semibold text-slate-600 peer-checked:text-blue-600 transition-all">
                                Pengajuan
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="laporan" class="peer hidden">
                            <div class="border border-zinc-200 peer-checked:border-blue-500 peer-checked:bg-blue-50/55 rounded-xl py-2.5 px-1 text-center text-xs  font-semibold text-slate-600 peer-checked:text-blue-600 transition-all">
                                Laporan (Informasi)
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-500 mb-1.5">Keterangan Detail</label>
                    <textarea name="description" id="description" rows="3" required placeholder="Tuliskan keterangan detail pengajuan atau laporan Anda..."
                        class="w-full bg-slate-50 border border-zinc-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">{{ old('description') }}</textarea>
                </div>

                <!-- Upload File Bukti -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Lampiran Pendukung (Opsional)</label>
                    <div class="relative border border-dashed border-slate-300 rounded-xl p-4 text-center bg-slate-50 hover:bg-slate-100 transition-colors">
                        <input type="file" name="attachment" id="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-1">
                            <i class="ph ph-upload-simple text-slate-400 text-xl block"></i>
                            <p id="file-name-label" class="text-[10px] text-slate-500 font-semibold truncate">
                                Upload Gambar atau PDF (Max 2MB)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/10 active:scale-[0.98] transition-all cursor-pointer">
                    Kirim Sekarang
                </button>
            </form>
        </div>

        <!-- History Title -->
        <h3 class="font-bold text-slate-800 mb-3 text-xs uppercase tracking-wider">
            Riwayat Pengajuan & Laporan
        </h3>

        <!-- History List -->
        <div class="space-y-3">
            @forelse($submissions as $sub)
                <div class="bg-white rounded-2xl border border-zinc-100 p-4 shadow-sm relative overflow-hidden">
                    <!-- Top Info row -->
                    <div class="flex items-start justify-between mb-2.5">
                        <div class="flex items-center gap-2">
                            @if($sub->type === 'pengajuan')
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    Pengajuan
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider bg-orange-50 text-orange-600 border border-orange-100">
                                    Laporan
                                </span>
                            @endif
                            <span class="text-[10px] text-slate-400 font-semibold">
                                {{ $sub->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <!-- Status Badge -->
                        @if($sub->status === 'pending')
                            <span class="text-[10px] bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                            </span>
                        @elseif($sub->status === 'approved')
                            <span class="text-[10px] bg-emerald-50 text-emerald-650 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                            </span>
                        @else
                            <span class="text-[10px] bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                            </span>
                        @endif
                    </div>

                    <!-- Title, Description -->
                    <div class="space-y-1">
                        <h4 class="text-xs font-bold text-slate-800 leading-tight">
                            {{ $sub->title }}
                        </h4>
                        <p class="text-xs text-slate-650 leading-relaxed font-medium">
                            {{ $sub->description }}
                        </p>
                    </div>

                    <!-- Action / Attachment / Rejection details -->
                    @if($sub->attachment_path || $sub->status === 'rejected')
                        <div class="mt-3 pt-3 border-t border-slate-50 flex flex-col gap-2">
                            @if($sub->attachment_path)
                                <a href="{{ $sub->attachment_path }}" target="_blank"
                                    class="text-[10px] font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                                    <i class="ph ph-paperclip"></i> Lihat Lampiran Pendukung
                                </a>
                            @endif

                            @if($sub->status === 'rejected' && $sub->rejection_reason)
                                <div class="bg-rose-50/50 rounded-xl p-2.5 border border-rose-100/30">
                                    <p class="text-[10px] font-bold text-rose-800">Alasan Penolakan:</p>
                                    <p class="text-[10px] text-rose-655 mt-0.5 font-semibold">
                                        {{ $sub->rejection_reason }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-zinc-100 p-10 text-center shadow-sm">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="ph ph-chat-centered-text text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Pengajuan/Laporan</h4>
                    <p class="text-xs text-slate-500 mt-1">Seluruh riwayat pengajuan klaim, saran, atau laporan Anda akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Script to show file name on input and add submit loading -->
    <script>
        document.getElementById('attachment')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = document.getElementById('file-name-label');
            if (label && fileName) {
                label.textContent = fileName;
                label.classList.remove('text-slate-500');
                label.classList.add('text-blue-600');
            }
        });

        // Add loading state to submit button
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                `;
                btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
            }
        });
    </script>
</x-layouts>
