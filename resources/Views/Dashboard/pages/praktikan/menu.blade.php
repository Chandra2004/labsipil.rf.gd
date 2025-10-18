<li>
    <button type="button" class="flex items-center w-full p-2 text-base py-3 px-5" aria-controls="dropdown-praktikum" data-collapse-toggle="dropdown-praktikum">
        <i data-lucide="book-open" class="w-5 h-5"></i>
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Praktikum</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
    <ul id="dropdown-praktikum" class="hidden py-2 space-y-2">
        <li>
            <a href="/dashboard/courses/register" class="flex items-center w-full p-2 text-base py-3 px-5 gap-2 transition duration-75 rounded-lg {{ request()->is('/dashboard/courses/register') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }}">
                <i data-lucide="book-open-check" class="shrink-0 w-5 h-5 transition duration-75"></i>
                <span>Daftar Praktikum</span>
            </a>
        </li>
        <li>
            <a href="/dashboard/courses/history" class="flex items-center w-full p-2 text-base py-3 px-5 gap-2 transition duration-75 rounded-lg {{ request()->is('/dashboard/courses/history') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }}">
                <i data-lucide="history" class="shrink-0 w-5 h-5 transition duration-75"></i>
                <span>History Praktikum</span>
            </a>
        </li>
        <li>
            <a href="/dashboard/courses/card" class="flex items-center w-full p-2 text-base py-3 px-5 gap-2 transition duration-75 rounded-lg {{ request()->is('/dashboard/courses/card') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }}">
                <i data-lucide="id-card" class="shrink-0 w-5 h-5 transition duration-75"></i>
                <span>Kartu Praktikum</span>
            </a>
        </li>
    </ul>
</li>
{{-- <li>
    <a href="/dashboard/card"
        class="{{ request()->is('/dashboard/card') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900' }} flex items-center py-3 px-5 rounded-lg">
        <i data-lucide="id-card" class="w-5 h-5"></i>
        <span class="ml-3">Card</span>
    </a>
</li> --}}