<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
  <title>Dashboard Super Admin</title>

  <!-- Google Fonts: Inter dan Space Grotesk -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

  <script src="https://unpkg.com/lucide@0.441.0/dist/umd/lucide.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #E0E8E9;
    }
    .font-headline {
      font-family: 'Space Grotesk', sans-serif;
    }
    .text-primary {
      color: #468B97;
    }
    .bg-primary {
      background-color: #468B97;
    }
    .text-accent {
      color: #FEE500;
    }
    .bg-accent {
      background-color: #FEE500;
    }
    .hover\:text-accent:hover {
      color: #FEE500;
    }
    .hover\:bg-accent:hover {
      background-color: #FEE500;
    }
    .border-primary {
      border-color: #468B97;
    }
  </style>
</head>
<body class="min-h-screen">
  <div class="flex">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0 bg-white border-r border-gray-200" id="sidebar" aria-label="Sidebar">
      <div class="flex flex-col h-full verflow-y-auto">
        <!-- Sidebar Header -->
        <div class="p-4">
          <a href="/superadmin" class="flex items-center gap-2 font-bold text-lg font-headline">
            <i data-lucide="hard-hat" class="h-6 w-6 text-primary"></i>
            <span>Super Admin</span>
          </a>
        </div>
        <!-- Sidebar Content -->
        <div class="flex-1">
          <ul class="space-y-2 px-3">
            <li>
              <a href="/superadmin" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-accent">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/users" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-accent">
                <i data-lucide="users" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Pengguna</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/payments" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-accent">
                <i data-lucide="credit-card" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Pembayaran</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/courses" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-accent">
                <i data-lucide="book-open" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Praktikum</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/schedule" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-accent">
                <i data-lucide="calendar-clock" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Jadwal</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 md:ml-64">
      <!-- Header -->
      <header class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 bg-white/80 border-b border-gray-200 backdrop-blur-sm sm:px-6">
        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-gray-500 rounded-lg md:hidden hover:bg-accent">
          <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <div class="w-full flex justify-end px-4 sm:px-6">
          <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
            <span class="font-medium text-gray-600" id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start">JL</span>
          </div>
          <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
            <div class="px-4 py-3 text-sm text-gray-900">
              <div>Bonnie Green</div>
              <div class="font-medium truncate">name@flowbite.com</div>
            </div>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="avatarButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary">Dashboard</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary">Settings</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-accent hover:text-primary">Earnings</a>
              </li>
            </ul>
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-accent hover:text-primary">Sign out</a>
            </div>
          </div>
        </div>
      </header>
      <!-- Main -->
      <main class="p-4 sm:p-6">
        <!-- Page Header -->
        <div class="mb-6">
          <h1 class="text-2xl font-bold font-headline text-primary">Dashboard Super Admin</h1>
          <p class="mt-1 text-sm text-gray-600">Selamat datang, Admin! Kelola pengguna dan pengaturan sistem dari sini.</p>
        </div>
        <!-- Summary Cards -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <!-- Card: Total Pengguna -->
          <div class="bg-white rounded-lg shadow">
            <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Pengguna</h3>
              <i data-lucide="users" class="h-6 w-6 text-gray-500"></i>
            </div>
            <div class="p-4">
              <div class="text-2xl font-bold">150</div>
              <a href="/superadmin/users" class="inline-flex items-center pt-4 text-sm text-primary hover:text-accent">
                Kelola Pengguna
                <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
              </a>
            </div>
          </div>
          <!-- Card: Verifikasi Tertunda -->
          <div class="bg-white rounded-lg shadow">
            <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
              <h3 class="text-sm font-medium">Verifikasi Tertunda</h3>
              <i data-lucide="credit-card" class="h-6 w-6 text-gray-500"></i>
            </div>
            <div class="p-4">
              <div class="text-2xl font-bold">10</div>
              <a href="/superadmin/payments" class="inline-flex items-center pt-4 text-sm text-primary hover:text-accent">
                Verifikasi Pembayaran
                <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
              </a>
            </div>
          </div>
          <!-- Card: Persetujuan Praktikum -->
          <div class="bg-white rounded-lg shadow">
            <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
              <h3 class="text-sm font-medium">Persetujuan Praktikum</h3>
              <i data-lucide="book-open" class="h-6 w-6 text-gray-500"></i>
            </div>
            <div class="p-4">
              <div class="text-2xl font-bold">5</div>
              <a href="/superadmin/courses" class="inline-flex items-center pt-4 text-sm text-primary hover:text-accent">
                Kelola Praktikum
                <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
              </a>
            </div>
          </div>
          <!-- Card: Jadwal Global -->
          <div class="bg-white rounded-lg shadow">
            <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
              <h3 class="text-sm font-medium">Jadwal Global</h3>
              <i data-lucide="calendar-clock" class="h-6 w-6 text-gray-500"></i>
            </div>
            <div class="p-4">
              <div class="text-2xl font-bold">Atur</div>
              <a href="/superadmin/schedule" class="inline-flex items-center pt-4 text-sm text-primary hover:text-accent">
                Atur Jadwal
                <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
              </a>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script>
    // Inisialisasi ikon Lucide
    lucide.createIcons();
  </script>
</body>
</html><?php /**PATH C:\laragon\www\resources\Views/dashboard/superadmin/home.blade.php ENDPATH**/ ?>