<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terms and Conditions | InnoElectrica EXPO 2026</title>
  
  <!-- Fonts: Space Grotesk (Headings), Plus Jakarta Sans & Inter (Body), JetBrains Mono (Tech Metadata), Orbitron (Accent/Brand) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Orbitron:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
    rel="stylesheet" />

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
      background-size: 4rem 4rem;
      background-image: 
        linear-gradient(to right, rgba(56, 189, 248, 0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(56, 189, 248, 0.04) 1px, transparent 1px);
      mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
      -webkit-mask-image: radial-gradient(ellipse 90% 70% at 50% 30%, #000 60%, transparent 100%);
    }

    /* Glowing Accents */
    .glow-amber-btn {
      box-shadow: 0 0 25px -4px rgba(250, 204, 21, 0.35);
    }
    .glow-amber-btn:hover {
      box-shadow: 0 0 35px -2px rgba(250, 204, 21, 0.55);
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
      <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl">
        <div class="relative">
          <img 
            src="{{ asset('images/Logo.png') }}" 
            alt="InnoElectrica Logo" 
            class="h-9 w-9 rounded-full object-cover ring-2 ring-cyan-400/40 group-hover:ring-cyan-400 transition-all shadow-[0_0_15px_rgba(56,189,248,0.3)]"
          />
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
        <a href="{{ url('/') }}#competitions" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
          Competitions
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="{{ url('/') }}#gallery" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
          Gallery
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="{{ url('/') }}#about" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group">
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
        <a href="{{ url('/') }}#competitions" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Competitions</a>
        <a href="{{ url('/') }}#gallery" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Gallery</a>
        <a href="{{ url('/') }}#about" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link">Contact</a>
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

  <main class="relative z-10 pt-10 sm:pt-16 pb-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

    <!-- TOP BREADCRUMB & STATUS BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-['JetBrains_Mono'] text-slate-400 hover:text-cyan-400 transition-colors group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Home</span>
      </a>

      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#050B24]/90 border border-cyan-400/30 text-cyan-300 text-[11px] font-['JetBrains_Mono'] backdrop-blur-md self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>VERSION 2026.1 • EFFECTIVE: {{ strtoupper(date('F Y')) }}</span>
      </div>
    </div>

    <!-- PAGE HERO HEADER -->
    <div class="mb-12 border-b border-white/10 pb-8">
      <div class="font-['JetBrains_Mono'] text-xs font-bold uppercase tracking-widest text-[#FACC15] mb-2 flex items-center gap-2">
        <span class="inline-block w-4 h-[2px] bg-[#FACC15]"></span>
        <span>OFFICIAL COMPETITION TERMS</span>
      </div>
      <h1 class="font-['Space_Grotesk'] font-black text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight">
        Terms and Conditions
      </h1>
      <p class="mt-4 text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed">
        Rules, guidelines, intellectual property protocols, and terms of participation governing all entrants of InnoElectrica EXPO 2026.
      </p>

      <!-- Meta Grid Pill -->
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">HOST</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-1">IEEE SB UNRI</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">BINDING LEVEL</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-cyan-300 mt-1">All Registered Teams</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">JUDGMENT</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-[#FACC15] mt-1">Final & Irrevocable</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">EDITION</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-emerald-400 mt-1">InnoElectrica 2026</div>
        </div>
      </div>
    </div>

    <!-- TWO-COLUMN CONTENT WITH STICKY TABLE OF CONTENTS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- STICKY TABLE OF CONTENTS -->
      <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
        <div class="rounded-2xl border border-blue-500/20 bg-[#050B24]/80 backdrop-blur-xl p-5 shadow-xl">
          <div class="font-['Space_Grotesk'] font-bold text-sm text-white mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>
            <span>Table of Contents</span>
          </div>

          <nav class="space-y-1.5 text-xs font-medium">
            <a href="#term-1" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">01</span>
              <span>Introduction & Agreement</span>
            </a>
            <a href="#term-2" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">02</span>
              <span>Competition Regulations</span>
            </a>
            <a href="#term-3" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">03</span>
              <span>User Accounts & Security</span>
            </a>
            <a href="#term-4" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">04</span>
              <span>Intellectual Property</span>
            </a>
            <a href="#term-5" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">05</span>
              <span>Amendments to Terms</span>
            </a>
          </nav>
        </div>

        <!-- Committee Notice Card -->
        <div class="rounded-2xl border border-white/10 bg-[#0A122C]/70 backdrop-blur-xl p-5 text-xs text-slate-300">
          <div class="font-['Space_Grotesk'] font-bold text-sm text-white mb-2">Rules Inquiries</div>
          <p class="text-slate-400 leading-relaxed mb-3">
            Have questions regarding specific competition rulebooks or judging criteria?
          </p>
          <a 
            href="{{ url('/') }}#about" 
            class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 font-['JetBrains_Mono'] font-medium"
          >
            <span>Contact Competition Committee</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
        </div>
      </aside>

      <!-- MAIN LEGAL ARTICLES -->
      <article class="lg:col-span-8 rounded-3xl border border-blue-500/20 bg-[#050B24]/85 backdrop-blur-xl p-6 sm:p-10 shadow-2xl space-y-12">

        <!-- Article 1 -->
        <section id="term-1" class="scroll-mt-28 space-y-4">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              01
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Introduction & Acceptance of Terms
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Welcome to <strong class="text-white">InnoElectrica EXPO 2026</strong>. By registering for our competitions, submitting project documentation, accessing the dashboard portal, or using this platform, you agree to be bound unconditionally by these Terms and Conditions and all associated competition guidebooks.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            If you disagree with any portion of these terms, you must refrain from registering or submitting materials to the competition.
          </p>
        </section>

        <!-- Article 2 -->
        <section id="term-2" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              02
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Competition Rules & Academic Integrity
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Every registered team and individual must abide by the following core competition regulations:
          </p>

          <div class="space-y-3 pt-2">
            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Official Verification</strong>
                All participants must be active students officially registered, paid (if applicable), and verified by the committee prior to technical evaluation.
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Original Work & Anti-Plagiarism</strong>
                Submissions must be original work created specifically by the participant team. Any form of intellectual theft, unauthorized code duplication, or plagiarism results in immediate, irreversible disqualification.
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
              </div>
              <div class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                <strong class="text-white block font-['Space_Grotesk']">Finality of Judges' Decision</strong>
                The decisions rendered by the judging panel and IEEE faculty advisory board are final, non-negotiable, and binding in all technical and scoring matters.
              </div>
            </div>
          </div>
        </section>

        <!-- Article 3 -->
        <section id="term-3" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              03
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              User Accounts & Security Responsibility
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Team leaders are solely responsible for preserving the confidentiality of their portal access credentials and for all submission revisions executed under their account session.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            The committee assumes no liability for unauthorized account modifications stemming from compromised passwords on the user's end. Notify our web team immediately if any security breach is suspected.
          </p>
        </section>

        <!-- Article 4 -->
        <section id="term-4" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              04
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Intellectual Property & Exhibition License
            </h2>
          </div>

          <div class="rounded-2xl border border-blue-500/20 bg-blue-950/20 p-5 space-y-3">
            <div class="flex items-center gap-2 text-cyan-300 font-['Space_Grotesk'] font-bold text-sm">
              <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
              <span>IP Ownership Retained by Creators</span>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
              Participants retain 100% full intellectual property ownership of their inventions, codebases, hardware designs, and scientific papers.
            </p>
            <p class="text-xs text-slate-400 leading-relaxed border-t border-white/10 pt-2">
              By participating, you grant InnoElectrica EXPO and IEEE Student Branch Universitas Riau a non-exclusive, perpetual, royalty-free license to showcase your project titles, abstracts, demo media, and photographs across official public event exhibitions, press releases, social media, and academic journals.
            </p>
          </div>
        </section>

        <!-- Article 5 -->
        <section id="term-5" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              05
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Modifications to Rules & Guidelines
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            The organizing committee reserves the right to amend competition timetables, submission deadlines, or technical guidelines should force majeure or extraordinary technical circumstances arise.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            All registered participants will receive immediate notifications via verified email and the official dashboard notification center.
          </p>
        </section>

      </article>

    </div>

    <!-- BOTTOM BACK TO HOME CTA -->
    <div class="mt-16 text-center">
      <a 
        href="{{ url('/') }}" 
        class="inline-flex items-center gap-2.5 px-6 py-3 rounded-xl bg-blue-600/20 hover:bg-blue-600/30 border border-cyan-400/30 text-cyan-300 font-['JetBrains_Mono'] text-xs font-semibold uppercase tracking-wider transition-all"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Return to Main Portal</span>
      </a>
    </div>

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
        <a href="{{ route('terms') }}" class="text-cyan-400 font-semibold transition-colors">Terms of Service</a>
        <a href="{{ url('/') }}#about" class="hover:text-cyan-400 transition-colors">Contact Support</a>
      </div>

    </div>
  </footer>

  <script>
    // Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileBtn && mobileMenu) {
      mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('flex');
      });
      document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
          mobileMenu.classList.add('hidden');
          mobileMenu.classList.remove('flex');
        });
      });
    }
  </script>

</body>

</html>
