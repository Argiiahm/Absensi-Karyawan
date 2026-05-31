<x-layouts>

    <!-- Header -->
    <div class="bg-blue-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between">
            <a href="/" class="w-10 h-10 flex items-center justify-center">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h1 class="font-semibold text-lg">
                Profile
            </h1>
            <div class="w-10"></div>
        </div>
    </div>
    <div class="px-4 -mt-5">
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
                    <span>Pembaruan Gagal:</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-rose-700 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white rounded-3xl border border-zinc-100 p-5 mb-5">
            <div class="flex items-center gap-4">
                <!-- Avatar: initial letter -->
                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-2xl shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-lg text-zinc-900">
                        {{ $user->name }}
                    </h2>
                    <p class="text-sm text-zinc-500">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Karyawan' }}
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                        {{ $user->email }}
                    </span>
                </div>
            </div>

            <!-- Biometric Badge -->
            <div class="mt-4 pt-4 border-t border-zinc-100 flex items-center justify-between">
                <span class="text-xs text-zinc-500 font-medium flex items-center gap-1.5">
                    <i class="ph ph-scan"></i> Wajah Biometrik
                </span>
                @if($user->is_face_enrolled)
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                        <i class="ph-bold ph-check"></i> Terdaftar
                    </span>
                @else
                    <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                        <i class="ph-bold ph-warning"></i> Belum Terdaftar
                    </span>
                @endif
            </div>
        </div>

        <!-- Menu -->
        <div class="bg-white rounded-3xl border border-zinc-100 overflow-hidden mb-5">
            <a href="javascript:void(0)" id="btn-data-diri" class="flex items-center justify-between p-4 border-b border-zinc-100 hover:bg-zinc-50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <i class="ph ph-user text-blue-600"></i>
                    </div>
                    <span class="font-medium">Data Diri</span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 border-b border-zinc-100 hover:bg-zinc-50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center">
                        <i class="ph ph-gear text-orange-600"></i>
                    </div>
                    <span class="font-medium">Pengaturan</span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
            <a href="/submissions" class="flex items-center justify-between p-4 hover:bg-zinc-50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center">
                        <i class="ph ph-question text-emerald-600"></i>
                    </div>
                    <span class="font-medium">Bantuan</span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
        </div>

        <!-- Logout -->
        <div class="mt-2">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" id="logout-btn"
                    class="w-full bg-red-50 text-red-600 rounded-2xl py-4 font-medium flex items-center justify-center gap-2 hover:bg-red-100 transition-all">
                    <i class="ph ph-sign-out"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Data Diri Modal / Slide-Over -->
    <div id="data-diri-modal" class="fixed inset-0 z-[9999] bg-slate-900/60 backdrop-blur-sm hidden flex items-end justify-center opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-t-3xl w-full max-w-sm p-6 transform translate-y-full transition-transform duration-300">
            <div class="flex items-center justify-between border-b border-zinc-150 pb-3 mb-5">
                <button type="button" id="close-data-diri" class="text-zinc-400 hover:text-zinc-700 transition-colors p-1 rounded-lg hover:bg-zinc-50">
                    <i class="ph ph-x text-lg"></i>
                </button>
                <h3 class="font-bold text-slate-800 text-sm">Ubah Data Diri</h3>
                <button type="submit" form="data-diri-form" id="submit-data-diri"
                    class="text-blue-600 hover:text-blue-700 text-xs font-bold transition-all px-2.5 py-1.5 rounded-lg hover:bg-blue-50/50 flex items-center gap-1 cursor-pointer">
                    Simpan
                </button>
            </div>
            
            <form id="data-diri-form" action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-500 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required placeholder="Nama Anda"
                        class="w-full bg-slate-50 border border-zinc-205 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                        value="{{ old('name', $user->name) }}">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 mb-1.5">Email</label>
                    <input type="email" name="email" id="email" required placeholder="email@contoh.com"
                        class="w-full bg-slate-50 border border-zinc-205 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                        value="{{ old('email', $user->email) }}">
                </div>

                <!-- Password Baru -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 mb-1.5">Kata Sandi Baru (Kosongkan jika tidak ingin diubah)</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                        class="w-full bg-slate-50 border border-zinc-205 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-500 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru"
                        class="w-full bg-slate-50 border border-zinc-205 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('logout-form').addEventListener('submit', function () {
            const btn = document.getElementById('logout-btn');
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-red-500 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg> Keluar...`;
            btn.disabled = true;
        });

        // Data Diri Slide-over Panel Toggle
        const openBtn = document.getElementById('btn-data-diri');
        const closeBtn = document.getElementById('close-data-diri');
        const modal = document.getElementById('data-diri-modal');
        const form = document.getElementById('data-diri-form');

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.classList.add('opacity-100');
                    modal.querySelector('.transform').classList.remove('translate-y-full');
                    modal.querySelector('.transform').classList.add('translate-y-0');
                }, 20);
            });

            const closeModalFunc = () => {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                modal.querySelector('.transform').classList.remove('translate-y-0');
                modal.querySelector('.transform').classList.add('translate-y-full');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 300);
            };

            closeBtn.addEventListener('click', closeModalFunc);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModalFunc();
                }
            });

            // Form Submit Spinner
            form?.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    `;
                    btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
                }
            });
        }
    </script>
</x-layouts>
