<!DOCTYPE html>
<html lang="id" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Karyawan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
        }
    </style>
</head>

<body class="flex justify-center min-h-screen">
    <!-- Mobile App Container -->
    <div class="w-full max-w-md bg-white min-h-screen relative shadow-2xl flex flex-col overflow-hidden">
        {{ $slot }}
    </div>

    <script>
        // Alpine.js App Data
        function appData() {
            return {
                tab: 'beranda',
                activeView: 'main',
                absenType: 'masuk',
                solatName: '',
                userDistance: 35,
                currentTime: '',
                currentDate: '',

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.$nextTick(() => lucide.createIcons());
                },

                updateClock() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    this.currentTime = `${hours}:${minutes}:${seconds}`;

                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    this.currentDate = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
                },

                openAbsenView(type, solatName = '') {
                    this.absenType = type;
                    this.solatName = solatName;
                    this.randomizeDistance();
                    this.activeView = 'absen_map';
                    this.$nextTick(() => lucide.createIcons());
                },

                randomizeDistance() {
                    this.userDistance = Math.floor(Math.random() * 80) + 5;
                    this.$nextTick(() => lucide.createIcons());
                },

                proceedFromMap() {
                    if (this.userDistance <= 50) {
                        this.activeView = 'absen_selfie';
                        this.$nextTick(() => lucide.createIcons());
                    }
                },

                submitAbsen() {
                    this.activeView = 'absen_berhasil';
                    this.$nextTick(() => lucide.createIcons());
                }
            };
        }

        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
</body>

</html>
