<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ url('/file/public/favicon.ico') }}" type="image/x-icon">
    <title>{{ $title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@latest/dist/turbo.es2017-esm.min.js"></script>
</head>

<body class="min-h-screen">
    @include('notification.notification')
    <div>
        <div class="flex">
            <aside
                class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full md:translate-x-0 bg-white border-r border-gray-200"
                id="sidebar" aria-label="Sidebar">
                <div class="flex flex-col h-full p-4 overflow-y-auto">
                    <div class="py-3 px-5">
                        <a href="/dashboard" class="flex items-center gap-2 font-bold text-lg font-headline">
                            <i data-lucide="hard-hat" class="h-6 w-6 text-[#468B97]"></i>
                            <span>SIPIL PRAKTIKUM</span>
                        </a>
                    </div>
                    <div class="flex-1">
                        <ul class="space-y-2">
                            @switch($user['role_name'])
                                @case('SuperAdmin')
                                    @include('Dashboard.pages.superadmin.menu')
                                @break

                                @case('Koordinator')
                                    @include('Dashboard.pages.koordinator.menu')
                                @break

                                @case('Pembimbing')
                                    {{-- @include('Dashboard.pages.pembimbing.menu') --}}
                                @break

                                @case('Asisten')
                                    {{-- @include('Dashboard.pages.asisten.menu') --}}
                                @break

                                @case('Praktikan')
                                    @include('Dashboard.pages.praktikan.menu')
                                @break

                                @default
                            @endswitch

                            <li data-turbo="false">
                                <a href="/logout/id/{{ $user['id'] }}/user/{{ $user['uid'] }}"
                                    class="flex items-center py-3 px-5 text-gray-900 rounded-lg hover:bg-red-500 hover:text-white">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                    <span class="ml-3">Log-out</span>
                                </a>
                            </li>




                            {{-- @if ($roleName == 'SuperAdmin') --}}
                            {{-- 
                            
                            <li>
                                <a href="//payment-management"
                                    class="{{ 'bg-[#468B97] text-white' . 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                    <span class="ml-3">Pembayaran</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="//session-management"
                                    class="{{ 'bg-[#468B97] text-white' . 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                                    <span class="ml-3">Sesi</span>
                                </a>
                            </li>
                            <li>
                                <a href="//module-management"
                                    class="{{ request()->is($link . '/module-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="book-text" class="w-5 h-5"></i>
                                    <span class="ml-3">Modul</span>
                                </a>
                            </li> --}}
                            {{-- @elseif($roleName == 'Praktikan')
                            <li>
                                <a href="//module-management"
                                    class="{{ request()->is($link . '/module-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                    <span class="ml-3">Pembayaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="//course-management"
                                    class="{{ request()->is($link . '/course-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="book-open" class="w-5 h-5"></i>
                                    <span class="ml-3">Praktikum</span>
                                </a>
                            </li>
                            <li>
                                <a href="//module-management"
                                    class="{{ request()->is($link . '/module-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="id-card" class="w-5 h-5"></i>
                                    <span class="ml-3">Kartu Praktikum</span>
                                </a>
                            </li> --}}
                            {{-- @endif  --}}
                        </ul>
                    </div>
                </div>
            </aside>

            <div class="flex-1 md:ml-64">
                <!-- Header -->
                <header
                    class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 bg-white/80 border-b border-gray-200 backdrop-blur-sm sm:px-6">
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-gray-500 rounded-lg md:hidden hover:bg-[#E0E8E9]">
                        <i data-lucide="panel-left"></i>
                    </button>
                    <div class="w-full flex justify-end px-4 sm:px-6">
                        @if (!empty($user['avatar']))
                            <div class="font-medium text-gray-600 cursor-pointer" id="avatarButton" type="button"
                                data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start">
                                <img src="{{ url('/file/avatar/' . $user['avatar']) }}" alt="{{ $user['full_name'] }}"
                                    class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                            </div>
                        @else
                            <div
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                                <span class="font-medium text-gray-600 cursor-pointer" id="avatarButton" type="button"
                                    data-dropdown-toggle="userDropdown"
                                    data-dropdown-placement="bottom-start">{{ $user['initials'] }}</span>
                            </div>
                        @endif
                        <div id="userDropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-auto">
                            <div class="px-4 py-3 text-sm text-gray-900">
                                <div>{{ $user['full_name'] }}</div>
                                <div class="font-medium truncate" id="email">{{ $user['email'] }}</div>
                            </div>
                            <ul class="p-2 space-y-1 text-sm text-gray-700" aria-labelledby="avatarButton">
                                <li>
                                    <a href="/dashboard"
                                        class="{{ request()->is('/dashboard') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} block px-4 py-2 rounded-md">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="/dashboard/profile"
                                        class="{{ request()->is('/dashboard/profile') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} block px-4 py-2 rounded-md">Profile</a>
                                </li>
                            </ul>
                            <div class="p-2" data-turbo="false">
                                <a href="/logout/id/{{ $user['id'] }}/user/{{ $user['uid'] }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white rounded-md">Log
                                    Out</a>
                            </div>
                        </div>
                    </div>
                </header>
                @yield('Dashboard.layouts.layout')
            </div>
        </div>
    </div>

    <!-- Flowbite & Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script src="{{ url('/assets/js/script.js') }}"></script>
</body>

</html>
