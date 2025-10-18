@extends('Guest.layouts.layout')
@section('Guest.layouts.layout')
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="text-center">
            <div class="error-number error-animation">403</div>
            <!-- Error Message -->
            <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight mb-4">
                Akses Ditolak
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
            </p>
        </div>
    </div>
@endsection