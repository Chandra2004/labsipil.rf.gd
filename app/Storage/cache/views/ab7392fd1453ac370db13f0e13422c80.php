
<?php $__env->startSection('content'); ?>
    <div class="container mx-auto max-w-4xl px-4 md:px-6 py-12">
        <a href="/news" class="mb-8 inline-flex items-center gap-2 border border-gray-800 text-gray-800 px-4 py-2 rounded-md hover:bg-[#468B97] hover:border-[#468B97] hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Beranda
        </a>

        <article>
            <div class="space-y-4">
                <h1 class="font-headline text-4xl md:text-5xl font-bold">
                    <?php echo e($item['title']); ?>

                </h1>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-muted-foreground">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="h-4 w-4"></i>
                        <time datetime="2025-07-06"><?php echo e($item['date']); ?></time>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="tag" class="h-4 w-4"></i>
                        <span class="bg-gray-300 text-[#468B97] text-sm font-medium px-2.5 py-0.5 rounded"><?php echo e($item['category']); ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6 prose prose-lg dark:prose-invert max-w-none">
                    <p class="lead font-semibold text-gray-800">
                        Indonesia terus mempercepat pengembangan teknologi kecerdasan buatan untuk berbagai sektor.
                    </p>
                    <div class="mt-6 whitespace-pre-line text-gray-700">
                        <?php echo e($item['excerpt']); ?>

                    </div>
                    <!-- <div class="mt-6 whitespace-pre-line text-gray-700">
                        <?php echo e($item['excerpt']); ?>

                    </div> -->
                </div>
            </div>
        </article>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.layoutHome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\Views/homepage/detailNews.blade.php ENDPATH**/ ?>