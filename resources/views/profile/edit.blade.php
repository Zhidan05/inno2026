<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;800;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
      :root {
          --bg-primary: #050816;
          --bg-secondary: #0a0f24;
          --bg-tertiary: #0f172a;
          --surface: rgba(15, 23, 42, 0.50);
          --surface-elevated: rgba(15, 23, 42, 0.70);
          --border-subtle: rgba(255, 255, 255, 0.08);
          --border-default: rgba(255, 255, 255, 0.12);
      }
      body {
          background: #050816 !important;
          color: #f8fafc;
      }
      .form-input-themed {
          width: 100%;
          background: rgba(2, 6, 23, 0.80);
          border: 1px solid rgba(255, 255, 255, 0.12);
          border-radius: 12px;
          padding: 0.75rem 1rem;
          color: #f8fafc;
          font-family: var(--font-body);
          font-size: 0.95rem;
          transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
      }
      .form-input-themed:focus {
          outline: none;
          border-color: #3b82f6;
          background: rgba(2, 6, 23, 0.95);
          box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
      }
      .form-input-themed[readonly] {
          background: rgba(15, 23, 42, 0.6);
          border-color: rgba(255, 255, 255, 0.06);
          color: #94a3b8;
          cursor: not-allowed;
      }
  </style>
</head>

