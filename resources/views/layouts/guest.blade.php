<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet" />
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { background: #050811 !important; }
            .navbar {
                background: rgba(5, 8, 17, 0.9) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-200 antialiased">
        <!-- NAVBAR -->
        <nav class="navbar" id="navbar">
            <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-logo" style="text-decoration: none;">
                <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" style="height: 40px; width: auto; border-radius: 50%; margin-right: 8px;">
                <span class="logo-text">IEE</span>
                <span class="logo-year">2026</span>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ url('/') }}#competitions" class="nav-link">Competitions</a></li>
                <li><a href="{{ url('/') }}#gallery" class="nav-link">Gallery</a></li>
                <li><a href="{{ url('/') }}#about" class="nav-link">Contact</a></li>
                @if (Route::has('login'))
                    <li><a href="{{ route('login') }}" class="nav-link nav-login">Login</a></li>
                @endif
            </ul>
            <div class="nav-hamburger" id="hamburger">
                <span></span><span></span><span></span>
            </div>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-24 sm:pt-0 relative overflow-hidden">
            <!-- Glow Effect -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#303AE4] rounded-full mix-blend-screen filter blur-[100px] opacity-30"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#FFC209] rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
            
            <div class="relative z-10 w-full flex justify-center mt-20 mb-10">
                <div class="w-full sm:max-w-md px-6 py-8 bg-[#111827] shadow-[0_0_30px_rgba(255,194,9,0.15)] border border-[#303AE4]/30 overflow-hidden sm:rounded-2xl relative z-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
