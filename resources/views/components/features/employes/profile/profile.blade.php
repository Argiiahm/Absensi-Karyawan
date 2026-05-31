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
            <a href="#" class="flex items-center justify-between p-4 border-b border-zinc-100 hover:bg-zinc-50 transition-all">
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

    <script>
        document.getElementById('logout-form').addEventListener('submit', function () {
            const btn = document.getElementById('logout-btn');
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg> Keluar...`;
            btn.disabled = true;
        });
    </script>
</x-layouts>
