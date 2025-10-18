<div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <div class="max-w-2xl text-center">
        <!-- Animated Icon -->
        <div class="mb-8 animate-pulse">
            <svg class="w-32 h-32 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
        </div>

        <!-- Content -->
        <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight text-gray-800 mb-4">Sedang Dalam Pemeliharaan</h1>
        <p class="text-lg text-gray-600 mb-6">Kami sedang bekerja keras untuk meningkatkan situs web kami. Kami akan segera kembali!</p>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8 mx-auto max-w-xs">
            <div class="bg-gray-600 h-2.5 rounded-full animate-progress"></div>
        </div>

        <!-- Additional Info -->
        <div class="space-y-2">
            <p class="text-gray-600">
                <span class="font-semibold">Estimasi selesai:</span> 2 jam
            </p>
            <p class="text-gray-600">
                <span class="font-semibold">Kontak Dukungan:</span> chandratriantomo123@gmail.com
            </p>
        </div>

        <!-- Refresh Button -->
        <button type="button" onclick="window.location.reload()"
            class="mt-8 text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition-all duration-300">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.131 7.131 0 0 0 12.68-3.15M6 20v-4h4" />
            </svg>
            Coba Lagi Nanti
        </button>
    </div>
</div>

<!-- Custom Animation -->
<style>
    @keyframes progress {
        0% {
            width: 0%;
        }

        50% {
            width: 50%;
        }

        100% {
            width: 100%;
        }
    }

    .animate-progress {
        animation: progress 2s ease-in-out infinite;
    }
</style>