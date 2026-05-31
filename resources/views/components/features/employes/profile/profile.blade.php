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
                <img src="https://i.pravatar.cc/150?img=11" alt="Profile" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <h2 class="font-bold text-lg text-zinc-900">
                        Andi Setiawan
                    </h2>
                    <p class="text-sm text-zinc-500">
                        Karyawan
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                        ID: KRP00123
                    </span>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="bg-white rounded-3xl border border-zinc-100 overflow-hidden">
            <a href="#" class="flex items-center justify-between p-4 border-b border-zinc-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <i class="ph ph-user text-blue-600"></i>
                    </div>
                    <span class="font-medium">
                        Data Diri
                    </span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 border-b border-zinc-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center">
                        <i class="ph ph-gear text-orange-600"></i>
                    </div>
                    <span class="font-medium">
                        Pengaturan
                    </span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center">
                        <i class="ph ph-question text-emerald-600"></i>
                    </div>
                    <span class="font-medium">
                        Bantuan
                    </span>
                </div>
                <i class="ph ph-caret-right text-zinc-400"></i>
            </a>
        </div>
        <!-- Logout -->
        <div class="mt-5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-red-50 text-red-600 rounded-2xl py-4 font-medium flex items-center justify-center gap-2">
                    <i class="ph ph-sign-out"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-layouts>
