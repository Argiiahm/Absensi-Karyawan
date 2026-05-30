<x-layout-attedance>
    <div class="h-full flex flex-col justify-between bg-slate-50 px-6 py-8 overflow-y-auto">
        <!-- Top Section: Brand Header -->
        <div class="flex flex-col items-center mt-6">
            <!-- Animated Premium Logo Wrapper -->
            <div class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-lg shadow-blue-500/20 mb-4 transform hover:scale-105 transition-transform duration-300">
                <i class="ph ph-fingerprint text-4xl text-white"></i>
                <div class="absolute inset-0 rounded-2xl border-2 border-white/20 animate-pulse"></div>
            </div>
            
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">AbsenKita</h1>
            <p class="text-sm text-slate-500 mt-1 text-center font-medium">Sistem Absensi Karyawan Modern & Presisi</p>
        </div>

        <!-- Middle Section: Login Card & Form -->
        <div class="my-auto py-8">
            <!-- Login Form -->
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700 block">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="email" name="email" id="email" required placeholder="name@company.com" 
                            class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-xs font-semibold text-slate-700 block">Password</label>
                        <a href="/forgot-password" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••" 
                            class="w-full pl-10 pr-10 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePasswordVisibility()" class="focus:outline-none text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="password-toggle-icon" class="ph ph-eye text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" 
                        class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2 transition-all">
                    <label for="remember" class="ml-2 text-xs font-medium text-slate-600 select-none cursor-pointer">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-300 transform active:scale-[0.98]">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <!-- Bottom Section: Signup Redirect or Copyright -->
        <div class="mt-auto pt-4 text-center">
            <p class="text-xs text-slate-500 font-medium">
                Belum punya akun? 
                <a href="/register" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">Daftar di sini</a>
            </p>
            <p class="text-[10px] text-slate-400 mt-6">&copy; 2026 AbsenKita. All rights reserved.</p>
        </div>
    </div>

    <!-- Script for interactive elements (password visibility) -->
    <script>

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('password-toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'ph ph-eye-slash text-lg';
            } else {
                passwordInput.type = 'password';
                icon.className = 'ph ph-eye text-lg';
            }
        }
    </script>
</x-layout-attedance>
