<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
  <title><?php echo e($title); ?></title>

  <link rel="stylesheet" href="<?php echo e(url('/assets/css/output.css')); ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo e(url('/assets/css/custom.css')); ?>">
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
            <span>PRAKTIKUM SIPIL</span>
          </a>
        </div>
        <!-- Sidebar Content -->
        <div class="flex-1">
          <ul class="space-y-2 px-3">
            <?php if($roleName == 'SuperAdmin'): ?>
            <li>
              <a href="/superadmin" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/users" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <i data-lucide="users" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Pengguna</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/payments" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <i data-lucide="credit-card" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Pembayaran</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/courses" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <i data-lucide="book-open" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Praktikum</span>
              </a>
            </li>
            <li>
              <a href="/superadmin/schedule" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <i data-lucide="calendar-clock" class="w-4 h-4 text-gray-500"></i>
                <span class="ml-3 text-sm">Jadwal</span>
              </a>
            </li>
            <?php endif; ?>
            <li>
              <a href="/logout" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                  <path d="m16 17 5-5-5-5" />
                  <path d="M21 12H9" />
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                </svg>
                <div class="icon-log-out w-4 h-4 text-gray-500"></div>
                <span class="ml-3 text-sm">Logout</span>
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
        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-gray-500 rounded-lg md:hidden hover:bg-[#E0E8E9]">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-icon lucide-panel-left">
            <rect width="18" height="18" x="3" y="3" rx="2" />
            <path d="M9 3v18" />
          </svg>
        </button>
        <div class="w-full flex justify-end px-4 sm:px-6">
          <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
            <?php if($roleName == 'SuperAdmin'): ?>
            <span class="font-medium text-gray-600" id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start">SA</span>
            <?php elseif($roleName == 'Praktikan'): ?>
            <span class="font-medium text-gray-600" id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start">PR</span>
            <?php endif; ?>
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

      <?php echo $__env->yieldContent('dashboard-content'); ?>
    </div>
  </div>
  <script>
    lucide.createIcons();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html><?php /**PATH C:\laragon\www\resources\Views/dashboard/layouts/layout.blade.php ENDPATH**/ ?>