<body class="bg-[#050816] text-slate-100 min-h-screen">
  <!-- FLOATING GLASS NAVBAR (100% Homepage Aligned) -->
  <header class="sticky top-4 z-50 mx-auto max-w-6xl px-4 sm:px-6">
    <nav class="rounded-2xl border border-white/15 bg-slate-900/40 backdrop-blur-xl px-5 sm:px-6 py-3.5 flex items-center justify-between shadow-[0_8px_32px_0_rgba(0,0,0,0.36),inset_0_1px_0_0_rgba(255,255,255,0.1)] relative" style="-webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px);">
      
      <!-- Left: Brand Logo Lockup -->
      <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-400 rounded-xl" style="text-decoration: none;">
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
      </div>

      <!-- Right: Logout Action -->
      <div class="hidden sm:flex items-center gap-4">
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
          @csrf
          <button type="submit" class="bg-white/10 hover:bg-red-500/20 text-white hover:text-red-300 border border-white/15 hover:border-red-500/30 font-medium text-xs px-4 py-2 rounded-xl transition-all cursor-pointer flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Logout</span>
          </button>
        </form>
      </div>

      <!-- Mobile Hamburger Button -->
      <button 
        id="mobileMenuBtn"
        type="button" 
        class="md:hidden w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 backdrop-blur-md text-slate-300 hover:text-white flex items-center justify-center transition-all focus:outline-none shadow-sm cursor-pointer"
        style="-webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);"
        aria-label="Toggle navigation menu"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path id="hamburgerIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

      <!-- Mobile Dropdown Menu -->
      <div id="mobileMenu" class="hidden absolute top-full left-0 right-0 mt-2 p-4 rounded-2xl border border-white/15 shadow-2xl flex-col gap-2 md:hidden z-50" style="background: #070d28 !important; box-shadow: 0 25px 50px -10px rgba(0,0,0,0.95), inset 0 1px 0 0 rgba(255,255,255,0.15);">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-cyan-400 bg-white/10' : 'text-slate-200 hover:text-cyan-400 hover:bg-white/5' }} px-4 py-3 rounded-xl transition-all flex items-center justify-between" style="text-decoration: none;">
          <span>Dashboard</span>
          @if(request()->routeIs('dashboard'))
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
          @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium {{ request()->routeIs('profile.edit') ? 'text-cyan-400 bg-white/10' : 'text-slate-200 hover:text-cyan-400 hover:bg-white/5' }} px-4 py-3 rounded-xl transition-all flex items-center justify-between" style="text-decoration: none;">
          <span>Profile</span>
          @if(request()->routeIs('profile.edit'))
            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
          @endif
        </a>
        @if(Auth::user() && Auth::user()->isBackofficeUser())
        <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Admin Panel
        </a>
        @endif
        <div class="pt-2 border-t border-white/10 mt-1">
          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="w-full text-center py-2.5 rounded-xl font-medium text-xs bg-white/10 hover:bg-red-500/20 text-white hover:text-red-300 border border-white/15 hover:border-red-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
              <span>Logout</span>
            </button>
          </form>
        </div>
      </div>

    </nav>
  </header>

  <main class="dashboard-main">
    <div class="dash-container">
      
      <header class="dash-header mb-6">
        <div class="dash-greeting">
            <h1 class="text-2xl sm:text-3xl font-bold font-['Orbitron'] text-white">Participant Profile</h1>
            <p class="text-slate-400 text-sm mt-1">Manage your account information and registration details</p>
        </div>
      </header>

      <div class="dash-grid">
          
          <div class="dash-card bg-slate-900/50 border border-white/10 backdrop-blur-md rounded-2xl p-6 sm:p-8 shadow-xl">
              <h3 class="card-title text-lg font-semibold text-white flex items-center gap-2 mb-6 border-b border-white/10 pb-4">
                <i class="fi fi-rr-user text-cyan-400"></i> Profile Information
              </h3>
              
              @php
                  $registration = \App\Models\Registration::where('user_id', Auth::id())->first();
                  $isLocked = $registration && $registration->status === 'approved';
              @endphp

              @if($isLocked)
                  <div class="p-4 rounded-xl mb-6 bg-emerald-500/10 border border-emerald-500/30 border-l-4 border-l-emerald-400">
                      <strong class="text-emerald-400 text-sm font-semibold tracking-wide block mb-1">PROFILE LOCKED</strong>
                      <p class="text-slate-300 text-xs sm:text-sm">Your registration is verified. Critical identity fields cannot be changed. Contact the committee for support.</p>
                  </div>
              @endif

              <form method="post" action="{{ route('profile.update') }}">
                  @csrf
                  @method('patch')

                  <div class="form-group mb-5">
                      <label class="form-label text-sm font-medium text-slate-300 block mb-2" for="name">Full Name</label>
                      <input id="name" name="name" type="text" class="form-input-themed" value="{{ old('name', $user->name) }}" required autocomplete="name" {{ $isLocked ? 'readonly' : '' }}>
                      @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group mb-5">
                      <label class="form-label text-sm font-medium text-slate-300 block mb-2" for="email">Email Address</label>
                      <input id="email" name="email" type="email" class="form-input-themed" value="{{ old('email', $user->email) }}" required autocomplete="username" {{ $isLocked ? 'readonly' : '' }}>
                      @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group mb-5">
                      <label class="form-label text-sm font-medium text-slate-300 block mb-2" for="phone">Phone / WhatsApp</label>
                      <input id="phone" name="phone" type="text" class="form-input-themed" value="{{ old('phone', $user->phone) }}" required {{ $isLocked ? 'readonly' : '' }}>
                      @error('phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group mb-5">
                      <label class="form-label text-sm font-medium text-slate-300 block mb-2" for="institution">Institution / University</label>
                      <input id="institution" name="institution" type="text" class="form-input-themed" value="{{ old('institution', $user->institution) }}" required {{ $isLocked ? 'readonly' : '' }}>
                      @error('institution') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                  </div>
                  
                  @if($registration)
                  <div class="form-group mb-5">
                      <label class="form-label text-sm font-medium text-slate-300 block mb-2" for="competition">Competition</label>
                      <input id="competition" type="text" class="form-input-themed" value="{{ $registration->competition->name }}" readonly disabled>
                  </div>
                  @endif

                  @if(session('status') === 'profile-updated')
                      <p class="text-emerald-400 text-sm font-medium mb-4 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Profile successfully updated.
                      </p>
                  @endif

                  @if(!$isLocked)
                  <div class="mt-6">
                      <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition-all cursor-pointer border-0">Save Changes</button>
                  </div>
                  @endif
              </form>
          </div>

      </div>
    </div>
  </main>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      const hamburgerIcon = document.getElementById('hamburgerIcon');

      if (mobileMenuBtn && mobileMenu) {
          mobileMenuBtn.addEventListener('click', () => {
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
      }
  </script>
</body>
</html>
