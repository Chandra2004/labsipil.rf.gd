<!DOCTYPE html>
<html lang="id">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
        <title>Login - Civil Praktikum Manager</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="{{ url('/assets/js/tailwind-3.4.16.js') }}"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
</head>

<body class="bg-[#E0E8E9] flex min-h-screen items-center justify-center p-4">
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
            <div>
                @include('notification.notification')
            </div>
            <form id="loginForm" class="grid gap-4" action="/login/auth" method="POST">
                @csrf
                <div class="grid gap-2">
                    <label for="identyfier" class="text-sm font-medium">NPM/Email</label>
                    <input name="identyfier" id="identyfier" type="text" placeholder="00.0000.0.00000" required
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input name="password" id="password" type="password" placeholder="••••••••" required
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <button type="submit" name="loginUser"
                    class="w-full bg-[#468B97] text-white rounded-md py-2 hover:bg-[#3a6f7a] transition-colors">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center text-sm">
                Belum punya akun? <a href="/register" class="underline text-[#468B97]">Register</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
