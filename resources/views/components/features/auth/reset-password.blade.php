<x-layout-attedance>
    <div class="h-full flex flex-col justify-between bg-slate-50 px-6 py-8 overflow-y-auto">
        <!-- Top Section: Brand Header -->
        <div class="flex flex-col items-center mt-4">
            <!-- Premium Logo Wrapper -->
            <div class="relative flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-md shadow-blue-500/20 mb-3">
                <i class="ph ph-shield-check text-3xl text-white"></i>
            </div>
            
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Atur Ulang Password</h1>
            <p class="text-xs text-slate-500 mt-1 text-center font-medium">Buat Kata Sandi Baru yang Aman</p>
        </div>

        <!-- Middle Section: Reset Form -->
        <div class="my-auto py-4">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                
                <!-- Hidden Token Field (Standard Laravel Reset flow requirement) -->
                <input type="hidden" name="token" value="{{ request()->route('token', '') }}">

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700 block">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="email" name="email" id="email" required value="{{ request()->query('email', '') }}" placeholder="name@company.com" 
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- New Password Input -->
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-semibold text-slate-700 block">Password Baru</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••" onkeyup="checkPasswordStrength(this.value)"
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password', 'pw-toggle-1')" class="focus:outline-none text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="pw-toggle-1" class="ph ph-eye text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <!-- Password strength check container -->
                <div class="bg-slate-200/50 p-3 rounded-xl space-y-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kriteria Keamanan</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500" id="req-length">
                        <i class="ph ph-circle text-slate-400" id="icon-length"></i>
                        <span>Minimal 8 karakter</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500" id="req-number">
                        <i class="ph ph-circle text-slate-400" id="icon-number"></i>
                        <span>Mengandung angka (0-9)</span>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-semibold text-slate-700 block">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple-open text-lg text-slate-400"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" 
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password_confirmation', 'pw-toggle-2')" class="focus:outline-none text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="pw-toggle-2" class="ph ph-eye text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-300 transform active:scale-[0.98]">
                    Perbarui Password
                </button>
            </form>
        </div>

        <!-- Bottom Section: Login Redirect -->
        <div class="mt-auto pt-4 text-center">
            <a href="/login" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                <i class="ph ph-arrow-left font-bold"></i>
                Kembali ke Halaman Masuk
            </a>
            <p class="text-[10px] text-slate-400 mt-6">&copy; 2026 AbsenKita. All rights reserved.</p>
        </div>
    </div>

    <!-- Script for interactive elements (password visibility & strength checks) -->
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'ph ph-eye-slash text-lg';
            } else {
                passwordInput.type = 'password';
                icon.className = 'ph ph-eye text-lg';
            }
        }

        function checkPasswordStrength(val) {
            const reqLength = document.getElementById('req-length');
            const iconLength = document.getElementById('icon-length');
            const reqNumber = document.getElementById('req-number');
            const iconNumber = document.getElementById('icon-number');

            // 1. Length check
            if (val.length >= 8) {
                reqLength.className = "flex items-center gap-2 text-xs text-emerald-600 font-medium";
                iconLength.className = "ph-fill ph-check-circle text-emerald-500 text-sm";
            } else {
                reqLength.className = "flex items-center gap-2 text-xs text-slate-500";
                iconLength.className = "ph ph-circle text-slate-400 text-sm";
            }

            // 2. Number check
            if (/\d/.test(val)) {
                reqNumber.className = "flex items-center gap-2 text-xs text-emerald-600 font-medium";
                iconNumber.className = "ph-fill ph-check-circle text-emerald-500 text-sm";
            } else {
                reqNumber.className = "flex items-center gap-2 text-xs text-slate-500";
                iconNumber.className = "ph ph-circle text-slate-400 text-sm";
            }
        }
    </script>
</x-layout-attedance>
