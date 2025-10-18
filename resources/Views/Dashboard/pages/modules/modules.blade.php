@extends('Dashboard.layouts.layout')
@section('Dashboard.layouts.layout')
    <main class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="font-headline text-2xl font-bold text-[#468B97]">Manajemen Modul</h1>
                <p class="text-sm text-gray-600">Buat dan kelola modul praktikum untuk semua kelompok.</p>
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
                                    @if (empty($course['modules']))
                                        <p class="text-gray-500 mt-1 text-center">Modul untuk praktikum ini belum ada</p>
                                    @else
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                            @foreach ($course['modules'] as $module)
                                                <div
                                                    class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <p class="text-base font-semibold text-gray-800">
                                                            {{ $module['name_module'] }}
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                                            <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                                            Aktif
                                                        </span>
                                                    </div>
                                                    <div class="space-y-2 text-sm text-gray-600">
                                                        <p class="flex items-center">
                                                            <i data-lucide="book-key"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Kode: {{ $module['code_module'] }}
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i data-lucide="file-text"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Deskripsi: {{ $module['description_module'] }}
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i data-lucide="calendar"
                                                                class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                            Tanggal: {{ date('d-m-Y', strtotime($module['date_module'])) }}
                                                        </p>
                                                        @if (!empty($module['file_module']))
                                                            <p class="flex items-center">
                                                                <i data-lucide="file"
                                                                    class="h-4 w-4 mr-2 text-[#468B97]"></i>
                                                                File: {{ $module['file_module'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="flex gap-2 mt-3">
                                                        <button
                                                            class="flex-1 flex items-center justify-center border border-[#468B97] text-[#468B97] py-2 px-3 rounded-lg text-sm hover:bg-[#468B97] hover:text-white transition-colors duration-200"
                                                            data-modal-target="update-module-modal-{{ $module['uid'] }}"
                                                            data-modal-toggle="update-module-modal-{{ $module['uid'] }}">
                                                            <i data-lucide="edit" class="h-4 w-4 mr-2"></i>
                                                            Edit
                                                        </button>
                                                        <button
                                                            class="flex-1 flex items-center justify-center bg-red-500 text-white py-2 px-3 rounded-lg text-sm hover:bg-red-600 transition-colors duration-200"
                                                            data-modal-target="delete-module-modal-{{ $module['uid'] }}"
                                                            data-modal-toggle="delete-module-modal-{{ $module['uid'] }}">
                                                            <i data-lucide="trash" class="h-4 w-4 mr-2"></i>
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="flex justify-center mt-6">
                                        <button
                                            class="flex items-center gap-2 bg-[#468B97] text-white px-4 py-2 mb-4 rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50"
                                            data-modal-target="create-module-modal-{{ $course['uid'] }}"
                                            data-modal-toggle="create-module-modal-{{ $course['uid'] }}">
                                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                            Tambah Modul Praktikum
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($courses as $course)
            <div id="update-course-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-[#468B97]" id="modalTitle">
                                Edit {{ $course['name_course'] }}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="update-course-modal-{{ $course['uid'] }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form class="p-4 md:p-5" action="/dashboard/courses/update/{{ $course['uid'] }}" method="POST">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="code"
                                        class="block mb-2 text-sm font-medium text-gray-900">Kode</label>
                                    <input value="{{ $course['code_course'] }}" id="code" type="text"
                                        name="code"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                        placeholder="Kode Praktikum">
                                </div>
                                <div class="col-span-2">
                                    <label for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                                    <input value="{{ $course['name_course'] }}" id="title" type="text"
                                        name="title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                        placeholder="Nama Praktikum">
                                </div>
                                <div class="col-span-2">
                                    <label for="study"
                                        class="block mb-2 text-sm font-medium text-gray-900">Study</label>
                                    <select name="study" id="study"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                        @foreach ($programStudies as $study)
                                            <option value="{{ $study['uid'] }}"
                                                {{ $course['study_course'] === $study['uid'] ? 'selected' : '' }}>
                                                {{ $study['name_study'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label for="semester"
                                        class="block mb-2 text-sm font-medium text-gray-900">Semester</label>
                                    <select name="semester" id="semester"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}"
                                                {{ $course['semester_course'] == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label for="author"
                                        class="block mb-2 text-sm font-medium text-gray-900">Author</label>
                                    <select name="author" id="author"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                        @foreach ($users as $dataUser)
                                            <option value="{{ $dataUser['uid'] }}"
                                                {{ $dataUser['uid'] === $user['uid'] ? 'selected' : '' }}>
                                                {{ $dataUser['full_name'] }}
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
                            <button id="submitUpdateCourse-{{ $course['uid'] }}" data-submit-loader
                                data-loader="#loaderUpdateCourse-{{ $course['uid'] }}" type="submit"
                                class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                    id="loaderUpdateCourse-{{ $course['uid'] }}"></i>
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="delete-course-modal-{{ $course['uid'] }}" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="delete-course-modal-{{ $course['uid'] }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <form action="/dashboard/courses/delete/{{ $course['uid'] }}" method="POST">
                                @csrf
                                <svg class="animate-bounce mx-auto mb-4 text-red-400 w-10 h-10" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus <span
                                        class="font-semibold text-gray-900">{{ $course['name_course'] }}</span>?
                                    Tindakan
                                    ini tidak dapat dibatalkan dan akan menghapus semua pendaftaran terkait.</h3>
                                <input id="title" type="text" name="title"
                                    class="my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                    placeholder="{{ $course['name_course'] }}">
                                <button id="submitDeleteCourse-{{ $course['uid'] }}" data-submit-loader
                                    data-loader="#loaderDeleteCourse-{{ $course['uid'] }}" type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                        id="loaderDeleteCourse-{{ $course['uid'] }}"></i>
                                    Hapus
                                </button>
                                <button data-modal-toggle="delete-course-modal-{{ $course['uid'] }}" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="create-module-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="font-semibold text-[#468B97]" id="modalTitle">
                                Modul untuk {{ $course['name_course'] }}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="create-module-modal-{{ $course['uid'] }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="p-4 md:p-5" action="/dashboard/modules/create/{{ $course['uid'] }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="file_module" class="block mb-2 text-sm font-medium text-gray-900">File
                                        Modul</label>
                                    <input type="file" name="file_module" id="file_module"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                </div>
                                <div class="col-span-2">
                                    <label for="code_module" class="block mb-2 text-sm font-medium text-gray-900">Kode
                                        Modul</label>
                                    <input id="code_module" type="text" name="code_module"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                        placeholder="Kode Modul">
                                </div>
                                <div class="col-span-2">
                                    <label for="name_module" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                        Modul</label>
                                    <input id="name_module" type="text" name="name_module"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                        placeholder="Nama Modul">
                                </div>
                                <div class="col-span-2">
                                    <label for="description_module"
                                        class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Modul</label>
                                    <textarea id="description_module" name="description_module" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Deskripsi Modul"></textarea>
                                </div>
                                <div class="col-span-2">
                                    <label for="date_module" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                        Modul</label>
                                    <input id="date_module" type="date" name="date_module"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                </div>
                            </div>
                            <button id="submitCreateModule-{{ $course['uid'] }}" data-submit-loader
                                data-loader="#loaderCreateModule-{{ $course['uid'] }}" type="submit"
                                class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                    id="loaderCreateModule-{{ $course['uid'] }}"></i>
                                Tambah Sesi Baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($course['modules'] as $module)
                <div id="update-module-modal-{{ $module['uid'] }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                <div>
                                    <h3 class="text-lg font-semibold text-[#468B97]" id="modalTitle">Edit
                                        {{ $module['name_module'] }}</h3>
                                    <p class="text-sm text-gray-600">untuk {{ $course['name_course'] }}</p>
                                </div>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-toggle="update-module-modal-{{ $module['uid'] }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form class="p-4 md:p-5" action="/dashboard/modules/update/{{ $module['uid'] }}/course/{{ $course['uid'] }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="file_module" class="block mb-2 text-sm font-medium text-gray-900">File
                                            Modul</label>
                                        <input type="file" name="file_module" id="file_module"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="code_module" class="block mb-2 text-sm font-medium text-gray-900">Kode
                                            Modul</label>
                                        <input value="{{ $module['code_module'] }}" id="code_module" type="text" name="code_module"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                            placeholder="Kode Modul">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="name_module" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                            Modul</label>
                                        <input value="{{ $module['name_module'] }}" id="name_module" type="text" name="name_module"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                            placeholder="Nama Modul">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description_module"
                                            class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Modul</label>
                                        <textarea id="description_module" name="description_module" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Deskripsi Modul">{{ $module['description_module'] }}</textarea>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="date_module"
                                            class="block mb-2 text-sm font-medium text-gray-900">Tanggal Modul</label>
                                        <input value="{{ $module['date_module'] }}" id="date_module" type="date" name="date_module"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                    </div>
                                </div>
                                <button id="submitUpdateModule-{{ $module['uid'] }}" data-submit-loader
                                    data-loader="#loaderUpdateModule-{{ $module['uid'] }}" type="submit"
                                    class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                        id="loaderUpdateModule-{{ $module['uid'] }}"></i>
                                    Update Modul
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete-module-modal-{{ $module['uid'] }}" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="delete-module-modal-{{ $module['uid'] }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <form action="/dashboard/modules/delete/{{ $module['uid'] }}" method="POST">
                                    @csrf
                                    <svg class="animate-bounce mx-auto mb-4 text-red-400 w-10 h-10" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus
                                        <span class="font-semibold text-gray-900">
                                            {{ $module['name_module'] }} pada {{ $course['name_course'] }}
                                        </span>
                                        ? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua pendaftaran terkait.
                                    </h3>
                                    <input id="title" type="text" name="name_module"
                                        class="my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5"
                                        placeholder="{{ $module['name_module'] }}">
                                    <button id="submitDeleteModule-{{ $module['uid'] }}" data-submit-loader
                                        data-loader="#loaderDeleteModule-{{ $module['uid'] }}" type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin"
                                            id="loaderDeleteModule-{{ $module['uid'] }}"></i>
                                        Hapus
                                    </button>
                                    <button data-modal-toggle="delete-module-modal-{{ $module['uid'] }}" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </main>
@endsection
