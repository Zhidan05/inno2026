@php
  $isPortal = request()->routeIs('dashboard*', 'profile.*', 'competition.register*') || (request()->routeIs('competition.show') && Auth::check());
@endphp

<!-- FLOATING GLASS NAVBAR (Single Source of Truth) -->
<header class="sticky top-4 z-50 mx-auto max-w-6xl px-4 sm:px-6">
  <nav class="rounded-2xl border border-white/15 bg-slate-900/35 backdrop-blur-xl px-5 sm:px-6 py-3.5 flex items-center justify-between shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.1)] relative" style="-webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px);">
    
    <!-- Left: Brand Logo Lockup -->
    <a href="{{ request()->is('/') ? '#home' : url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl" style="text-decoration: none;">
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

    <!-- Center: Desktop Nav Links -->
    <div class="hidden md:flex items-center gap-8">
      @if($isPortal)
        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-cyan-400' : 'text-slate-300 hover:text-cyan-400' }} transition-colors relative py-1 group" style="text-decoration: none;">
          Dashboard
          <span class="absolute bottom-0 left-0 {{ request()->routeIs('dashboard') ? 'w-full' : 'w-0 group-hover:w-full' }} h-[2px] bg-cyan-400 transition-all duration-200"></span>
        </a>
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium {{ request()->routeIs('profile.edit') ? 'text-cyan-400' : 'text-slate-300 hover:text-cyan-400' }} transition-colors relative py-1 group" style="text-decoration: none;">
          Profile
          <span class="absolute bottom-0 left-0 {{ request()->routeIs('profile.edit') ? 'w-full' : 'w-0 group-hover:w-full' }} h-[2px] bg-cyan-400 transition-all duration-200"></span>
        </a>
        @if(Auth::user() && Auth::user()->isBackofficeUser())
          <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
            Admin Panel
            <span class="absolute bottom-0 left-0 w-0 group-hover:w-full h-[2px] bg-cyan-400 transition-all duration-200"></span>
          </a>
        @endif
      @else
        <a href="{{ request()->is('/') ? '#competitions' : url('/#competitions') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Competitions
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="{{ request()->is('/') ? '#gallery' : url('/#gallery') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Gallery
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
        <a href="{{ request()->is('/') ? '#about' : url('/#about') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Contact
          <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-cyan-400 group-hover:w-full transition-all duration-200"></span>
        </a>
      @endif
    </div>

    <!-- Right Action / Auth Buttons -->
    <div class="hidden sm:flex items-center gap-4">
      @if($isPortal)
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
          @csrf
          <button type="submit" class="bg-white/10 hover:bg-red-500/20 text-white hover:text-red-300 border border-white/15 hover:border-red-500/30 font-medium text-xs px-4 py-2 rounded-xl transition-all cursor-pointer flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Logout</span>
          </button>
        </form>
      @else
        @auth
          <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all" style="text-decoration: none;">
            Dashboard
          </a>
        @else
          @if (Route::has('login'))
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors px-3 py-1.5" style="text-decoration: none;">
              Login
            </a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] glow-amber-btn active:scale-95 transition-all" style="text-decoration: none;">
                Register
              </a>
            @endif
          @endif
        @endauth
      @endif
    </div>

    <!-- Mobile Menu Toggle Button -->
    <button 
      id="mobileMenuBtn"
      type="button" 
      class="md:hidden p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 backdrop-blur-md text-slate-300 hover:text-white transition-all focus:outline-none shadow-sm cursor-pointer"
      style="-webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);"
      aria-label="Toggle navigation menu"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path id="hamburgerIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <!-- Mobile Dropdown Menu -->
    <div id="mobileMenu" class="hidden absolute top-full left-0 right-0 mt-3 p-5 rounded-2xl border border-white/15 bg-slate-950/80 backdrop-blur-2xl shadow-[0_8px_32px_0_rgba(0,0,0,0.5),inset_0_1px_0_0_rgba(255,255,255,0.08)] flex-col gap-3 md:hidden z-50" style="-webkit-backdrop-filter: blur(24px); backdrop-filter: blur(24px);">
      @if($isPortal)
        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-cyan-400 bg-white/10' : 'text-slate-200 hover:text-cyan-400 hover:bg-white/5' }} px-4 py-2.5 rounded-xl transition-all flex items-center justify-between mobile-nav-link" style="text-decoration: none;">
          <span>Dashboard</span>
          @if(request()->routeIs('dashboard'))
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
          @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium {{ request()->routeIs('profile.edit') ? 'text-cyan-400 bg-white/10' : 'text-slate-200 hover:text-cyan-400 hover:bg-white/5' }} px-4 py-2.5 rounded-xl transition-all flex items-center justify-between mobile-nav-link" style="text-decoration: none;">
          <span>Profile</span>
          @if(request()->routeIs('profile.edit'))
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
          @endif
        </a>
        @if(Auth::user() && Auth::user()->isBackofficeUser())
          <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-2.5 rounded-xl transition-all block mobile-nav-link" style="text-decoration: none;">
            Admin Panel
          </a>
        @endif
        <div class="pt-2 border-t border-white/10 mt-1">
          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="w-full text-center py-2.5 rounded-xl font-medium text-xs bg-white/10 hover:bg-red-500/20 text-white hover:text-red-300 border border-white/15 hover:border-red-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              <span>Logout</span>
            </button>
          </form>
        </div>
      @else
        <a href="{{ request()->is('/') ? '#competitions' : url('/#competitions') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link" style="text-decoration: none;">Competitions</a>
        <a href="{{ request()->is('/') ? '#gallery' : url('/#gallery') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link" style="text-decoration: none;">Gallery</a>
        <a href="{{ request()->is('/') ? '#about' : url('/#about') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 py-2 border-b border-white/5 mobile-nav-link" style="text-decoration: none;">Contact</a>
        <div class="pt-2 flex flex-col gap-2">
          @auth
            <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] hover:bg-[#F59E0B] text-[#03071E] transition-all" style="text-decoration: none;">Dashboard</a>
          @else
            @if (Route::has('login'))
              <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-xl text-sm font-medium text-slate-200 hover:bg-white/5" style="text-decoration: none;">Login</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl font-heading font-bold text-xs uppercase tracking-wider bg-[#FACC15] text-[#03071E]" style="text-decoration: none;">Register</a>
              @endif
            @endif
          @endauth
        </div>
      @endif
    </div>

  </nav>
</header>

<script>
  (function initNavbarMobileMenu() {
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const hamburgerIcon = document.getElementById('hamburgerIcon');

    if (mobileBtn && mobileMenu && !mobileBtn.__navInitialized) {
      mobileBtn.__navInitialized = true;
      mobileBtn.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.toggle('hidden');
        if (!isHidden) {
          mobileMenu.classList.add('flex');
          if (hamburgerIcon) {
            hamburgerIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
          }
        } else {
          mobileMenu.classList.remove('flex');
          if (hamburgerIcon) {
            hamburgerIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
          }
        }
      });

      document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
          mobileMenu.classList.add('hidden');
          mobileMenu.classList.remove('flex');
          if (hamburgerIcon) {
            hamburgerIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
          }
        });
      });
    }
  })();
</script>
