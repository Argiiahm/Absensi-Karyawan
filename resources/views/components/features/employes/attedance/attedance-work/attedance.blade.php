<x-layout-attedance>
    <!-- Leaflet CSS and JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <div class="bg-white min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-5 py-4 flex items-center gap-3">
            <a href="/" class="p-1">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <h2 class="text-lg font-semibold">
                Absen {{ $type === 'masuk' ? 'Masuk' : 'Pulang' }}
            </h2>
        </div>

        <div class="p-5 flex-1 flex flex-col">
            <h3 class="text-2xl font-bold text-slate-800 mb-2">
                Validasi Lokasi (GPS)
            </h3>
            <p class="text-sm text-slate-500 mb-6">
                Pastikan Anda berada di lokasi kantor dalam radius toleransi maksimal <span id="text-office-radius">100</span> meter.
            </p>

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-xs font-semibold rounded-xl p-4 mb-6 flex items-center gap-2.5">
                    <i class="ph-bold ph-warning-circle text-lg"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            
            <!-- Interactive Map (Leaflet) -->
            <div id="map" class="rounded-2xl h-64 w-full mb-4 border border-slate-200 shadow-md relative z-10 overflow-hidden">
                <!-- Fallback Map loading screen -->
                <div id="map-loading" class="absolute inset-0 bg-slate-100 rounded-2xl flex flex-col items-center justify-center text-slate-500 z-20">
                    <div class="w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span class="text-xs font-semibold">Memuat peta lokasi...</span>
                </div>
            </div>

            <!-- Office Info Detail Bar -->
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 mb-6 flex justify-between items-center text-xs font-semibold text-slate-700">
                <span class="flex items-center gap-1.5">
                    <i class="ph-fill ph-buildings text-blue-600 text-base"></i>
                    <span id="map-office-name">Kantor Pusat</span>
                </span>
                <span class="flex items-center gap-1.5 text-slate-500">
                    Radius: <strong class="text-blue-600" id="map-office-radius">100 meter</strong>
                </span>
            </div>

            <!-- Geolocation Status Box -->
            <div id="status-card" class="border border-slate-200 bg-slate-50 rounded-xl p-4 flex items-center justify-between mb-6 transition-all duration-300">
                <div class="flex items-start gap-3">
                    <div id="status-card-icon-container" class="text-slate-500 mt-1">
                        <i class="ph-bold ph-map-pin text-xl"></i>
                    </div>
                    <div>
                        <h4 id="status-card-title" class="font-bold text-sm text-slate-750">
                            Mencari Lokasi Anda
                        </h4>
                        <p id="status-card-desc" class="text-xs mt-1 text-slate-500 font-medium">
                            Menginisialisasi modul GPS browser...
                        </p>
                        <p id="status-card-details" class="text-[10px] text-slate-400 mt-1 font-semibold">
                            Tolong izinkan akses lokasi jika ditanyakan.
                        </p>
                    </div>
                </div>
                <div id="status-badge" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center shrink-0">
                    <div class="w-4 h-4 border-2 border-slate-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            <!-- Action -->
            <div class="mt-auto space-y-3">
                <button onclick="getLocation()" id="btn-refresh"
                    class="w-full py-3 bg-slate-150 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm border border-slate-200 transition-all">
                    <i class="ph-bold ph-arrows-clockwise mr-1.5"></i>
                    Refresh Lokasi
                </button>
                <button id="btn-continue" disabled
                    class="w-full py-3.5 rounded-xl font-bold text-white bg-slate-350 cursor-not-allowed flex items-center justify-center gap-2 shadow-md transition-all duration-350">
                    <i class="ph-fill ph-camera"></i>
                    Lanjutkan ke Selfie & Liveness
                </button>
                <p class="text-xs text-center text-slate-500 flex items-center justify-center gap-1.5 font-medium">
                    <i class="ph ph-info-semibold"></i>
                    Gunakan jaringan internet yang stabil untuk akurasi GPS
                </p>
            </div>
        </div>
    </div>

    <script>
        let userLat = null;
        let userLon = null;
        let map = null;
        let userMarker = null;
        let officeMarker = null;
        let officeCircle = null;
        const btnContinue = document.getElementById('btn-continue');
        const btnRefresh = document.getElementById('btn-refresh');
        const statusCard = document.getElementById('status-card');
        const statusCardIcon = document.getElementById('status-card-icon-container');
        const statusCardTitle = document.getElementById('status-card-title');
        const statusCardDesc = document.getElementById('status-card-desc');
        const statusCardDetails = document.getElementById('status-card-details');
        const statusBadge = document.getElementById('status-badge');
        const mapOfficeName = document.getElementById('map-office-name');
        const mapOfficeRadius = document.getElementById('map-office-radius');

        function resetRefreshButton() {
            btnRefresh.disabled = false;
            btnRefresh.innerHTML = `<i class="ph-bold ph-arrows-clockwise mr-1.5"></i> Refresh Lokasi`;
            btnRefresh.className = "w-full py-3 bg-slate-150 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm border border-slate-200 transition-all";
        }

        function getLocation() {
            btnContinue.disabled = true;
            btnContinue.className = "w-full py-3.5 rounded-xl font-bold text-white bg-slate-350 cursor-not-allowed flex items-center justify-center gap-2 shadow-md transition-all duration-350";
            
            // Set loading state on refresh button
            btnRefresh.disabled = true;
            btnRefresh.innerHTML = `<span class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Tunggu sebentar...
            </span>`;
            btnRefresh.className = "w-full py-3 bg-slate-100 text-slate-400 font-semibold rounded-xl text-sm border border-slate-200 transition-all cursor-not-allowed";

            // Reset Map Loading visual overlay
            const mapLoading = document.getElementById('map-loading');
            if (mapLoading) mapLoading.classList.remove('hidden');

            statusCard.className = "border border-slate-200 bg-slate-50 rounded-xl p-4 flex items-center justify-between mb-6 transition-all duration-300";
            statusCardIcon.className = "text-slate-500 mt-1";
            statusCardIcon.innerHTML = '<i class="ph-bold ph-map-pin text-xl"></i>';
            statusCardTitle.textContent = "Mencari Lokasi Anda";
            statusCardDesc.textContent = "Mengambil koordinat satelit GPS...";
            statusCardDetails.textContent = "Pastikan GPS perangkat Anda dalam keadaan aktif.";
            statusBadge.className = "w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center shrink-0";
            statusBadge.innerHTML = '<div class="w-4 h-4 border-2 border-slate-500 border-t-transparent rounded-full animate-spin"></div>';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(checkOfficeRadius, handleGeoError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                updateUIError("GPS Tidak Didukung", "Browser Anda tidak mendukung Geolocation API.");
            }
        }

        function handleGeoError(error) {
            let msg = "Gagal mendapatkan lokasi Anda.";
            if (error.code === error.PERMISSION_DENIED) {
                msg = "Izin akses lokasi ditolak oleh pengguna.";
            } else if (error.code === error.POSITION_UNAVAILABLE) {
                msg = "Informasi lokasi tidak tersedia.";
            } else if (error.code === error.TIMEOUT) {
                msg = "Waktu pencarian lokasi habis.";
            }
            updateUIError("Error Geolocation", msg);
            resetRefreshButton();
            
            // Hide map loading overlay
            const mapLoading = document.getElementById('map-loading');
            if (mapLoading) mapLoading.classList.add('hidden');
        }

        function updateUIError(title, desc) {
            statusCard.className = "border border-red-200 bg-red-50 rounded-xl p-4 flex items-center justify-between mb-6 transition-all duration-300";
            statusCardIcon.className = "text-red-500 mt-1";
            statusCardIcon.innerHTML = '<i class="ph-bold ph-warning-circle text-xl"></i>';
            statusCardTitle.textContent = title;
            statusCardTitle.className = "font-bold text-sm text-red-800";
            statusCardDesc.textContent = desc;
            statusCardDesc.className = "text-xs mt-1 text-red-650 font-medium";
            statusCardDetails.textContent = "Silakan periksa izin lokasi dan muat ulang halaman.";
            statusBadge.className = "w-8 h-8 rounded-full bg-red-200 text-red-700 flex items-center justify-center shrink-0";
            statusBadge.innerHTML = '<i class="ph-bold ph-x text-base"></i>';
            resetRefreshButton();
            
            // Hide map loading overlay
            const mapLoading = document.getElementById('map-loading');
            if (mapLoading) mapLoading.classList.add('hidden');
        }


        async function checkOfficeRadius(position) {
            userLat = position.coords.latitude;
            userLon = position.coords.longitude;

            try {
                const response = await fetch('{{ route("api.offices.closest", [], false) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: userLat,
                        longitude: userLon
                    })
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    const officeName = data.office.name;
                    const distance = data.distance; // in meters
                    const radius = data.office.radius;
                    
                    // Enforce strict 100 meters geofencing limit
                    const maxRadius = Math.min(100, radius);
                    const withinRadius = distance <= maxRadius;

                    mapOfficeName.textContent = officeName;
                    mapOfficeRadius.textContent = maxRadius + ' meter';
                    const textOfficeRadius = document.getElementById('text-office-radius');
                    if (textOfficeRadius) {
                        textOfficeRadius.textContent = maxRadius;
                    }

                    // ===== Leaflet Map Update =====
                    const officeLat = parseFloat(data.office.latitude);
                    const officeLon = parseFloat(data.office.longitude);

                    // Remove loading overlay
                    const mapLoading = document.getElementById('map-loading');
                    if (mapLoading) mapLoading.classList.add('hidden');

                    if (!map) {
                        // Initialize Map
                        map = L.map('map').setView([userLat, userLon], 16);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
                    }

                    // Update User Marker
                    if (userMarker) {
                        userMarker.setLatLng([userLat, userLon]);
                    } else {
                        userMarker = L.marker([userLat, userLon]).addTo(map)
                            .bindPopup("<b>Lokasi Anda</b>").openPopup();
                    }

                    // Update Office Marker
                    if (officeMarker) {
                        officeMarker.setLatLng([officeLat, officeLon]);
                    } else {
                        // Custom red icon for office
                        const redIcon = L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });
                        officeMarker = L.marker([officeLat, officeLon], { icon: redIcon }).addTo(map)
                            .bindPopup(`<b>${officeName}</b>`);
                    }

                    // Update Office Geofence Circle
                    if (officeCircle) {
                        officeCircle.setLatLng([officeLat, officeLon]);
                        officeCircle.setRadius(maxRadius);
                    } else {
                        officeCircle = L.circle([officeLat, officeLon], {
                            color: withinRadius ? '#10B981' : '#F59E0B',
                            fillColor: withinRadius ? '#10B981' : '#F59E0B',
                            fillOpacity: 0.15,
                            radius: maxRadius
                        }).addTo(map);
                    }
                    
                    // Update circle color dynamically based on proximity
                    officeCircle.setStyle({
                        color: withinRadius ? '#10B981' : '#F59E0B',
                        fillColor: withinRadius ? '#10B981' : '#F59E0B'
                    });

                    // Fit Map Bounds to fit both markers
                    const group = new L.featureGroup([userMarker, officeMarker]);
                    map.fitBounds(group.getBounds().pad(0.15));
                    map.invalidateSize();

                    if (withinRadius) {
                        // Safe to proceed
                        statusCard.className = "border border-emerald-200 bg-emerald-50 rounded-xl p-4 flex items-center justify-between mb-6 transition-all duration-300";
                        statusCardIcon.className = "text-emerald-550 mt-1";
                        statusCardIcon.innerHTML = '<i class="ph-bold ph-map-pin text-xl"></i>';
                        statusCardTitle.textContent = "Dalam Jangkauan Kantor";
                        statusCardTitle.className = "font-bold text-sm text-emerald-850";
                        statusCardDesc.textContent = `Anda berada di area ${officeName}.`;
                        statusCardDesc.className = "text-xs mt-1 text-emerald-700 font-medium";
                        statusCardDetails.innerHTML = `Jarak ke kantor: <strong>${Math.round(distance)} meter</strong> (Batas: ${maxRadius}m)`;
                        statusCardDetails.className = "text-[10px] text-slate-500 mt-1 font-semibold";
                        
                        statusBadge.className = "w-8 h-8 rounded-full bg-emerald-200 text-emerald-700 flex items-center justify-center shrink-0";
                        statusBadge.innerHTML = '<i class="ph-bold ph-check text-base"></i>';

                        // Enable continue button
                        btnContinue.disabled = false;
                        btnContinue.className = "w-full py-3.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 flex items-center justify-center gap-2 shadow-md transition-all active:scale-[0.98]";
                        btnContinue.onclick = () => {
                            window.location.href = `{{ route('attendance.action', [], false) }}?type={{ $type }}&lat=${userLat}&lon=${userLon}`;
                        };
                    } else {
                        // Outside radius
                        statusCard.className = "border border-zinc-200 bg-amber-50 rounded-xl p-4 flex items-center justify-between mb-6 transition-all duration-300";
                        statusCardIcon.className = "text-amber-600 mt-1";
                        statusCardIcon.innerHTML = '<i class="ph-bold ph-warning-octagon text-xl"></i>';
                        statusCardTitle.textContent = "Di Luar Jangkauan Kantor";
                        statusCardTitle.className = "font-bold text-sm text-amber-850";
                        statusCardDesc.textContent = `Anda terdeteksi di luar area ${officeName}.`;
                        statusCardDesc.className = "text-xs mt-1 text-amber-700 font-medium";
                        statusCardDetails.innerHTML = `Jarak Anda: <strong>${Math.round(distance)} meter</strong>. Maksimal toleransi: ${maxRadius}m.`;
                        statusCardDetails.className = "text-[10px] text-slate-550 mt-1 font-semibold";

                        statusBadge.className = "w-8 h-8 rounded-full bg-amber-200 text-amber-700 flex items-center justify-center shrink-0";
                        statusBadge.innerHTML = '<i class="ph-bold ph-x text-base"></i>';

                        btnContinue.disabled = true;
                        btnContinue.className = "w-full py-3.5 rounded-xl font-bold text-white bg-slate-350 cursor-not-allowed flex items-center justify-center gap-2 shadow-md transition-all duration-350";
                    }
                    resetRefreshButton();
                } else {
                    throw new Error(data.message || "Gagal mencocokkan lokasi kantor.");
                }
            } catch (err) {
                console.error("API error:", err);
                updateUIError("Error Geofencing", err.message || "Gagal menghubungi server absensi.");
            }
        }

        // Run automatically when page is loaded
        window.addEventListener('DOMContentLoaded', getLocation);
    </script>
</x-layout-attedance>
