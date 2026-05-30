<x-layout-attedance>
    <div class="h-full flex flex-col justify-between bg-slate-50 px-6 py-8 overflow-y-auto">
        <!-- Top Section: Brand Header -->
        <div class="flex flex-col items-center mt-6">
            <!-- Premium Logo Wrapper -->
            <div class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-lg shadow-blue-500/20 mb-4">
                <i class="ph ph-keyhole text-4xl text-white"></i>
                <div class="absolute inset-0 rounded-2xl border-2 border-white/20 animate-pulse"></div>
            </div>
            
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Lupa Password</h1>
            <p class="text-sm text-slate-500 mt-1 text-center font-medium">Atur Ulang Kata Sandi Akun Anda</p>
        </div>

        <!-- Middle Section: Reset Request Form -->
        <div class="my-auto py-8 space-y-6">
            <!-- Informational Alert -->
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-3">
                <i class="ph ph-info text-xl text-blue-600 shrink-0 mt-0.5"></i>
                <p class="text-xs text-blue-700 leading-relaxed">
                    Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan tautan (link) untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700 block">Alamat Email Terdaftar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="email" name="email" id="email" required placeholder="name@company.com" 
                            class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-300 transform active:scale-[0.98]">
                    Kirim Link Atur Ulang
                </button>
            </form>
        </div>

        <!-- Bottom Section: Back to Login -->
        <div class="mt-auto pt-4 text-center">
            <a href="/login" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                <i class="ph ph-arrow-left font-bold"></i>
                Kembali ke Halaman Masuk
            </a>
            <p class="text-[10px] text-slate-400 mt-6">&copy; 2026 AbsenKita. All rights reserved.</p>
        </div>
    </div>
</x-layout-attedance>
