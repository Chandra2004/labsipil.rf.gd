@extends('Auth.layouts.layout')
@section('Auth-layouts-layout')
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="p-6 text-center">
            <div class="mb-4 flex justify-center">
                <a href="/" class="flex items-center gap-2 font-bold text-xl font-headline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-hard-hat h-7 w-7 text-[#468B97]">
                        <path d="M10 10V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5"></path>
                        <path d="M14 6a6 6 0 0 1 6 6v3"></path>
                        <path d="M4 15v-3a6 6 0 0 1 6-6"></path>
                        <rect x="2" y="15" width="20" height="4" rx="1"></rect>
                    </svg>
                    <span class="font-headline">Civil Praktikum Manager</span>
                </a>
            </div>
            <h1 class="font-headline text-2xl font-bold">Masuk ke Akun Anda</h1>
            <p class="text-gray-500 mt-1">Masukkan Email atau NPM dan Password.</p>
        </div>
        <div class="p-6">
            <form id="loginForm" class="grid gap-4" action="/login/auth" method="POST">
                @csrf
                <div class="grid gap-2">
                    <label for="identifier" class="text-sm font-medium">NPM/Email</label>
                    <input name="identifier" id="identifier" type="text" placeholder="00.0000.0.00000"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input name="password" id="password" type="password" placeholder="••••••••"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <button type="submit" id="submitLoginUser" data-submit-loader data-loader="#loaderLoginUser"
                    class="flex items-center justify-center w-full bg-[#468B97] text-white rounded-md py-2 hover:bg-[#3a6f7a] transition-colors">
                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderLoginUser"></i>
                    Login
                </button>
            </form>
            <div class="mt-4 text-center text-sm">
                <span>
                    Belum punya akun? <a href="/register" class="underline text-[#468B97]">Register</a>
                </span>
                <br>
                <span>
                    <a href="/" class="underline text-[#468B97]">kembali ke beranda</a>
                </span>
            </div>
        </div>
    </div>
@endsection
