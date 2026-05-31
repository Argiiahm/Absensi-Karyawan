<x-layout-admin title="Tambah Karyawan Baru">
    <div class="">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 md:p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <a href="/admin/employees" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                    <i class="ph ph-arrow-left text-lg"></i>
                </a>
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Tambah Karyawan Baru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Isi data karyawan untuk menambahkan ke sistem absensi.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-xs font-semibold rounded-xl p-4 mb-6">
                    <ul class="space-y-1 list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/employees" method="POST" id="create-employee-form" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="budi@company.com"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white">
                        <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                        placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <!-- Password Confirm -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required
                        placeholder="Ulangi password"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <a href="/admin/employees"
                        class="flex-1 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold text-center hover:bg-slate-50 transition-all">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i class="ph ph-plus-circle"></i>
                        Tambah Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('create-employee-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            btn.innerHTML = `<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg> Menyimpan...`;
            setTimeout(() => { btn.disabled = true; }, 10);
        });
    </script>
</x-layout-admin>
