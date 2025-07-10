

<?php $__env->startSection('dashboard-content'); ?>
<main class="p-4 sm:p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold font-headline text-primary">Dashboard Super Admin</h1>
        <p class="mt-1 text-sm text-gray-600">Selamat datang, Super Admin! Kelola pengguna dan pengaturan sistem dari sini.</p>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\Views/dashboard/superadmin/home.blade.php ENDPATH**/ ?>