{{-- <li>
    <a href="/users"
        class="{{ request()->is('users') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
        <i data-lucide="users" class="w-5 h-5"></i>
        <span class="ml-3">Pengguna</span>
    </a>
</li> --}}
<li>
    <a href="/dashboard/courses"
        class="{{ request()->is('/dashboard/courses') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
        <i data-lucide="book-open" class="w-5 h-5"></i>
        <span class="ml-3">Praktikum</span>
    </a>
</li>
<li>
    <a href="/dashboard/modules"
        class="{{ request()->is('/dashboard/modules') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
        <i data-lucide="book" class="w-5 h-5"></i>
        <span class="ml-3">Modul</span>
    </a>
</li>
<li>
    <button type="button" class="flex items-center w-full p-2 text-base py-3 px-5" aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
        <i data-lucide="user" class="w-5 h-5"></i>
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">User</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
    <ul id="dropdown-user" class="hidden py-2 space-y-2">
        <li>
            <a href="/dashboard/users/approval" class="flex items-center w-full p-2 text-base py-3 px-5 gap-2 transition duration-75 rounded-lg {{ request()->is('/dashboard/courses/approval') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }}">
                <i data-lucide="user-check" class="shrink-0 w-5 h-5 transition duration-75"></i>
                <span class="text-sm">Persetujuan Praktikum</span>
            </a>
        </li>
    </ul>
</li>