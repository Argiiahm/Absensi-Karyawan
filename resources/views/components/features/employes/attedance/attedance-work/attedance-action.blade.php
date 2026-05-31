<x-layout-attedance>
    <!-- Header -->
    <div class="flex items-center gap-3 p-5 border-b border-zinc-100 bg-white">
        <a href="/attedance" class="w-10 h-10 flex items-center justify-center rounded-full bg-zinc-100 text-zinc-700">
            <i class="ph ph-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="font-bold text-zinc-900">
                Selfie & Liveness
            </h1>
            <p class="text-xs text-zinc-500">
                Absen {{ $type === 'masuk' ? 'Masuk' : 'Pulang' }} - Verifikasi Kehadiran
            </p>
        </div>
    </div>

    <div class="p-5 flex flex-col items-center bg-slate-50 min-h-[calc(100vh-80px)] overflow-y-auto">
        
        <!-- Live status notification -->
        <div id="alert-banner" class="w-full bg-blue-50 border border-blue-100 rounded-xl p-3 mb-4 flex items-center gap-2.5 transition-all">
            <div id="alert-icon" class="text-blue-600 animate-pulse">
                <i class="ph-bold ph-smiley-wink text-lg"></i>
            </div>
            <p id="alert-text" class="text-xs text-blue-800 font-medium">
                Menginisialisasi sistem keamanan biometrik...
            </p>
        </div>

        <!-- Camera Circular Preview -->
        <div id="camera-frame" class="relative w-64 h-64 rounded-full border-4 border-dashed border-slate-350 p-2 mb-6 transition-all duration-300">
            <div class="w-full h-full bg-slate-950 rounded-full overflow-hidden relative shadow-inner">
                <!-- Camera initializing overlay -->
                <div id="camera-loading" class="absolute inset-0 bg-slate-950/90 z-20 flex flex-col items-center justify-center text-center p-4">
                    <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span id="loading-txt" class="text-xs text-blue-200 font-medium">Memuat pemindai wajah...</span>
                </div>
                
                <!-- Video Element -->
                <video id="webcam" autoplay playsinline muted class="w-full h-full object-cover scale-x-[-1]"></video>
                
                <!-- Overlay canvas for feedback -->
                <canvas id="overlay" style="display: none !important;" class="hidden absolute inset-0 w-full h-full object-cover scale-x-[-1] pointer-events-none z-10"></canvas>

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

        <!-- Real-time Verification Progress -->
        <div class="w-full max-w-xs space-y-4 mb-4">
            <!-- Progress Bar -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                    <span>Tantangan Keamanan</span>
                    <span id="progress-val">0/4 Selesai</span>
                </div>
                <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                    <div id="progress-fill" class="bg-gradient-to-r from-blue-600 to-indigo-650 h-full rounded-full transition-all duration-300 w-0"></div>
                </div>
            </div>

            <!-- Challenges Checkbox List -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm space-y-3">
                <div id="challenge-0" class="flex items-center justify-between text-xs text-slate-400 font-semibold transition-all">
                    <span class="flex items-center gap-2.5">
                        <span id="bullet-0" class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 border border-slate-200">1</span>
                        Lihat Kiri (Turn Head Left)
                    </span>
                    <span id="check-0" class="hidden text-emerald-600"><i class="ph-bold ph-check text-base"></i></span>
                </div>
                <div id="challenge-1" class="flex items-center justify-between text-xs text-slate-400 font-semibold transition-all">
                    <span class="flex items-center gap-2.5">
                        <span id="bullet-1" class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 border border-slate-200">2</span>
                        Lihat Kanan (Turn Head Right)
                    </span>
                    <span id="check-1" class="hidden text-emerald-600"><i class="ph-bold ph-check text-base"></i></span>
                </div>
                <div id="challenge-2" class="flex items-center justify-between text-xs text-slate-400 font-semibold transition-all">
                    <span class="flex items-center gap-2.5">
                        <span id="bullet-2" class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 border border-slate-200">3</span>
                        Kedipkan Mata (Blink Eyes)
                    </span>
                    <span id="check-2" class="hidden text-emerald-600"><i class="ph-bold ph-check text-base"></i></span>
                </div>
                <div id="challenge-3" class="flex items-center justify-between text-xs text-slate-400 font-semibold transition-all">
                    <span class="flex items-center gap-2.5">
                        <span id="bullet-3" class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 border border-slate-200">4</span>
                        Buka Mulut (Open Mouth)
                    </span>
                    <span id="check-3" class="hidden text-emerald-600"><i class="ph-bold ph-check text-base"></i></span>
                </div>
            </div>

            <!-- Coordinate audit details -->
            <div class="text-[10px] text-center text-slate-400 font-medium">
                GPS: <span id="audit-coords" class="font-mono text-slate-500">Mendapatkan...</span>
            </div>
        </div>
    </div>

    <!-- MediaPipe Vision Task ESM Load -->
    <script type="module">
        import { FilesetResolver, FaceLandmarker } from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.8/vision_bundle.mjs";

        // Query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const lat = parseFloat(urlParams.get('lat'));
        const lon = parseFloat(urlParams.get('lon'));
        const type = urlParams.get('type') || 'masuk';

        if (isNaN(lat) || isNaN(lon)) {
            alert("Koordinat GPS tidak valid! Mengalihkan kembali...");
            window.location.href = "/attedance";
        } else {
            document.getElementById('audit-coords').textContent = `${lat.toFixed(6)}, ${lon.toFixed(6)}`;
        }

        const video = document.getElementById('webcam');
        const canvas = document.getElementById('overlay');
        const cameraFrame = document.getElementById('camera-frame');
        const cameraLoading = document.getElementById('camera-loading');
        const loadingTxt = document.getElementById('loading-txt');
        const alertBanner = document.getElementById('alert-banner');
        const alertIcon = document.getElementById('alert-icon');
        const alertText = document.getElementById('alert-text');
        const progressFill = document.getElementById('progress-fill');
        const progressVal = document.getElementById('progress-val');

        let faceLandmarker = null;
        let isCameraActive = false;

        // Challenge management
        let currentChallengeIndex = 0;
        const challenges = [
            { id: 0, detect: detectLookLeft, message: "Arahkan wajah Anda ke Kiri" },
            { id: 1, detect: detectLookRight, message: "Arahkan wajah Anda ke Kanan" },
            { id: 2, detect: detectBlink, message: "Kedipkan kedua mata Anda" },
            { id: 3, detect: detectMouthOpen, message: "Buka mulut Anda lebar-lebar" }
        ];

        let snapshot = null;
        let verificationSent = false;
        let blinkRegistered = false;
        let eyesOpenedInitial = false;
        let lastLandmarks = null; // Store landmarks from the last successful detection
        let lastDetectTime = 0;
        const DETECT_INTERVAL = 100; // Throttle: max ~10fps for low-end phones
        let canvasInitialized = false;

        // ===== Normalized Landmark Descriptor =====
        function extractDescriptor(landmarks) {
            const nose = landmarks[4];
            const leftEye = landmarks[33];
            const rightEye = landmarks[263];
            const iod = Math.sqrt(
                (rightEye.x - leftEye.x) ** 2 +
                (rightEye.y - leftEye.y) ** 2 +
                (rightEye.z - leftEye.z) ** 2
            );
            if (iod < 0.001) return null;

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

        async function init() {
            try {
                // 1. Start camera stream
                loadingTxt.textContent = "Mengaktifkan kamera depan...";
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
                isCameraActive = true;

                // 2. Load MediaPipe Face Landmarker
                loadingTxt.textContent = "Mengunduh model pemindai wajah...";
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
                    loadingTxt.textContent = "GPU tidak tersedia, beralih ke CPU...";
                    faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
                        baseOptions: {
                            modelAssetPath: "/models/face_landmarker.task",
                            delegate: "CPU"
                        },
                        runningMode: "VIDEO",
                        numFaces: 1
                    });
                }

                // Clear overlay and start
                cameraLoading.classList.add('hidden');
                updateAlert('smiley-wink', 'Inisialisasi Sukses', 'Mulai tantangan liveness. Harap lihat lurus dahulu.', 'text-blue-600', 'bg-blue-50', 'border-blue-100');
                
                // Highlight challenge 0
                highlightChallenge(0);
                
                requestAnimationFrame(loop);
            } catch (err) {
                console.error("Liveness initialization error:", err);
                loadingTxt.innerHTML = "<span class='text-red-500 font-bold'>Gagal Menginisialisasi Kamera/Pemindai!</span><br>Pastikan izin kamera diberikan.";
                updateAlert('warning-circle', 'Error Biometrik', 'Sistem pemindai atau kamera tidak dapat dimuat.', 'text-red-600', 'bg-red-50', 'border-red-100');
            }
        }

        function updateAlert(icon, title, text, iconColor, bgColor, borderColor) {
            alertIcon.innerHTML = `<i class="ph-bold ph-${icon} text-lg"></i>`;
            alertIcon.className = `${iconColor} shrink-0`;
            alertText.textContent = text;
            alertBanner.className = `w-full ${bgColor} border ${borderColor} rounded-xl p-3 mb-4 flex items-center gap-2.5 transition-all`;
        }

        function highlightChallenge(index) {
            for (let i = 0; i < 4; i++) {
                const el = document.getElementById(`challenge-${i}`);
                const bullet = document.getElementById(`bullet-${i}`);
                if (i === index) {
                    el.className = "flex items-center justify-between text-xs text-blue-700 font-bold transition-all transform scale-[1.02]";
                    bullet.className = "w-5 h-5 rounded-full bg-blue-100 text-blue-650 flex items-center justify-center text-[10px] border border-blue-300 font-bold animate-pulse";
                    updateAlert('smiley-wink', 'Liveness Challenge', challenges[i].message, 'text-blue-650', 'bg-blue-50', 'border-blue-100');
                    cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-blue-500 p-2 mb-6 transition-all duration-300";
                } else if (i < index) {
                    el.className = "flex items-center justify-between text-xs text-emerald-650 font-bold transition-all line-through opacity-80";
                    bullet.className = "w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] border border-emerald-300 font-bold";
                    document.getElementById(`check-${i}`).classList.remove('hidden');
                } else {
                    el.className = "flex items-center justify-between text-xs text-slate-400 font-semibold transition-all opacity-50";
                    bullet.className = "w-5 h-5 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-[10px] border border-slate-200";
                }
            }
            const progressPercent = Math.round((index / 4) * 100);
            progressFill.style.width = progressPercent + '%';
            progressVal.textContent = `${index}/4 Selesai`;
        }

        let lastVideoTime = -1;

        async function loop(now) {
            if (!faceLandmarker || verificationSent) return;

            // Throttle: skip frames to maintain ~10fps max on budget phones
            if (now - lastDetectTime < DETECT_INTERVAL) {
                requestAnimationFrame(loop);
                return;
            }
            lastDetectTime = now;

            let timestamp = performance.now();
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

                    // 2. Perform bounding box, centering, and size checks
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

                    // Centering check (horizontal skip during head rotation left/right)
                    const skipXCentering = (currentChallengeIndex === 0 || currentChallengeIndex === 1);
                    if ((!skipXCentering && Math.abs(faceCenterX - 0.5) > 0.20) || Math.abs(faceCenterY - 0.5) > 0.22) {
                        cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateAlert('user-focus', 'Posisikan Wajah', 'Posisikan wajah Anda tepat di tengah lingkaran silhouette.', 'text-amber-600', 'bg-amber-50', 'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(loop);
                        return;
                    }

                    // Face size / distance check
                    if (faceWidth < 0.28) {
                        cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateAlert('user-focus', 'Dekatkan Wajah', 'Wajah terlalu jauh. Dekatkan wajah Anda sedikit ke kamera.', 'text-amber-600', 'bg-amber-50', 'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(loop);
                        return;
                    } else if (faceWidth > 0.70) {
                        cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";
                        updateAlert('user-focus', 'Jauhkan Wajah', 'Wajah terlalu dekat. Jauhkan wajah Anda sedikit dari kamera.', 'text-amber-600', 'bg-amber-50', 'border-amber-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(loop);
                        return;
                    }

                    // 3. Clarity / Focus check (using standard deviation of face region brightness)
                    const clarity = checkFaceClarity(video, minX, minY, maxX, maxY);
                    if (clarity < 16.0) {
                        cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-red-500 p-2 mb-6 transition-all duration-300";
                        updateAlert('warning-circle', 'Wajah Buram / Tidak Jelas', 'Gambar terdeteksi buram atau tidak fokus. Bersihkan kamera atau pastikan tidak bergerak.', 'text-red-650', 'bg-red-50', 'border-red-100');
                        
                        const faceGuide = document.getElementById('face-guide');
                        if (faceGuide) {
                            faceGuide.className.baseVal = "w-5/6 h-5/6 text-red-500/50 transition-all duration-300";
                            faceGuide.style.strokeDasharray = "3 3";
                        }
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        
                        requestAnimationFrame(loop);
                        return;
                    }

                    const faceGuide = document.getElementById('face-guide');
                    if (faceGuide) {
                        faceGuide.className.baseVal = "w-5/6 h-5/6 text-emerald-500/70 transition-all duration-300";
                        faceGuide.style.strokeDasharray = "none";
                    }

                    lastLandmarks = landmarks; // Store for descriptor extraction later
                    // drawLandmarks(landmarks);

                    // Run the active challenge detection
                    const currentChallenge = challenges[currentChallengeIndex];
                    const detected = currentChallenge.detect(landmarks);

                    if (detected) {
                        currentChallengeIndex++;
                        if (currentChallengeIndex >= 4) {
                            // Liveness verification success! Proceed to face recognition
                            verificationSent = true;
                            progressFill.style.width = '100%';
                            progressVal.textContent = `4/4 Selesai`;
                            highlightChallenge(4); // check all
                            
                            updateAlert('hourglass-medium', 'Liveness Berhasil', 'Mengambil wajah dan memverifikasi...', 'text-indigo-650', 'bg-indigo-50', 'border-indigo-150');
                            cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-emerald-500 p-2 mb-6 transition-all duration-300 animate-pulse";
                            
                            // Capture snapshot base64
                            captureSnapshot();
                            
                            // Extract descriptor from MediaPipe landmarks and submit
                            submitWithLandmarks();
                            return;
                        } else {
                            // Move to next challenge
                            highlightChallenge(currentChallengeIndex);
                        }
                    }
                } else {
                    const faceGuide = document.getElementById('face-guide');
                    if (faceGuide) {
                        faceGuide.className.baseVal = "w-5/6 h-5/6 text-amber-500/50 transition-all duration-300";
                        faceGuide.style.strokeDasharray = "3 3";
                    }

                    // Clear landmarks drawing
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-amber-500 p-2 mb-6 transition-all duration-300";

                    // Non-blocking brightness check only when face is not detected
                    const brightness = checkBrightness(video);
                    if (brightness < 40) {
                        updateAlert('warning-circle', 'Cahaya Kurang Terang', 'Wajah belum terdeteksi. Pencahayaan terdeteksi kurang terang, silakan cari tempat yang lebih terang atau nyalakan lampu ruangan.', 'text-amber-650', 'bg-amber-50', 'border-amber-100');
                    } else if (brightness > 245) {
                        updateAlert('warning-circle', 'Cahaya Terlalu Terang', 'Wajah belum terdeteksi. Pencahayaan terlalu silau atau terang. Hindari cahaya langsung ke kamera.', 'text-amber-650', 'bg-amber-50', 'border-amber-100');
                    } else {
                        // Restore active challenge guide alert if the light is okay but face is just not centered/detected
                        updateAlert('smiley-wink', 'Liveness Challenge', challenges[currentChallengeIndex].message, 'text-blue-650', 'bg-blue-50', 'border-blue-100');
                    }
                }
            }

            requestAnimationFrame(loop);
        }

        function drawLandmarks(landmarks) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#10B981";
            
            // Draw points selectively to look modern and avoid cluttering
            const keyLandmarks = [
                33, 133, 159, 145, // Left eye
                362, 263, 386, 374, // Right eye
                4, 1, 197, 2, // Nose bridge/tip
                78, 308, 13, 14, // Lips
                234, 454 // Face border
            ];

            for (let index of keyLandmarks) {
                const landmark = landmarks[index];
                if (landmark) {
                    const x = landmark.x * canvas.width;
                    const y = landmark.y * canvas.height;
                    ctx.beginPath();
                    ctx.arc(x, y, 2.5, 0, 2 * Math.PI);
                    ctx.fill();
                }
            }
        }

        // Liveness detection math
        function detectLookLeft(landmarks) {
            const xNose = landmarks[4].x;
            const xLeft = landmarks[234].x;
            const xRight = landmarks[454].x;
            
            const ratio = (xNose - xLeft) / (xRight - xLeft);
            return ratio > 0.57;
        }

        function detectLookRight(landmarks) {
            const xNose = landmarks[4].x;
            const xLeft = landmarks[234].x;
            const xRight = landmarks[454].x;
            
            const ratio = (xNose - xLeft) / (xRight - xLeft);
            return ratio < 0.43;
        }

        function detectBlink(landmarks) {
            const earLeft = (landmarks[145].y - landmarks[159].y) / (landmarks[133].x - landmarks[33].x);
            const earRight = (landmarks[374].y - landmarks[386].y) / (landmarks[263].x - landmarks[362].x);
            const avgEar = (earLeft + earRight) / 2;

            if (!eyesOpenedInitial) {
                if (avgEar > 0.16) {
                    eyesOpenedInitial = true;
                }
                return false;
            }

            if (avgEar < 0.14) {
                blinkRegistered = true;
            }

            if (blinkRegistered && avgEar > 0.16) {
                return true;
            }
            return false;
        }

        function detectMouthOpen(landmarks) {
            const mar = (landmarks[14].y - landmarks[13].y) / (landmarks[308].x - landmarks[78].x);
            return mar > 0.20;
        }

        function captureSnapshot() {
            const snapCanvas = document.createElement('canvas');
            snapCanvas.width = video.videoWidth || 640;
            snapCanvas.height = video.videoHeight || 480;
            const ctx = snapCanvas.getContext('2d');
            
            // Mirror
            ctx.translate(snapCanvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, snapCanvas.width, snapCanvas.height);
            
            snapshot = snapCanvas.toDataURL('image/jpeg', 0.95);
        }

        async function submitWithLandmarks() {
            try {
                // Use stored landmarks from the last detection or do one more detection
                let landmarks = lastLandmarks;
                
                if (!landmarks) {
                    // Try one more detection
                    const results = faceLandmarker.detectForVideo(video, performance.now());
                    if (results.faceLandmarks && results.faceLandmarks.length > 0) {
                        landmarks = results.faceLandmarks[0];
                    }
                }

                if (!landmarks) {
                    updateAlert('warning-circle', 'Deteksi Wajah', 'Gagal mendeteksi wajah. Harap diam dan tatap kamera...', 'text-amber-600', 'bg-amber-50', 'border-amber-100');
                    setTimeout(submitWithLandmarks, 1500);
                    return;
                }

                // Extract normalized descriptor from MediaPipe landmarks
                const descriptor = extractDescriptor(landmarks);
                if (!descriptor) {
                    updateAlert('warning-circle', 'Deteksi Wajah', 'Wajah terlalu kecil. Dekatkan wajah ke kamera...', 'text-amber-600', 'bg-amber-50', 'border-amber-100');
                    setTimeout(submitWithLandmarks, 1500);
                    return;
                }

                // Send to backend
                const payload = {
                    type: type,
                    latitude: lat,
                    longitude: lon,
                    face_descriptor: descriptor,
                    snapshot: snapshot,
                    _token: '{{ csrf_token() }}'
                };

                updateAlert('cloud-arrow-up', 'Mengirim Data', 'Menghubungkan ke server absensi...', 'text-blue-600', 'bg-blue-50', 'border-blue-100');

                const response = await fetch('{{ route("attendance.submit", [], false) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    updateAlert('check-circle', 'Absensi Sukses', 'Kehadiran Anda berhasil diverifikasi!', 'text-emerald-600', 'bg-emerald-50', 'border-emerald-100');
                    cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-emerald-500 p-2 mb-6 transition-all duration-300";
                    
                    setTimeout(() => {
                        window.location.href = '{{ route("attendance.success", [], false) }}';
                    }, 1500);
                } else {
                    throw new Error(result.message || 'Gagal mengirim data absensi.');
                }
            } catch (err) {
                console.error("Attendance submission error:", err);
                updateAlert('warning-circle', 'Absensi Ditolak', err.message, 'text-red-600', 'bg-red-50', 'border-red-100');
                cameraFrame.className = "relative w-64 h-64 rounded-full border-4 border-dashed border-red-500 p-2 mb-6 transition-all duration-300";
                
                // Allow restarting challenge verification after 4 seconds
                setTimeout(() => {
                    verificationSent = false;
                    currentChallengeIndex = 0;
                    blinkRegistered = false;
                    eyesOpenedInitial = false;
                    lastLandmarks = null;
                    highlightChallenge(0);
                    requestAnimationFrame(loop);
                }, 4000);
            }
        }

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            init();
        } else {
            window.addEventListener('DOMContentLoaded', init);
        }
    </script>
</x-layout-attedance>
