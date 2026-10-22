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
                background: rgba(15, 23, 42, 0.35) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36), inset 0 1px 0 0 rgba(255, 255, 255, 0.1) !important;
            }
    </head>
    <body class="font-sans text-gray-200 antialiased bg-[#03071E] min-h-screen">
        <!-- FLOATING GLASS NAVBAR -->
        <header class="sticky top-4 z-50 mx-auto max-w-6xl px-4 sm:px-6">
            <nav class="rounded-2xl border border-white/15 bg-slate-900/35 backdrop-blur-xl px-5 py-3.5 flex items-center justify-between shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.1)] relative" style="-webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px);">
                <!-- Brand Logo Lockup -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl" style="text-decoration: none;">
                    <div class="relative">
                        <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" class="h-9 w-9 rounded-full object-cover ring-2 ring-cyan-400/40 group-hover:ring-cyan-400 transition-all shadow-[0_0_15px_rgba(56,189,248,0.3)]">
                        <div class="absolute inset-0 rounded-full bg-cyan-400/20 animate-pulse"></div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5 leading-none">
                            <span class="font-['Orbitron'] font-extrabold text-base tracking-wider text-white">IEE</span>
                            <span class="font-['Orbitron'] font-black text-base text-[#FACC15]">2026</span>
                        </div>
                        <span class="font-['JetBrains_Mono'] text-[9px] uppercase tracking-widest text-slate-400 group-hover:text-slate-300 transition-colors">
                            IEEE SB UNRI
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/') }}#competitions" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
                        Competitions
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
                    </a>
                    <a href="{{ url('/') }}#gallery" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
                        Gallery
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
                    </a>
                    <a href="{{ url('/') }}#about" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
                    </a>
                </div>

                <!-- Right Action / Auth Buttons -->
                <div class="hidden sm:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all" style="text-decoration: none;">
                            Dashboard
                        </a>
                    @else
                        @if (Route::has('login'))
                            @if (request()->routeIs('login'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all" style="text-decoration: none;">
                                    Register
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all" style="text-decoration: none;">
                                    Login
                                </a>
                            @endif
                        @endif
                    @endauth
                </div>

                <!-- Mobile Menu Toggle Button -->
                <button 
                    id="mobileMenuBtn"
                    type="button" 
                    class="md:hidden p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 backdrop-blur-md text-slate-300 hover:text-white transition-all focus:outline-none shadow-sm"
                    style="-webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);"
                    aria-label="Toggle navigation menu"
                    onclick="document.getElementById('mobileMenu').classList.toggle('hidden'); document.getElementById('mobileMenu').classList.toggle('flex');"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Mobile Dropdown Menu -->
                <div id="mobileMenu" class="hidden absolute top-full left-0 right-0 mt-3 p-5 rounded-2xl border border-white/15 flex-col gap-4 md:hidden" style="background: #070d28 !important; box-shadow: 0 25px 50px -10px rgba(0,0,0,0.95), inset 0 1px 0 0 rgba(255,255,255,0.15); z-index: 9999;">
                    <a href="{{ url('/') }}#competitions" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5" style="text-decoration: none;">Competitions</a>
                    <a href="{{ url('/') }}#gallery" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5" style="text-decoration: none;">Gallery</a>
                    <a href="{{ url('/') }}#about" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5" style="text-decoration: none;">Contact</a>
                    <div class="pt-2 flex flex-col gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] transition-all" style="text-decoration: none;">Dashboard</a>
                        @else
                            @if (Route::has('login'))
                                @if (request()->routeIs('login'))
                                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] text-[#03071E]" style="text-decoration: none;">Register</a>
                                @else
                                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] text-[#03071E]" style="text-decoration: none;">Login</a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        {{-- Auth page wrapper --}}
        <div class="relative overflow-x-hidden flex flex-col items-center justify-center px-4 sm:px-6"
             style="min-height: calc(100vh - 90px); padding-top: 32px; padding-bottom: 48px;">
            {{-- Glow effects (absolute so they don't cause overflow) --}}
            <div class="absolute top-1/4 left-0 w-80 h-80 sm:w-96 sm:h-96 bg-[#303AE4] rounded-full mix-blend-screen blur-[100px] opacity-30 pointer-events-none z-0" style="max-width: 100%;"></div>
            <div class="absolute bottom-1/4 right-0 w-80 h-80 sm:w-96 sm:h-96 bg-[#FFC209] rounded-full mix-blend-screen blur-[100px] opacity-20 pointer-events-none z-0" style="max-width: 100%;"></div>

            <div class="relative z-10 w-full sm:max-w-md">
                <div class="w-full px-6 py-8 bg-[#111827] shadow-[0_0_30px_rgba(255,194,9,0.15)] border border-[#303AE4]/30 rounded-2xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
