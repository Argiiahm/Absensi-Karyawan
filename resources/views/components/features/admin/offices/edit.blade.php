<x-layout-admin title="Edit Lokasi Kantor">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <div class="">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 md:p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <a href="/admin/offices" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                    <i class="ph ph-arrow-left text-lg"></i>
                </a>
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Edit Lokasi Kantor</h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $office->name }} — perbarui data koordinat dan radius.</p>
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

            <!-- Interactive Map -->
            <div id="office-map" class="w-full h-56 rounded-xl border border-slate-200 mb-5 overflow-hidden"></div>
            <p class="text-[10px] text-slate-400 text-center mb-5 font-medium">
                <i class="ph ph-info"></i> Klik pada peta untuk mengubah koordinat kantor.
            </p>

            <form action="/admin/offices/{{ $office->id }}" method="POST" id="edit-office-form" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kantor <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $office->name) }}" required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Latitude -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Latitude <span class="text-red-500">*</span></label>
                        <input type="number" name="latitude" id="lat-input" value="{{ old('latitude', $office->latitude) }}" required step="any"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Longitude <span class="text-red-500">*</span></label>
                        <input type="number" name="longitude" id="lon-input" value="{{ old('longitude', $office->longitude) }}" required step="any"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>

                <!-- Radius -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Radius Geofencing (meter) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="radius" value="{{ old('radius', $office->radius) }}" required min="10" max="1000"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Jam Mulai Absen Masuk -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jam Masuk Kantor <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" value="{{ old('start_time', substr($office->start_time, 0, 5)) }}" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>

                    <!-- Jam Mulai Absen Pulang -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jam Pulang Kantor <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" value="{{ old('end_time', substr($office->end_time, 0, 5)) }}" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <a href="/admin/offices"
                        class="flex-1 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold text-center hover:bg-slate-50 transition-all">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize map centered on existing office coordinates
        const initLat = {{ $office->latitude }};
        const initLon = {{ $office->longitude }};
        const initRadius = {{ $office->radius }};

        const map = L.map('office-map').setView([initLat, initLon], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([initLat, initLon]).addTo(map);
        let circle = L.circle([initLat, initLon], {
            color: '#3b82f6',
            fillColor: '#3b82f6',
            fillOpacity: 0.12,
            radius: initRadius
        }).addTo(map);

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            document.getElementById('lat-input').value = lat.toFixed(8);
            document.getElementById('lon-input').value = lng.toFixed(8);
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
        });

        // Loading state
        document.getElementById('edit-office-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            btn.innerHTML = `<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg> Menyimpan...`;
            setTimeout(() => { btn.disabled = true; }, 10);
        });
    </script>
</x-layout-admin>
