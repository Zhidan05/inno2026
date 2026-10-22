<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Privacy Policy | InnoElectrica EXPO 2026</title>
  
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
        <span>LAST UPDATED: {{ strtoupper(date('F Y')) }}</span>
      </div>
    </div>

    <!-- PAGE HERO HEADER -->
    <div class="mb-12 border-b border-white/10 pb-8">
      <div class="font-['JetBrains_Mono'] text-xs font-bold uppercase tracking-widest text-[#FACC15] mb-2 flex items-center gap-2">
        <span class="inline-block w-4 h-[2px] bg-[#FACC15]"></span>
        <span>LEGAL & COMPLIANCE FRAMEWORK</span>
      </div>
      <h1 class="font-['Space_Grotesk'] font-black text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight">
        Privacy Policy
      </h1>
      <p class="mt-4 text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed">
        Our commitment to personal data protection, participant privacy, and transparency for all innovators, academic institutions, and partners of InnoElectrica EXPO 2026.
      </p>

      <!-- Meta Grid Pill -->
      <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">ORGANIZATION</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-1">IEEE SB UNRI</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">APPLICABILITY</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-white mt-1">Global Participants</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">DATA USAGE</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-cyan-300 mt-1">Strictly Non-Commercial</div>
        </div>
        <div class="rounded-xl bg-[#050B24]/60 border border-blue-500/20 p-3">
          <div class="text-[10px] font-['JetBrains_Mono'] uppercase tracking-wider text-slate-400">JURISDICTION</div>
          <div class="font-['Space_Grotesk'] font-bold text-xs text-emerald-400 mt-1">Republic of Indonesia</div>
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
            <a href="#section-1" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">01</span>
              <span>Information We Collect</span>
            </a>
            <a href="#section-2" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">02</span>
              <span>How We Use Your Information</span>
            </a>
            <a href="#section-3" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">03</span>
              <span>Data Protection & Security</span>
            </a>
            <a href="#section-4" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">04</span>
              <span>Sharing of Information</span>
            </a>
            <a href="#section-5" class="flex items-center gap-2.5 p-2 rounded-xl text-slate-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
              <span class="font-['JetBrains_Mono'] text-[10px] text-cyan-400 px-1.5 py-0.5 rounded bg-cyan-950/60 border border-cyan-800/40">05</span>
              <span>Data Rights & Inquiries</span>
            </a>
          </nav>
        </div>

        <!-- Support Card -->
        <div class="rounded-2xl border border-white/10 bg-[#0A122C]/70 backdrop-blur-xl p-5 text-xs text-slate-300">
          <div class="font-['Space_Grotesk'] font-bold text-sm text-white mb-2">Need Clarification?</div>
          <p class="text-slate-400 leading-relaxed mb-3">
            Have questions or requests regarding your personal records or submission privacy?
          </p>
          <a 
            href="mailto:innoelectrica@unri.ac.id" 
            class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 font-['JetBrains_Mono'] font-medium"
          >
            <span>innoelectrica@unri.ac.id</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
        </div>
      </aside>

      <!-- MAIN LEGAL CLAUSES -->
      <article class="lg:col-span-8 rounded-3xl border border-blue-500/20 bg-[#050B24]/85 backdrop-blur-xl p-6 sm:p-10 shadow-2xl space-y-12">

        <!-- Section 1 -->
        <section id="section-1" class="scroll-mt-28 space-y-4">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              01
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Information We Collect
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            We collect information you provide directly to us when you register for an account, sign up for a competition, upload project artifacts, or communicate with our event committee. This includes:
          </p>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div>
                <div class="font-['Space_Grotesk'] font-bold text-sm text-white">Personal Contact Details</div>
                <div class="text-xs text-slate-400 mt-0.5">Full name, active email address, WhatsApp / phone contact.</div>
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <div>
                <div class="font-['Space_Grotesk'] font-bold text-sm text-white">Academic Credentials</div>
                <div class="text-xs text-slate-400 mt-0.5">School/University affiliation, student ID cards (KTM), and faculty.</div>
              </div>
            </div>

            <div class="rounded-xl border border-white/5 bg-white/[0.02] p-4 flex items-start gap-3 sm:col-span-2">
              <div class="w-6 h-6 rounded-lg bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400 shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div>
                <div class="font-['Space_Grotesk'] font-bold text-sm text-white">Competition Submissions</div>
                <div class="text-xs text-slate-400 mt-0.5">Scientific papers, algorithm source code, design posters, project demo videos, and accompanying documentation.</div>
              </div>
            </div>
          </div>
        </section>

        <!-- Section 2 -->
        <section id="section-2" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              02
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              How We Use Your Information
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Your information is used solely for the purpose of administering and managing the InnoElectrica EXPO 2026 proceedings, including:
          </p>

          <ul class="space-y-2.5 text-xs sm:text-sm text-slate-300">
            <li class="flex items-start gap-3">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mt-2 shrink-0 shadow-[0_0_8px_#38BDF8]"></span>
              <span><strong>Verifying participant eligibility:</strong> Confirming student status, age brackets, and category compliance.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mt-2 shrink-0 shadow-[0_0_8px_#38BDF8]"></span>
              <span><strong>Event communications:</strong> Delivering schedule announcements, briefing invites, technical rulebooks, and jury results.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mt-2 shrink-0 shadow-[0_0_8px_#38BDF8]"></span>
              <span><strong>Public exhibition & showcase:</strong> Showcasing winning innovations, finalists, and notable engineering prototypes in our public event gallery.</span>
            </li>
            <li class="flex items-start gap-3">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mt-2 shrink-0 shadow-[0_0_8px_#38BDF8]"></span>
              <span><strong>Certificate issuance:</strong> Generating verifiable e-certificates authenticated by IEEE Student Branch Universitas Riau.</span>
            </li>
          </ul>
        </section>

        <!-- Section 3 -->
        <section id="section-3" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              03
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Data Protection & Security
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            We implement comprehensive technical and administrative security controls to safeguard your personal records and submissions:
          </p>

          <div class="rounded-2xl border border-blue-500/20 bg-blue-950/20 p-5 space-y-3">
            <div class="flex items-center gap-2 text-cyan-300 font-['Space_Grotesk'] font-bold text-sm">
              <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              <span>Security Protocols in Effect</span>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
              Personal data is maintained behind secured firewalled networks and is exclusively accessible by an authorized committee subset with role-based cryptographic authentication. Passwords are encrypted using irreversible multi-round Argon2/Bcrypt hashes.
            </p>
          </div>
        </section>

        <!-- Section 4 -->
        <section id="section-4" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              04
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Sharing of Information
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            We do <strong class="text-white">not</strong> sell, rent, monetize, or trade your personally identifiable information to external third parties.
          </p>

          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
            Information is only exchanged with verified operational partners (such as server infrastructure providers, judges under non-disclosure obligations, and institutional faculty advisors) who agree strictly to preserve data confidentiality.
          </p>
        </section>

        <!-- Section 5 -->
        <section id="section-5" class="scroll-mt-28 space-y-4 pt-6 border-t border-white/10">
          <div class="flex items-center gap-3">
            <span class="font-['JetBrains_Mono'] text-xs font-bold text-cyan-400 px-2.5 py-1 rounded-lg bg-blue-900/40 border border-cyan-400/30">
              05
            </span>
            <h2 class="font-['Space_Grotesk'] font-bold text-2xl text-white">
              Participant Rights & Contact
            </h2>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed">
            Participants hold full rights to request inspection, modification, or erasure of their account records upon competition conclusion, subject to institutional record-keeping compliance.
          </p>

          <!-- Interactive Action Card -->
          <div class="rounded-2xl border border-cyan-400/30 bg-[#0A122C]/90 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
              <div class="font-['Space_Grotesk'] font-bold text-sm text-white">Direct Privacy Support</div>
              <div class="text-xs text-slate-400 mt-0.5">Faculty of Engineering, Universitas Riau</div>
            </div>
            <div class="flex items-center gap-3">
              <a 
                href="mailto:innoelectrica@unri.ac.id" 
                class="px-4 py-2 rounded-xl text-xs font-['JetBrains_Mono'] font-bold bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn transition-all"
              >
                innoelectrica@unri.ac.id
              </a>
              <button 
                onclick="copyToClipboard('innoelectrica@unri.ac.id')"
                type="button"
                class="p-2 rounded-xl bg-white/5 hover:bg-cyan-400/20 border border-white/10 text-slate-300 hover:text-cyan-300 transition"
                title="Copy Email"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke-width="2"></rect>
                  <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke-width="2"></path>
                </svg>
              </button>
            </div>
          </div>
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
        <a href="{{ route('privacy') }}" class="text-cyan-400 font-semibold transition-colors">Privacy Policy</a>
        <a href="{{ route('terms') }}" class="hover:text-cyan-400 transition-colors">Terms of Service</a>
        <a href="{{ url('/') }}#about" class="hover:text-cyan-400 transition-colors">Contact Support</a>
      </div>

    </div>
  </footer>

  <!-- Toast Notification Container for Clipboard Actions -->
  <div id="toast" class="fixed bottom-6 right-6 z-50 pointer-events-none transform translate-y-12 opacity-0 transition-all duration-300">
    <div class="px-4 py-2.5 rounded-xl bg-[#050B24] border border-cyan-400/40 shadow-2xl text-xs font-['JetBrains_Mono'] text-cyan-300 flex items-center gap-2">
      <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
      </svg>
      <span id="toastMsg">Email copied to clipboard</span>
    </div>
  </div>

  <script>
    // 1. Mobile Menu Toggle
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

    // 2. Clipboard Toast
    function copyToClipboard(text) {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(showToast);
      } else {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast();
      }
    }

    function showToast() {
      const toast = document.getElementById('toast');
      if (!toast) return;
      toast.classList.remove('opacity-0', 'translate-y-12', 'pointer-events-none');
      setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-12', 'pointer-events-none');
      }, 2500);
    }
  </script>

</body>

</html>
