<nav class="absolute bottom-0 left-0 right-0 bg-white border-t border-zinc-100">
    <div class="grid grid-cols-4 h-16">

        <a href="/"
            class="flex flex-col items-center justify-center {{ request()->is('/') ? 'text-blue-600' : 'text-zinc-500' }}">
            <i class="ph-fill ph-house text-xl"></i>
            <span class="text-[11px] mt-1 font-medium">
                Beranda
            </span>
        </a>

        <a href="/history"
            class="flex flex-col items-center justify-center {{ request()->is('history*') ? 'text-blue-600' : 'text-zinc-500' }}">
            <i class="ph ph-clock-counter-clockwise text-xl"></i>
            <span class="text-[11px] mt-1">
                Riwayat
            </span>
        </a>

        <a href="/attedance/ishoma/index"
            class="flex flex-col items-center justify-center {{ request()->is('attedance/ishoma*') ? 'text-blue-600' : 'text-zinc-500' }}">
            <i class="ph ph-moon text-xl"></i>
            <span class="text-[11px] mt-1">
                Absen Solat
            </span>
        </a>

        <a href="/profile"
            class="flex flex-col items-center justify-center {{ request()->is('profile*') ? 'text-blue-600' : 'text-zinc-500' }}">
            <i class="ph ph-user text-xl"></i>
            <span class="text-[11px] mt-1">
                Profil
            </span>
        </a>

    </div>
</nav>
