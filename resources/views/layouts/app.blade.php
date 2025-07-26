<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Icon Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Vite untuk Tailwind & JavaScript -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles') {{-- Untuk tambahan CSS di halaman tertentu --}}
</head>

<body class="font-sans antialiased bg-white text-gray-800">

    <div class="min-h-screen flex flex-col">
        {{-- Navigation Bar --}}
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="min-h-screen px-4 sm:px-6 lg:px-8 py-6 bg-white shadow-md">
            {{ $slot }}
        </main>
            <diV class="max-w-7xl mx-auto py-2 px-2 mb-2">
                <p class="text-base text-[#565d59] text-center mt-2">
                        &copy; {{ date('Y') }} Ibnu Nur Azis - Semua Hak Dilindungi.
                        
                    </p>
                </diV>
    </div>
    @stack('scripts') {{-- Untuk tambahan script di halaman tertentu --}}



    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    
</body>

</html>
