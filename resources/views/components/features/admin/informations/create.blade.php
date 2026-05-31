<x-layout-admin title="Buat Informasi & Pengumuman Baru">
    <div class="mb-6">
        <a href="/admin/informations" class="text-xs font-bold text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            <i class="ph ph-arrow-left"></i> Kembali ke Daftar Informasi
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm max-w-2xl">
        <h3 class="font-bold text-slate-800 text-sm mb-5 flex items-center gap-2">
            <i class="ph-fill ph-megaphone text-blue-600"></i>
            Formulir Publikasi Informasi Baru
        </h3>

        <form action="/admin/informations" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Judul -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-500 mb-2">Judul Pengumuman</label>
                <input type="text" name="title" id="title" required placeholder="Contoh: Pengumuman Hari Libur Nasional, Perubahan Jam Kerja..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                    value="{{ old('title') }}">
                @error('title')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten -->
            <div>
                <label for="content" class="block text-xs font-bold text-slate-500 mb-2">Isi Pengumuman / Detail Informasi</label>
                <textarea name="content" id="content" rows="6" required placeholder="Tuliskan detail informasi di sini..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lampiran Berkas -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">Lampiran Dokumen / Gambar (Opsional)</label>
                <div class="relative border border-dashed border-slate-350 rounded-xl p-6 text-center bg-slate-50 hover:bg-slate-100 transition-colors">
                    <input type="file" name="attachment" id="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="space-y-1">
                        <i class="ph ph-upload-simple text-slate-400 text-2xl block"></i>
                        <p id="file-name-label" class="text-xs text-slate-500 font-semibold truncate">
                            Pilih file PDF, PNG, JPG, JPEG (Max 2MB)
                        </p>
                    </div>
                </div>
                @error('attachment')
                    <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-3 pt-3 border-t border-slate-50">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-3 text-xs font-bold shadow-md shadow-blue-500/10 active:scale-[0.98] transition-all flex items-center gap-1.5 cursor-pointer">
                    Publikasikan Informasi
                </button>
                <a href="/admin/informations"
                    class="border border-slate-200 hover:bg-slate-50 text-slate-650 rounded-xl px-6 py-3 text-xs font-bold transition-all flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Script to show file name on input & button spinner -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File input label
            document.getElementById('attachment')?.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name;
                const label = document.getElementById('file-name-label');
                if (label && fileName) {
                    label.textContent = fileName;
                    label.classList.remove('text-slate-500');
                    label.classList.add('text-blue-600');
                }
            });

            // Submit loading spinner
            document.querySelector('form')?.addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mempublikasikan...
                    `;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            });
        });
    </script>
</x-layout-admin>
