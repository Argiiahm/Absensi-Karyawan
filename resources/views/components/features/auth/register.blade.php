<x-layout-attedance>
    <div class="h-full flex flex-col justify-between bg-slate-50 px-6 py-8 overflow-y-auto">
        <!-- Top Section: Brand Header -->
        <div class="flex flex-col items-center mt-4">
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Daftar Akun</h1>
            <p class="text-xs text-slate-500 mt-1 text-center font-medium">Registrasi Karyawan Baru AbsenKita</p>
        </div>

        <!-- Middle Section: Register Form -->
        <div class="my-auto py-4">
            <form action="#" method="POST" class="space-y-4">
                @csrf

                <!-- Full Name Input -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-semibold text-slate-700 block">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-user text-lg text-slate-400"></i>
                        </span>
                        <input type="text" name="name" id="name" required placeholder="Andi Setiawan"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700 block">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="email" name="email" id="email" required placeholder="name@gmail.com"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-semibold text-slate-700 block">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple text-lg text-slate-400"></i>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password', 'pw-toggle-1')"
                                class="focus:outline-none text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="pw-toggle-1" class="ph ph-eye text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-semibold text-slate-700 block">Konfirmasi
                        Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple-open text-lg text-slate-400"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password_confirmation', 'pw-toggle-2')"
                                class="focus:outline-none text-slate-400 hover:text-slate-600 transition-colors">
                                <i id="pw-toggle-2" class="ph ph-eye text-lg"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required
                        class="mt-0.5 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2 transition-all">
                    <label for="terms"
                        class="ml-2 text-xs font-medium text-slate-600 select-none cursor-pointer leading-relaxed">
                        Saya menyetujui <a href="#" class="text-blue-600 font-bold hover:underline">Syarat &
                            Ketentuan</a> serta <a href="#"
                            class="text-blue-600 font-bold hover:underline">Kebijakan Privasi</a> perusahaan.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-300 transform active:scale-[0.98]">
                    Daftar Akun
                </button>
            </form>
        </div>

        <!-- Bottom Section: Login Redirect -->
        <div class="mt-auto pt-4 text-center">
            <p class="text-xs text-slate-500 font-medium">
                Sudah punya akun?
                <a href="/login" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">Masuk di
                    sini</a>
            </p>
            <p class="text-[10px] text-slate-400 mt-6">&copy; 2026 AbsenKita. All rights reserved.</p>
        </div>
    </div>

    <!-- Script for password visibility toggle -->
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
    </script>
</x-layout-attedance>
