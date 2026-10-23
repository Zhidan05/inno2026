<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnoElectrica EXPO 2026 | IEEE Student Branch Universitas Riau</title>
  
  <!-- Fonts: Space Grotesk (Headings), Plus Jakarta Sans & Inter (Body), JetBrains Mono (Tech Metadata), Orbitron (Accent/Brand) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Orbitron:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Vite Scripts for React / Thumbnail Carousel and Frontend Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Tailwind CSS Play CDN for instant, guaranteed zero-runtime-error styling -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            midnight: '#03071E',
            abyss: '#050B24',
            cyber: {
              cyan: '#38BDF8',
              blue: '#2563EB',
              cobalt: '#1D4ED8',
              amber: '#FACC15',
              gold: '#F59E0B',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', '"Inter"', 'sans-serif'],
            heading: ['"Space Grotesk"', 'sans-serif'],
            display: ['"Space Grotesk"', 'sans-serif'],
            brand: ['"Orbitron"', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'monospace'],
          }
        }
      }
    }
  </script>

  <style>
    /* Architectural Blueprint & Spotlight System */
    :root {
      --bg-abyss: #03071E;
      --card-navy: rgba(10, 18, 44, 0.72);
      --border-tech: rgba(59, 130, 246, 0.18);
      --accent-blue: #2563EB;
      --accent-cyan: #38BDF8;
      --accent-amber: #FACC15;
    }

    body {
      background-color: var(--bg-abyss);
      color: #F8FAFC;
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
    }

    /* 1px Engineering Blueprint Grid with radial decay */
    .blueprint-grid {
      background-size: 48px 48px;
      background-image: 
        linear-gradient(to right, rgba(56, 189, 248, 0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(56, 189, 248, 0.04) 1px, transparent 1px);
      mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
      -webkit-mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
    }

    /* Linear / Raycast Style Spotlight Card Effect */
    .spotlight-card {
      position: relative;
      background: var(--card-navy);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid var(--border-tech);
      border-radius: 1rem;
      transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .spotlight-card:hover {
      border-color: rgba(56, 189, 248, 0.45);
      box-shadow: 0 10px 30px -10px rgba(37, 99, 235, 0.2);
    }

    .spotlight-card::before {
      content: '';
      position: absolute;
      inset: -1px;
      border-radius: inherit;
      padding: 1px;
      background: radial-gradient(400px circle at var(--mouse-x, -999px) var(--mouse-y, -999px), rgba(56, 189, 248, 0.5), transparent 60%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 2;
    }

    .spotlight-card:hover::before {
      opacity: 1;
    }

    .spotlight-card::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background: radial-gradient(500px circle at var(--mouse-x, -999px) var(--mouse-y, -999px), rgba(37, 99, 235, 0.08), transparent 70%);
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 1;
    }

    .spotlight-card:hover::after {
      opacity: 1;
    }

    /* Glowing Accents */
    .glow-amber-btn {
      box-shadow: 0 0 25px -4px rgba(250, 204, 21, 0.35);
    }
    .glow-amber-btn:hover {
      box-shadow: 0 0 35px -2px rgba(250, 204, 21, 0.55);
    }

    .glow-blue-btn {
      box-shadow: 0 0 25px -4px rgba(37, 99, 235, 0.4);
    }
    .glow-blue-btn:hover {
      box-shadow: 0 0 35px -2px rgba(56, 189, 248, 0.55);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #03071E;
    }
    ::-webkit-scrollbar-thumb {
      background: #1E293B;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #334155;
    }

    /* SideRays (React Bits) WebGL Styles */
    .side-rays {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
      pointer-events: none;
    }
    .side-rays__canvas {
      position: absolute;
      inset: 0;
      display: block;
      width: 100%;
      height: 100%;
    }

    /* Mascot Floating & Entrance Animations */
    @keyframes mascotEntrance {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    .animate-mascot-entrance {
      animation: mascotEntrance 0.8s ease-out forwards;
    }

    @keyframes mascot-float {
      0%, 100% {
        transform: translate3d(0px, 0px, 0) rotate(0deg);
      }
      25% {
        transform: translate3d(6px, -10px, 0) rotate(1.5deg);
      }
      50% {
        transform: translate3d(-4px, -16px, 0) rotate(-1deg);
      }
      75% {
        transform: translate3d(-6px, -6px, 0) rotate(1deg);
      }
    }

    .animate-mascot-float {
      animation: mascot-float 5s ease-in-out infinite !important;
      will-change: transform;
    }
  </style>
</head>

<body class="bg-[#03071E] text-slate-100 antialiased selection:bg-[#FACC15] selection:text-[#03071E] relative">

  <!-- Ambient Background Lighting -->
  <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
    <!-- Blueprint Grid -->
    <div class="absolute inset-0 blueprint-grid"></div>
    <!-- Radial Top Gradient -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1100px] h-[550px] bg-gradient-to-b from-blue-600/15 via-cyan-500/5 to-transparent blur-[120px] rounded-full"></div>
    <!-- Subtle Bottom Glow -->
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[350px] bg-blue-900/10 blur-[140px] rounded-full"></div>
  </div>

  <!-- FLOATING GLASS NAVBAR -->
  <header class="sticky top-4 z-50 mx-auto max-w-6xl px-4 sm:px-6">
    <nav class="rounded-2xl border border-white/15 bg-slate-900/35 backdrop-blur-xl px-5 py-3.5 flex items-center justify-between shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.1)] relative" style="-webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px);">
      
      <!-- Brand Logo Lockup -->
      <a href="#home" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl">
        <div class="relative">
          <img 
            src="{{ asset('images/Logo.png') }}" 
            alt="InnoElectrica Logo" 
            class="h-9 w-9 rounded-full object-cover ring-2 ring-cyan-400/40 group-hover:ring-cyan-400 transition-all shadow-[0_0_15px_rgba(56,189,248,0.3)]"
          />
          <div class="absolute inset-0 rounded-full bg-cyan-400/10 pointer-events-none"></div>
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
        <a href="#competitions" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
          Competitions
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="#gallery" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
          Gallery
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="#about" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
          Contact
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
      </div>

      <!-- Right Action / Auth Buttons -->
      <div class="hidden sm:flex items-center gap-4">
        @auth
          <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all">
            Dashboard
          </a>
        @else
          @if (Route::has('login'))
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors px-3 py-1.5">
              Login
            </a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all">
                Register
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
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path id="hamburgerIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

      <!-- Mobile Dropdown Menu -->
      <div id="mobileMenu" class="hidden absolute top-full left-0 right-0 mt-3 p-5 rounded-2xl border border-white/15 bg-slate-950/60 backdrop-blur-2xl shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.08)] flex-col gap-4 md:hidden" style="-webkit-backdrop-filter: blur(24px); backdrop-filter: blur(24px);">
        <a href="#competitions" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Competitions</a>
        <a href="#gallery" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Gallery</a>
        <a href="#about" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Contact</a>
        <div class="pt-2 flex flex-col gap-2">
          @auth
            <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] transition-all">Dashboard</a>
          @else
            @if (Route::has('login'))
              <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-xl text-sm font-medium text-slate-200 hover:bg-white/5">Login</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] text-[#03071E]">Register</a>
              @endif
            @endif
          @endauth
        </div>
      </div>

    </nav>
  </header>

  <main class="relative z-10">

    <!-- HERO SECTION -->
    <section id="home" class="relative -mt-20 sm:-mt-24 pt-28 sm:pt-36 pb-20 sm:pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden text-center flex flex-col items-center justify-center">
      
      <!-- SideRays WebGL2 Background (React Bits) -->
      <div id="sideRaysContainer" class="side-rays absolute inset-0 pointer-events-none overflow-hidden -z-20">
        <canvas id="sideRaysCanvas" class="side-rays__canvas" aria-hidden="true"></canvas>
      </div>

      <!-- Aceternity Stars Background & Shooting Stars Layer -->
      <div class="absolute inset-0 pointer-events-none overflow-hidden -z-10">
        <!-- Twinkling Stars Canvas -->
        <canvas id="starsCanvas" class="w-full h-full absolute inset-0 pointer-events-none"></canvas>
        <!-- Shooting Stars SVG Layer -->
        <svg id="shootingStarsSvg" class="w-full h-full absolute inset-0 pointer-events-none">
          <defs>
            <linearGradient id="shootingStarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" style="stop-color: #2563EB; stop-opacity: 0;" />
              <stop offset="100%" style="stop-color: #38BDF8; stop-opacity: 1;" />
            </linearGradient>
            <linearGradient id="shootingStarGoldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" style="stop-color: #F59E0B; stop-opacity: 0;" />
              <stop offset="100%" style="stop-color: #FACC15; stop-opacity: 1;" />
            </linearGradient>
          </defs>
          <g id="shootingStarsGroup"></g>
        </svg>
      </div>

      <!-- Interactive SVG Schematic Visuals in Background -->
      <div class="absolute inset-0 pointer-events-none opacity-25 flex items-center justify-center -z-10">
        <svg class="w-full max-w-5xl h-auto" viewBox="0 0 1000 600" fill="none" stroke="currentColor">
          <!-- Concentric Architectural Precision Circles -->
          <circle cx="500" cy="300" r="260" stroke="rgba(56, 189, 248, 0.12)" stroke-dasharray="4 8" />
          <circle cx="500" cy="300" r="380" stroke="rgba(56, 189, 248, 0.08)" />
          <circle cx="500" cy="300" r="480" stroke="rgba(56, 189, 248, 0.04)" stroke-dasharray="12 12" />
          
          <!-- Circuit Horizon Trace Lines -->
          <path d="M50 300 H350 L420 230 H580 L650 300 H950" stroke="rgba(56, 189, 248, 0.15)" stroke-width="1.5" />
          <path d="M120 400 H380 L440 340 H560 L620 400 H880" stroke="rgba(250, 204, 21, 0.12)" stroke-width="1.2" />
          
          <!-- Node Dots -->
          <circle cx="420" cy="230" r="3" fill="#38BDF8" />
          <circle cx="580" cy="230" r="3" fill="#38BDF8" />
          <circle cx="440" cy="340" r="3" fill="#FACC15" />
          <circle cx="560" cy="340" r="3" fill="#FACC15" />
        </svg>
      </div>

      <div class="max-w-7xl mx-auto w-full flex flex-col items-center">

        <!-- 2-Column Responsive Hero Grid (Desktop: Mascot Left, Text Right; Mobile: Centered Mascot Above Text) -->
        <div class="w-full flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-10 lg:gap-12 xl:gap-16">
          
          <!-- MASCOT (Left on Desktop, Top on Mobile) -->
          <div class="relative flex justify-center items-center shrink-0 order-1 animate-mascot-entrance">
            <style>
              @keyframes mascot-float {
                0%, 100% {
                  transform: translate3d(0px, 0px, 0) rotate(0deg);
                }
                25% {
                  transform: translate3d(6px, -10px, 0) rotate(1.5deg);
                }
                50% {
                  transform: translate3d(-4px, -16px, 0) rotate(-1deg);
                }
                75% {
                  transform: translate3d(-6px, -6px, 0) rotate(1deg);
                }
              }

              .animate-mascot-float {
                animation: mascot-float 5s ease-in-out infinite !important;
                will-change: transform;
              }
            </style>

            <!-- Glow Effect behind Mascot -->
            <div class="absolute w-48 h-48 sm:w-60 sm:h-60 md:w-72 md:h-72 lg:w-80 lg:h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Floating Mascot Image -->
            <img 
              src="{{ asset('images/mascot.png') }}" 
              alt="IEE 2026 Mascot" 
              class="relative z-10 w-48 sm:w-60 md:w-72 lg:w-80 xl:w-96 h-auto object-contain drop-shadow-[0_15px_30px_rgba(59,130,246,0.3)] select-none pointer-events-none animate-mascot-float"
              style="animation: mascot-float 5s ease-in-out infinite !important; will-change: transform;"
              draggable="false"
            />
          </div>

          <!-- HERO CONTENT (Right on Desktop, Below Mascot on Mobile) -->
          <div class="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left max-w-2xl xl:max-w-3xl order-2">

            <!-- Cohesive Typographic Lockup Headline -->
            <h1 class="font-['Space_Grotesk'] font-black text-4xl sm:text-6xl lg:text-6xl xl:text-7xl tracking-tight leading-[1.05] text-white">
              InnoElectrica
              <span class="block mt-1 sm:mt-2 text-3xl sm:text-5xl lg:text-5xl xl:text-6xl font-extrabold">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-slate-200">EXPO</span>
                <span class="font-['Orbitron'] text-[#FACC15] ml-2 tracking-wider drop-shadow-[0_0_25px_rgba(250,204,21,0.4)]">2026</span>
              </span>
            </h1>

            <!-- Monospace Tagline -->
            <p class="font-['JetBrains_Mono'] font-bold text-xs sm:text-sm tracking-[0.22em] text-[#FACC15]/95 uppercase max-w-2xl mt-4 sm:mt-5">
              NEXT GEN INNOVATORS: WHERE SCIENCE MEETS THE FUTURE
            </p>

            <!-- Refined Body Description -->
            <p class="mt-4 text-slate-300 text-sm sm:text-base lg:text-lg max-w-xl font-normal leading-relaxed text-slate-300/90">
              Push the limits of smart systems, electrical innovation, and technological breakthroughs. The premier university technology competition of 2026.
            </p>

            <!-- Action CTA Buttons -->
            <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center lg:items-start gap-4 w-full sm:w-auto">
              <a 
                href="#competitions" 
                class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 font-heading font-bold text-sm tracking-wide text-white glow-blue-btn border border-blue-400/30 flex items-center justify-center gap-2.5 active:scale-95 transition-all"
              >
                <span>Explore Competitions</span>
                <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
              </a>

              @auth
                <a 
                  href="{{ route('dashboard') }}" 
                  class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-[#0A122C]/80 hover:bg-[#101c44] border border-blue-500/30 hover:border-blue-400/60 text-slate-200 font-heading font-semibold text-sm tracking-wide flex items-center justify-center active:scale-95 transition-all"
                >
                  Go to Dashboard
                </a>
              @else
                @if (Route::has('register'))
                  <a 
                    href="{{ route('register') }}" 
                    class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-[#0A122C]/80 hover:bg-[#101c44] border border-blue-500/30 hover:border-blue-400/60 text-slate-200 font-heading font-semibold text-sm tracking-wide flex items-center justify-center active:scale-95 transition-all"
                  >
                    Register Now
                  </a>
                @endif
              @endauth
            </div>

            <!-- Live Event Countdown HUD (Dynamic Database Driven) -->
            @php
              $countdownActive = ($eventSetting->countdown_enabled ?? false) && $eventSetting->countdown_target_at;
            @endphp
            @if($countdownActive)
            <div class="mt-10 sm:mt-12 w-full max-w-lg">
              <div class="font-['JetBrains_Mono'] text-[11px] tracking-widest text-slate-400 uppercase text-center lg:text-left mb-3 flex items-center justify-center lg:justify-start gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                <span>{{ e($eventSetting->countdown_label ?? 'EVENT COUNTDOWN') }}</span>
              </div>
              <div class="rounded-2xl border border-blue-500/20 bg-[#0A122C]/75 backdrop-blur-xl p-5 shadow-2xl">
                <div class="grid grid-cols-4 gap-2 text-center items-center">
                  <div class="flex flex-col items-center">
                    <span class="font-['Space_Grotesk'] font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight" id="cd-days">00</span>
                    <span class="font-['JetBrains_Mono'] text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Days</span>
                  </div>
                  <div class="flex flex-col items-center">
                    <span class="font-['Space_Grotesk'] font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight" id="cd-hours">00</span>
                    <span class="font-['JetBrains_Mono'] text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Hours</span>
                  </div>
                  <div class="flex flex-col items-center">
                    <span class="font-['Space_Grotesk'] font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight" id="cd-mins">00</span>
                    <span class="font-['JetBrains_Mono'] text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Mins</span>
                  </div>
                  <div class="flex flex-col items-center">
                    <span class="font-['Space_Grotesk'] font-bold text-3xl sm:text-4xl text-[#FACC15] tracking-tight" id="cd-secs">00</span>
                    <span class="font-['JetBrains_Mono'] text-[10px] tracking-wider text-slate-400 mt-1 uppercase">Secs</span>
                  </div>
                </div>
              </div>
            </div>
            <script>
              window.__COUNTDOWN_TARGET = "{{ $eventSetting->countdown_target_at->toIso8601String() }}";
            </script>
            @endif

          </div>

        </div>

        <!-- Minimal Animated Scroll Indicator -->
        <a href="#competitions" class="mt-12 sm:mt-16 inline-flex flex-col items-center gap-2 text-slate-400 hover:text-cyan-400 transition-colors group">
          <span class="font-['JetBrains_Mono'] text-[10px] tracking-[0.25em] uppercase text-slate-500 group-hover:text-cyan-400 transition-colors">SCROLL</span>
          <svg class="w-4 h-4 text-cyan-400/80 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
          </svg>
        </a>

      </div>
    </section>

    <!-- COMPETITIONS SECTION -->
    <section id="competitions" class="py-24 relative border-t border-blue-500/15 bg-[#050B24]/40">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header without Cliché AI Pulse -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
            <span>Competitions & Challenges</span>
          </div>
          <h2 class="text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
            Competitions
          </h2>
          <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
            Explore official engineering and technology innovation competitions at InnoElectrica EXPO 2026.
          </p>
        </div>

        @php
          // Helper: Distinct Minimalist Lucide Icons for each competition
          $getCompIconSvg = function($title, $slug = '') {
            $key = strtolower(($title ?? '') . ' ' . ($slug ?? ''));
            if (str_contains($key, 'code') || str_contains($key, 'program') || str_contains($key, 'algoritma') || str_contains($key, 'it')) {
              // Code Terminal
              return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>';
            } elseif (str_contains($key, 'paper') || str_contains($key, 'future') || str_contains($key, 'tulis') || str_contains($key, 'ilmiah') || str_contains($key, 'esai')) {
              // Research Document / Scientific Node
              return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>';
            } elseif (str_contains($key, 'race') || str_contains($key, 'line') || str_contains($key, 'robot') || str_contains($key, 'follower')) {
              // Autonomous Robot / Track Sensor
              return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="12" cy="5" r="2"></circle><path d="M12 7v4"></path><line x1="8" y1="16" x2="8.01" y2="16"></line><line x1="16" y1="16" x2="16.01" y2="16"></line></svg>';
            } elseif (str_contains($key, 'visual') || str_contains($key, 'poster') || str_contains($key, 'desain') || str_contains($key, 'design')) {
              // Design Layers / Graphic Vector
              return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 17 22 12"></polyline></svg>';
            } else {
              // Hardware / Prototype / General Trophy
              return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path></svg>';
            }
          };

          $compCount = count($competitions ?? []);
        @endphp

        <!-- Flexible Dynamic Bento Grid: Perfectly centered based on real competition count from database -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
          @forelse($competitions ?? [] as $index => $competition)
            @php
              $regType = $competition->registration_type ?? 'individual_or_team';
              $typeBadge = match($regType) {
                'individual' => 'SOLO',
                'team' => 'TEAM',
                'individual_or_team' => 'SOLO / TEAM',
                default => strtoupper(str_replace('_', ' ', $regType)),
              };

              $teamMax = (int) ($competition->max_team_members ?? 1);
              $teamLabel = match($regType) {
                'individual' => '1 Member (Solo)',
                'team' => 'Max ' . $teamMax . ' Members',
                'individual_or_team' => $teamMax > 1 ? '1 - ' . $teamMax . ' Members' : '1 Member',
                default => 'Max ' . $teamMax . ' Members',
              };

              $fee = (float) ($competition->registration_fee ?? 0);
              $feeFormatted = $fee > 0 ? 'IDR ' . number_format($fee, 0, ',', '.') : 'Free';

              $isExtended = $competition->isExtended();
              $status = $competition->status ?? 'draft';
              $isOpen = $competition->isRegistrationOpen();
              $statusLabel = $isExtended
                ? 'Registration Extended'
                : match($status) {
                  'extended' => 'Registration Extended',
                  'registration_open' => 'Registration Open',
                  'upcoming' => 'Upcoming',
                  'ongoing' => 'Ongoing',
                  'registration_closed' => 'Registration Closed',
                  'completed' => 'Competition Ended',
                  'results_published' => 'Results Announced',
                  default => ucfirst(str_replace('_', ' ', $status)),
                };

              $statusBadgeClass = ($isExtended || $status === 'extended')
                ? 'bg-amber-500/15 text-amber-300 border-amber-400/30'
                : match($status) {
                  'registration_open' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
                  'upcoming' => 'bg-amber-500/15 text-amber-300 border-amber-500/30',
                  'ongoing' => 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
                  'registration_closed' => 'bg-rose-500/15 text-rose-300 border-rose-500/30',
                  'completed' => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
                  'results_published' => 'bg-purple-500/15 text-purple-300 border-purple-500/30',
                  default => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
                };

              $subType = $competition->submission_type ?? 'none';
              $submissionLabel = match($subType) {
                'file' => 'Document / File Upload',
                'link' => 'Online URL / Link',
                'both' => 'Document File & URL Link',
                default => null,
              };

              // Collect ONLY real timeline dates present in database
              $timeline = [];
              if (!empty($competition->registration_open_at)) {
                $timeline[] = [
                  'phase' => 'Registration Opens',
                  'date' => $competition->registration_open_at->format('d M Y, H:i') . ' WIB',
                ];
              }
              if (!empty($competition->registration_close_at)) {
                $timeline[] = [
                  'phase' => 'Registration Closes',
                  'date' => $competition->registration_close_at->format('d M Y, H:i') . ' WIB',
                  'is_extended' => $isExtended,
                  'extended_date' => ($isExtended && $competition->extended_registration_close_at) ? $competition->extended_registration_close_at->format('d M Y, H:i') . ' WIB' : null,
                ];
              }
              if (!empty($competition->competition_start_at)) {
                $timeline[] = [
                  'phase' => 'Competition Begins',
                  'date' => $competition->competition_start_at->format('d M Y, H:i') . ' WIB',
                ];
              }
              if (!empty($competition->competition_end_at)) {
                $timeline[] = [
                  'phase' => 'Competition Ends',
                  'date' => $competition->competition_end_at->format('d M Y, H:i') . ' WIB',
                ];
              }

              $registerUrl = $isOpen ? route('competition.register', $competition->slug ?? '') : null;
              $extendedDateLabel = ($isExtended && $competition->extended_registration_close_at)
                ? 'Extended to ' . $competition->extended_registration_close_at->translatedFormat('l, d F Y')
                : null;

              // Schedule Info Bar Configuration (consistent across all competition statuses)
              if ($isExtended && $competition->extended_registration_close_at) {
                $scheduleBarClass = 'bg-amber-500/10 border-amber-400/25 text-amber-300';
                $scheduleIconClass = 'text-amber-400';
                $scheduleText = 'Extended to ' . $competition->extended_registration_close_at->translatedFormat('l, d F Y');
              } elseif ($isOpen || $status === 'registration_open') {
                $scheduleBarClass = 'bg-emerald-500/10 border-emerald-400/20 text-emerald-300';
                $scheduleIconClass = 'text-emerald-400';
                $scheduleText = $competition->registration_close_at 
                  ? 'Closes on ' . $competition->registration_close_at->translatedFormat('l, d F Y')
                  : 'Open for registration';
              } elseif ($status === 'completed' || $status === 'results_published') {
                $scheduleBarClass = 'bg-white/[0.03] border-white/10 text-slate-400';
                $scheduleIconClass = 'text-slate-400';
                $scheduleText = $competition->competition_end_at 
                  ? 'Ended on ' . $competition->competition_end_at->translatedFormat('l, d F Y')
                  : 'Ended on ' . ($competition->effective_registration_close_at?->translatedFormat('l, d F Y') ?? 'concluded');
              } elseif ($status === 'upcoming') {
                $scheduleBarClass = 'bg-cyan-500/10 border-cyan-400/20 text-cyan-300';
                $scheduleIconClass = 'text-cyan-400';
                $scheduleText = $competition->registration_open_at
                  ? 'Opens on ' . $competition->registration_open_at->translatedFormat('l, d F Y')
                  : 'Opening soon';
              } else {
                // Registration Closed / Ongoing / default
                $scheduleBarClass = 'bg-slate-800/60 border-white/10 text-slate-400';
                $scheduleIconClass = 'text-slate-400';
                $closedDate = $competition->effective_registration_close_at ?? $competition->registration_close_at;
                $scheduleText = $closedDate 
                  ? 'Registration closed on ' . $closedDate->translatedFormat('d F Y')
                  : 'Registration closed';
              }

              // Disabled button text: avoid repeating 'Competition Ended' when badge already says 'Competition Ended'
              $disabledButtonLabel = match($status) {
                'completed', 'results_published' => 'Registration Closed',
                'upcoming' => 'Upcoming',
                default => ($statusLabel === 'Competition Ended' ? 'Registration Closed' : $statusLabel),
              };

              $payload = [
                'name' => $competition->name ?? 'Competition',
                'slug' => $competition->slug ?? '',
                'description' => $competition->description ?? '',
                'team' => $teamLabel,
                'fee' => $feeFormatted,
                'badge' => $typeBadge,
                'status' => $statusLabel,
                'isExtended' => $isExtended,
                'extendedDateLabel' => $extendedDateLabel,
                'statusBadgeClass' => $statusBadgeClass,
                'location' => $competition->location ?? '',
                'submission' => $submissionLabel,
                'timeline' => $timeline,
                'isOpen' => $isOpen,
                'registerUrl' => $registerUrl,
              ];

              // Symmetrical dynamic grid column spans
              $colSpanClass = 'lg:col-span-2';
              if ($compCount === 1) {
                $colSpanClass = 'lg:col-span-6 max-w-xl mx-auto';
              } elseif ($compCount === 2) {
                $colSpanClass = 'lg:col-span-3';
              } elseif ($compCount === 4) {
                $colSpanClass = 'lg:col-span-3';
              } elseif ($compCount === 5) {
                $colSpanClass = ($index < 3) ? 'lg:col-span-2' : 'lg:col-span-3';
              } else {
                $colSpanClass = 'lg:col-span-2';
              }
            @endphp

            <div 
              class="{{ $colSpanClass }} comp-card-item spotlight-card relative rounded-2xl p-6 sm:p-7 flex flex-col justify-between group overflow-hidden transition-all duration-300 hover:-translate-y-1.5 cursor-pointer bg-[#070F2B]/75 hover:bg-[#0A1438]/90 border border-blue-500/20 hover:border-cyan-400/50 backdrop-blur-xl shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_20px_40px_-15px_rgba(37,99,235,0.35)]"
              onclick="openExpandableCard(this)"
              data-comp="{{ json_encode($payload) }}"
            >
              <!-- Top Card Accent Line -->
              <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent group-hover:via-cyan-300 transition-all"></div>
              
              <div>
                <!-- Card Header: Icon + Status & Type Badges -->
                <div class="flex items-center justify-between gap-3 mb-5">
                  <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/15 to-cyan-500/10 border border-cyan-400/25 flex items-center justify-center text-cyan-300 group-hover:scale-105 group-hover:border-cyan-300/50 group-hover:shadow-[0_0_20px_rgba(56,189,248,0.25)] transition-all shrink-0">
                    {!! $getCompIconSvg($competition->name ?? '', $competition->slug ?? '') !!}
                  </div>
                  <div class="flex items-center gap-2 min-w-0">
                    <span class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wide border whitespace-nowrap {{ $statusBadgeClass }}">
                      {{ $statusLabel }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase bg-blue-950/60 text-cyan-300 border border-cyan-500/25 whitespace-nowrap shrink-0">
                      <svg class="w-3 h-3 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span>{{ $typeBadge }}</span>
                    </span>
                  </div>
                </div>

                <!-- Title & Real Description from Database -->
                <div class="min-h-[3.5rem] sm:min-h-[3.75rem] flex items-start">
                  <h3 class="font-['Space_Grotesk'] font-bold text-xl sm:text-2xl text-white group-hover:text-cyan-300 transition-colors tracking-tight leading-snug">
                    {{ $competition->name ?? 'Competition' }}
                  </h3>
                </div>

                <!-- Description container with consistent min-height & clean 3-line clamp -->
                <div class="mt-2.5 mb-3 min-h-[4.5rem]">
                  @if(!empty($competition->description))
                    <p 
                      class="text-xs sm:text-sm text-slate-400"
                      style="padding: 0 !important; margin: 0 !important; line-height: 1.5rem; max-height: 4.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"
                    >
                      {{ $competition->description }}
                    </p>
                  @endif
                </div>
              </div>

              <!-- Card Footer: Stats & Expandable Action Buttons -->
              <div class="pt-4 border-t border-white/[0.08]">
                <!-- Consistent Schedule Info Bar for All Statuses -->
                <div class="flex items-center gap-2 px-3.5 py-2 mb-3 rounded-xl border text-xs font-medium {{ $scheduleBarClass }}">
                  <svg class="w-4 h-4 shrink-0 {{ $scheduleIconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="truncate">{{ $scheduleText }}</span>
                </div>

                <div class="grid grid-cols-2 gap-2.5 mb-4">
                  <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Team Format</span>
                    <span class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 truncate">
                      {{ $teamLabel }}
                    </span>
                  </div>
                  <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
                    <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Fee</span>
                    <span class="text-xs sm:text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 truncate">
                      {{ $feeFormatted }}
                    </span>
                  </div>
                </div>

                <!-- Dual Action: View Details (Expands) & Direct Register -->
                <div class="flex items-center gap-2">
                  <button 
                    type="button" 
                    onclick="openExpandableCard(this.closest('.comp-card-item'))"
                    class="flex-1 py-2.5 px-3 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 hover:text-white border border-white/10 font-['Space_Grotesk'] font-semibold text-xs transition-colors text-center cursor-pointer"
                  >
                    View Details
                  </button>
                  @if($isOpen)
                    <a 
                      href="{{ route('competition.register', $competition->slug ?? '') }}" 
                      onclick="event.stopPropagation()"
                      class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-['Space_Grotesk'] font-bold text-xs text-center shadow-[0_4px_16px_rgba(37,99,235,0.3)] hover:shadow-[0_6px_22px_rgba(56,189,248,0.4)] transition-all duration-200 active:scale-[0.98] group/btn"
                    >
                      <span>Register</span>
                      <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                      </svg>
                    </a>
                  @else
                    <button 
                      type="button" 
                      disabled 
                      onclick="event.stopPropagation()"
                      class="flex-1 py-2.5 px-3 rounded-xl bg-white/[0.04] text-slate-400 border border-white/10 font-['Space_Grotesk'] font-medium text-xs text-center cursor-not-allowed opacity-75"
                    >
                      {{ $disabledButtonLabel }}
                    </button>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full py-16 px-6 text-center rounded-3xl bg-[#070F2B]/50 border border-white/10 backdrop-blur-xl">
              <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
              </div>
              <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white mb-2">No Competitions Available</h3>
              <p class="text-slate-400 text-sm max-w-md mx-auto">
                Competitions are currently being prepared by the committee. Please check back regularly for the latest registration updates.
              </p>
            </div>
          @endforelse
        </div>

        <!-- Aceternity Expandable Card Modal Component (Shared-Element Morph Transition) -->
        <div 
          id="expandable-card-backdrop" 
          class="fixed inset-0 bg-[#03071E]/80 backdrop-blur-md z-[100] opacity-0 pointer-events-none transition-opacity duration-300"
          onclick="closeExpandableCard()"
        ></div>

        <div 
          id="expandable-card-container" 
          class="fixed inset-0 z-[101] grid place-items-center p-4 sm:p-6 pointer-events-none opacity-0 overflow-y-auto"
          onclick="closeExpandableCard()"
        >
          <!-- Aceternity Modal Card Dialog -->
          <div 
            id="expandable-card-dialog" 
            class="relative w-full max-w-[520px] max-h-[90vh] bg-[#070F2B] border border-cyan-500/30 rounded-3xl overflow-hidden shadow-[0_25px_60px_-15px_rgba(37,99,235,0.4)] flex flex-col my-auto backdrop-blur-2xl will-change-transform"
            onclick="event.stopPropagation()"
          >
            <!-- Close Button (Matching Aceternity CloseIcon) -->
            <button 
              type="button" 
              onclick="closeExpandableCard()" 
              class="exp-fade-item absolute top-3.5 right-3.5 sm:top-4 sm:right-4 z-30 flex items-center justify-center bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-white/20 rounded-full h-8 w-8 sm:h-9 sm:w-9 backdrop-blur-md transition-colors shadow-lg cursor-pointer"
              aria-label="Close"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
              </svg>
            </button>

            <!-- Visual Header / Banner matching card visual -->
            <div id="exp-banner" class="relative w-full h-44 sm:h-52 bg-gradient-to-br from-blue-950 via-[#070F2B] to-[#0A1438] border-b border-white/[0.08] flex items-center justify-center overflow-hidden shrink-0">
              <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-cyan-500/20 via-transparent to-transparent"></div>
              <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:20px_20px]"></div>
              
              <div id="exp-icon-container" class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/10 border border-cyan-400/30 flex items-center justify-center text-cyan-300 shadow-[0_0_30px_rgba(56,189,248,0.25)]"></div>

              <div class="absolute top-4 left-4 flex items-center gap-2">
                <span id="exp-status" class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold border backdrop-blur-md whitespace-nowrap"></span>
                <span id="exp-badge" class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold bg-blue-950/80 text-cyan-300 border border-cyan-500/30 uppercase font-['JetBrains_Mono'] backdrop-blur-md whitespace-nowrap shrink-0"></span>
              </div>
            </div>

            <!-- Aceternity Header: Title on left, CTA Button on right -->
            <div class="p-4 sm:p-5 flex justify-between items-start gap-4 border-b border-white/[0.06] shrink-0">
              <div class="min-w-0 pr-1">
                <h3 id="exp-title" class="font-['Space_Grotesk'] font-bold text-xl sm:text-2xl text-white tracking-tight leading-snug"></h3>
                <div class="flex items-center gap-2.5 mt-1">
                  <span id="exp-fee-badge" class="font-['Space_Grotesk'] font-bold text-xs sm:text-sm text-[#FACC15]"></span>
                </div>
              </div>

              <a 
                id="exp-register-btn" 
                href="#" 
                class="exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white shadow-[0_4px_16px_rgba(37,99,235,0.4)] transition-all shrink-0 cursor-pointer inline-flex items-center gap-1.5"
              >
                <span>Register Now</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
              </a>
            </div>

            <!-- Aceternity Scrollable Body Content (Real DB Only) -->
            <div class="pt-3 pb-6 px-4 sm:px-5 relative flex-1 overflow-hidden flex flex-col">
              <div 
                id="exp-scroll-body" 
                class="exp-fade-item text-slate-300 text-xs sm:text-sm overflow-y-auto pr-1 flex flex-col gap-4 max-h-[42vh] [mask:linear-gradient(to_bottom,white_85%,transparent)] [scrollbar-width:none] [-ms-overflow-style:none] [-webkit-overflow-scrolling:touch]"
              >
                <!-- Deskripsi Real DB -->
                <div id="exp-desc-wrapper">
                  <h4 class="text-[11px] font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold mb-1.5">
                    Competition Overview
                  </h4>
                  <p id="exp-description" class="text-slate-300 text-xs sm:text-sm leading-relaxed whitespace-pre-line"></p>
                </div>

                <!-- Info Extended Banner Real DB -->
                <div id="exp-extended-banner" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-amber-500/10 border border-amber-400/25 text-amber-300 text-xs font-medium shadow-[0_0_12px_rgba(245,158,11,0.08)] hidden">
                  <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span id="exp-extended-date"></span>
                </div>

                <!-- Info Stats Real DB -->
                <div class="grid grid-cols-2 gap-2.5 w-full">
                  <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3">
                    <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Participation Format</span>
                    <span id="exp-team" class="text-xs sm:text-sm font-semibold text-white mt-0.5 block"></span>
                  </div>
                  <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3">
                    <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Registration Fee</span>
                    <span id="exp-fee" class="text-xs sm:text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 block"></span>
                  </div>
                  <div id="exp-location-wrapper" class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3 hidden">
                    <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Event Location</span>
                    <span id="exp-location" class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 block"></span>
                  </div>
                  <div id="exp-submission-wrapper" class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-3 hidden">
                    <span class="text-[10px] uppercase font-['JetBrains_Mono'] tracking-wider text-slate-400 block">Submission Method</span>
                    <span id="exp-submission" class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 block"></span>
                  </div>
                </div>

                <!-- Jadwal Real DB -->
                <div id="exp-timeline-wrapper" class="space-y-2.5 pt-1 hidden w-full">
                  <h4 class="text-[11px] font-['JetBrains_Mono'] uppercase tracking-wider text-cyan-400 font-bold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>Official Timeline & Schedule</span>
                  </h4>
                  <div id="exp-timeline-list" class="grid grid-cols-1 sm:grid-cols-2 gap-2 w-full"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- GALLERY SECTION -->
    <section id="gallery" class="py-24 relative border-t border-blue-500/15 bg-[#03071E]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
            <span>Event Highlights</span>
          </div>
          <h2 class="mt-2 text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
            Gallery
          </h2>
          <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
            Highlights from past InnoElectrica editions.
          </p>
        </div>

        @php
          $galleryItems = [];
          foreach(($galleries ?? []) as $idx => $gallery) {
            $imgUrl = !empty($gallery->image) ? \Illuminate\Support\Facades\Storage::url($gallery->image) : null;
            if ($imgUrl) {
              $galleryItems[] = [
                'id' => $gallery->id ?? ($idx + 1),
                'url' => $imgUrl,
                'title' => $gallery->title ?? 'InnoElectrica Highlight',
                'number' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'tag' => 'IEE MOMENTS',
              ];
            }
          }
        @endphp

        <!-- React Framer Motion Thumbnail Carousel Container -->
        <div id="gallery-carousel-root" data-items="{{ json_encode($galleryItems) }}">
          @if(count($galleryItems) === 0)
            <div class="py-16 px-6 text-center rounded-2xl bg-[#070F2B]/40 border border-white/10 backdrop-blur-md max-w-lg mx-auto">
              <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-blue-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <p class="text-slate-300 font-['Space_Grotesk'] font-medium text-sm">Official event documentation will be updated regularly.</p>
              <p class="text-slate-500 text-xs mt-1">Event highlights will be published by the organizing committee.</p>
            </div>
          @else
            {{-- Initial server-rendered carousel structure for instant visual appearance and graceful degradation --}}
            <div class="w-full max-w-5xl mx-auto px-2 sm:px-4">
              <div class="flex flex-col gap-6">
                <div class="relative overflow-hidden rounded-2xl bg-[#0A122C]/80 border border-white/10 shadow-[0_12px_40px_rgba(0,0,0,0.6)] backdrop-blur-sm">
                  <div class="relative w-full h-[320px] sm:h-[420px] md:h-[500px]">
                    <img 
                      src="{{ $galleryItems[0]['url'] }}" 
                      alt="{{ $galleryItems[0]['title'] }}" 
                      class="w-full h-full object-cover select-none"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#03071E] via-[#03071E]/30 to-transparent"></div>
                    <div class="absolute top-4 left-4 font-['JetBrains_Mono'] text-xs font-semibold px-3 py-1 rounded-md bg-[#03071E]/80 border border-white/15 text-cyan-300 backdrop-blur-md shadow-sm">
                      {{ $galleryItems[0]['number'] }}
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 md:left-6 md:right-6 p-3.5 sm:p-4 rounded-xl bg-[#050B24]/85 border border-white/10 backdrop-blur-md flex items-center justify-between text-white shadow-lg">
                      <h3 class="font-['Space_Grotesk'] font-bold text-sm sm:text-base md:text-lg text-white truncate mr-3">
                        {{ $galleryItems[0]['title'] }}
                      </h3>
                      <span class="font-['JetBrains_Mono'] text-[10px] sm:text-xs font-semibold text-cyan-400 shrink-0 tracking-wider">
                        {{ $galleryItems[0]['tag'] }}
                      </span>
                    </div>
                    <div class="absolute top-4 right-4 bg-[#03071E]/80 border border-white/15 text-cyan-300 px-3 py-1 rounded-full text-xs font-['JetBrains_Mono'] backdrop-blur-md shadow-sm">
                      1 / {{ count($galleryItems) }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

      </div>
    </section>

    <!-- SECTION 1: OFFICIAL SPONSORS (Aceternity Minimalist Style) -->
    <section id="sponsors" class="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header matching User Screenshot -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
          <h2 class="text-3xl sm:text-4xl md:text-5xl font-['Space_Grotesk'] font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style="background-image: linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Trusted by Industry Leaders
          </h2>
          <p class="mt-2.5 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
            Forward-thinking organizations powering engineering, energy, and digital breakthroughs.
          </p>
        </div>

        <!-- Frameless Horizontal Brand Logos Row (Logo Gambar Saja Tanpa Box, Nama Dibawah Logo) -->
        <div class="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
          @php
            $dbSponsors = $sponsors ?? [];
            $sponsorCount = count($dbSponsors);
          @endphp

          {{-- Render Dynamic Sponsors from Database --}}
          @foreach($dbSponsors as $sponsor)
            @php
              $link = $sponsor->link ?? $sponsor['link'] ?? null;
              $name = $sponsor->name ?? $sponsor['name'] ?? 'Sponsor';
              $logo = $sponsor->logo ?? $sponsor['logo'] ?? null;
              $isGold = !empty($sponsor->is_gold) || !empty($sponsor['is_gold']);
            @endphp
            @if($link)
              <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1">
            @else
              <div class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
            @endif
              @if(!empty($logo))
                <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="{{ $name }}" class="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300">
              @else
                <div class="w-10 h-10 flex items-center justify-center text-cyan-400 font-bold font-['Space_Grotesk'] text-xl">
                  {{ substr($name, 0, 1) }}
                </div>
              @endif
              <span class="font-['Space_Grotesk'] font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center flex items-center justify-center gap-1.5">
                {{ $name }}
                @if($isGold)
                  <span class="text-[9px] font-['JetBrains_Mono'] px-1.5 py-0.2 rounded bg-amber-400/10 text-amber-400 border border-amber-400/30 font-semibold tracking-wider uppercase">GOLD</span>
                @endif
              </span>
            @if($link)
              </a>
            @else
              </div>
            @endif
          @endforeach

          @if($sponsorCount === 0)
            <div class="text-center py-4 px-4 w-full">
              <p class="text-slate-400 text-sm max-w-md mx-auto">Official sponsor announcements will be published soon.</p>
            </div>
          @endif
        </div>

        <div class="mt-10 text-center">
          <a href="mailto:inno-ieee.sb@unri.ac.id?subject=Sponsorship%20Inquiry%20IEE%202026" class="inline-flex items-center gap-1.5 text-xs font-['JetBrains_Mono'] text-slate-500 hover:text-cyan-400 transition-colors">
            <span>Interested in empowering future innovators?</span>
            <span class="text-cyan-400 font-medium">Become an Official Sponsor →</span>
          </a>
        </div>
      </div>
    </section>

    <!-- SECTION 2: MEDIA PARTNERS (Aceternity Minimalist Style - SEPARATED) -->
    <section id="media-partners" class="py-20 sm:py-24 relative border-t border-white/5 bg-[#03071E]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header matching User Screenshot -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
          <h2 class="text-3xl sm:text-4xl md:text-5xl font-['Space_Grotesk'] font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-slate-100 to-slate-400" style="background-image: linear-gradient(180deg, #FFFFFF 0%, #E2E8F0 50%, #94A3B8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Supported by Media Networks
          </h2>
          <p class="mt-2.5 text-slate-400 text-sm sm:text-base font-normal max-w-xl mx-auto">
            National press, broadcast channels, and student media networks amplifying IEE 2026 across Indonesia.
          </p>
        </div>

        <!-- Frameless Horizontal Brand Logos Row (Logo Gambar Saja Tanpa Box, Nama Dibawah Logo) -->
        <div class="flex flex-wrap items-end justify-center gap-10 sm:gap-14 md:gap-16">
          @php
            $dbMedia = $mediaPartners ?? [];
            $mediaCount = count($dbMedia);
          @endphp

          {{-- Render Dynamic Media Partners from Database --}}
          @foreach($dbMedia as $partner)
            @php
              $link = $partner->link ?? $partner['link'] ?? null;
              $name = $partner->name ?? $partner['name'] ?? 'Media Partner';
              $logo = $partner->logo ?? $partner['logo'] ?? null;
            @endphp
            @if($link)
              <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1">
            @else
              <div class="group flex flex-col items-center justify-center gap-2.5 transition-all duration-300 opacity-80 hover:opacity-100 hover:-translate-y-1 cursor-pointer">
            @endif
              @if(!empty($logo))
                <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="{{ $name }}" class="h-10 sm:h-12 w-auto max-w-[140px] object-contain group-hover:scale-105 transition-transform duration-300">
              @else
                <div class="w-10 h-10 flex items-center justify-center text-indigo-400 font-bold font-['Space_Grotesk'] text-xl">
                  {{ substr($name, 0, 1) }}
                </div>
              @endif
              <span class="font-['Space_Grotesk'] font-medium text-xs sm:text-sm text-slate-300 group-hover:text-white transition-colors text-center">
                {{ $name }}
              </span>
            @if($link)
              </a>
            @else
              </div>
            @endif
          @endforeach

          @if($mediaCount === 0)
            <div class="text-center py-4 px-4 w-full">
              <p class="text-slate-400 text-sm max-w-md mx-auto">Official media partner announcements will be published soon.</p>
            </div>
          @endif
        </div>

        <div class="mt-10 text-center">
          <a href="mailto:inno-ieee.sb@unri.ac.id?subject=Media%20Partnership%20IEE%202026" class="inline-flex items-center gap-1.5 text-xs font-['JetBrains_Mono'] text-slate-500 hover:text-cyan-400 transition-colors">
            <span>Broadcasting student technology & events?</span>
            <span class="text-cyan-400 font-medium">Join as Media Partner →</span>
          </a>
        </div>
      </div>
    </section>

    <!-- ABOUT & CONTACT SECTION -->
    <section id="about" class="py-24 relative border-t border-blue-500/15 bg-[#050B24]/50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-cyan-300 text-xs font-semibold tracking-wider uppercase font-['JetBrains_Mono'] mb-3">
            <span>Official Center</span>
          </div>
          <h2 class="mt-2 text-3xl sm:text-5xl font-['Space_Grotesk'] font-bold text-white tracking-tight">
            About & Contact
          </h2>
          <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal">
            Everything you need to know about InnoElectrica 26.
          </p>
        </div>

        <!-- Equal-Height 3-Column Core Information Architectural Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          <!-- Card 1: CONTACT US (Interactive Clickable Rows + Copy Action) -->
          <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
            <div>
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Contact Us</h3>
              </div>

              <div class="space-y-3">
                <!-- Email Row with Interactive Copy Button -->
                <div class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row">
                  <div class="flex items-center gap-3 truncate mr-2">
                    <span class="text-cyan-400 shrink-0">@</span>
                    <div class="truncate">
                      <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">Email</div>
                      <a href="mailto:inno-ieee.sb@unri.ac.id" class="text-xs font-medium text-slate-200 hover:text-cyan-400 transition truncate block">
                        inno-ieee.sb@unri.ac.id
                      </a>
                    </div>
                  </div>
                  <button 
                    onclick="copyToClipboard('inno-ieee.sb@unri.ac.id', this)"
                    type="button" 
                    title="Copy Email"
                    class="p-1.5 rounded-lg bg-white/5 hover:bg-cyan-400/20 text-slate-400 hover:text-cyan-300 transition shrink-0"
                  >
                    <svg class="w-4 h-4 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke-width="2"></rect>
                      <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke-width="2"></path>
                    </svg>
                  </button>
                </div>

                <!-- Instagram Row -->
                <a 
                  href="https://instagram.com/innoelectricaunri" 
                  target="_blank" 
                  rel="noopener noreferrer" 
                  class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
                >
                  <div class="flex items-center gap-3">
                    <span class="text-pink-400 shrink-0">#</span>
                    <div>
                      <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">Instagram</div>
                      <span class="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">@innoelectricaunri</span>
                    </div>
                  </div>
                  <svg class="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                  </svg>
                </a>

                <!-- WhatsApp Row -->
                <a 
                  href="https://wa.me/6282268863544" 
                  target="_blank" 
                  rel="noopener noreferrer" 
                  class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition flex items-center justify-between group/row"
                >
                  <div class="flex items-center gap-3">
                    <span class="text-emerald-400 shrink-0">✆</span>
                    <div>
                      <div class="font-['JetBrains_Mono'] text-[10px] text-slate-400 uppercase">WhatsApp (Phone)</div>
                      <span class="text-xs font-medium text-slate-200 group-hover/row:text-cyan-400 transition">+62 822-6886-3544</span>
                    </div>
                  </div>
                  <svg class="w-4 h-4 text-slate-400 group-hover/row:text-cyan-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                  </svg>
                </a>
              </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 text-[11px] font-['JetBrains_Mono'] text-slate-500">
              Active response: Mon - Sat 08:00 - 17:00 WIB
            </div>
          </div>

          <!-- Card 2: ORGANIZER (Verified Branch Architecture) -->
          <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
            <div>
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
                <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Organizer</h3>
              </div>

              <div class="space-y-4">
                <div>
                  <h4 class="font-['Space_Grotesk'] font-bold text-base text-white">
                    IEEE Student Branch Universitas Riau
                  </h4>
                  <p class="text-xs sm:text-sm text-slate-400 mt-1 leading-relaxed">
                    Faculty of Engineering, Universitas Riau
                  </p>
                </div>

                <p class="text-xs text-slate-400/90 leading-relaxed">
                  A professional student engineering community fostering technological breakthroughs, global technical standards, and scientific leadership.
                </p>
              </div>
            </div>

            <!-- Verified Official Branch Badge -->
            <div class="mt-6 pt-4 border-t border-white/10">
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600/15 border border-cyan-400/30 text-cyan-300 font-['JetBrains_Mono'] text-xs font-semibold">
                <svg class="w-4 h-4 text-cyan-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Official IEEE Student Branch</span>
              </div>
            </div>
          </div>

          <!-- Card 3: LOCATION & EVENT FORMAT -->
          <div class="spotlight-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between group">
            <div>
              <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-cyan-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <h3 class="font-['Space_Grotesk'] font-bold text-xl text-white">Location</h3>
              </div>

              <div>
                <h4 class="font-['Space_Grotesk'] font-bold text-base text-white">
                  Faculty of Engineering - Universitas Riau
                </h4>
                <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                  Kampus Bina Widya, Jl. HR. Soebrantas KM. 12.5, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293
                </p>
              </div>
            </div>

            <!-- Distinct Technical Format Status Box -->
            <div class="mt-6 pt-4 border-t border-white/10">
              <div class="rounded-xl bg-[#03071E]/80 border border-blue-500/20 p-3.5 flex items-center justify-between">
                <div>
                  <div class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400">EVENT FORMAT</div>
                  <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-0.5">Hybrid (Online & Offline)</div>
                </div>
                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 shadow-[0_0_8px_#38BDF8]"></span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

  </main>

  <!-- ENGINEERING FOOTER -->
  <footer class="border-t border-white/10 bg-[#03071E] relative z-10 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
      
      <!-- Logo & Brand Info -->
      <div class="flex items-center gap-3">
        <img 
          src="{{ asset('images/Logo.png') }}" 
          alt="InnoElectrica Logo" 
          class="h-8 w-8 rounded-full object-cover ring-1 ring-cyan-400/40"
        />
        <div class="flex flex-col">
          <div class="flex items-center gap-1.5 font-['Space_Grotesk'] font-bold text-sm text-white">
            <span>InnoElectrica EXPO</span>
            <span class="text-[#FACC15] font-['Orbitron']">2026</span>
          </div>
          <span class="text-[11px] text-slate-400">
            &copy; 2026 IEEE Student Branch Universitas Riau. All rights reserved.
          </span>
        </div>
      </div>

      <!-- Legal Links -->
      <div class="flex items-center gap-6 text-xs font-['JetBrains_Mono'] text-slate-400">
        <a href="{{ route('privacy') }}" class="hover:text-cyan-400 transition-colors">Privacy Policy</a>
        <a href="{{ route('terms') }}" class="hover:text-cyan-400 transition-colors">Terms of Service</a>
        <a href="#about" class="hover:text-cyan-400 transition-colors">Contact Support</a>
      </div>

    </div>
  </footer>

  <!-- Toast Notification Container for Clipboard Actions -->
  <div id="toast" class="fixed bottom-6 right-6 z-50 pointer-events-none transform translate-y-12 opacity-0 transition-all duration-300">
    <div class="px-4 py-2.5 rounded-xl bg-[#050B24] border border-cyan-400/40 shadow-2xl text-xs font-['JetBrains_Mono'] text-cyan-300 flex items-center gap-2">
      <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
      </svg>
      <span id="toastMsg">Copied to clipboard</span>
    </div>
  </div>

  <!-- INTERACTION SCRIPTS: Spotlight, Mobile Menu, Countdown, Clipboard -->
  <script>
    // 1. Raycast / Linear Spotlight Cursor Tracker
    document.querySelectorAll('.spotlight-card').forEach(card => {
      card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
      });
      card.addEventListener('mouseleave', () => {
        card.style.setProperty('--mouse-x', `-999px`);
        card.style.setProperty('--mouse-y', `-999px`);
      });
    });

    // 2. Mobile Hamburger Toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileBtn && mobileMenu) {
      mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('flex');
      });
      // Close on link click
      document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
          mobileMenu.classList.add('hidden');
          mobileMenu.classList.remove('flex');
        });
      });
    }

    // 3. Dynamic Countdown HUD Timer
    (function initCountdownTimer() {
      const targetStr = window.__COUNTDOWN_TARGET;
      if (!targetStr) return;

      const targetDate = new Date(targetStr).getTime();
      if (isNaN(targetDate)) return;

      const dEl = document.getElementById('cd-days');
      const hEl = document.getElementById('cd-hours');
      const mEl = document.getElementById('cd-mins');
      const sEl = document.getElementById('cd-secs');

      if (!dEl || !hEl || !mEl || !sEl) return;

      function pad(val) {
        return String(val).padStart(2, '0');
      }

      function updateClock() {
        const diff = targetDate - Date.now();
        if (diff <= 0) {
          dEl.textContent = '00';
          hEl.textContent = '00';
          mEl.textContent = '00';
          sEl.textContent = '00';
          return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const secs = Math.floor((diff % (1000 * 60)) / 1000);

        dEl.textContent = pad(days);
        hEl.textContent = pad(hours);
        mEl.textContent = pad(mins);
        sEl.textContent = pad(secs);
      }

      updateClock();
      setInterval(updateClock, 1000);
    })();

    // 4. Copy to Clipboard with Visual Toast
    function copyToClipboard(text, btnElement) {
      navigator.clipboard.writeText(text).then(() => {
        const toast = document.getElementById('toast');
        const toastMsg = document.getElementById('toastMsg');
        if (toast && toastMsg) {
          toastMsg.textContent = `Copied: ${text}`;
          toast.classList.remove('translate-y-12', 'opacity-0');
          toast.classList.add('translate-y-0', 'opacity-100');
          setTimeout(() => {
            toast.classList.add('translate-y-12', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
          }, 2400);
        }
      });
    }

    // 6. Aceternity-Style Expandable Competition Card (Shared-Element Morphing Transition via FLIP)
    let activeExpandableCardEl = null;
    let isExpandableAnimating = false;

    function openExpandableCard(cardEl) {
      if (!cardEl || isExpandableAnimating) return;
      const dataStr = cardEl.getAttribute('data-comp');
      if (!dataStr) return;

      try {
        const data = JSON.parse(dataStr);
        activeExpandableCardEl = cardEl;

        // 1. Populate text and metadata into modal
        document.getElementById('exp-title').textContent = data.name || 'Kompetisi';
        
        // Description
        const descEl = document.getElementById('exp-description');
        const descWrapper = document.getElementById('exp-desc-wrapper');
        if (data.description && data.description.trim().length > 0) {
          descEl.textContent = data.description;
          descWrapper.classList.remove('hidden');
        } else {
          descWrapper.classList.add('hidden');
        }

        // Badges & Status
        document.getElementById('exp-badge').textContent = data.badge || '';
        document.getElementById('exp-fee-badge').textContent = data.fee || 'Free';
        
        const statusEl = document.getElementById('exp-status');
        statusEl.textContent = data.status || '';
        statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold border backdrop-blur-md whitespace-nowrap ' + (data.statusBadgeClass || 'bg-slate-500/15 text-slate-300 border-slate-500/30');

        // Extended Info Banner
        const expExtBanner = document.getElementById('exp-extended-banner');
        if (expExtBanner) {
          if (data.isExtended && data.extendedDateLabel) {
            document.getElementById('exp-extended-date').textContent = data.extendedDateLabel;
            expExtBanner.classList.remove('hidden');
          } else {
            expExtBanner.classList.add('hidden');
          }
        }

        // Formats & Fees
        document.getElementById('exp-team').textContent = data.team || '-';
        document.getElementById('exp-fee').textContent = data.fee || 'Free';

        // Location (Only if present in DB)
        const locWrapper = document.getElementById('exp-location-wrapper');
        if (data.location && data.location.trim().length > 0) {
          document.getElementById('exp-location').textContent = data.location;
          locWrapper.classList.remove('hidden');
        } else {
          locWrapper.classList.add('hidden');
        }

        // Submission Type (Only if present in DB)
        const subWrapper = document.getElementById('exp-submission-wrapper');
        if (data.submission && data.submission.trim().length > 0) {
          document.getElementById('exp-submission').textContent = data.submission;
          subWrapper.classList.remove('hidden');
        } else {
          subWrapper.classList.add('hidden');
        }

        // Render Real Timeline Dates from DB
        const timelineWrapper = document.getElementById('exp-timeline-wrapper');
        const timelineList = document.getElementById('exp-timeline-list');
        timelineList.innerHTML = '';
        if (data.timeline && data.timeline.length > 0) {
          data.timeline.forEach(item => {
            const div = document.createElement('div');
            if (item.is_extended && item.extended_date) {
              div.className = 'rounded-xl bg-amber-500/10 border border-amber-400/30 p-2.5 flex flex-col col-span-1 sm:col-span-2 shadow-[0_0_15px_rgba(245,158,11,0.12)]';
              div.innerHTML = `
                <div class="flex items-center justify-between gap-1 mb-0.5">
                  <span class="text-[11px] text-amber-300 font-semibold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    ${item.phase}
                  </span>
                  <span class="text-[9px] uppercase tracking-wider font-bold text-amber-300 bg-amber-400/20 border border-amber-400/30 px-1.5 py-0.5 rounded-full font-['JetBrains_Mono']">Extended</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-0.5">
                  <span class="text-xs line-through opacity-50 text-slate-400 font-['JetBrains_Mono']">${item.date}</span>
                  <span class="text-xs font-bold text-amber-300 font-['JetBrains_Mono']">${item.extended_date}</span>
                </div>
              `;
            } else {
              div.className = 'rounded-xl bg-white/[0.02] border border-white/[0.05] p-2.5 flex flex-col';
              div.innerHTML = `<span class="text-[11px] text-slate-400 font-medium">${item.phase}</span><span class="text-xs font-semibold text-slate-200 mt-0.5">${item.date}</span>`;
            }
            timelineList.appendChild(div);
          });
          timelineWrapper.classList.remove('hidden');
        } else {
          timelineWrapper.classList.add('hidden');
        }

        // Register Action Button (Aceternity CTA)
        const regBtn = document.getElementById('exp-register-btn');
        if (data.isOpen && data.registerUrl) {
          regBtn.href = data.registerUrl;
          regBtn.innerHTML = '<span>Register Now</span><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
          regBtn.className = 'exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white shadow-[0_4px_16px_rgba(37,99,235,0.4)] transition-all shrink-0 cursor-pointer inline-flex items-center gap-1.5';
        } else {
          regBtn.removeAttribute('href');
          const disabledBtnText = (data.status === 'Competition Ended' || data.status === 'Results Announced') ? 'Registration Closed' : (data.status || 'Registration Closed');
          regBtn.innerHTML = `<span>${disabledBtnText}</span>`;
          regBtn.className = 'exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-slate-800/80 text-slate-400 border border-white/5 transition-all shrink-0 cursor-not-allowed inline-flex items-center gap-1.5';
        }

        // Copy icon from card into modal banner
        const sourceIcon = cardEl.querySelector('.w-12.h-12 svg');
        const iconContainer = document.getElementById('exp-icon-container');
        if (sourceIcon && iconContainer) {
          iconContainer.innerHTML = sourceIcon.outerHTML;
          const svg = iconContainer.querySelector('svg');
          if (svg) {
            svg.setAttribute('class', 'w-8 h-8 text-cyan-300');
          }
        }

        // 2. Prepare FLIP Animation
        const backdrop = document.getElementById('expandable-card-backdrop');
        const container = document.getElementById('expandable-card-container');
        const dialog = document.getElementById('expandable-card-dialog');
        const fadeItems = dialog.querySelectorAll('.exp-fade-item');

        // Hide inner reveal items initially (matching initial opacity: 0)
        fadeItems.forEach(el => {
          el.style.opacity = '0';
          el.style.pointerEvents = 'none';
          el.style.transition = 'none';
        });

        // Activate container & backdrop
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('pointer-events-auto');
        backdrop.style.opacity = '0';

        container.classList.remove('opacity-0', 'pointer-events-none');
        container.classList.add('pointer-events-auto');
        container.style.opacity = '1';

        // Measure origin bounding box (FIRST) and target bounding box (LAST)
        const originRect = cardEl.getBoundingClientRect();

        dialog.style.transition = 'none';
        dialog.style.transform = 'none';
        const targetRect = dialog.getBoundingClientRect();

        if (targetRect.width <= 0 || targetRect.height <= 0) {
          backdrop.style.opacity = '1';
          fadeItems.forEach(el => { el.style.opacity = '1'; el.style.pointerEvents = 'auto'; });
          document.body.style.overflow = 'hidden';
          return;
        }

        // INVERT: Calculate position & scale deltas to fit card exactly
        const deltaX = originRect.left - targetRect.left;
        const deltaY = originRect.top - targetRect.top;
        const scaleX = originRect.width / targetRect.width;
        const scaleY = originRect.height / targetRect.height;

        dialog.style.transformOrigin = '0 0';
        dialog.style.transform = `translate3d(${deltaX}px, ${deltaY}px, 0) scale(${scaleX}, ${scaleY})`;
        dialog.style.borderRadius = '16px';

        // Hide origin card in grid (it "becomes" the expanding dialog)
        cardEl.style.opacity = '0';
        document.body.style.overflow = 'hidden';
        isExpandableAnimating = true;

        // PLAY: Smoothly expand to target modal position with Framer Motion spring physics
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            dialog.style.transition = 'transform 420ms cubic-bezier(0.16, 1, 0.3, 1), border-radius 420ms cubic-bezier(0.16, 1, 0.3, 1)';
            dialog.style.transform = 'translate3d(0, 0, 0) scale(1, 1)';
            dialog.style.borderRadius = '24px';

            backdrop.style.transition = 'opacity 380ms cubic-bezier(0.16, 1, 0.3, 1)';
            backdrop.style.opacity = '1';

            // Reveal CTA button, close button, and inner body details with stagger
            setTimeout(() => {
              fadeItems.forEach(el => {
                el.style.transition = 'opacity 240ms ease';
                el.style.opacity = '1';
                el.style.pointerEvents = 'auto';
              });
              isExpandableAnimating = false;
            }, 140);
          });
        });

      } catch (err) {
        console.error('Error opening expandable card:', err);
        isExpandableAnimating = false;
      }
    }

    function closeExpandableCard() {
      if (!activeExpandableCardEl || isExpandableAnimating) return;
      isExpandableAnimating = true;

      const backdrop = document.getElementById('expandable-card-backdrop');
      const container = document.getElementById('expandable-card-container');
      const dialog = document.getElementById('expandable-card-dialog');
      const fadeItems = dialog.querySelectorAll('.exp-fade-item');

      // 1. Immediately fade out revealed items (matching Framer Motion duration: 0.05)
      fadeItems.forEach(el => {
        el.style.transition = 'opacity 90ms ease';
        el.style.opacity = '0';
        el.style.pointerEvents = 'none';
      });

      // 2. Measure current positions and morph back into the source card
      const currentOriginRect = activeExpandableCardEl.getBoundingClientRect();
      const currentTargetRect = dialog.getBoundingClientRect();

      const deltaX = currentOriginRect.left - currentTargetRect.left;
      const deltaY = currentOriginRect.top - currentTargetRect.top;
      const scaleX = currentOriginRect.width / currentTargetRect.width;
      const scaleY = currentOriginRect.height / currentTargetRect.height;

      dialog.style.transition = 'transform 360ms cubic-bezier(0.16, 1, 0.3, 1), border-radius 360ms cubic-bezier(0.16, 1, 0.3, 1)';
      dialog.style.transform = `translate3d(${deltaX}px, ${deltaY}px, 0) scale(${scaleX}, ${scaleY})`;
      dialog.style.borderRadius = '16px';

      backdrop.style.transition = 'opacity 320ms cubic-bezier(0.16, 1, 0.3, 1)';
      backdrop.style.opacity = '0';

      // 3. Complete closing cleanup
      setTimeout(() => {
        if (activeExpandableCardEl) {
          activeExpandableCardEl.style.opacity = '1';
          activeExpandableCardEl = null;
        }

        container.classList.add('opacity-0', 'pointer-events-none');
        container.classList.remove('pointer-events-auto');
        container.style.opacity = '0';

        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('pointer-events-auto');

        dialog.style.transform = 'none';
        dialog.style.transition = 'none';

        document.body.style.overflow = '';
        isExpandableAnimating = false;
      }, 360);
    }

    // ESC key listener to close expandable card
    window.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        closeExpandableCard();
      }
    });

    // 5. Aceternity Stars Background (Twinkling Starfield)
    (function initStarsBackground() {
      const canvas = document.getElementById('starsCanvas');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      let w = canvas.width = canvas.offsetWidth;
      let h = canvas.height = canvas.offsetHeight;

      function resize() {
        w = canvas.width = canvas.offsetWidth;
        h = canvas.height = canvas.offsetHeight;
        generate();
      }
      window.addEventListener('resize', resize);

      let stars = [];
      function generate() {
        stars = [];
        const count = Math.floor(w * h * 0.00018);
        for (let i = 0; i < count; i++) {
          stars.push({
            x: Math.random() * w,
            y: Math.random() * h,
            r: Math.random() * 0.8 + 0.35,
            opacity: Math.random() * 0.5 + 0.3,
            twinkleSpeed: Math.random() > 0.3 ? Math.random() * 0.6 + 0.4 : null
          });
        }
      }
      generate();

      function render() {
        ctx.clearRect(0, 0, w, h);
        const now = Date.now() * 0.001;
        for (let i = 0; i < stars.length; i++) {
          const s = stars[i];
          let op = s.opacity;
          if (s.twinkleSpeed !== null) {
            op = 0.25 + Math.abs(Math.sin(now / s.twinkleSpeed)) * 0.75;
          }
          ctx.beginPath();
          ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
          ctx.fillStyle = `rgba(248, 250, 252, ${op})`;
          ctx.fill();
        }
        requestAnimationFrame(render);
      }
      render();
    })();

    // 6. Aceternity Shooting Stars (Dynamic Gradient Streaks)
    (function initShootingStars() {
      const group = document.getElementById('shootingStarsGroup');
      if (!group) return;

      const minSpeed = 10;
      const maxSpeed = 26;
      const minDelay = 1400;
      const maxDelay = 3800;

      function getRandomStart() {
        const side = Math.floor(Math.random() * 4);
        const w = window.innerWidth;
        const h = window.innerHeight;
        const offset = Math.random() * w;
        switch (side) {
          case 0: return { x: offset, y: -20, angle: 45 };
          case 1: return { x: w + 20, y: Math.random() * h * 0.6, angle: 135 };
          case 2: return { x: offset, y: h + 20, angle: 225 };
          case 3: return { x: -20, y: Math.random() * h * 0.6, angle: 45 };
          default: return { x: offset, y: -20, angle: 45 };
        }
      }

      function spawnStar() {
        const start = getRandomStart();
        const speed = Math.random() * (maxSpeed - minSpeed) + minSpeed;
        const isGold = Math.random() > 0.75;
        const gradId = isGold ? 'url(#shootingStarGoldGradient)' : 'url(#shootingStarGradient)';
        const star = {
          x: start.x,
          y: start.y,
          angle: start.angle,
          speed: speed,
          scale: 1,
          distance: 0,
          element: document.createElementNS('http://www.w3.org/2000/svg', 'rect')
        };

        star.element.setAttribute('height', '1.6');
        star.element.setAttribute('fill', gradId);
        group.appendChild(star.element);

        function move() {
          star.x += star.speed * Math.cos(star.angle * Math.PI / 180);
          star.y += star.speed * Math.sin(star.angle * Math.PI / 180);
          star.distance += star.speed;
          star.scale = 1 + star.distance / 85;

          const width = 14 * star.scale;
          star.element.setAttribute('x', star.x);
          star.element.setAttribute('y', star.y);
          star.element.setAttribute('width', width);
          star.element.setAttribute('transform', `rotate(${star.angle}, ${star.x + width / 2}, ${star.y + 0.8})`);

          if (star.x < -60 || star.x > window.innerWidth + 60 || star.y < -60 || star.y > window.innerHeight + 60) {
            if (star.element.parentNode === group) {
              group.removeChild(star.element);
            }
          } else {
            requestAnimationFrame(move);
          }
        }
        requestAnimationFrame(move);

        const nextDelay = Math.random() * (maxDelay - minDelay) + minDelay;
        setTimeout(spawnStar, nextDelay);
      }

      spawnStar();
    })();

    // 7. React Bits - SideRays WebGL2 Shimmering Rays
    (function initSideRays() {
      const container = document.getElementById('sideRaysContainer');
      const canvas = document.getElementById('sideRaysCanvas');
      if (!container || !canvas) return;

      const gl = canvas.getContext('webgl2', {
        alpha: true,
        premultipliedAlpha: true,
        antialias: false,
        depth: false,
        stencil: false,
        powerPreference: 'high-performance'
      });
      if (!gl) return;

      const PIXEL_BUDGET = 2.4e6;
      const TAU = Math.PI * 2;

      const ORIGINS = {
        'top-right': { flipX: 0, flipY: 0, side: 0 },
        'top-left': { flipX: 1, flipY: 0, side: 0 },
        'bottom-right': { flipX: 0, flipY: 1, side: 0 },
        'bottom-left': { flipX: 1, flipY: 1, side: 0 },
        right: { flipX: 0, flipY: 0, side: 1 },
        left: { flipX: 1, flipY: 0, side: 1 }
      };

      const VERTEX = `#version 300 es
      const vec2 corners[3] = vec2[3](vec2(-1.0, -1.0), vec2(3.0, -1.0), vec2(-1.0, 3.0));
      void main() {
        gl_Position = vec4(corners[gl_VertexID], 0.0, 1.0);
      }`;

      const FRAGMENT = `#version 300 es
      precision highp float;
      uniform vec2 uResolution;
      uniform float uTime;
      uniform vec3 uColorA;
      uniform vec3 uColorB;
      uniform float uBlend;
      uniform float uIntensity;
      uniform float uSpread;
      uniform float uDensity;
      uniform float uSharpness;
      uniform float uFalloff;
      uniform float uGlow;
      uniform float uSaturation;
      uniform float uDust;
      uniform float uOpacity;
      uniform float uReveal;
      uniform float uLight;
      uniform vec3 uFrame;
      uniform float uAim;
      uniform vec3 uFocus;
      uniform float uSway;
      out vec4 fragColor;

      float hash(vec2 p) {
        p = fract(p * vec2(123.34, 456.21));
        p += dot(p, p + 45.32);
        return fract(p.x * p.y);
      }

      float noise(vec2 p) {
        vec2 i = floor(p);
        vec2 f = p - i;
        vec2 w = f * f * f * (f * (f * 6.0 - 15.0) + 10.0);
        float a = hash(i);
        float b = hash(i + vec2(1.0, 0.0));
        float c = hash(i + vec2(0.0, 1.0));
        float d = hash(i + vec2(1.0, 1.0));
        return mix(mix(a, b, w.x), mix(c, d, w.x), w.y);
      }

      float shafts(float u, float t, float seed, float aa) {
        float sway = (0.4 * sin(t * 0.31 + seed) + 0.24 * sin(t * 0.17 + seed * 2.3)) * uSway;
        float n = 0.7 * noise(vec2(u + sway + seed, t * 0.3)) + 0.3 * noise(vec2(u * 2.4 + sway * 1.5 + seed * 1.7, t * 0.45 + 3.0));
        float width = mix(0.5, 0.1, uSharpness);
        float s = mix(smoothstep(0.5 - width, 0.5 + width, n), 0.5, aa);
        return mix(0.05, 1.0, s);
      }

      float motes(vec2 p, float cell, float t, float seed) {
        p += vec2(t * 0.021, -t * 0.013) + seed * 7.31;
        vec2 grid = p / cell;
        vec2 id = floor(grid);
        vec2 f = grid - id;
        float h = hash(id + seed);
        if (h > 0.5) return 0.0;
        vec2 center = 0.25 + 0.5 * vec2(hash(id + 1.7 + seed), hash(id + 3.1 + seed));
        center += 0.1 * vec2(sin(t * 0.7 + h * 31.0), cos(t * 0.6 + h * 23.0));
        float size = mix(0.035, 0.09, hash(id + 5.3 + seed));
        float edge = length(fwidth(grid)) * 0.7;
        float twinkle = 0.55 + 0.45 * sin(t * 1.9 + h * 41.0);
        return (1.0 - smoothstep(size - edge, size + edge, length(f - center))) * twinkle;
      }

      void main() {
        float aspect = uResolution.x / uResolution.y;
        vec2 q = (gl_FragCoord.xy - 0.5 * uResolution) / uResolution.y;
        if (uFrame.x > 0.5) q.x = -q.x;
        if (uFrame.y > 0.5) q.y = -q.y;
        vec2 source = uFrame.z > 0.5 ? vec2(aspect * 0.5 + 0.42, 0.3) : vec2(aspect * 0.5 + 0.1, 0.62);
        float heading = (uFrame.z > 0.5 ? 3.42 : -2.48) + uAim + 0.035 * sin(uTime * 0.21) * uSway;
        vec2 v = q - source;
        float r = length(v);
        float angle = mod(atan(v.y, v.x) - heading + 3.14159265, 6.28318531) - 3.14159265;
        float t = uTime;
        float u = angle * uDensity;
        float aa = smoothstep(0.12, 0.45, fwidth(u));
        float offset = uSpread * 0.22;
        float fanA = exp(-pow((angle + offset) / uSpread, 2.0) * 1.4);
        float fanB = exp(-pow((angle - offset) / (uSpread * 1.15), 2.0) * 1.4);
        float focus = 1.0 + uFocus.z * exp(-pow((angle - uFocus.x) / uFocus.y, 2.0));
        float lightA = fanA * shafts(u, t, 0.0, aa) * focus;
        float lightB = fanB * shafts(u * 0.83, t * 0.6, 17.0, aa) * focus;
        float reach = 1.0 / (1.0 + pow(r / 0.4, uFalloff));
        vec3 glowColor = mix(uColorA, uColorB, uBlend);
        vec3 light = (uColorA * lightA * (1.0 - uBlend) + uColorB * lightB * uBlend) * 2.0 * reach;
        light += glowColor * uGlow * exp(-pow(r / 0.4, 2.0));
        if (uDust > 0.0) {
          float sparkle = motes(q, 0.06, t, 0.0) + 0.7 * motes(q, 0.038, t * 0.8, 9.0);
          light += mix(glowColor, vec3(1.0), 0.6) * sparkle * (lightA + lightB) * reach * uDust * 2.5;
        }
        light *= uIntensity * (1.0 - smoothstep(uReveal * 2.6 - 0.45, uReveal * 2.6, r)) * smoothstep(0.0, 0.35, uReveal);
        float gray = dot(light, vec3(0.2126, 0.7152, 0.0722));
        light = max(mix(vec3(gray), light, uSaturation), 0.0);
        float peak = max(light.r, max(light.g, light.b));
        float grain = (fract(52.9829189 * fract(dot(gl_FragCoord.xy, vec2(0.06711056, 0.00583715)))) - 0.5) / 255.0;
        if (uLight > 0.5) {
          vec3 ink = pow(light / max(peak, 1e-4), vec3(2.0)) * 0.75;
          float alpha = clamp(pow(1.0 - exp(-peak * 2.6), 2.5) * 0.9 * uOpacity + grain, 0.0, 1.0);
          fragColor = vec4(pow(ink, vec3(1.0 / 2.2)) * alpha, alpha);
          return;
        }
        float mapped = 1.0 - exp(-peak);
        vec3 tone = light * (mapped / max(peak, 1e-4));
        tone = mix(tone, vec3(mapped), smoothstep(0.7, 1.0, mapped) * 0.55);
        vec3 shown = clamp(tone * uOpacity, 0.0, 1.0);
        float alpha = max(shown.r, max(shown.g, shown.b));
        vec3 color = clamp(shown * alpha + grain, 0.0, 1.0);
        fragColor = vec4(min(color, vec3(alpha)), alpha);
      }`;

      const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
      const wrapAngle = angle => ((((angle + Math.PI) % TAU) + TAU) % TAU) - Math.PI;

      const parseColor = value => {
        const text = String(value || '').trim();
        const hex = /^#?([0-9a-f]{3}|[0-9a-f]{6})$/i.exec(text);
        if (hex) {
          const full = hex[1].length === 3 ? hex[1].replace(/./g, digit => digit + digit) : hex[1];
          return [0, 2, 4].map(index => parseInt(full.slice(index, index + 2), 16) / 255);
        }
        const rgb = /^rgba?\(\s*([\d.]+)[\s,]+([\d.]+)[\s,]+([\d.]+)/i.exec(text);
        if (rgb) return [rgb[1], rgb[2], rgb[3]].map(channel => clamp(parseFloat(channel) / 255, 0, 1));
        return [1, 1, 1];
      };

      const geometryFor = (frame, aspect) => ({
        source: frame.side ? [aspect * 0.5 + 0.42, 0.3] : [aspect * 0.5 + 0.1, 0.62],
        heading: frame.side ? 3.42 : -2.48
      });

      const compile = (glCtx, type, source) => {
        const shader = glCtx.createShader(type);
        if (!shader) return null;
        glCtx.shaderSource(shader, source);
        glCtx.compileShader(shader);
        if (!glCtx.getShaderParameter(shader, glCtx.COMPILE_STATUS)) {
          console.error(glCtx.getShaderInfoLog(shader));
          glCtx.deleteShader(shader);
          return null;
        }
        return shader;
      };

      const link = glCtx => {
        const vertex = compile(glCtx, glCtx.VERTEX_SHADER, VERTEX);
        const fragment = compile(glCtx, glCtx.FRAGMENT_SHADER, FRAGMENT);
        const program = vertex && fragment ? glCtx.createProgram() : null;
        if (!vertex || !fragment || !program) {
          if (vertex) glCtx.deleteShader(vertex);
          if (fragment) glCtx.deleteShader(fragment);
          return null;
        }
        glCtx.attachShader(program, vertex);
        glCtx.attachShader(program, fragment);
        glCtx.linkProgram(program);
        glCtx.deleteShader(vertex);
        glCtx.deleteShader(fragment);
        if (!glCtx.getProgramParameter(program, glCtx.LINK_STATUS)) {
          console.error(glCtx.getProgramInfoLog(program));
          glCtx.deleteProgram(program);
          return null;
        }
        const uniforms = {};
        const count = glCtx.getProgramParameter(program, glCtx.ACTIVE_UNIFORMS);
        for (let index = 0; index < count; index++) {
          const info = glCtx.getActiveUniform(program, index);
          if (info) uniforms[info.name] = glCtx.getUniformLocation(program, info.name);
        }
        return { program, uniforms };
      };

      const shader = link(gl);
      if (!shader) return;

      const props = {
        rayColor1: '#FFC46B',
        rayColor2: '#96c8ff',
        blend: 0.6,
        origin: 'top-right',
        speed: 2.5,
        intensity: 2,
        spread: 2,
        density: 5,
        sharpness: 0.5,
        tilt: 0,
        falloff: 1.6,
        glow: 1,
        saturation: 1,
        dust: 0,
        followMouse: true,
        mouseInfluence: 0.5,
        intro: true,
        lightMode: false,
        opacity: 1,
        maxRatio: 2
      };

      const settings = {
        colorA: parseColor(props.rayColor1),
        colorB: parseColor(props.rayColor2),
        blend: clamp(props.blend, 0, 1),
        frame: ORIGINS[props.origin] ?? ORIGINS['top-right'],
        speed: Math.max(0, props.speed) * 0.4,
        intensity: Math.max(0, props.intensity) * 0.75,
        spread: clamp(props.spread, 0.1, 8) * 0.225,
        density: clamp(props.density, 1, 40),
        sharpness: clamp(props.sharpness, 0, 1),
        tilt: (clamp(props.tilt, -180, 180) * Math.PI) / 180,
        falloff: clamp(props.falloff, 0.2, 6),
        glow: Math.max(0, props.glow) * 1.2,
        saturation: Math.max(0, props.saturation),
        dust: clamp(props.dust, 0, 1),
        followMouse: props.followMouse,
        mouseInfluence: clamp(props.mouseInfluence, 0, 1),
        intro: props.intro,
        light: props.lightMode,
        opacity: clamp(props.opacity, 0, 1),
        maxRatio: clamp(props.maxRatio, 0.5, 3)
      };

      const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const vao = gl.createVertexArray();
      const size = { width: 1, height: 1 };
      const pointer = { x: 0, y: 0, inside: false };
      const aim = { value: 0, velocity: 0 };
      const focus = { angle: 0, strength: 0 };
      let time = Math.random() * 100;
      let reveal = settings.intro && !reduced ? 0 : 1;
      let raf = 0;
      let last = 0;
      let visible = true;
      let pageVisible = document.visibilityState !== 'hidden';
      let lost = false;

      const resize = () => {
        const rect = container.getBoundingClientRect();
        const cssWidth = Math.max(1, rect.width);
        const cssHeight = Math.max(1, rect.height);
        const ratio = Math.min(
          window.devicePixelRatio || 1,
          settings.maxRatio,
          Math.sqrt(PIXEL_BUDGET / (cssWidth * cssHeight))
        );
        const width = Math.max(1, Math.round(cssWidth * ratio));
        const height = Math.max(1, Math.round(cssHeight * ratio));
        if (canvas.width !== width || canvas.height !== height) {
          canvas.width = width;
          canvas.height = height;
        }
        size.width = cssWidth;
        size.height = cssHeight;
      };

      const pointerAngle = s => {
        let x = (pointer.x - size.width / 2) / size.height;
        let y = (size.height / 2 - pointer.y) / size.height;
        if (s.frame.flipX) x = -x;
        if (s.frame.flipY) y = -y;
        const { source, heading } = geometryFor(s.frame, size.width / size.height);
        return wrapAngle(Math.atan2(y - source[1], x - source[0]) - heading - s.tilt);
      };

      const frame = now => {
        raf = 0;
        if (lost) return;
        const s = settings;
        const dt = clamp((now - last) / 1000 || 0, 0, 0.05);
        last = Math.max(last, now);
        time += dt * s.speed * (reduced ? 0.3 : 1);
        if (reveal < 1) reveal = Math.min(1, reveal + dt / 1.6);

        const tracking = s.followMouse && pointer.inside && !reduced;
        const pointed = tracking ? pointerAngle(s) : 0;
        const target = tracking ? clamp(pointed, -s.spread, s.spread) * s.mouseInfluence : 0;
        const focusTarget = tracking ? s.mouseInfluence : 0;
        const ease = 1 - Math.exp(-dt * 6);
        if (tracking) focus.angle += (clamp(pointed - aim.value, -s.spread * 1.5, s.spread * 1.5) - focus.angle) * ease;
        focus.strength += (focusTarget - focus.strength) * ease;
        const stiffness = 18;
        const damping = 2 * Math.sqrt(stiffness);
        aim.velocity += ((target - aim.value) * stiffness - aim.velocity * damping) * dt;
        aim.value += aim.velocity * dt;

        gl.viewport(0, 0, canvas.width, canvas.height);
        gl.useProgram(shader.program);
        gl.bindVertexArray(vao);
        const u = shader.uniforms;
        gl.uniform2f(u.uResolution, canvas.width, canvas.height);
        gl.uniform1f(u.uTime, time);
        gl.uniform3f(u.uColorA, s.colorA[0], s.colorA[1], s.colorA[2]);
        gl.uniform3f(u.uColorB, s.colorB[0], s.colorB[1], s.colorB[2]);
        gl.uniform1f(u.uBlend, s.blend);
        gl.uniform1f(u.uIntensity, s.intensity);
        gl.uniform1f(u.uSpread, s.spread);
        gl.uniform1f(u.uDensity, s.density);
        gl.uniform1f(u.uSharpness, s.sharpness);
        gl.uniform1f(u.uFalloff, s.falloff);
        gl.uniform1f(u.uGlow, s.glow);
        gl.uniform1f(u.uSaturation, s.saturation);
        gl.uniform1f(u.uDust, s.dust);
        gl.uniform1f(u.uOpacity, s.opacity);
        gl.uniform1f(u.uReveal, 1 - Math.pow(1 - reveal, 3));
        gl.uniform1f(u.uLight, s.light ? 1 : 0);
        gl.uniform3f(u.uFrame, s.frame.flipX, s.frame.flipY, s.frame.side);
        gl.uniform1f(u.uAim, s.tilt + aim.value);
        gl.uniform3f(u.uFocus, focus.angle, Math.max(0.06, s.spread * 0.25), focus.strength * 1.4);
        gl.uniform1f(u.uSway, reduced ? 0 : 1);
        gl.drawArrays(gl.TRIANGLES, 0, 3);

        const settling =
          Math.abs(target - aim.value) > 1e-4 ||
          Math.abs(aim.velocity) > 1e-4 ||
          Math.abs(focusTarget - focus.strength) > 1e-3;
        const busy = (s.speed > 0 && !reduced) || reveal < 1 || settling;
        if (busy && visible && pageVisible) raf = requestAnimationFrame(frame);
      };

      const wake = () => {
        if (raf || lost || !visible || !pageVisible) return;
        last = performance.now();
        raf = requestAnimationFrame(frame);
      };

      const onPointerMove = event => {
        const rect = container.getBoundingClientRect();
        pointer.x = event.clientX - rect.left;
        pointer.y = event.clientY - rect.top;
        pointer.inside =
          event.clientX >= rect.left &&
          event.clientX <= rect.right &&
          event.clientY >= rect.top &&
          event.clientY <= rect.bottom;
        wake();
      };
      const onLeave = () => {
        pointer.inside = false;
        wake();
      };
      const onPointerUp = event => {
        if (event.pointerType !== 'mouse') onLeave();
      };
      window.addEventListener('pointermove', onPointerMove, { passive: true });
      window.addEventListener('pointerup', onPointerUp, { passive: true });
      window.addEventListener('pointercancel', onPointerUp, { passive: true });
      document.documentElement.addEventListener('pointerleave', onLeave);

      const onLost = event => {
        event.preventDefault();
        lost = true;
        cancelAnimationFrame(raf);
        raf = 0;
      };
      const onRestored = () => {
        lost = false;
        wake();
      };
      canvas.addEventListener('webglcontextlost', onLost);
      canvas.addEventListener('webglcontextrestored', onRestored);

      const resizeObserver = new ResizeObserver(() => {
        resize();
        wake();
      });
      resizeObserver.observe(container);

      const intersection = new IntersectionObserver(entries => {
        visible = entries.some(entry => entry.isIntersecting);
        wake();
      });
      intersection.observe(container);

      const onVisibility = () => {
        pageVisible = document.visibilityState !== 'hidden';
        wake();
      };
      document.addEventListener('visibilitychange', onVisibility);

      resize();
      wake();
    })();
  </script>
</body>

</html>