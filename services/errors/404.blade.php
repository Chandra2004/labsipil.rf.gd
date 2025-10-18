@extends('Guest.layouts.layout')
@section('Guest.layouts.layout')
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="text-center">
            <div class="error-number error-animation">404</div>
            <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight mb-4">
                Halaman Tidak Ditemukan
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Maaf, halaman yang Anda cari tidak ditemukan.
                Mungkin halaman tersebut telah dipindahkan atau dihapus.
            </p>
        </div>
    </div>
@endsection