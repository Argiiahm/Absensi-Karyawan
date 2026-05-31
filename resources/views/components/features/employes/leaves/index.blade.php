<x-layouts>
    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center hover:bg-blue-700/50 rounded-full transition-colors">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Pengajuan Izin / Cuti
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
                    <span>Pengajuan Gagal:</span>
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
                <i class="ph-fill ph-note-pencil text-blue-600"></i>
                Form Pengajuan Baru
            </h3>

            <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Tipe Izin -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2">Tipe Pengajuan</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="izin" class="peer hidden" checked>
                            <div class="border border-zinc-200 peer-checked:border-blue-500 peer-checked:bg-blue-50/55 rounded-xl py-2.5 text-center text-xs font-semibold text-slate-600 peer-checked:text-blue-600 transition-all">
                                Izin
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="sakit" class="peer hidden">
                            <div class="border border-zinc-200 peer-checked:border-blue-500 peer-checked:bg-blue-50/55 rounded-xl py-2.5 text-center text-xs font-semibold text-slate-600 peer-checked:text-blue-600 transition-all">
                                Sakit
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="cuti" class="peer hidden">
                            <div class="border border-zinc-200 peer-checked:border-blue-500 peer-checked:bg-blue-50/55 rounded-xl py-2.5 text-center text-xs font-semibold text-slate-600 peer-checked:text-blue-600 transition-all">
                                Cuti
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-slate-500 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" required
                            class="w-full bg-slate-50 border border-zinc-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                            value="{{ old('start_date', date('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-bold text-slate-500 mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" required
                            class="w-full bg-slate-50 border border-zinc-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                            value="{{ old('end_date', date('Y-m-d')) }}">
                    </div>
                </div>

                <!-- Alasan -->
                <div>
                    <label for="reason" class="block text-xs font-bold text-slate-500 mb-1.5">Alasan / Keterangan</label>
                    <textarea name="reason" id="reason" rows="3" required placeholder="Tuliskan alasan pengajuan secara rinci..."
                        class="w-full bg-slate-50 border border-zinc-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">{{ old('reason') }}</textarea>
                </div>

                <!-- Upload File Bukti -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Lampiran Bukti (Opsional)</label>
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
                    Ajukan Permohonan
                </button>
            </form>
        </div>

        <!-- History Title -->
        <h3 class="font-bold text-slate-800 mb-3 text-xs uppercase tracking-wider">
            Riwayat Permohonan Anda
        </h3>

        <!-- History List -->
        <div class="space-y-3">
            @forelse($leaves as $leave)
                <div class="bg-white rounded-2xl border border-zinc-100 p-4 shadow-sm relative overflow-hidden">
                    <!-- Top Info row -->
                    <div class="flex items-start justify-between mb-2.5">
                        <div class="flex items-center gap-2">
                            @php
                                $typeColor = 'bg-blue-50 text-blue-600';
                                if($leave->type === 'sakit') $typeColor = 'bg-red-50 text-red-600';
                                if($leave->type === 'cuti') $typeColor = 'bg-indigo-50 text-indigo-600';
                            @endphp
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider {{ $typeColor }}">
                                {{ $leave->type }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-semibold">
                                {{ $leave->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <!-- Status Badge -->
                        @if($leave->status === 'pending')
                            <span class="text-[10px] bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                            </span>
                        @elseif($leave->status === 'approved')
                            <span class="text-[10px] bg-emerald-50 text-emerald-650 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                            </span>
                        @else
                            <span class="text-[10px] bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full font-bold flex items-center gap-1 border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                            </span>
                        @endif
                    </div>

                    <!-- Dates & Reason -->
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="ph ph-calendar text-slate-400"></i>
                            {{ $leave->start_date->translatedFormat('d M Y') }} 
                            @if($leave->start_date != $leave->end_date)
                                s/d {{ $leave->end_date->translatedFormat('d M Y') }}
                            @endif
                        </p>
                        <p class="text-xs text-slate-650 leading-relaxed font-medium">
                            {{ $leave->reason }}
                        </p>
                    </div>

                    <!-- Action / Attachment / Rejection details -->
                    @if($leave->attachment_path || $leave->status === 'rejected')
                        <div class="mt-3 pt-3 border-t border-slate-50 flex flex-col gap-2">
                            @if($leave->attachment_path)
                                <a href="{{ $leave->attachment_path }}" target="_blank"
                                    class="text-[10px] font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                                    <i class="ph ph-paperclip"></i> Lihat Lampiran Bukti
                                </a>
                            @endif

                            @if($leave->status === 'rejected' && $leave->rejection_reason)
                                <div class="bg-rose-50/50 rounded-xl p-2.5 border border-rose-100/30">
                                    <p class="text-[10px] font-bold text-rose-800">Alasan Penolakan:</p>
                                    <p class="text-[10px] text-rose-650 mt-0.5 font-semibold">
                                        {{ $leave->rejection_reason }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-zinc-100 p-10 text-center shadow-sm">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="ph ph-envelope-open text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Pengajuan</h4>
                    <p class="text-xs text-slate-500 mt-1">Semua riwayat permohonan izin atau cuti Anda akan ditampilkan di sini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Script to show file name on input -->
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
    </script>
</x-layouts>
