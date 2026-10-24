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
