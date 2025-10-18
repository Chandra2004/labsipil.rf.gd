<!DOCTYPE html>
<html lang="id">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="shortcut icon" href="{{ url('/file/public/favicon.ico') }}" type="image/x-icon">
        <title>{{ $title }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">

        <script src="https://unpkg.com/lucide@latest"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-background flex min-h-screen items-center justify-center p-4">
    @include('notification.notification')

    @yield('Auth-layouts-layout')

    <script src="{{ url('/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
