<x-layouts>
    <div x-data="appData()" class="h-full flex flex-col w-full relative bg-gray-50 text-slate-800"
         @alpine:initialized="$watch('tab', value => setTimeout(() => lucide.createIcons(), 10))">
         
        <!-- MAIN CONTENT AREA (Scrollable) -->
        <div class="flex-1 overflow-y-auto pb-24 relative no-scrollbar">

            <!-- ===================== -->
            <!-- VIEW: BERANDA         -->
            <!-- ===================== -->
            <div x-show="tab === 'beranda' && activeView === 'main'" class="relative" x-transition.opacity>
                <!-- Blue Header -->
                <div class="bg-blue-600 text-white rounded-b-3xl px-6 pt-10 pb-20 relative">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-xl font-bold flex items-center gap-2">
                                Halo, Andi Setiawan <span class="text-2xl">👋</span>
                            </h1>
                            <p class="text-blue-100 text-sm mt-1">Selamat pagi! Semangat bekerja hari ini.</p>
                        </div>
                        <button class="bg-blue-500/50 p-2 rounded-full relative">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1.5 right-2 w-2 h-2 bg-red-500 rounded-full border border-blue-600"></span>
                        </button>
                    </div>
                </div>

                <!-- Clock & Status Card -->
                <div class="px-5 -mt-14 relative z-10">
                    <div class="bg-white rounded-2xl p-5 shadow-lg border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium" x-text="currentDate"></p>
                            <h2 class="text-4xl font-bold text-slate-800 mt-1 tracking-tight" x-text="currentTime"></h2>
                            <p class="text-xs font-semibold text-emerald-600 mt-2 bg-emerald-50 inline-block px-2 py-1 rounded-md">Sudah Absen Masuk</p>
                        </div>
                        <!-- Illustration Placeholder -->
                        <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center">
                            <i data-lucide="laptop" class="w-10 h-10 text-blue-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Hari Ini -->
                <div class="px-5 mt-6">
                    <h3 class="font-bold text-slate-800 mb-3">Ringkasan Hari Ini</h3>
                    <div class="space-y-3">
                        <!-- Masuk -->
                        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                                    <i data-lucide="log-in" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Absen Masuk</p>
                                    <p class="text-xs text-slate-500">09:41 WIB</p>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Tepat Waktu</span>
                        </div>
                        <!-- Pulang -->
                        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Absen Pulang</p>
                                    <p class="text-xs text-slate-500">Belum absen pulang</p>
                                </div>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Menu Utama -->
                <div class="px-5 mt-6 mb-8">
                    <h3 class="font-bold text-slate-800 mb-3">Menu Utama</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <button @click="openAbsenView('masuk')" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="scan-face" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Absen</span>
                        </button>
                        <button @click="tab = 'riwayat'" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Riwayat</span>
                        </button>
                        <button @click="tab = 'statistik'" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Statistik</span>
                        </button>
                        <button @click="tab = 'solat'" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="moon" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Absen Solat</span>
                        </button>
                        <button class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="bell" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Notifikasi</span>
                        </button>
                        <button @click="tab = 'profil'" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm hover:bg-slate-50 transition">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="user" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-medium text-slate-700">Profil</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- VIEW: ABSEN MAP       -->
            <!-- ===================== -->
            <div x-show="activeView === 'absen_map'" class="bg-white min-h-full flex flex-col" style="display: none;" x-transition>
                <!-- Header -->
                <div class="bg-blue-600 text-white px-5 py-4 flex items-center gap-3">
                    <button @click="activeView = 'main'" class="p-1"><i data-lucide="arrow-left" class="w-6 h-6"></i></button>
                    <h2 class="text-lg font-semibold" x-text="absenType === 'solat' ? 'Absen Solat ' + solatName : 'Absen ' + (absenType === 'masuk' ? 'Masuk' : 'Pulang')"></h2>
                </div>
                
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2" x-text="absenType === 'solat' ? 'Absen Solat ' + solatName : 'Absen ' + (absenType === 'masuk' ? 'Masuk' : 'Pulang')"></h3>
                    <p class="text-sm text-slate-500 mb-6">Pastikan Anda berada di lokasi <span x-text="absenType === 'solat' ? 'masjid/musala' : 'kantor'"></span> dalam radius yang ditentukan (Maksimal 50 meter).</p>

                    <!-- Map Container -->
                    <div class="bg-slate-200 rounded-2xl h-64 w-full relative overflow-hidden mb-6 flex items-center justify-center border border-slate-300">
                        <!-- Fake Map Background -->
                        <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cartographer.png')]"></div>
                        
                        <!-- Radius Circle -->
                        <div class="w-48 h-48 bg-blue-500/20 rounded-full absolute flex items-center justify-center border border-blue-500/30">
                            <!-- Pin -->
                            <div class="relative flex flex-col items-center">
                                <div class="bg-blue-600 text-white p-2 rounded-full shadow-lg z-10">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div class="w-2 h-2 bg-blue-800 rounded-full mt-1"></div>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 bg-white/90 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold text-slate-700">
                            Titik Pusat<br><span class="text-slate-500 font-normal">Radius 50 meter</span>
                        </div>
                    </div>

                    <!-- Location Status Box -->
                    <div class="border rounded-xl p-4 flex items-center justify-between mb-6" 
                         :class="userDistance <= 50 ? 'border-emerald-200 bg-emerald-50' : 'border-red-200 bg-red-50'">
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 mt-0.5" :class="userDistance <= 50 ? 'text-emerald-600' : 'text-red-600'"></i>
                            <div>
                                <h4 class="font-bold text-sm" :class="userDistance <= 50 ? 'text-emerald-800' : 'text-red-800'">Lokasi Anda</h4>
                                <p class="text-xs mt-1" :class="userDistance <= 50 ? 'text-emerald-600' : 'text-red-600'" x-text="userDistance <= 50 ? 'Dalam Radius' : 'Di Luar Radius'"></p>
                                <p class="text-xs text-slate-500 mt-1">Jarak ke lokasi: <strong x-text="userDistance + ' meter'"></strong></p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="userDistance <= 50 ? 'bg-emerald-200 text-emerald-700' : 'bg-red-200 text-red-700'">
                            <i :data-lucide="userDistance <= 50 ? 'check' : 'x'" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="mt-auto space-y-3">
                        <button @click="randomizeDistance()" class="w-full py-3 bg-slate-100 text-slate-600 font-semibold rounded-xl text-sm border border-slate-200 hover:bg-slate-200 transition">
                            <i data-lucide="refresh-cw" class="w-4 h-4 inline-block mr-1 mb-0.5"></i> Refresh Lokasi (Simulasi)
                        </button>

                        <button @click="proceedFromMap()" class="w-full py-3.5 rounded-xl font-bold text-white transition flex items-center justify-center gap-2"
                                :class="userDistance <= 50 ? 'bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-200' : 'bg-slate-300 cursor-not-allowed'">
                            <i data-lucide="camera" class="w-5 h-5"></i> Lanjutkan ke Selfie
                        </button>
                        
                        <p class="text-xs text-center text-slate-500 flex items-center justify-center gap-1">
                            <i data-lucide="info" class="w-3.5 h-3.5"></i> Pastikan GPS aktif untuk akurasi lokasi
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- VIEW: ABSEN SELFIE    -->
            <!-- ===================== -->
            <div x-show="activeView === 'absen_selfie'" class="bg-white min-h-full flex flex-col" style="display: none;" x-transition>
                <div class="bg-blue-600 text-white px-5 py-4 flex items-center gap-3">
                    <button @click="activeView = 'absen_map'" class="p-1"><i data-lucide="arrow-left" class="w-6 h-6"></i></button>
                    <h2 class="text-lg font-semibold">Selfie Kehadiran</h2>
                </div>
                
                <div class="p-5 flex-1 flex flex-col items-center">
                    <p class="text-slate-600 text-sm text-center mb-8 mt-4">Ambil selfie Anda untuk verifikasi kehadiran</p>

                    <!-- Camera UI Placeholder -->
                    <div class="relative w-64 h-64 rounded-full border-4 border-dashed border-emerald-500 p-2 mb-8">
                        <div class="w-full h-full bg-slate-200 rounded-full overflow-hidden relative">
                            <!-- Mock User Image -->
                            <img src="https://i.pravatar.cc/300?img=11" alt="Selfie" class="w-full h-full object-cover">
                            <!-- Face Guide -->
                            <div class="absolute inset-0 border-[8px] border-white/20 rounded-full pointer-events-none"></div>
                        </div>
                    </div>

                    <div class="space-y-3 w-full max-w-xs mb-auto">
                        <p class="text-sm text-slate-600 flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Pastikan wajah terlihat jelas</p>
                        <p class="text-sm text-slate-600 flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Jangan memakai kacamata hitam</p>
                        <p class="text-sm text-slate-600 flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Pastikan pencahayaan cukup</p>
                    </div>

                    <!-- Camera Controls -->
                    <div class="w-full flex items-center justify-between px-6 mt-8">
                        <button class="p-3 bg-slate-100 rounded-full text-slate-600"><i data-lucide="image" class="w-6 h-6"></i></button>
                        <button @click="submitAbsen()" class="w-20 h-20 bg-blue-600 rounded-full border-4 border-blue-100 flex items-center justify-center shadow-lg shadow-blue-200 transition transform active:scale-95">
                            <div class="w-16 h-16 rounded-full border-2 border-white"></div>
                        </button>
                        <button class="p-3 bg-slate-100 rounded-full text-slate-600"><i data-lucide="refresh-ccw" class="w-6 h-6"></i></button>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- VIEW: ABSEN BERHASIL  -->
            <!-- ===================== -->
            <div x-show="activeView === 'absen_berhasil'" class="bg-white min-h-full flex flex-col" style="display: none;" x-transition.duration.500ms>
                <div class="bg-blue-600 text-white px-5 py-4 flex items-center justify-center">
                    <h2 class="text-lg font-semibold">Status Absensi</h2>
                </div>
                
                <div class="p-6 flex-1 flex flex-col items-center mt-10">
                    <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mb-6">
                        <i data-lucide="check-circle" class="w-14 h-14"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2 text-center">Absen Berhasil!</h2>
                    <p class="text-slate-500 text-center mb-8">Kehadiran Anda berhasil dicatat.</p>

                    <div class="w-full bg-slate-50 rounded-2xl border border-slate-100 p-5 space-y-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="calendar" class="w-5 h-5 text-slate-400 mt-0.5"></i>
                            <div>
                                <p class="text-xs text-slate-500">Tanggal</p>
                                <p class="text-sm font-semibold text-slate-800" x-text="currentDate"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="clock" class="w-5 h-5 text-slate-400 mt-0.5"></i>
                            <div>
                                <p class="text-xs text-slate-500">Waktu</p>
                                <p class="text-sm font-semibold text-slate-800" x-text="currentTime + ' WIB'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 mt-0.5"></i>
                            <div>
                                <p class="text-xs text-slate-500">Lokasi</p>
                                <p class="text-sm font-semibold text-slate-800">Kantor Pusat</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="crosshair" class="w-5 h-5 text-slate-400 mt-0.5"></i>
                            <div>
                                <p class="text-xs text-slate-500">Jarak</p>
                                <p class="text-sm font-semibold text-slate-800" x-text="userDistance + ' meter dalam radius'"></p>
                            </div>
                        </div>
                    </div>

                    <button @click="activeView = 'main'" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold mt-auto shadow-lg shadow-blue-200">
                        Kembali ke Beranda
                    </button>
                </div>
            </div>

            <!-- ===================== -->
            <!-- TAB: RIWAYAT          -->
            <!-- ===================== -->
            <div x-show="tab === 'riwayat' && activeView === 'main'" class="bg-white min-h-full" style="display: none;" x-transition.opacity>
                <div class="bg-blue-600 text-white px-5 pt-10 pb-6 rounded-b-3xl">
                    <h2 class="text-xl font-bold text-center">Riwayat Absensi</h2>
                </div>
                
                <div class="p-5">
                    <!-- Date Selector -->
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl p-3 mb-6">
                        <button><i data-lucide="chevron-left" class="w-5 h-5 text-slate-600"></i></button>
                        <span class="font-bold text-slate-800">Mei 2024</span>
                        <button><i data-lucide="calendar" class="w-5 h-5 text-slate-600"></i></button>
                    </div>

                    <!-- History List -->
                    <div class="space-y-6">
                        <!-- Day 1 -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 mb-3" x-text="currentDate"></h4>
                            <div class="space-y-3 relative before:absolute before:inset-y-4 before:left-[19px] before:w-0.5 before:bg-slate-200">
                                <div class="flex gap-4 relative z-10">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center border-4 border-white shrink-0">
                                        <i data-lucide="log-in" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 bg-white border border-slate-100 p-3 rounded-xl shadow-sm">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="font-bold text-slate-800 text-sm">Absen Masuk</p>
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tepat Waktu</span>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium">09:41 WIB</p>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Kantor Pusat (25 meter)</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 relative z-10">
                                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center border-4 border-white shrink-0">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 bg-white border border-slate-100 p-3 rounded-xl shadow-sm">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="font-bold text-slate-800 text-sm">Absen Pulang</p>
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tepat Waktu</span>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium">18:02 WIB</p>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Kantor Pusat (30 meter)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Day 2 -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 mb-3">Rabu, 15 Mei 2024</h4>
                            <div class="space-y-3 relative before:absolute before:inset-y-4 before:left-[19px] before:w-0.5 before:bg-slate-200">
                                <div class="flex gap-4 relative z-10">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center border-4 border-white shrink-0">
                                        <i data-lucide="log-in" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1 bg-white border border-slate-100 p-3 rounded-xl shadow-sm">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="font-bold text-slate-800 text-sm">Absen Masuk</p>
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tepat Waktu</span>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium">08:55 WIB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- TAB: STATISTIK        -->
            <!-- ===================== -->
            <div x-show="tab === 'statistik' && activeView === 'main'" class="bg-white min-h-full" style="display: none;" x-transition.opacity>
                <div class="bg-blue-600 text-white px-5 pt-10 pb-6 rounded-b-3xl">
                    <h2 class="text-xl font-bold text-center">Statistik</h2>
                </div>
                
                <div class="p-5">
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl p-3 mb-6">
                        <button><i data-lucide="chevron-left" class="w-5 h-5 text-slate-600"></i></button>
                        <span class="font-bold text-slate-800">Mei 2024</span>
                        <button><i data-lucide="calendar" class="w-5 h-5 text-slate-600"></i></button>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-3 gap-3 mb-8">
                        <div class="bg-blue-50 border border-blue-100 p-3 rounded-xl text-center">
                            <p class="text-[10px] font-bold text-blue-600 mb-1 uppercase">Total Hadir</p>
                            <p class="text-2xl font-bold text-blue-800">22</p>
                            <p class="text-[10px] text-blue-500">Hari</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-xl text-center">
                            <p class="text-[10px] font-bold text-emerald-600 mb-1 uppercase">Tepat Waktu</p>
                            <p class="text-2xl font-bold text-emerald-800">18</p>
                            <p class="text-[10px] text-emerald-500">Hari</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-100 p-3 rounded-xl text-center">
                            <p class="text-[10px] font-bold text-orange-600 mb-1 uppercase">Terlambat</p>
                            <p class="text-2xl font-bold text-orange-800">4</p>
                            <p class="text-[10px] text-orange-500">Hari</p>
                        </div>
                    </div>

                    <!-- Donut Chart (Simulated) -->
                    <div class="bg-white border border-slate-100 shadow-sm p-5 rounded-2xl mb-6 text-center">
                        <h3 class="font-bold text-slate-800 mb-4">Persentase Kehadiran</h3>
                        <div class="relative w-40 h-40 mx-auto">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" fill="transparent" stroke="#f1f5f9" stroke-width="12"></circle>
                                <circle cx="50" cy="50" r="40" fill="transparent" stroke="#2563eb" stroke-width="12" stroke-dasharray="251.2" stroke-dashoffset="22.6" class="transition-all duration-1000"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-slate-800">91%</span>
                                <span class="text-xs text-slate-500 font-medium">Kehadiran</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bar Chart (Simulated) -->
                    <div class="bg-white border border-slate-100 shadow-sm p-5 rounded-2xl">
                        <h3 class="font-bold text-slate-800 mb-4">Keterlambatan (Per Minggu)</h3>
                        <div class="flex items-end justify-between h-32 mt-4 px-2">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs text-slate-400 font-bold">1</span>
                                <div class="w-8 bg-blue-500 rounded-t-md h-8 relative group">
                                    <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100">1</div>
                                </div>
                                <span class="text-[10px] text-slate-500">Minggu 1</span>
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs text-slate-400 font-bold">2</span>
                                <div class="w-8 bg-blue-500 rounded-t-md h-16 relative group">
                                    <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100">2</div>
                                </div>
                                <span class="text-[10px] text-slate-500">Minggu 2</span>
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs text-slate-400 font-bold">1</span>
                                <div class="w-8 bg-blue-500 rounded-t-md h-8 relative group">
                                    <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100">1</div>
                                </div>
                                <span class="text-[10px] text-slate-500">Minggu 3</span>
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs text-slate-400 font-bold">0</span>
                                <div class="w-8 bg-slate-200 rounded-t-md h-1 relative group"></div>
                                <span class="text-[10px] text-slate-500">Minggu 4</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- TAB: ABSEN SOLAT      -->
            <!-- ===================== -->
            <div x-show="tab === 'solat' && activeView === 'main'" class="bg-white min-h-full" style="display: none;" x-transition.opacity>
                <div class="bg-blue-600 text-white px-5 pt-10 pb-20 rounded-b-3xl relative">
                    <h2 class="text-xl font-bold text-center">Absen Solat</h2>
                    <p class="text-blue-100 text-sm text-center mt-1">Laksanakan ibadah tepat waktu</p>
                </div>
                
                <div class="px-5 -mt-10 relative z-10 mb-6">
                    <div class="bg-white border border-slate-100 shadow-lg rounded-2xl p-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-bold mb-1" x-text="currentDate"></p>
                            <p class="text-sm font-semibold text-slate-800"><i data-lucide="map-pin" class="w-3.5 h-3.5 inline text-blue-500"></i> Kantor Pusat</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-5 h-5 text-slate-400"></i>
                    </div>
                </div>

                <div class="px-5 space-y-3 pb-8">
                    <!-- Subuh -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between bg-white shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center">
                                <i data-lucide="sunrise" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Subuh</h4>
                                <p class="text-xs text-slate-500">04:38</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full">Belum Absen</span>
                    </div>

                    <!-- Zuhur -->
                    <div class="border border-blue-200 rounded-xl p-4 flex items-center justify-between bg-blue-50/50 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                                <i data-lucide="sun" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Zuhur</h4>
                                <p class="text-xs text-slate-500">12:05</p>
                            </div>
                        </div>
                        <button @click="openAbsenView('solat', 'Zuhur')" class="text-xs font-bold text-white bg-blue-600 px-4 py-2 rounded-full shadow-md hover:bg-blue-700 transition">
                            Absen
                        </button>
                    </div>

                    <!-- Asar -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between bg-white shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center">
                                <i data-lucide="sun-dim" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Asar</h4>
                                <p class="text-xs text-slate-500">15:28</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full">Belum Absen</span>
                    </div>

                    <!-- Maghrib -->
                    <div class="border border-emerald-200 rounded-xl p-4 flex items-center justify-between bg-white shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-full flex items-center justify-center">
                                <i data-lucide="sunset" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Maghrib</h4>
                                <p class="text-xs text-slate-500">18:10</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Selesai</span>
                    </div>

                    <!-- Isya -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between bg-white shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-800 text-blue-300 rounded-full flex items-center justify-center">
                                <i data-lucide="moon" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Isya</h4>
                                <p class="text-xs text-slate-500">19:20</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full">Belum Absen</span>
                    </div>
                </div>
            </div>

            <!-- ===================== -->
            <!-- TAB: PROFIL           -->
            <!-- ===================== -->
            <div x-show="tab === 'profil' && activeView === 'main'" class="bg-white min-h-full" style="display: none;" x-transition.opacity>
                <div class="bg-blue-600 text-white px-5 pt-10 pb-20 rounded-b-3xl">
                    <h2 class="text-xl font-bold text-center">Profil</h2>
                </div>
                
                <div class="px-5 -mt-12 relative z-10">
                    <div class="bg-white rounded-2xl p-5 shadow-lg border border-slate-100 flex items-center gap-4 mb-6">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Profile" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Andi Setiawan</h3>
                            <p class="text-sm text-slate-500">Karyawan</p>
                            <p class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded inline-block mt-1">ID: KRP00123</p>
                        </div>
                    </div>

                    <div class="space-y-2 bg-white rounded-2xl border border-slate-100 p-2 shadow-sm">
                        <button class="w-full flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center"><i data-lucide="user" class="w-4 h-4"></i></div>
                                <span class="text-sm font-semibold text-slate-700">Data Diri</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center"><i data-lucide="settings" class="w-4 h-4"></i></div>
                                <span class="text-sm font-semibold text-slate-700">Pengaturan</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center"><i data-lucide="help-circle" class="w-4 h-4"></i></div>
                                <span class="text-sm font-semibold text-slate-700">Bantuan</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        </button>
                        <div class="h-px bg-slate-100 my-2 mx-3"></div>
                        <button class="w-full flex items-center justify-between p-3 hover:bg-red-50 rounded-xl transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-red-50 text-red-500 rounded-full flex items-center justify-center group-hover:bg-red-100 transition"><i data-lucide="log-out" class="w-4 h-4"></i></div>
                                <span class="text-sm font-semibold text-red-600">Keluar</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===================== -->
        <!-- BOTTOM NAVIGATION     -->
        <!-- ===================== -->
        <div x-show="activeView === 'main'" class="absolute bottom-0 inset-x-0 bg-white border-t border-slate-200 px-6 py-2 pb-5 flex justify-between items-center z-50 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
            <button @click="tab = 'beranda'" class="flex flex-col items-center p-2 w-16" :class="tab === 'beranda' ? 'text-blue-600' : 'text-slate-400'">
                <i data-lucide="home" class="w-6 h-6 mb-1" :class="tab === 'beranda' ? 'fill-blue-100' : ''"></i>
                <span class="text-[10px] font-semibold">Beranda</span>
            </button>
            <button @click="tab = 'riwayat'" class="flex flex-col items-center p-2 w-16" :class="tab === 'riwayat' ? 'text-blue-600' : 'text-slate-400'">
                <i data-lucide="clock" class="w-6 h-6 mb-1" :class="tab === 'riwayat' ? 'fill-blue-100' : ''"></i>
                <span class="text-[10px] font-semibold">Riwayat</span>
            </button>
            <button @click="tab = 'solat'" class="flex flex-col items-center p-2 w-16" :class="tab === 'solat' ? 'text-blue-600' : 'text-slate-400'">
                <i data-lucide="moon" class="w-6 h-6 mb-1" :class="tab === 'solat' ? 'fill-blue-100' : ''"></i>
                <span class="text-[10px] font-semibold">Absen Solat</span>
            </button>
            <button @click="tab = 'profil'" class="flex flex-col items-center p-2 w-16" :class="tab === 'profil' ? 'text-blue-600' : 'text-slate-400'">
                <i data-lucide="user" class="w-6 h-6 mb-1" :class="tab === 'profil' ? 'fill-blue-100' : ''"></i>
                <span class="text-[10px] font-semibold">Profil</span>
            </button>
        </div>

    </div>
</x-layouts>