@extends('Guest.layouts.layout')
@section('Guest.layouts.layout')
    <div class="container mx-auto max-w-4xl px-4 md:px-6 py-12">
        <!-- Header dengan Logo -->
        <div class="mb-8 flex items-center justify-between">
            <a href="/news"
                class="inline-flex items-center gap-2 border border-gray-800 text-gray-800 px-4 py-2 rounded-md hover:bg-[#468B97] hover:border-[#468B97] hover:text-white transition-colors">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Beranda
            </a>
        </div>

        <article>
            <div class="space-y-4">
                <h1 class="font-headline text-4xl md:text-5xl font-bold">
                    {{ $item['title'] }}
                </h1>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-muted-foreground">
                    <!-- Tanggal -->
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="h-4 w-4"></i>
                        <time>
                            @php
                                $locale = 'id_ID';
                                $timezone = 'Asia/Jakarta';
                                $formatter = new IntlDateFormatter(
                                    $locale,
                                    IntlDateFormatter::LONG,
                                    IntlDateFormatter::NONE,
                                    $timezone,
                                );
                                $dateTime = new DateTime($item['date_time'], new DateTimeZone($timezone));
                                $formattedTime = $dateTime->format('H:i');
                                $formattedDate = $formatter->format($dateTime);
                            @endphp
                            {{ $formattedTime }} | {{ $formattedDate }}
                        </time>
                    </div>
                    <!-- Kategori -->
                    <div class="flex items-center gap-2">
                        <i data-lucide="tag" class="h-4 w-4"></i>
                        <span class="bg-gray-300 text-[#468B97] text-sm font-medium px-2.5 py-0.5 rounded">
                            {{ $item['category'] }}
                        </span>
                    </div>
                    <!-- Author -->
                    <div class="flex items-center gap-2">
                        <i data-lucide="user" class="h-4 w-4"></i>
                        <span class="text-sm font-medium text-[#468B97] px-2.5 py-0.5 rounded bg-gray-100"
                            data-tooltip-target="tooltip-author">
                            {{ $item['author_name'] }}
                        </span>
                        <!-- Tooltip Flowbite untuk Author -->
                        <div id="tooltip-author" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                            Ditulis oleh {{ $item['author_name'] }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6 prose prose-lg prose-invert max-w-none">
                    <div class="whitespace-pre-line text-gray-700">
                        {{ $item['description'] }}
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection
