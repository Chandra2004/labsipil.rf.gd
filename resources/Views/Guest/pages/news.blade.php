@extends('Guest.layouts.layout')
@section('Guest.layouts.layout')
    <main class="flex-1 max">
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 md:py-32">
            <div class="text-center mb-12">
                <h2 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight">Berita & Pengumuman</h2>
                <p class="mt-4 mx-auto text-base sm:text-lg text-gray-600">
                    Ikuti terus informasi dan pembaruan terkini seputar kegiatan praktikum.
                </p>
            </div>

            <div class="grid gap-4 mt-8 md:p-8 sm:grid-cols-2 md:grid-cols-3">
                @if (!empty($news['data']))
                    @foreach ($news['data'] as $item)
                        <article
                            class="flex flex-col overflow-hidden bg-white border border-[#468B97]/50 rounded-xl shadow-soft transition-transform hover:scale-[1.02] hover:shadow-lg">
                            <div class="p-6">
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $item['category'] }}</span>
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
                                <a href="/news/detail/title/{{ $item['slug'] }}/item/{{ $item['uid'] }}">
                                    <h3 class="font-headline text-xl pt-3 font-semibold">{{ $item['title'] }}</h3>
                                </a>
                            </div>
                            <div class="px-6 pb-6 flex-1">
                                <p class="text-gray-600 line-clamp-3">{{ $item['description'] }}</p>
                            </div>
                            <div class="px-6 pb-6">
                                <a href="/news/detail/title/{{ $item['slug'] }}/item/{{ $item['uid'] }}"
                                    class="text-[#468B97] hover:underline flex items-center text-sm font-medium transition-colors"
                                    aria-label="Baca selengkapnya tentang {{ $item['title'] }}">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="#468B97" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="ml-2">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                @else
                        <h1>TIDAK ADA DATA</h1>
                @endif
            </div>

            
            <div class="mt-12 flex justify-center">
                <div class="flex flex-col items-center">
                    <span class="text-sm text-gray-700">
                        Showing <span class="font-semibold text-gray-900">{{ $news['current_page'] }}</span> to <span
                            class="font-semibold text-gray-900">{{ $news['last_page'] }}</span> of <span
                            class="font-semibold text-gray-900">{{ $news['total'] }}</span> Entries
                    </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                        <a href="{{ $news['current_page'] > 1 ? '/news/page/' . ($news['current_page'] - 1) : '/news' }}"
                            class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-s hover:bg-[#468B97] hover:text-white">
                            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5H1m0 0 4 4M1 5l4-4" />
                            </svg>
                            Prev
                        </a>
                        <a href="{{ $news['current_page'] < $news['last_page'] ? '/news/page/' . ($news['current_page'] + 1) : '/news/page/' . $news['last_page'] }}"
                            class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-e hover:bg-[#468B97] hover:text-white">
                            Next
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div> 
        </section>
    </main>
@endsection
