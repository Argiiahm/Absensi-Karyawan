<x-layout-admin title="Manajemen Pengajuan & Laporan Karyawan">
    <!-- Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm rounded-2xl p-4 mb-6 flex items-center gap-2">
            <i class="ph-fill ph-check-circle text-emerald-600 text-xl"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-100 text-rose-800 text-sm rounded-2xl p-4 mb-6 space-y-1">
            <div class="flex items-center gap-2 font-bold text-rose-900">
                <i class="ph-fill ph-warning-circle text-rose-600 text-xl"></i>
                <span>Gagal Melakukan Aksi:</span>
            </div>
            <ul class="list-disc list-inside pl-1 text-xs text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-8 shadow-sm">
        <form method="GET" action="/admin/submissions" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search input -->
            <div>
                <label for="search" class="block text-xs font-bold text-slate-500 mb-2">Nama Karyawan</label>
                <div class="relative">
                    <input type="text" name="search" id="search" placeholder="Cari nama..."
                        value="{{ request('search') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                    <i class="ph ph-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <!-- Type filter -->
            <div>
                <label for="type" class="block text-xs font-bold text-slate-500 mb-2">Tipe</label>
                <select name="type" id="type"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                    <option value="">Semua Tipe</option>
                    <option value="pengajuan" {{ request('type') === 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                    <option value="laporan" {{ request('type') === 'laporan' ? 'selected' : '' }}>Laporan</option>
                </select>
            </div>

            <!-- Status filter -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-500 mb-2">Status</label>
                <select name="status" id="status"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2.5">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 text-sm font-bold shadow-sm transition-all cursor-pointer">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'type', 'status']))
                    <a href="/admin/submissions"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl px-4 py-2.5 text-sm font-bold transition-all flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Karyawan</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Judul / Perihal</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Lampiran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                    @forelse($submissions as $sub)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Karyawan Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold uppercase shrink-0">
                                        {{ substr($sub->user->name ?? 'K', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 leading-none mb-1">{{ $sub->user->name ?? 'Karyawan' }}</p>
                                        <p class="text-[10px] text-slate-400 font-semibold">{{ $sub->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Tipe -->
                            <td class="px-6 py-4">
                                @if($sub->type === 'pengajuan')
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider border bg-indigo-50 text-indigo-600 border-indigo-100">
                                        Pengajuan
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider border bg-orange-50 text-orange-600 border-orange-100">
                                        Laporan
                                    </span>
                                @endif
                            </td>

                            <!-- Judul -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800">{{ $sub->title }}</p>
                                    <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Dikirim: {{ $sub->created_at->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </td>

                            <!-- Keterangan -->
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-xs line-clamp-2 text-slate-650" title="{{ $sub->description }}">{{ $sub->description }}</p>
                            </td>

                            <!-- Lampiran -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sub->attachment_path)
                                    <a href="{{ $sub->attachment_path }}" target="_blank"
                                        class="text-xs text-blue-600 hover:text-blue-700 font-bold inline-flex items-center gap-1">
                                        <i class="ph ph-file-text text-base"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">-</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sub->status === 'pending')
                                    <span class="text-[10px] bg-amber-50 text-amber-600 border border-amber-100 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @elseif($sub->status === 'approved')
                                    <div class="space-y-0.5">
                                        <span class="text-[10px] bg-emerald-50 text-emerald-650 border border-emerald-100 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui / ACC
                                        </span>
                                        <p class="text-[9px] text-slate-400">Oleh: {{ $sub->approver->name ?? 'Admin' }}</p>
                                    </div>
                                @else
                                    <div class="space-y-0.5">
                                        <span class="text-[10px] bg-rose-50 text-rose-600 border border-rose-100 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                        </span>
                                        <p class="text-[9px] text-slate-400">Oleh: {{ $sub->approver->name ?? 'Admin' }}</p>
                                        @if($sub->rejection_reason)
                                            <p class="text-[9px] text-rose-550 max-w-[150px] truncate" title="{{ $sub->rejection_reason }}">Ket: {{ $sub->rejection_reason }}</p>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if($sub->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Approve form -->
                                        <form action="/admin/submissions/{{ $sub->id }}/approve" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg px-3 py-1.5 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-check"></i> ACC
                                            </button>
                                        </form>
                                        <!-- Reject button (triggers JS modal) -->
                                        <button type="button"
                                            onclick="openRejectModal({{ $sub->id }}, '{{ addslashes($sub->user->name ?? 'Karyawan') }}', '{{ addslashes($sub->title) }}')"
                                            class="bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg px-3 py-1.5 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                            <i class="ph ph-x"></i> Tolak
                                        </button>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <i class="ph ph-chat-centered-text text-2xl"></i>
                                </div>
                                <p class="font-bold text-slate-700 text-sm">Tidak Ada Data</p>
                                <p class="text-xs text-slate-400 mt-1">Belum ada pengajuan atau laporan karyawan sesuai filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination footer -->
        @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 mx-4 shadow-xl border border-slate-150 transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <h3 class="font-bold text-slate-800 text-base">Tolak Pengajuan Karyawan</h3>
                <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-700 transition-colors p-1 rounded-lg hover:bg-slate-50">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
            
            <form id="reject-form" method="POST" class="space-y-4">
                @csrf
                <div>
                    <p class="text-xs text-slate-500 font-medium">Anda akan menolak pengajuan:</p>
                    <p id="reject-item-title" class="text-sm font-bold text-slate-800 mt-1"></p>
                    <p class="text-xs text-slate-450 mt-0.5">Dikirim oleh: <span id="reject-user-name" class="font-semibold text-slate-700"></span></p>
                </div>

                <div>
                    <label for="rejection_reason" class="block text-xs font-bold text-slate-500 mb-2">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" required placeholder="Tuliskan alasan penolakan pengajuan ini..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-650 rounded-xl text-xs font-bold transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all cursor-pointer">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal script -->
    <script>
        function openRejectModal(subId, userName, title) {
            const modal = document.getElementById('reject-modal');
            const form = document.getElementById('reject-form');
            const nameEl = document.getElementById('reject-user-name');
            const titleEl = document.getElementById('reject-item-title');
            const textarea = document.getElementById('rejection_reason');

            if (modal && form && nameEl && titleEl) {
                form.action = `/admin/submissions/${subId}/reject`;
                nameEl.textContent = userName;
                titleEl.textContent = title;
                textarea.value = '';
                
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.classList.add('opacity-100');
                    modal.querySelector('.transform').classList.remove('scale-95');
                    modal.querySelector('.transform').classList.add('scale-100');
                }, 20);
            }
        }

        function closeRejectModal() {
            const modal = document.getElementById('reject-modal');
            if (modal) {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                modal.querySelector('.transform').classList.remove('scale-100');
                modal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 300);
            }
        }
    </script>
</x-layout-admin>
