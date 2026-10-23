<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $competition->name }} - Details - InnoElectrica 26</title>
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
          background-color: #050816 !important;
          color: #f8fafc;
      }
      .details-block {
          border: 1px solid rgba(255, 255, 255, 0.10);
          border-radius: 16px;
          overflow: hidden;
          margin-bottom: 2rem;
          background: rgba(15, 23, 42, 0.50);
          backdrop-filter: blur(12px);
          -webkit-backdrop-filter: blur(12px);
          box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
      }
      .det-header {
          background: rgba(255, 255, 255, 0.03);
          padding: 1.25rem 1.75rem;
          border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      }
      .det-header h2 {
          font-family: var(--font-display);
          font-size: 1.3rem;
          color: #38bdf8;
      }
      .det-body {
          padding: 1.75rem;
      }
      .info-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 1.5rem;
          margin-bottom: 1.5rem;
      }
      .info-item {
          background: rgba(2, 6, 23, 0.6);
          border: 1px solid rgba(255, 255, 255, 0.10);
          padding: 1.25rem;
          border-radius: 12px;
      }
      .info-label {
          color: #94a3b8;
          font-size: 0.85rem;
          margin-bottom: 0.35rem;
          display: block;
      }
      .info-value {
          color: #f8fafc;
          font-weight: 600;
          font-size: 1.05rem;
      }
      .btn-secondary {
          background: rgba(255, 255, 255, 0.06);
          color: #94a3b8;
          border: 1px solid rgba(255, 255, 255, 0.15);
          padding: 0.75rem 1.5rem;
          border-radius: 12px;
          font-family: var(--font-body);
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          text-decoration: none;
          display: inline-block;
          text-align: center;
      }
      .btn-secondary:hover {
          border-color: rgba(255, 255, 255, 0.3);
          color: #ffffff;
          background: rgba(255, 255, 255, 0.12);
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
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Dashboard
          <span class="absolute bottom-0 left-0 w-0 group-hover:w-full h-[2px] bg-cyan-400 transition-all duration-200"></span>
        </a>
        @auth
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Profile
          <span class="absolute bottom-0 left-0 w-0 group-hover:w-full h-[2px] bg-cyan-400 transition-all duration-200"></span>
        </a>
        @if(Auth::user()->isBackofficeUser())
        <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Admin Panel
          <span class="absolute bottom-0 left-0 w-0 group-hover:w-full h-[2px] bg-cyan-400 transition-all duration-200"></span>
        </a>
        @endif
        @endauth
      </div>

      <!-- Right: Logout / Login Action -->
      <div class="hidden sm:flex items-center gap-4">
        @auth
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
          @csrf
          <button type="submit" class="bg-white/10 hover:bg-red-500/20 text-white hover:text-red-300 border border-white/15 hover:border-red-500/30 font-medium text-xs px-4 py-2 rounded-xl transition-all cursor-pointer flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Logout</span>
          </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors px-3 py-1.5" style="text-decoration: none;">Login</a>
        @endauth
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
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Dashboard
        </a>
        @auth
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Profile
        </a>
        @if(Auth::user()->isBackofficeUser())
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
        @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Login
        </a>
        @endauth
      </div>

    </nav>
  </header>

  <main class="dashboard-main">
    <div class="dash-container" style="max-width: 800px; margin: 0 auto;">
      
      <header class="dash-header" style="margin-bottom: 2rem;">
        <div class="dash-greeting">
            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem; display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('dashboard') }}" style="color: var(--accent-blue-light); text-decoration: none;">Dashboard</a> 
                <span>/</span> 
                <span>Competitions</span>
            </div>
            <h1 style="color: var(--text-primary); font-size: 2rem; margin-bottom: 0.25rem;">{{ $competition->name }}</h1>
        </div>
      </header>

      <div class="details-block">
          <div class="det-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
              <h2>Competition Details</h2>
              @php
                  $isExtended = $competition->isExtended();
                  $detailsBadge = $isExtended
                      ? ['label' => $competition->extended_status_label, 'bg' => 'rgba(245, 158, 11, 0.15)', 'color' => '#fbbf24', 'border' => 'rgba(245, 158, 11, 0.35)']
                      : match($competition->status) {
                          'extended' => ['label' => $competition->extended_status_label ?: 'Extended', 'bg' => 'rgba(245, 158, 11, 0.15)', 'color' => '#fbbf24', 'border' => 'rgba(245, 158, 11, 0.35)'],
                          'registration_open' => ['label' => 'Registration Open', 'bg' => 'rgba(16, 185, 129, 0.15)', 'color' => '#10b981', 'border' => 'rgba(16, 185, 129, 0.3)'],
                          'ongoing' => ['label' => 'Ongoing', 'bg' => 'rgba(56, 189, 248, 0.15)', 'color' => '#38bdf8', 'border' => 'rgba(56, 189, 248, 0.3)'],
                          'completed' => ['label' => 'Competition Ended', 'bg' => 'rgba(148, 163, 184, 0.15)', 'color' => '#94a3b8', 'border' => 'rgba(148, 163, 184, 0.3)'],
                          'upcoming' => ['label' => 'Upcoming', 'bg' => 'rgba(251, 191, 36, 0.15)', 'color' => '#fbbf24', 'border' => 'rgba(251, 191, 36, 0.3)'],
                          default => ['label' => 'Registration Closed', 'bg' => 'rgba(244, 63, 94, 0.15)', 'color' => '#f43f5e', 'border' => 'rgba(244, 63, 94, 0.3)'],
                      };
                  $detBtnLabel = match($competition->status) {
                      'completed' => 'Registration Closed',
                      'ongoing' => 'Ongoing',
                      'upcoming' => 'Coming Soon',
                      default => 'Registration Closed',
                  };
              @endphp
              <span style="font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px; background: {{ $detailsBadge['bg'] }}; color: {{ $detailsBadge['color'] }}; border: 1px solid {{ $detailsBadge['border'] }};">
                  {{ $detailsBadge['label'] }}
              </span>
          </div>
          <div class="det-body">
              
              <div class="dash-card" style="margin-bottom: 1.5rem;">
                  <h4 style="font-family: var(--font-display); color: var(--accent-blue-light); margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.5rem;">
                      <i class="fi fi-rr-info" style="margin-right: 0.5rem;"></i> Description
                  </h4>
                  <p style="color: var(--text-secondary); line-height: 1.6; font-size: 0.95rem;">
                      {{ $competition->description ?? 'No description provided.' }}
                  </p>
              </div>

              <div class="info-grid">
                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-users"></i> Participation Type</span>
                      <span class="info-value">{{ ucwords(str_replace('_', ' ', $competition->registration_type)) }}</span>
                  </div>
                  
                  @if(in_array($competition->registration_type, ['team', 'individual_or_team']))
                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-users-alt"></i> Max Team Members</span>
                      <span class="info-value">{{ $competition->max_team_members }}</span>
                  </div>
                  @endif

                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-money-bill-wave"></i> Registration Fee</span>
                      <span class="info-value">
                          {{ $competition->registration_fee > 0 ? 'IDR ' . number_format($competition->registration_fee, 0, ',', '.') : 'Free' }}
                      </span>
                  </div>

                  @if($competition->registration_close_at || $competition->extended_registration_close_at)
                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-clock"></i> Registration Deadline</span>
                      <span class="info-value">
                          @if($isExtended && $competition->extended_registration_close_at)
                              <span style="text-decoration: line-through; opacity: 0.5; font-size: 0.85rem; margin-right: 0.35rem;">
                                  {{ $competition->registration_close_at ? $competition->registration_close_at->format('d M Y, H:i') : '' }}
                              </span>
                              <span style="color: #fbbf24; font-weight: 700;">
                                  {{ $competition->extended_registration_close_at->format('d M Y, H:i') }} WIB
                              </span>
                          @else
                              {{ $competition->effective_registration_close_at ? $competition->effective_registration_close_at->format('F j, Y, H:i') . ' WIB' : 'TBA' }}
                          @endif
                      </span>
                  </div>
                  @endif

                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-calendar"></i> Event Date</span>
                      <span class="info-value">
                          {{ $competition->competition_start_at ? $competition->competition_start_at->format('F j, Y') : 'TBA' }}
                      </span>
                  </div>
                  
                  <div class="info-item">
                      <span class="info-label"><i class="fi fi-rr-marker"></i> Location</span>
                      <span class="info-value">{{ $competition->location ?? 'TBA' }}</span>
                  </div>
              </div>

              <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; flex-wrap: wrap;">
                  <a href="{{ route('dashboard') }}" class="btn-secondary" style="flex: 1; min-width: 150px; max-width: 200px;">Back to Dashboard</a>
                  
                  @if($competition->isRegistrationOpen())
                      @if($latestRegistration)
                          @if(in_array($latestRegistration->status, ['rejected', 'cancelled']))
                              <a href="{{ route('competition.register', $competition->slug) }}" class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; text-align: center;">Register Again</a>
                          @elseif(in_array($latestRegistration->status, ['approved', 'verified']))
                              <button disabled class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; opacity: 0.5; cursor: not-allowed; text-align: center;">Registered</button>
                          @else
                              <button disabled class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; opacity: 0.5; cursor: not-allowed; text-align: center;">Under Review</button>
                          @endif
                      @else
                          <a href="{{ route('competition.register', $competition->slug) }}" class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; text-align: center;">Register Now</a>
                      @endif
                  @else
                      <button disabled class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; opacity: 0.6; cursor: not-allowed; text-align: center; background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.15); color: #94a3b8;">
                          {{ $detBtnLabel }}
                      </button>
                  @endif
              </div>
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
