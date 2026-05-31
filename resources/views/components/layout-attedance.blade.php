<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - Karyawan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="bg-zinc-200 md:flex md:justify-center">
    <script>
        window.addEventListener('error', function(e) {
            console.error("Global Error Caught:", e);
            // Handle loading status in face enrollment
            const loadingStatus = document.getElementById('loading-status');
            if (loadingStatus) {
                loadingStatus.innerHTML =
                    `<span class="text-red-500 font-bold">Error Loaded:</span><br><span class="text-[10px] text-red-300 block max-h-20 overflow-y-auto font-mono">${e.message || 'Unknown Error'}</span>`;
            }
            const statusDesc = document.getElementById('status-desc');
            if (statusDesc) {
                statusDesc.textContent = "Error: " + (e.message || 'Kesalahan pemuatan.');
            }
            const statusBox = document.getElementById('status-box');
            if (statusBox) {
                statusBox.className =
                    "bg-red-50 border border-red-200 rounded-xl p-3.5 flex items-center gap-3 shadow-sm transition-all duration-300";
            }
            // Handle loading text in attendance action
            const loadingTxt = document.getElementById('loading-txt');
            if (loadingTxt) {
                loadingTxt.innerHTML =
                    `<span class="text-red-500 font-bold">Error Loaded:</span><br><span class="text-[10px] text-red-300 block max-h-20 overflow-y-auto font-mono">${e.message || 'Unknown Error'}</span>`;
            }
            const alertText = document.getElementById('alert-text');
            if (alertText) {
                alertText.textContent = "Error: " + (e.message || 'Kesalahan pemuatan.');
            }
            const alertBanner = document.getElementById('alert-banner');
            if (alertBanner) {
                alertBanner.className =
                    "w-full bg-red-50 border border-red-200 rounded-xl p-3 mb-4 flex items-center gap-2.5 transition-all text-red-800";
            }
        }, true);
    </script>
    <main class="w-full min-h-screen bg-white md:max-w-sm">
        {{ $slot }}
    </main>
</body>

</html>
