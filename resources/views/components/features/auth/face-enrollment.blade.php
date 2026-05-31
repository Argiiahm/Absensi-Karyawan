<x-layout-attedance>
    <div class="h-full min-h-screen flex flex-col justify-between bg-slate-50 px-6 py-8 overflow-y-auto">

        <!-- Header -->
        <div class="flex flex-col items-center mt-4">
            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-3 text-blue-600 shadow-sm">
                <i class="ph-bold ph-smiley text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pendaftaran Wajah</h1>
            <p class="text-xs text-slate-500 mt-1 text-center font-medium">Daftarkan wajah Anda untuk verifikasi absensi
                biometrik</p>
        </div>

        <!-- Middle: Camera Scanning Interface -->
        <div class="my-auto py-6 flex flex-col items-center">

            <!-- Camera Container -->
            <div id="camera-frame"
                class="relative w-64 h-64 rounded-full border-4 border-dashed border-slate-350 p-2 mb-6 transition-all duration-300">
                <div class="w-full h-full bg-slate-900 rounded-full overflow-hidden relative shadow-inner">
                    <!-- Loading overlay -->
                    <div id="loading-overlay"
                        class="absolute inset-0 bg-slate-950/80 z-20 flex flex-col items-center justify-center p-4 text-center">
                        <div
                            class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mb-3">
                        </div>
                        <p id="loading-status" class="text-xs text-blue-200 font-medium">Menginisialisasi kamera...</p>
                    </div>

                    <!-- Video Element -->
                    <video id="webcam" autoplay playsinline muted
                        class="w-full h-full object-cover scale-x-[-1]"></video>

                    <!-- Canvas for Face Landmark Overlay (Optional, but looks premium!) -->
                    <canvas id="overlay"
                        style="display: none !important;" class="hidden absolute inset-0 w-full h-full object-cover scale-x-[-1] pointer-events-none z-10"></canvas>

                    <!-- Face Guide Silhouette Overlay -->
                    <div style="display: none !important;" class="hidden absolute inset-0 z-15 pointer-events-none flex items-center justify-center">
                        <svg id="face-guide" class="w-5/6 h-5/6 text-slate-400/50 transition-all duration-300" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3">
                            <!-- Oval for face outline -->
                            <path d="M50,15 C33,15 26,30 26,50 C26,70 36,83 50,85 C64,83 74,70 74,50 C74,30 67,15 50,15 Z" />
                            <!-- Eye guide line -->
                            <line x1="33" y1="46" x2="67" y2="46" stroke-width="0.8" />
                            <!-- Nose center line -->
                            <line x1="50" y1="40" x2="50" y2="58" stroke-width="0.8" />
                            <!-- Mouth guide line -->
                            <line x1="42" y1="68" x2="58" y2="68" stroke-width="0.8" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Progress & Indicators -->
            <div class="w-full max-w-xs space-y-4">

                <!-- Status Box -->
                <div id="status-box"
                    class="bg-white border border-slate-200 rounded-xl p-3.5 flex items-center gap-3 shadow-sm transition-all duration-300">
                    <div id="status-icon"
                        class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                        <i class="ph ph-video-camera text-base"></i>
                    </div>
                    <div class="flex-1">
                        <h4 id="status-title" class="font-bold text-xs text-slate-700">Status Kamera</h4>
                        <p id="status-desc" class="text-[10px] text-slate-500 mt-0.5">Meminta izin akses kamera...</p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div id="progress-container" class="hidden space-y-2">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-blue-600">Progres Pemindaian</span>
                        <span id="progress-text" class="text-slate-650">0%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                        <div id="progress-bar"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-200 w-0">
                        </div>
                    </div>
                    <p class="text-[10px] text-center text-slate-400 font-medium">Tatap layar, posisikan wajah di dalam
                        lingkaran dan jangan bergerak.</p>
                </div>

            </div>
        </div>

        <!-- Footer redirection or error alert -->
        <div id="footer-section" class="mt-auto pt-4 text-center">
            <p class="text-[10px] text-slate-400">&copy; 2026 AbsenKita. All rights reserved.</p>
        </div>
    </div>

    <!-- MediaPipe Vision Task ESM Load -->
    <script type="module">
        import { FilesetResolver, FaceLandmarker } from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.8/vision_bundle.mjs";

        const video = document.getElementById('webcam');
        const canvas = document.getElementById('overlay');
        const cameraFrame = document.getElementById('camera-frame');
        const loadingOverlay = document.getElementById('loading-overlay');
        const loadingStatus = document.getElementById('loading-status');
        const statusBox = document.getElementById('status-box');
        const statusIcon = document.getElementById('status-icon');
        const statusTitle = document.getElementById('status-title');
        const statusDesc = document.getElementById('status-desc');
        const progressContainer = document.getElementById('progress-container');
        const progressText = document.getElementById('progress-text');
        const progressBar = document.getElementById('progress-bar');

        let faceLandmarker = null;
        let enrollmentSent = false;
        let faceDescriptors = [];
        const TARGET_DESCRIPTORS = 3; // Collect 3 samples for averaging
        let lastVideoTime = -1;
        let lastDetectTime = 0;
        const DETECT_INTERVAL = 100; // Throttle: max ~10fps detection for low-end phones
        let canvasInitialized = false;

        // ===== Normalized Landmark Descriptor =====
        function extractDescriptor(landmarks) {
            // Nose tip as origin (landmark #4)
            const nose = landmarks[4];
            // Inter-ocular distance for scale normalization (left eye #33, right eye #263)
            const leftEye = landmarks[33];
            const rightEye = landmarks[263];
            const iod = Math.sqrt(
                (rightEye.x - leftEye.x) ** 2 +
                (rightEye.y - leftEye.y) ** 2 +
                (rightEye.z - leftEye.z) ** 2
            );
            if (iod < 0.001) return null; // Face too small / invalid

            const descriptor = [];
            for (const lm of landmarks) {
                descriptor.push(
                    (lm.x - nose.x) / iod,
                    (lm.y - nose.y) / iod,
                    (lm.z - nose.z) / iod
                );
            }
            return descriptor;
        }

        // ===== Quality Checks (Brightness, Clarity, Size, Position) =====
        function checkBrightness(videoEl) {
            if (!videoEl.videoWidth) return 128;
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = 40;
            tempCanvas.height = 30;
            const tempCtx = tempCanvas.getContext('2d');
            tempCtx.drawImage(videoEl, 0, 0, tempCanvas.width, tempCanvas.height);
            const imgData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height).data;
            
            let totalLuminance = 0;
            for (let i = 0; i < imgData.length; i += 4) {
                const r = imgData[i];
                const g = imgData[i + 1];
                const b = imgData[i + 2];
                const luminance = 0.299 * r + 0.587 * g + 0.114 * b;
                totalLuminance += luminance;
            }
            return totalLuminance / (tempCanvas.width * tempCanvas.height);
        }

        function checkFaceClarity(videoEl, minX, minY, maxX, maxY) {
            if (!videoEl.videoWidth) return 50; // default
            const tempCanvas = document.createElement('canvas');
            const videoW = videoEl.videoWidth;
            const videoH = videoEl.videoHeight;
            const x = Math.max(0, Math.floor(minX * videoW));
            const y = Math.max(0, Math.floor(minY * videoH));
            const w = Math.min(videoW - x, Math.floor((maxX - minX) * videoW));
            const h = Math.min(videoH - y, Math.floor((maxY - minY) * videoH));
            
            if (w < 20 || h < 20) return 0;
            
            tempCanvas.width = 40;
            tempCanvas.height = 40;
            const tempCtx = tempCanvas.getContext('2d');
            tempCtx.drawImage(videoEl, x, y, w, h, 0, 0, 40, 40);
            
            const imgData = tempCtx.getImageData(0, 0, 40, 40).data;
            let sum = 0;
            let sumSq = 0;
            const count = imgData.length / 4;
            
            for (let i = 0; i < imgData.length; i += 4) {
                const r = imgData[i];
                const g = imgData[i + 1];
                const b = imgData[i + 2];
                const l = 0.299 * r + 0.587 * g + 0.114 * b;
                sum += l;
                sumSq += l * l;
            }
            const mean = sum / count;
            const variance = (sumSq / count) - (mean * mean);
            return Math.sqrt(Math.max(0, variance));
        }

        // ===== UI Helpers =====
        function updateStatus(icon, title, desc, iconColorClass, bgColorClass, borderColorClass) {
            statusIcon.innerHTML = `<i class="ph-bold ph-${icon} text-lg"></i>`;
            statusIcon.className =
                `w-8 h-8 rounded-full ${bgColorClass} ${iconColorClass} flex items-center justify-center shrink-0`;
            statusTitle.textContent = title;
            statusTitle.className = `font-bold text-xs ${iconColorClass}`;
            statusDesc.textContent = desc;
            statusBox.className =
                `bg-white border ${borderColorClass} rounded-xl p-3.5 flex items-center gap-3 shadow-sm transition-all duration-300`;
        }

        function drawLandmarks(landmarks) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#10B981";

            const keyPoints = [
                33, 133, 159, 145,   // Left eye
                362, 263, 386, 374,  // Right eye
                4, 1, 197, 2,        // Nose
                78, 308, 13, 14,     // Lips
                234, 454             // Face border
            ];

            for (const idx of keyPoints) {
                const lm = landmarks[idx];
                if (lm) {
                    const x = lm.x * canvas.width;
                    const y = lm.y * canvas.height;
                    ctx.beginPath();
                    ctx.arc(x, y, 2.5, 0, 2 * Math.PI);
                    ctx.fill();
                }
            }
        }

        // ===== Initialization =====
        async function init() {
            try {
                // 1. Request camera
                loadingStatus.textContent = "Menghubungkan ke kamera depan...";
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error("Akses kamera diblokir atau tidak didukung. Perangkat memerlukan koneksi HTTPS atau 'localhost' untuk membuka kamera.");
                }
                let stream;
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                } catch (camErr) {
                    // Fallback to lower resolution for budget phones
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 320 }, height: { ideal: 240 } }
                    });
                }
                video.srcObject = stream;

                // 2. Load MediaPipe Face Landmarker
                loadingStatus.textContent = "Mengunduh model pemindai wajah...";
                updateStatus('cloud-arrow-down', 'Memuat Pemindai', 'Mengunduh model pemindai (hanya sekali)...', 'text-blue-600',
                    'bg-blue-50', 'border-blue-100');

                const vision = await FilesetResolver.forVisionTasks("/models");

                // Try GPU first, fallback to CPU for low-end phones
                try {
                    faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
                        baseOptions: {
                            modelAssetPath: "/models/face_landmarker.task",
                            delegate: "GPU"
                        },
                        runningMode: "VIDEO",
                        numFaces: 1
                    });
                } catch (gpuErr) {
                    console.warn("GPU tidak didukung, menggunakan CPU:", gpuErr);
                    loadingStatus.textContent = "GPU tidak tersedia, beralih ke CPU...";
                    faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
                        baseOptions: {
                            modelAssetPath: "/models/face_landmarker.task",
                            delegate: "CPU"
                        },
                        runningMode: "VIDEO",
                        numFaces: 1
                    });
                }

                loadingOverlay.classList.add('hidden');

                updateStatus('smiley', 'Wajah Siap Dipindai', 'Silakan posisikan wajah Anda tepat di tengah.',
                    'text-emerald-600', 'bg-emerald-50', 'border-emerald-100');
                cameraFrame.className =
                    "relative w-64 h-64 rounded-full border-4 border-dashed border-emerald-500 p-2 mb-6 transition-all duration-300";

                // 3. Start detection loop
                requestAnimationFrame(detectFace);
            } catch (err) {
                console.error("Initialization error:", err);
                loadingStatus.innerHTML =
                    "<span class='text-red-500 font-bold'>Error Akses Kamera / Model!</span><br>Pastikan izin kamera diberikan.";
                updateStatus('warning-circle', 'Error Kamera', 'Izin kamera ditolak atau tidak didukung.',
                    'text-red-600', 'bg-red-50', 'border-red-100');
                cameraFrame.className =
                    "relative w-64 h-64 rounded-full border-4 border-dashed border-red-500 p-2 mb-6 transition-all duration-300";
            }
        }

        // ===== Detection Loop (throttled for low-end phones) =====
        function detectFace(now) {
            if (!faceLandmarker || enrollmentSent) return;

            // Throttle: skip frames to maintain ~10fps max on budget phones
            if (now - lastDetectTime < DETECT_INTERVAL) {
                requestAnimationFrame(detectFace);
                return;
            }
            lastDetectTime = now;

            const timestamp = performance.now();
            if (video.currentTime !== lastVideoTime) {
                lastVideoTime = video.currentTime;

                // (Strict brightness block removed to prevent false blocks. Checked non-blockingly when no face is found.)

                const results = faceLandmarker.detectForVideo(video, timestamp);

                // Only resize canvas once (expensive buffer reallocation)
                if (!canvasInitialized && video.videoWidth) {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvasInitialized = true;
                }

                if (results.faceLandmarks && results.faceLandmarks.length > 0) {
                    const landmarks = results.faceLandmarks[0];

                    // 2. Perform bounding box and centering/size checks
                    let minX = 1, maxX = 0, minY = 1, maxY = 0;
                    for (const lm of landmarks) {
                        if (lm.x < minX) minX = lm.x;
                        if (lm.x > maxX) maxX = lm.x;
                        if (lm.y < minY) minY = lm.y;
                        if (lm.y > maxY) maxY = lm.y;
                    }
                    const faceWidth = maxX - minX;
                    const faceHeight = maxY - minY;
                    const faceCenterX = minX + faceWidth / 2;
                    const faceCenterY = minY + faceHeight / 2;

                    // Position / Centering check
                    if (Math.abs(faceCenterX - 0.5) > 0.18 || Math.abs(faceCenterY - 0.5) > 0.20) {
                        cameraFrame.className =
                            "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateStatus('user-focus', 'Posisikan Wajah',
                            'Posisikan wajah Anda tepat di tengah lingkaran silhouette.', 'text-amber-600', 'bg-amber-50',
                            'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(detectFace);
                        return;
                    }

                    // Face size/distance check
                    if (faceWidth < 0.28) {
                        cameraFrame.className =
                            "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateStatus('user-focus', 'Dekatkan Wajah',
                            'Wajah terlalu jauh. Dekatkan wajah Anda sedikit ke kamera.', 'text-amber-600', 'bg-amber-50',
                            'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(detectFace);
                        return;
                    } else if (faceWidth > 0.70) {
                        cameraFrame.className =
                            "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateStatus('user-focus', 'Jauhkan Wajah',
                            'Wajah terlalu dekat. Jauhkan wajah Anda sedikit dari kamera.', 'text-amber-600', 'bg-amber-50',
                            'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(detectFace);
                        return;
                    }

                    // Head rotation angle check (face straight for registration)
                    const leftDist = Math.abs(landmarks[4].x - landmarks[234].x);
                    const rightDist = Math.abs(landmarks[4].x - landmarks[454].x);
                    const angleRatio = Math.max(leftDist, rightDist) / Math.min(leftDist, rightDist);
                    if (angleRatio > 1.6) {
                        cameraFrame.className =
                            "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateStatus('user-focus', 'Hadap Lurus Depan',
                            'Hadap lurus ke depan kamera untuk meregistrasi wajah.', 'text-amber-600', 'bg-amber-50',
                            'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(detectFace);
                        return;
                    }

                    // 3. Clarity / Focus check (using standard deviation of face region brightness)
                    const clarity = checkFaceClarity(video, minX, minY, maxX, maxY);
                    if (clarity < 16.0) {
                        cameraFrame.className =
                            "relative w-64 h-64 rounded-full border-4 border-dashed border-red-500 p-2 mb-6 transition-all duration-300";
                        updateStatus('warning-circle', 'Wajah Buram / Tidak Jelas',
                            'Gambar terlalu buram atau tidak fokus. Bersihkan kamera atau pastikan tidak bergerak.', 'text-red-650', 'bg-red-50',
                            'border-red-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-red-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(detectFace);
                        return;
                    }

                    const faceGuide = document.getElementById('face-guide');
                    if (faceGuide) {
                        faceGuide.className.baseVal = "w-5/6 h-5/6 text-emerald-500/70 transition-all duration-300";
                        faceGuide.style.strokeDasharray = "none";
                    }

                    // drawLandmarks(landmarks);

                    // Extract normalized descriptor
                    const descriptor = extractDescriptor(landmarks);
                    if (descriptor) {
                        faceDescriptors.push(descriptor);
                    }

                    progressContainer.classList.remove('hidden');
                    cameraFrame.className =
                        "relative w-64 h-64 rounded-full border-4 border-emerald-500 p-2 mb-6 transition-all duration-300 animate-pulse";

                    const percent = Math.min(100, Math.floor((faceDescriptors.length / TARGET_DESCRIPTORS) * 100));
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';

                    updateStatus('user-focus', 'Memindai Wajah', `Mengambil sampel wajah (${faceDescriptors.length}/${TARGET_DESCRIPTORS})...`,
                        'text-blue-600', 'bg-blue-50', 'border-blue-100');

                    if (faceDescriptors.length >= TARGET_DESCRIPTORS) {
                        progressContainer.classList.add('hidden');
                        updateStatus('hourglass-medium', 'Mengunggah Wajah', 'Menyimpan wajah Anda ke database...',
                            'text-indigo-650', 'bg-indigo-50', 'border-indigo-150');
                        submitEnrollment();
                        return;
                    }
                } else {
                    const faceGuide = document.getElementById('face-guide');
                    if (faceGuide) {
                        faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                        faceGuide.style.strokeDasharray = "3 3";
                    }

                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    cameraFrame.className =
                        "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                    
                    // Non-blocking brightness check only when face is not detected
                    const brightness = checkBrightness(video);
                    if (brightness < 40) {
                        updateStatus('warning-circle', 'Cahaya Kurang Terang',
                            'Wajah belum terdeteksi. Pencahayaan terdeteksi kurang terang, silakan cari tempat yang lebih terang atau nyalakan lampu ruangan.', 'text-amber-650', 'bg-amber-50',
                            'border-amber-100');
                    } else if (brightness > 245) {
                        updateStatus('warning-circle', 'Cahaya Terlalu Terang',
                            'Wajah belum terdeteksi. Pencahayaan terlalu silau atau terang. Hindari cahaya langsung ke kamera.', 'text-amber-650', 'bg-amber-50',
                            'border-amber-100');
                    } else {
                        updateStatus('warning-circle', 'Pemindaian Tertunda',
                            'Wajah belum terdeteksi. Posisikan wajah Anda tepat di tengah lingkaran, pastikan cahaya cukup terang, dan lepaskan kacamata/masker.', 'text-amber-600', 'bg-amber-50',
                            'border-amber-100');
                    }
                }
            }

            requestAnimationFrame(detectFace);
        }

        // ===== Enrollment Submission =====
        async function submitEnrollment() {
            if (enrollmentSent) return;
            enrollmentSent = true;

            if (faceDescriptors.length === 0) {
                enrollmentSent = false;
                updateStatus('warning-circle', 'Gagal Memindai', 'Karakteristik wajah tidak terbaca. Coba lagi.',
                    'text-red-600', 'bg-red-50', 'border-red-100');
                requestAnimationFrame(detectFace);
                return;
            }

            // Average collected descriptors for a stable descriptor
            const len = faceDescriptors[0].length;
            const avgDescriptor = new Array(len).fill(0);
            for (let i = 0; i < len; i++) {
                for (let j = 0; j < faceDescriptors.length; j++) {
                    avgDescriptor[i] += faceDescriptors[j][i];
                }
                avgDescriptor[i] /= faceDescriptors.length;
            }

            const payload = {
                face_descriptor: avgDescriptor,
                _token: '{{ csrf_token() }}'
            };

            try {
                const response = await fetch('{{ route('face.enrollment.store', [], false) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    updateStatus('check-circle', 'Registrasi Sukses', 'Wajah berhasil didaftarkan. Mengalihkan...',
                        'text-emerald-600', 'bg-emerald-50', 'border-emerald-100');
                    cameraFrame.className =
                        "relative w-64 h-64 rounded-full border-4 border-emerald-500 p-2 mb-6 transition-all duration-300";
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Gagal menyimpan wajah.');
                }
            } catch (err) {
                console.error("Upload error:", err);
                enrollmentSent = false;
                faceDescriptors = [];
                updateStatus('warning-circle', 'Pendaftaran Gagal', err.message, 'text-red-600', 'bg-red-50',
                    'border-red-100');
                cameraFrame.className =
                    "relative w-64 h-64 rounded-full border-4 border-dashed border-red-500 p-2 mb-6 transition-all duration-300";

                // Restart detection after 3 seconds
                setTimeout(() => {
                    if (!enrollmentSent) requestAnimationFrame(detectFace);
                }, 3000);
            }
        }

        // Initialize on load
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            init();
        } else {
            window.addEventListener('DOMContentLoaded', init);
        }
    </script>
</x-layout-attedance>
