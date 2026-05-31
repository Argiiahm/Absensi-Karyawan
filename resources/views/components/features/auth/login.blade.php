<x-layout-attedance>
    <div class="flex justify-center items-center min-h-screen px-5 bg-slate-50">
        <div class="w-full max-w-sm">

            <!-- Header -->
            <div class="flex flex-col items-center mb-10">
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Selamat Datang!
                </h1>
                <p class="text-base text-slate-500 text-center mt-2">
                    Selamat bekerja & selamat beraktivitas!
                </p>
            </div>

            <!-- Card -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl p-4 mb-6">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat Email
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-xl text-slate-400"></i>
                        </span>

                        <input type="email" name="email" id="email" required placeholder="name@company.com"
                            value="{{ old('email') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="text-sm font-semibold text-slate-700">
                            Password
                        </label>

                        <a href="/forgot-password" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                            Lupa Password?
                        </a>
                    </div>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-lock-simple text-xl text-slate-400"></i>
                        </span>

                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-800 placeholder-slate-400">

                        <button type="button" onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <i id="password-toggle-icon" class="ph ph-eye text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" id="login-btn"
                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-base shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 active:scale-[0.98] transition">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500">
                    Belum punya akun?
                    <a href="/register" class="font-bold text-blue-600 hover:text-blue-700">
                        Daftar di sini
                    </a>
                </p>

                <p class="text-xs text-slate-400 mt-6">
                    &copy; 2026 AbsenKita. All rights reserved.
                </p>
            </div>

        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('password-toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'ph ph-eye-slash text-xl';
            } else {
                passwordInput.type = 'password';
                icon.className = 'ph ph-eye text-xl';
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.getElementById('login-btn');
            if (btn) {
                btn.innerHTML = `<span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses Masuk...
                </span>`;
                setTimeout(() => { btn.disabled = true; }, 10);
            }
        });
    </script>
</x-layout-attedance>
