@extends('Dashboard.layouts.layout')
@section('Dashboard.layouts.layout')
    <main class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="font-headline text-2xl font-bold text-[#468B97]">Pendaftaran Praktikum</h1>
                <p class="text-sm text-gray-600">Daftar sebagai praktikan untuk praktikum yang tersedia, kelola pendaftaran
                    Anda sendiri, dan tunggu persetujuan dari pihak terkait.</p>
            </div>
        </div>

        <!-- Accordion -->
        <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
            @foreach ($courses as $course)
                @php
                    $joined = false;
                    $joinedSession = null;
                    $sessionUid = '';
                    $status = '';
                    foreach ($course['sessions'] as $session) {
                        foreach ($session['participants'] as $participant) {
                            if ($participant['user_uid'] === $user['uid']) {
                                $joined = true;
                                $joinedSession = $session;
                                $sessionUid = $participant['session_uid'];
                                $status = $participant['status'];
                                break 2;
                            }
                        }
                    }

                    $hasOpenSessions = false;
                    $openSessions = [];
                    foreach ($course['sessions'] as $session) {
                        if (strtotime($session['open_session']) <= strtotime(updateAt())) {
                            $hasOpenSessions = true;
                            $openSessions[] = $session;
                        }
                    }
                @endphp
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md mb-4">
                    <h2 id="accordion-collapse-heading-{{ $course['uid'] }}">
                        <button type="button"
                            class="flex items-center justify-between w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white"
                            data-accordion-target="#accordion-collapse-body-{{ $course['uid'] }}" aria-expanded="false"
                            aria-controls="accordion-collapse-body-{{ $course['uid'] }}">
                            <div class="text-left">
                                <p class="font-semibold">{{ $course['name_course'] }}</p>
                                <p class="text-sm">Kode: {{ $course['code_course'] }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                @if ($joined)
                                    @if ($status === 'accepted')
                                        <div class="flex items-center gap-1">
                                            <a href="{{ $course['link_course'] }}" target="_blank" data-turbo="false">
                                                <i data-lucide="messages-square" class="h-5 w-5 mr-2"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </div>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{ $course['uid'] }}" class="hidden"
                        aria-labelledby="accordion-collapse-heading-{{ $course['uid'] }}">
                        <div class="bg-gray-50 p-4 border-t border-gray-200">
                            <div class="space-y-3">
                                <div>
                                    <h4 class="font-semibold text-sm text-[#468B97]">Koordinator Praktikum</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $course['author_name'] }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-sm text-[#468B97]">Program Studi | Semester</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $course['study_name'] }} |
                                        {{ $course['semester_course'] }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-sm text-[#468B97]">Deskripsi</h4>
                                    <p class="text-xs text-gray-500 mt-1">{!! $course['description_course'] !!}</p>
                                </div>
                                <div class="mx-auto">
                                    @if ($joined)
                                    @php
                                        $isExpired = strtotime($joinedSession['close_session']) < time();
                                    @endphp
                                        <form
                                            action="/dashboard/courses/register/delete/user/{{ $user['uid'] }}/course/{{ $course['uid'] }}/session/{{ $sessionUid }}"
                                            method="POST">
                                            @csrf
                                            <div class="grid grid-cols-1 gap-4">
                                                <div
                                                    class="bg-white border {{ $status === 'pending' ? 'border-yellow-200' : ($status === 'accepted' ? 'border-green-200' : 'border-red-200') }} rounded-lg p-4 shadow-sm">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div
                                                            class="h-5 w-5 border-2 {{ $status === 'pending' ? 'border-yellow-400 bg-yellow-600' : ($status === 'accepted' ? 'border-green-400 bg-green-600' : 'border-red-400 bg-red-600') }} rounded-full animate-pulse">
                                                        </div>
                                                        <p class="text-base font-semibold text-gray-800 ml-2 flex-1">
                                                            {{ $joinedSession['name_session'] }} |
                                                            {{ $joinedSession['code_session'] }}
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-xs font-medium {{ $status === 'pending' ? 'text-yellow-700 bg-yellow-100' : ($status === 'accepted' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100') }} rounded-full">
                                                            <i data-lucide="{{ $status === 'pending' ? 'clock' : ($status === 'accepted' ? 'check-circle' : 'x-circle') }}"
                                                                class="h-3 w-3 mr-1 {{ $status === 'pending' ? 'animate-spin' : '' }}"></i>
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </div>
                                                    <div class="space-y-2 text-sm text-gray-600">
                                                        <p class="flex items-center">
                                                            <i data-lucide="users" class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Kuota: {{ count($joinedSession['participants']) }} /
                                                            {{ $joinedSession['kuota_session'] }}
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i data-lucide="calendar"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Mulai:
                                                            {{ date('H:i', strtotime($joinedSession['start_session'])) }}
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i data-lucide="calendar"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Selesai:
                                                            {{ date('H:i', strtotime($joinedSession['end_session'])) }}
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i data-lucide="calendar-x"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Tutup:
                                                            {{ date('H:i d-m-Y', strtotime($joinedSession['close_session'])) }}
                                                        </p>
                                                    </div>
                                                    <div class="flex justify-end mt-3">
                                                        @if(!$isExpired)
                                                            @if($status == 'pending')
                                                                <button id="submitDeleteRegisterSession-{{ $course['uid'] }}"
                                                                    data-submit-loader
                                                                    data-loader="#loaderDeleteRegisterSession-{{ $course['uid'] }}"
                                                                    type="submit"
                                                                    class="bg-red-500 text-white py-1 px-3 rounded text-sm flex items-center hover:bg-red-600 transition-colors">
                                                                    <i data-lucide="loader-2"
                                                                        class="h-4 w-4 mr-2 hidden animate-spin"
                                                                        id="loaderDeleteRegisterSession-{{ $course['uid'] }}"></i>
                                                                    Batalkan pendaftaran
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @elseif (empty($course['sessions']))
                                        <p class="text-gray-500 mt-1 text-center">Sesi untuk praktikum ini belum ada</p>
                                    @elseif (!$hasOpenSessions)
                                        <p class="text-gray-500 mt-1 text-center">Sesi untuk praktikum ini belum terbuka</p>
                                    @else
                                        <form
                                            action="/dashboard/courses/register/{{ $course['uid'] }}/user/{{ $user['uid'] }}"
                                            method="POST">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                                @csrf
                                                @foreach ($openSessions as $session)
                                                    @php
                                                        $isExpired = strtotime($session['close_session']) < time();
                                                    @endphp
                                                    @if ($isExpired)
                                                        <label class="block">
                                                            <div
                                                                class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 cursor-not-allowed opacity-75">
                                                                <div class="flex justify-between items-start mb-2">
                                                                    <div
                                                                        class="h-5 w-5 border-2 border-gray-400 rounded-full">
                                                                    </div>
                                                                    <p
                                                                        class="text-base font-semibold text-gray-800 ml-2 flex-1">
                                                                        {{ $session['name_session'] }} |
                                                                        {{ $session['code_session'] }}
                                                                    </p>
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                                                                        <i data-lucide="x-circle" class="h-3 w-3 mr-1"></i>
                                                                        Expired
                                                                    </span>
                                                                </div>
                                                                <div class="space-y-2 text-sm text-gray-600">
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="users"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Kuota: {{ count($session['participants']) }} /
                                                                        {{ $session['kuota_session'] }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Mulai:
                                                                        {{ date('H:i', strtotime($session['start_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Selesai:
                                                                        {{ date('H:i', strtotime($session['end_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar-x"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Tutup:
                                                                        {{ date('H:i d-m-Y', strtotime($session['close_session'])) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    @elseif ($session['kuota_session'] > count($session['participants']))
                                                        <label for="session_{{ $session['uid'] }}" class="block">
                                                            <div
                                                                class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 cursor-pointer">
                                                                <div class="flex justify-between items-start mb-2">
                                                                    <input type="radio" name="uid_session"
                                                                        id="session_{{ $session['uid'] }}"
                                                                        value="{{ $session['uid'] }}"
                                                                        class="h-5 w-5 border-2 border-gray-400 text-blue-600 focus:ring-2 focus:ring-blue-500 rounded-full appearance-none checked:bg-blue-600 checked:border-transparent transition duration-150 ease-in-out">
                                                                    <p
                                                                        class="text-base font-semibold text-gray-800 ml-2 flex-1">
                                                                        {{ $session['name_session'] }} |
                                                                        {{ $session['code_session'] }}
                                                                    </p>
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                                                        Aktif
                                                                    </span>
                                                                </div>
                                                                <div class="space-y-2 text-sm text-gray-600">
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="users"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Kuota: {{ count($session['participants']) }} /
                                                                        {{ $session['kuota_session'] }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Mulai:
                                                                        {{ date('H:i', strtotime($session['start_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Selesai:
                                                                        {{ date('H:i', strtotime($session['end_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar-x"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Tutup:
                                                                        {{ date('H:i d-m-Y', strtotime($session['close_session'])) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    @else
                                                        <label class="block">
                                                            <div
                                                                class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 cursor-not-allowed opacity-75">
                                                                <div class="flex justify-between items-start mb-2">
                                                                    <div
                                                                        class="h-5 w-5 border-2 border-gray-400 rounded-full">
                                                                    </div>
                                                                    <p
                                                                        class="text-base font-semibold text-gray-800 ml-2 flex-1">
                                                                        {{ $session['name_session'] }} |
                                                                        {{ $session['code_session'] }}
                                                                    </p>
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                                                        <i data-lucide="x-circle"
                                                                            class="h-3 w-3 mr-1"></i>
                                                                        Penuh
                                                                    </span>
                                                                </div>
                                                                <div class="space-y-2 text-sm text-gray-600">
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="users"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Kuota: {{ count($session['participants']) }} /
                                                                        {{ $session['kuota_session'] }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Mulai:
                                                                        {{ date('H:i', strtotime($session['start_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Selesai:
                                                                        {{ date('H:i', strtotime($session['end_session'])) }}
                                                                    </p>
                                                                    <p class="flex items-center">
                                                                        <i data-lucide="calendar-x"
                                                                            class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                        Tutup:
                                                                        {{ date('H:i d-m-Y', strtotime($session['close_session'])) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    @endif
                                                @endforeach
                                                <div class="col-span-full mt-4 text-center">
                                                    <button id="submitRegisterCourse-{{ $course['uid'] }}"
                                                        data-submit-loader
                                                        data-loader="#loaderRegisterCourse-{{ $course['uid'] }}"
                                                        type="submit"
                                                        class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                                            id="loaderRegisterCourse-{{ $course['uid'] }}"></i>
                                                        Daftar Sesi Praktikum
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
