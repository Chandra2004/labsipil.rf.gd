<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
    <title>Praktikan Area</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('/assets/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/assets/css/app.css')); ?>">
    <script src="<?php echo e(url('/assets/js/lucide.min.js')); ?>"></script>
</head>

<body class="min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-4 bg-primary text-white">
                <a href="#" class="flex items-center gap-3 font-headline text-xl font-bold">
                    <i data-lucide="hard-hat" class="h-7 w-7"></i>
                    <span>Praktikan Area</span>
                </a>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="credit-card" class="h-5 w-5"></i>
                    Pembayaran
                </a>
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="book-open" class="h-5 w-5"></i>
                    Pemilihan Mata Kuliah
                </a>
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="user-check" class="h-5 w-5"></i>
                    Pemilihan Mentor
                </a>
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="users" class="h-5 w-5"></i>
                    Pembentukan Grup
                </a>
                <a href="#" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-accent hover:text-black transition-colors text-sm font-medium">
                    <i data-lucide="id-card" class="h-5 w-5"></i>
                    Kartu Identitas
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Header -->
            <header class="sticky top-0 z-40 flex h-14 items-center justify-between px-4 sm:px-6 bg-white/90 border-b backdrop-blur-sm">
                <button class="md:hidden p-2 rounded-md hover:bg-gray-100" data-drawer-target="sidebar" data-drawer-toggle="sidebar">
                    <i data-lucide="panel-left" class="h-5 w-5 text-primary"></i>
                </button>
                <!-- Wrapper untuk posisikan ke kanan -->
                <div class="w-full flex justify-end px-4 sm:px-6">
                    <!-- Avatar Button -->
                    <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer" src="/docs/images/people/profile-picture-5.jpg" alt="User dropdown">

                    <!-- Dropdown menu -->
                    <div
                        id="userDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>Bonnie Green</div>
                            <div class="font-medium truncate">name@flowbite.com</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                        </div>
                    </div>
                </div>


            </header>

            <!-- Main -->
            <main class="p-4 sm:p-6 max-w-7xl mx-auto">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold font-headline tracking-tight text-primary">Dashboard</h1>
                    <p class="text-gray-600 text-sm sm:text-base mt-2">Selamat datang, Praktikan! Berikut adalah alur dan jadwal praktikum Anda.</p>
                </div>

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                    <!-- Calendar -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md card">
                            <div class="p-4 sm:p-6 border-b border-gray-200">
                                <h2 class="text-lg sm:text-xl font-bold font-headline text-primary flex items-center gap-2">
                                    <i data-lucide="calendar" class="h-6 w-6"></i>
                                    Kalender Jadwal
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Tanggal yang ditandai memiliki jadwal praktikum. Klik untuk melihat detail.</p>
                            </div>
                            <div class="p-4 sm:p-6">
                                <div id="datepicker" data-date="07/15/2025" class="flowbite-datepicker w-full"></div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const datepickerEl = document.getElementById('datepicker');
                                        new Datepicker(datepickerEl, {
                                            autohide: true,
                                            format: 'EEEE, dd MMMM yyyy',
                                            highlight: ['2025-07-15', '2025-07-16'],
                                            todayHighlight: true,
                                            weekStart: 1
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Sessions -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md card">
                            <div class="p-4 sm:p-6 border-b border-gray-200">
                                <h2 class="text-lg sm:text-xl font-bold font-headline text-primary">Sesi Akan Datang</h2>
                                <p class="text-sm text-gray-600 mt-1">Jadwal praktikum Anda berikutnya.</p>
                            </div>
                            <div class="p-4 sm:p-6 space-y-4">
                                <div class="flex gap-4 p-4 rounded-lg border bg-white hover:bg-accent/10 transition-colors card">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary text-white">
                                        <i data-lucide="beaker" class="h-6 w-6"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-sm sm:text-base text-primary">Praktikum Kimia Dasar</h4>
                                        <p class="text-sm text-gray-600">Senin, 15 Juli 2025</p>
                                        <div class="mt-2 flex flex-col sm:flex-row sm:items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Kimia 101</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4 p-4 rounded-lg border bg-white hover:bg-accent/10 transition-colors card">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary text-white">
                                        <i data-lucide="beaker" class="h-6 w-6"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-sm sm:text-base text-primary">Praktikum Fisika Dasar</h4>
                                        <p class="text-sm text-gray-600">Selasa, 16 Juli 2025</p>
                                        <div class="mt-2 flex flex-col sm:flex-row sm:items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 10:00 - 12:00</span>
                                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Fisika 202</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workflow Steps -->
                <div class="space-y-6">
                    <h2 class="text-xl sm:text-2xl font-bold font-headline text-primary">Alur Praktikum</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Step 1 -->
                        <div class="bg-white rounded-xl shadow-md card border-2 border-primary">
                            <div class="p-4 sm:p-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white">
                                        <i data-lucide="circle-dot" class="h-6 w-6 animate-pulse"></i>
                                    </div>
                                    <div>
                                        <p class="text-base sm:text-lg font-semibold font-headline text-primary">Pembayaran</p>
                                        <p class="text-sm text-gray-600">Lengkapi pembayaran praktikum Anda.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="bg-accent text-black px-3 py-1 rounded-full text-xs font-medium">Dalam Proses</span>
                                    <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center gap-2 justify-center">Lanjutkan <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div class="bg-white rounded-xl shadow-md card">
                            <div class="p-4 sm:p-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                        <i data-lucide="circle" class="h-6 w-6 text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-base sm:text-lg font-semibold font-headline text-primary">Pemilihan Mata Kuliah</p>
                                        <p class="text-sm text-gray-600">Pilih mata kuliah praktikum yang diinginkan.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="border border-gray-300 px-3 py-1 rounded-full text-xs font-medium">Menunggu</span>
                                    <a href="#" class="border border-gray-300 text-gray-500 px-4 py-2 rounded-lg flex items-center gap-2 justify-center opacity-50 cursor-not-allowed">Pilih Mata Kuliah <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Step 3 -->
                        <div class="bg-white rounded-xl shadow-md card">
                            <div class="p-4 sm:p-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                        <i data-lucide="circle" class="h-6 w-6 text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-base sm:text-lg font-semibold font-headline text-primary">Pemilihan Mentor</p>
                                        <p /kotlin
                                            class="text-sm text-gray-600">Pilih mentor untuk praktikum Anda.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="border border-gray-300 px-3 py-1 rounded-full text-xs font-medium">Menunggu</span>
                                    <a href="#" class="border border-gray-300 text-gray-500 px-4 py-2 rounded-lg flex items-center gap-2 justify-center opacity-50 cursor-not-allowed">Pilih Mentor <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Step 4 -->
                        <div class="bg-white rounded-xl shadow-md card">
                            <div class="p-4 sm:p-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                        <i data-lucide="circle" class="h-6 w-6 text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-base sm:text-lg font-semibold font-headline text-primary">Pembentukan Grup</p>
                                        <p class="text-sm text-gray-600">Bentuk grup untuk praktikum Anda.</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <span class="border border-gray-300 px-3 py-1 rounded-full text-xs font-medium">Menunggu</span>
                                    <a href="#" class="border border-gray-300 text-gray-500 px-4 py-2 rounded-lg flex items-center gap-2 justify-center opacity-50 cursor-not-allowed">Bentuk Grup <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div id="day-detail-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50" data-modal-backdrop="static">
        <div class="modal-content bg-white rounded-xl w-full max-w-lg m-4 p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-bold font-headline text-primary">Jadwal untuk Senin, 15 Juli 2025</h2>
            <p class="text-sm text-gray-600 mb-4">Berikut adalah semua sesi praktikum yang dijadwalkan pada tanggal ini.</p>
            <div class="space-y-4 max-h-[60vh] overflow-y-auto">
                <div class="p-3 rounded-md border flex items-start gap-4">
                    <div>
                        <p class="font-semibold text-sm sm:text-base text-primary">Praktikum Kimia Dasar</p>
                        <p class="text-sm text-gray-600">Kimia Dasar I</p>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 text-sm text-gray-600 mt-2">
                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Kimia 101</span>
                        </div>
                    </div>
                </div>
                <div class="p-3 rounded-md border flex items-start gap-4">
                    <div>
                        <p class="font-semibold text-sm sm:text-base text-primary">Praktikum Fisika Dasar</p>
                        <p class="text-sm text-gray-600">Fisika Dasar I</p>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 text-sm text-gray-600 mt-2">
                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 10:00 - 12:00</span>
                            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Fisika 202</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button data-modal-hide="day-detail-modal" class="px-4 py-2 border border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition-colors text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    <script src="<?php echo e(url('/assets/js/flowbite.min.js')); ?>"></script>
</body>

</html><?php /**PATH C:\laragon\www\resources\Views/dashboard/praktikan/home.blade.php ENDPATH**/ ?>