@extends('Dashboard.layouts.layout')
@section('Dashboard.layouts.layout')
    <main class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="font-headline text-2xl font-bold text-[#468B97]">Persetujuan Praktikum</h1>
                <p class="text-sm text-gray-600">Tinjau dan setujui akun praktikan yang mendaftar untuk mengikuti praktikum.
                </p>
            </div>
        </div>


        <!-- Accordion -->
        <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
            @foreach ($courses as $course)
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
                                <div class="flex items-center gap-1">
                                    <span class="text-sm">{{ $course['total_participants'] }} Pendaftar</span>
                                    <span class="text-sm mx-1">|</span>
                                    <span class="text-sm">{{ $course['total_accepted'] }} Diterima</span>
                                </div>
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
                                    <div class="mt-2 border border-gray-200 rounded-md overflow-hidden">
                                        <table class="w-full">
                                            <thead>
                                                <tr class="bg-[#468B97] text-white">
                                                    <th class="p-2 text-left">Praktikan</th>
                                                    <th class="p-2 text-left">Pembimbing</th>
                                                    <th class="p-2 text-left">Asisten</th>
                                                    <th class="p-2 text-left">Status</th>
                                                    <th class="p-2 text-left">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($course['sessions'] as $session)
                                                    @foreach ($session['participants'] as $participant)
                                                        @php
                                                            $tooltipUser = 'tooltip-user-' . $participant['uid'];
                                                            $tooltipPembimbing =
                                                                'tooltip-pembimbing-' . $participant['uid'];
                                                            $tooltipAsisten = 'tooltip-asisten-' . $participant['uid'];
                                                        @endphp
                                                        <tr class="border-b border-gray-200">
                                                            {{-- USER --}}
                                                            <td class="p-2 relative">
                                                                <button data-tooltip-target="{{ $tooltipUser }}"
                                                                    data-tooltip-placement="right" type="button"
                                                                    class="text-blue-700 hover:underline font-medium text-sm">
                                                                    {{ $participant['user']['full_name'] }}
                                                                </button>
                                                                <div id="{{ $tooltipUser }}" role="tooltip"
                                                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                                    <ul class="list-disc pl-5">
                                                                        <li>{{ $participant['user']['full_name'] }}</li>
                                                                        <li>{{ $participant['user']['phone_number'] }}</li>
                                                                        <li>{{ $participant['user']['email'] }}</li>
                                                                        <li>{{ $session['name_session'] }}</li>
                                                                    </ul>
                                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                                </div>
                                                            </td>

                                                            {{-- PEMBIMBING --}}
                                                            <td class="p-2 relative">
                                                                <span data-tooltip-target="{{ $tooltipPembimbing }}"
                                                                    data-tooltip-placement="right"
                                                                    class="text-indigo-700 hover:underline font-medium text-sm cursor-pointer">
                                                                    {{ $participant['pembimbing']['full_name'] }}
                                                                </span>
                                                                <div id="{{ $tooltipPembimbing }}" role="tooltip"
                                                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-indigo-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-indigo-700">
                                                                    <ul class="list-disc pl-5">
                                                                        <li>{{ $participant['pembimbing']['full_name'] }}
                                                                        </li>
                                                                        <li>{{ $participant['pembimbing']['phone_number'] }}
                                                                        </li>
                                                                        <li>{{ $participant['pembimbing']['email'] }}</li>
                                                                    </ul>
                                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                                </div>
                                                            </td>

                                                            {{-- ASISTEN --}}
                                                            <td class="p-2 relative">
                                                                <span data-tooltip-target="{{ $tooltipAsisten }}"
                                                                    data-tooltip-placement="right"
                                                                    class="text-teal-700 hover:underline font-medium text-sm cursor-pointer">
                                                                    {{ $participant['asisten']['full_name'] }}
                                                                </span>
                                                                <div id="{{ $tooltipAsisten }}" role="tooltip"
                                                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-teal-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-teal-700">
                                                                    <ul class="list-disc pl-5">
                                                                        <li>{{ $participant['asisten']['full_name'] }}</li>
                                                                        <li>{{ $participant['asisten']['phone_number'] }}
                                                                        </li>
                                                                        <li>{{ $participant['asisten']['email'] }}</li>
                                                                    </ul>
                                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                                </div>
                                                            </td>

                                                            {{-- STATUS --}}
                                                            @if ($participant['status'] === 'pending')
                                                                <td class="p-2">
                                                                    <span
                                                                        class="inline-flex items-center gap-1 badge-Pending px-2 py-1 rounded text-xs text-yellow-700 bg-yellow-100">
                                                                        <i data-lucide="clock"
                                                                            class="h-3 w-3 animate-spin"></i>
                                                                        Pending
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td class="p-2">
                                                                    <span
                                                                        class="inline-flex items-center gap-1 badge-Accepted px-2 py-1 rounded text-xs text-green-700 bg-green-100">
                                                                        <i data-lucide="check-circle" class="h-3 w-3"></i>
                                                                        Accepted
                                                                    </span>
                                                                </td>
                                                            @endif

                                                            <td class="p-2">
                                                                <form
                                                                    action="/dashboard/users/approval/update/{{ $participant['uid'] }}/{{ $participant['user']['uid'] }}"
                                                                    method="POST" class="flex gap-2">
                                                                    @csrf
                                                                    <div>
                                                                        <span data-modal-target="update-user-approvement-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}" data-modal-toggle="update-user-approvement-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}"
                                                                            class="cursor-pointer text-white inline-flex items-center bg-blue-500 hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                            <i data-lucide="square-pen" class="h-4 w-4"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-2">
                                                                        @if($participant['status'] === 'pending')
                                                                            <button name="action" value="accepted"
                                                                                id="submitUpdateAccepted-{{ $course['uid'] }}-{{ $participant['uid'] }}"
                                                                                data-submit-loader
                                                                                data-loader="#loaderUpdateAccepted-{{ $course['uid'] }}-{{ $participant['uid'] }}"
                                                                                data-hide-icon="true" type="submit"
                                                                                class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-green-500 hover:bg-[#3a6f7a] focus:outline-none focus:ring-4 focus:ring-blue-300 rounded-lg transition duration-200 ease-in-out">
                                                                                <i data-lucide="loader-2"
                                                                                    id="loaderUpdateAccepted-{{ $course['uid'] }}-{{ $participant['uid'] }}"
                                                                                    class="h-4 w-4 hidden animate-spin"></i>
                                                                                <i data-lucide="circle-check-big" data-content
                                                                                    class="h-4 w-4"></i>
                                                                            </button>
                                                                        @endif
                                                                        <button name="action" value="rejected"
                                                                            id="submitUpdateRejected-{{ $course['uid'] }}-{{ $participant['uid'] }}"
                                                                            data-submit-loader
                                                                            data-loader="#loaderUpdateRejected-{{ $course['uid'] }}-{{ $participant['uid'] }}"type="submit"
                                                                            data-hide-icon="true"
                                                                            class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-[#3a6f7a] focus:outline-none focus:ring-4 focus:ring-blue-300 rounded-lg transition duration-200 ease-in-out">
                                                                            <i data-lucide="loader-2"
                                                                                id="loaderUpdateRejected-{{ $course['uid'] }}-{{ $participant['uid'] }}"
                                                                                class="h-4 w-4 hidden animate-spin"></i>
                                                                            <i data-lucide="ban" data-content
                                                                                class="h-4 w-4"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <div id="update-user-approvement-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}"
                                                            tabindex="-1" aria-hidden="true"
                                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                            <div class="relative p-4 w-full max-w-md max-h-full">
                                                                <div class="relative bg-white rounded-lg shadow">
                                                                    <div
                                                                        class="flex items-center justify-between border-b p-4 rounded-t">
                                                                        <h3 class="text-lg font-semibold text-gray-900"
                                                                            id="modalTitle">
                                                                            Edit Persetujuan Praktikan
                                                                        </h3>
                                                                        <button type="button"
                                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                                            data-modal-toggle="update-user-approvement-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}">
                                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 14">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                            </svg>
                                                                            <span class="sr-only">Close modal</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="p-4">
                                                                        <form
                                                                            action="/dashboard/users/approval/update/{{ $participant['uid'] }}/{{ $participant['user']['uid'] }}"
                                                                            method="POST">
                                                                            @csrf

                                                                            <div class="grid gap-4">
                                                                                <div>
                                                                                    <label for="pembimbing"
                                                                                        class="block mb-2 text-sm font-medium text-gray-900">Pembimbing</label>
                                                                                    <select name="pembimbing"
                                                                                        id="pembimbing"
                                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                                                                        @foreach ($pembimbings as $pembimbing)
                                                                                            <option
                                                                                                value="{{ $pembimbing['uid'] }}"
                                                                                                {{ $pembimbing['uid'] == $participant['pembimbing']['uid'] ? 'selected' : '' }}>
                                                                                                {{ $pembimbing['full_name'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <div>
                                                                                    <label for="asisten"
                                                                                        class="block mb-2 text-sm font-medium text-gray-900">Asisten</label>
                                                                                    <select name="asisten" id="asisten"
                                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                                                                        @foreach ($asistens as $asisten)
                                                                                            <option
                                                                                                value="{{ $asisten['uid'] }}"
                                                                                                {{ $asisten['uid'] == $participant['asisten']['uid'] ? 'selected' : '' }}>
                                                                                                {{ $asisten['full_name'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <div>
                                                                                    <button
                                                                                        id="submitUpdatePraktikan-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}"
                                                                                        data-submit-loader
                                                                                        data-loader="#loaderUpdatePraktikan-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}"
                                                                                        type="submit"
                                                                                        class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                                        <i data-lucide="loader-2"
                                                                                            class="h-4 w-4 mr-2 hidden animate-spin"
                                                                                            id="loaderUpdatePraktikan-{{ $participant['user']['uid'] }}-{{ $session['uid'] }}"></i>
                                                                                        Update
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>


                                                                    {{-- <form class="p-4 md:p-5"
                                                                        action="/dashboard/superadmin/course-management/update/{{ $course['uid'] }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div
                                                                            class="grid gap-4 mb-4 grid-cols-2">
                                                                            <div class="col-span-2">
                                                                                <label for="code"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900">Kode</label>
                                                                                <input
                                                                                    value="{{ $course['code_course'] }}"
                                                                                    id="code"
                                                                                    type="text"
                                                                                    name="code"
                                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                                                                    placeholder="Kode Praktikum">
                                                                            </div>
                                                                            <div class="col-span-2">
                                                                                <label for="title"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                                                                                <input
                                                                                    value="{{ $course['title_course'] }}"
                                                                                    id="title"
                                                                                    type="text"
                                                                                    name="title"
                                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                                                                    placeholder="Judul Praktikum">
                                                                            </div>
                                                                            <div class="col-span-2">
                                                                                <label for="creator"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900">Creator</label>
                                                                                <select name="creator"
                                                                                    id="creator"
                                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                                                                    @foreach ($userSuperAdmins as $user)
                                                                                        <option
                                                                                            value="{{ $user['uid'] }}"
                                                                                            {{ $user['uid'] === $course['uid_creator_course'] ? 'selected' : '' }}>
                                                                                            {{ $user['full_name'] . ' | ' . $user['posisi'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-span-2">
                                                                                <label for="description"
                                                                                    class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                                                <textarea id="description" name="description" rows="4"
                                                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                                                    placeholder="Deskripsi praktikum">{{ $course['description_course'] }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <button
                                                                            id="submitUpdateCourse-{{ $course['uid'] }}"
                                                                            data-submit-loader
                                                                            data-loader="#loaderUpdateCourse-{{ $course['uid'] }}"
                                                                            type="submit"
                                                                            class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                            <i data-lucide="loader-2"
                                                                                class="h-4 w-4 mr-2 hidden animate-spin"
                                                                                id="loaderUpdateCourse-{{ $course['uid'] }}"></i>
                                                                            Update
                                                                        </button>
                                                                    </form> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>




        {{-- @foreach ($coursesList as $course)


        <div id="delete-modal-{{ $course['uid'] }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="delete-modal-{{ $course['uid'] }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <form action="/dashboard/superadmin/course-management/delete/{{ $course['uid'] }}" method="POST">
                            @csrf
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus praktikum <span class="font-semibold text-gray-900">{{ $course['title_course'] }}</span>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua pendaftaran terkait.</h3>
                            <input type="hidden" name="uid" value="{{ $course['uid'] }}">
                            <input id="title" type="text" name="title" class="my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="{{ $course['title_course'] }}">
                            <button id="submitDeleteCourse-{{ $course['uid'] }}" data-submit-loader data-loader="#loaderDeleteCourse-{{ $course['uid'] }}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderDeleteCourse-{{ $course['uid'] }}"></i>
                                Hapus
                            </button>
                            <button data-modal-toggle="delete-modal-{{ $course['uid'] }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}

    </main>
@endsection
