<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - InnoElectrica 26</title>
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
      .comp-grid {
          display: grid;
          grid-template-columns: 1fr;
          gap: 1rem;
          margin-bottom: 2rem;
      }
      .available-comp-card {
          background: rgba(15, 23, 42, 0.50);
          border: 1px solid rgba(255, 255, 255, 0.10);
          backdrop-filter: blur(12px);
          -webkit-backdrop-filter: blur(12px);
          padding: 1.5rem;
          border-radius: 16px;
          text-align: left;
          transition: 0.3s;
          display: flex;
          flex-direction: column;
          box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
      }
      .available-comp-card:hover {
          border-color: rgba(56, 189, 248, 0.4);
          background: rgba(15, 23, 42, 0.70);
      }
      .available-comp-card h4 {
          color: #f8fafc;
          font-family: var(--font-body);
          font-weight: 600;
          font-size: 1.15rem;
          margin-bottom: 0.25rem;
      }
      .available-comp-card .desc {
          color: #94a3b8;
          font-size: 0.85rem;
          margin-bottom: 1.25rem;
          line-height: 1.5;
          flex-grow: 1;
      }
      .available-comp-card .meta {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 0.75rem;
          margin-bottom: 1.5rem;
          font-size: 0.8rem;
          color: #64748b;
      }
      .available-comp-card .meta div {
          display: flex;
          align-items: center;
          gap: 0.35rem;
      }
      .dash-action-row {
          display: flex;
          gap: 0.75rem;
          align-items: center;
          margin-top: auto;
      }
      .btn-dash-primary {
          background: #2563eb;
          color: #fff;
          font-family: var(--font-body);
          font-size: 0.85rem;
          font-weight: 600;
          height: 42px;
          padding: 0 1.25rem;
          border-radius: 10px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          text-decoration: none;
          transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
          border: none;
          flex: 1;
          cursor: pointer;
          box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
      }
      .btn-dash-primary:hover:not(:disabled) {
          background: #3b82f6;
          transform: translateY(-1px);
          box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
      }
      .btn-dash-secondary {
          background: rgba(255, 255, 255, 0.05);
          color: #94a3b8;
          font-family: var(--font-body);
          font-size: 0.85rem;
          font-weight: 500;
          height: 42px;
          padding: 0 1.25rem;
          border-radius: 10px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          text-decoration: none;
          transition: 0.2s;
          border: 1px solid rgba(255, 255, 255, 0.12);
      }
      .btn-dash-secondary:hover {
          border-color: rgba(255, 255, 255, 0.3);
          color: #f8fafc;
          background: rgba(255, 255, 255, 0.1);
      }
      @media (max-width: 640px) {
          .dash-action-row {
              flex-direction: column;
          }
          .dash-action-row .btn-dash-secondary, 
          .dash-action-row .btn-dash-primary {
              width: 100%;
          }
      }
      .registration-block {
          border: 1px solid rgba(255, 255, 255, 0.10);
          border-radius: 16px;
          overflow: hidden;
          margin-bottom: 2rem;
          background: rgba(15, 23, 42, 0.40);
      }
      .reg-header {
          background: rgba(255, 255, 255, 0.03);
          padding: 1rem 1.5rem;
          border-bottom: 1px solid rgba(255, 255, 255, 0.08);
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      .reg-header h2 {
          font-family: var(--font-display);
          font-size: 1.2rem;
          color: #38bdf8;
      }
      .reg-body {
          padding: 1.5rem;
      }
      .reg-body .dash-grid {
          margin-top: 0;
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
      
      <!-- HEADER -->
      <header class="dash-header">
        <div class="dash-greeting">
            <h1>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h1>
        </div>
      </header>

      @if(session('success'))
          <div class="status-alert alert-approved" style="margin-bottom: 1.5rem;">
              <strong>SUCCESS</strong>
              <p>{{ session('success') }}</p>
          </div>
      @endif

      @if(session('error'))
          <div class="status-alert alert-rejected" style="margin-bottom: 1.5rem;">
              <strong>ERROR</strong>
              <p>{{ session('error') }}</p>
          </div>
      @endif

      @if($latestRegistrations->count() > 0)
          @foreach($latestRegistrations as $registration)
          <div class="registration-block">
              <div class="reg-header">
                  <h2>{{ $registration->competition->name }}</h2>
                  <div class="dash-status-badge badge-{{ $registration->status }}">
                      {{ ucfirst(str_replace('_', ' ', $registration->status)) }}
                  </div>
              </div>
              <div class="reg-body">
                  <div class="dash-grid">
                      
                      <!-- REGISTRATION STATUS -->
                      <div class="dash-card">
                          <h3 class="card-title"><i class="fi fi-rr-clipboard-list"></i> Registration Status</h3>
                          
                          <div class="status-alert alert-{{ str_replace('_required', '', $registration->status) }}">
                              <strong>
                                  @if($registration->status === 'pending')
                                      UNDER REVIEW
                                  @elseif($registration->status === 'approved')
                                      VERIFIED
                                  @elseif($registration->status === 'rejected')
                                      REJECTED
                                  @elseif($registration->status === 'revision_required')
                                      ACTION REQUIRED
                                  @endif
                              </strong>
                              <p>
                                  @if($registration->status === 'pending')
                                      @if($registration->competition->isFree())
                                          Your registration is currently being reviewed.
                                      @else
                                          Your registration and payment proof are currently being reviewed.
                                      @endif
                                  @elseif($registration->status === 'approved')
                                      Your participation has been confirmed.
                                  @elseif($registration->status === 'rejected')
                                      Your registration has been rejected.
                                  @elseif($registration->status === 'revision_required')
                                      Your registration requires revision. Please check the notes below.
                                  @endif
                              </p>
                          </div>

                          @if($registration->verification_notes && ($registration->status === 'rejected' || $registration->status === 'revision_required'))
                              <div class="verification-notes" style="border-left: 3px solid #ff4d4d; background: rgba(255, 77, 77, 0.05); padding: 1rem; border-radius: 6px; margin-top: 1rem;">
                                  <strong style="color: #ff4d4d; display: block; margin-bottom: 0.25rem;">Moderator Note:</strong>
                                  <p style="color: var(--text-secondary); font-size: 0.9rem;">{{ $registration->verification_notes }}</p>
                              </div>
                          @endif

                          @if($registration->status === 'rejected')
                              <div style="margin-top: 1.5rem;">
                                  <a href="{{ route('competition.register', $registration->competition->slug) }}" class="btn-primary" style="display: block; text-align: center; width: 100%;">Submit New Registration</a>
                              </div>
                          @endif

                          @if($registration->registration_mode === 'team')
                              <div style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-secondary);">
                                  <strong style="color: var(--text-primary);">Team Name:</strong> {{ $registration->team_name }}<br>
                                  <strong style="color: var(--text-primary);">Members:</strong> {{ $registration->members->count() + 1 }}
                              </div>
                          @endif

                          <!-- Compact Progress -->
                          <div class="progress-track">
                              <div class="progress-step {{ $registration ? 'active' : '' }}">Submitted</div>
                              <div class="progress-step {{ $registration->status === 'approved' ? 'active' : '' }}">Verified</div>
                              <div class="progress-step {{ in_array($registration->competition->status, ['ongoing', 'completed', 'results_published']) ? 'active' : '' }}">Competition</div>
                              <div class="progress-step {{ $registration->competition->status === 'results_published' ? 'active' : '' }}">Results</div>
                          </div>
                      </div>

                      <!-- TICKET -->
                      @if($registration->status === 'approved' && $registration->ticket)
                      <div class="dash-card ticket-card">
                          <h3 class="card-title"><i class="fi fi-rr-ticket"></i> Participant Pass</h3>
                          <div class="ticket-content">
                              <div class="ticket-code">{{ $registration->ticket->ticket_code }}</div>
                              <p class="ticket-meta">{{ $registration->registration_mode === 'team' ? $registration->team_name : Auth::user()->name }}</p>
                              <a href="#" class="btn-primary" style="display:inline-block; margin-top:1rem; padding: 0.5rem 1rem; font-size: 0.8rem;">View Ticket</a>
                          </div>
                      </div>
                      @endif

                      <!-- COMPETITION INFO -->
                      <div class="dash-card comp-info-card">
                          <h3 class="card-title"><i class="fi fi-rr-calendar-lines"></i> Event Information</h3>
                          <ul class="comp-details-list">
                              <li><strong>Status:</strong> 
                                <span class="comp-status-text">
                                    {{ ucwords(str_replace('_', ' ', $registration->competition->status)) }}
                                </span>
                              </li>
                              <li><strong>Date:</strong> 
                                {{ $registration->competition->competition_start_at ? $registration->competition->competition_start_at->format('F j, Y') : 'TBA' }}
                              </li>
                              <li><strong>Location:</strong> {{ $registration->competition->location ?? 'TBA' }}</li>
                          </ul>
                          
                          @if($registration->competition->status === 'ongoing')
                              <div class="ongoing-alert">
                                  COMPETITION IS CURRENTLY ONGOING
                              </div>
                          @elseif($registration->competition->status === 'completed')
                              <div class="completed-alert">
                                  COMPETITION COMPLETED<br>Results will be announced soon.
                              </div>
                          @elseif($registration->competition->status === 'upcoming' && $registration->competition->competition_start_at)
                              <div class="dash-countdown-wrapper">
                                  <div class="countdown-label">COMPETITION STARTS IN</div>
                                  <div class="dash-countdown" data-time="{{ $registration->competition->competition_start_at->toIso8601String() }}">
                                      <div class="dash-count-block"><span class="d-days">00</span><small>Days</small></div>
                                      <div class="dash-count-block"><span class="d-hours">00</span><small>Hours</small></div>
                                      <div class="dash-count-block"><span class="d-mins">00</span><small>Mins</small></div>
                                  </div>
                              </div>
                          @endif
                      </div>

                      <!-- SUBMISSIONS -->
                      @if(in_array($registration->competition->status, ['ongoing']) && $registration->competition->submission_type !== 'none' && $registration->status === 'approved')
                      <div class="dash-card submission-card" style="margin-top: 1rem;">
                          <h3 class="card-title"><i class="fi fi-rr-cloud-upload"></i> Project Submission</h3>
                          
                          @if($registration->submitted_at)
                              <div style="margin-bottom: 1rem; color: #10b981; font-weight: 600;">
                                  <i class="fi fi-rr-check-circle"></i> Work Submitted on {{ $registration->submitted_at->format('M j, Y H:i') }}
                              </div>
                              <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1rem;">You can resubmit to update your work before the deadline.</p>
                          @endif

                          <form action="{{ route('competition.submission.store', $registration) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              
                              @if(in_array($registration->competition->submission_type, ['file', 'both']))
                                  <div class="form-group" style="margin-bottom: 1rem;">
                                      <label class="form-label">Upload File (Max 5MB)</label>
                                      <input type="file" name="submission_file" class="form-input" style="padding: 0.5rem;" />
                                      @if($registration->submission_file_path)
                                          <div style="font-size: 0.8rem; margin-top: 0.5rem;">
                                              Current File: <a href="{{ Storage::url($registration->submission_file_path) }}" target="_blank" style="color: var(--accent-blue);">View File</a>
                                          </div>
                                      @endif
                                  </div>
                              @endif

                              @if(in_array($registration->competition->submission_type, ['link', 'both']))
                                  <div class="form-group" style="margin-bottom: 1rem;">
                                      <label class="form-label">Submission Link (URL)</label>
                                      <input type="url" name="submission_link" class="form-input" placeholder="https://..." value="{{ $registration->submission_link }}" />
                                  </div>
                              @endif

                              <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                  {{ $registration->submitted_at ? 'Update Submission' : 'Submit Work' }}
                              </button>
                          </form>
                      </div>
                      @endif

                      <!-- RESULTS -->
                      @if($registration->competition->status === 'results_published')
                      <div class="dash-card result-card">
                          <h3 class="card-title"><i class="fi fi-rr-trophy"></i> Your Result</h3>
                          <div class="result-display">
                              <div class="result-box">
                                  <span class="result-label">Score</span>
                                  <span class="result-value">{{ $registration->grade ?? 'N/A' }}</span>
                              </div>
                              <div class="result-box">
                                  <span class="result-label">Rank</span>
                                  <span class="result-value">
                                      @if($registration->rank)
                                          #{{ $registration->rank }}
                                      @else
                                          N/A
                                      @endif
                                  </span>
                              </div>
                          </div>
                      </div>
                      @endif

                  </div>
              </div>
          </div>
          @endforeach
      @else
      <div class="dash-card empty-state">
          <i class="fi fi-rr-sad-tear"></i>
          <h3>WELCOME</h3>
          <p>You are not registered for any competition yet.</p>
          <a href="#available-competitions" class="btn-primary" style="margin-top: 1rem; display: inline-block;">Explore Competitions</a>
      </div>
      @endif

      <!-- REGISTRATION HISTORY -->
      @if($registrationHistory->count() > 0)
      <div class="dash-card" style="margin-top: 2rem;">
          <h3 style="color: var(--text-primary); font-family: var(--font-display); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
              <i class="fi fi-rr-time-past"></i> Registration History
          </h3>
          <div class="history-list">
              @foreach($registrationHistory as $index => $historyReg)
              <div class="history-item" style="border: 1px solid var(--border-subtle); background: rgba(0,0,0,0.2); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.5rem;">
                      <strong style="color: var(--text-primary);">Attempt #{{ $registrationHistory->count() - $index }} - {{ $historyReg->competition->name }}</strong>
                      <span class="dash-status-badge badge-{{ $historyReg->status }}" style="font-size: 0.75rem; padding: 0.2rem 0.5rem;">
                          {{ strtoupper(str_replace('_', ' ', $historyReg->status)) }}
                      </span>
                  </div>
                  <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                      <strong>Submitted:</strong> {{ $historyReg->created_at->format('M j, Y H:i') }}
                  </div>
                  @if($historyReg->verification_notes)
                  <div style="font-size: 0.85rem; color: var(--text-secondary); background: rgba(255,255,255,0.02); padding: 0.5rem; border-radius: 4px; border-left: 2px solid #ff4d4d;">
                      <strong>Moderator Note:</strong><br>
                      {{ $historyReg->verification_notes }}
                  </div>
                  @endif
              </div>
              @endforeach
          </div>
      </div>
      @endif

      <!-- AVAILABLE COMPETITIONS -->
      <div id="available-competitions" style="margin-top: 2rem;">
          <h3 style="color: var(--text-primary); font-family: var(--font-display); margin-bottom: 1rem;">Available Competitions</h3>
          @if($availableCompetitions->count() > 0)
          <div class="comp-grid">
              @foreach($availableCompetitions as $comp)
              @php
                  $userReg = $latestRegistrations->where('competition_id', $comp->id)->first();
                  $isOpen = $comp->isRegistrationOpen();
                  $isExtended = $comp->isExtended();
                  $dashStatusBadge = $isExtended
                      ? ['label' => 'EXTENDED', 'bg' => 'rgba(245, 158, 11, 0.15)', 'color' => '#fbbf24', 'border' => 'rgba(245, 158, 11, 0.3)']
                      : match($comp->status) {
                          'extended' => ['label' => 'EXTENDED', 'bg' => 'rgba(245, 158, 11, 0.15)', 'color' => '#fbbf24', 'border' => 'rgba(245, 158, 11, 0.3)'],
                          'registration_open' => ['label' => 'OPEN', 'bg' => 'rgba(16, 185, 129, 0.12)', 'color' => '#10b981', 'border' => 'rgba(16, 185, 129, 0.25)'],
                          'ongoing' => ['label' => 'ONGOING', 'bg' => 'rgba(56, 189, 248, 0.12)', 'color' => '#38bdf8', 'border' => 'rgba(56, 189, 248, 0.25)'],
                          'completed' => ['label' => 'ENDED', 'bg' => 'rgba(148, 163, 184, 0.12)', 'color' => '#94a3b8', 'border' => 'rgba(148, 163, 184, 0.25)'],
                          'upcoming' => ['label' => 'UPCOMING', 'bg' => 'rgba(251, 191, 36, 0.12)', 'color' => '#fbbf24', 'border' => 'rgba(251, 191, 36, 0.25)'],
                          default => ['label' => 'CLOSED', 'bg' => 'rgba(244, 63, 94, 0.12)', 'color' => '#f43f5e', 'border' => 'rgba(244, 63, 94, 0.25)'],
                      };
                  $btnLabel = match($comp->status) {
                      'completed' => 'Registration Closed',
                      'ongoing' => 'Ongoing',
                      'upcoming' => 'Coming Soon',
                      default => 'Registration Closed',
                  };
              @endphp
              <div class="available-comp-card">
                  <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; gap: 0.5rem;">
                      <h4>{{ $comp->name }}</h4>
                      <span style="font-size: 0.7rem; font-weight: 600; padding: 0.2rem 0.55rem; border-radius: 6px; background: {{ $dashStatusBadge['bg'] }}; color: {{ $dashStatusBadge['color'] }}; border: 1px solid {{ $dashStatusBadge['border'] }}; letter-spacing: 0.5px; flex-shrink: 0;">
                          {{ $dashStatusBadge['label'] }}
                      </span>
                  </div>
                  
                  @if($comp->description)
                      <p class="desc">{{ Str::limit($comp->description, 80) }}</p>
                  @else
                      <div style="flex-grow: 1;"></div>
                  @endif
                  
                  <div class="meta">
                      <div><i class="fi fi-rr-users"></i> {{ ucwords(str_replace('_', ' ', $comp->registration_type)) }}</div>
                      <div><i class="fi fi-rr-calendar"></i> {{ $comp->competition_start_at ? $comp->competition_start_at->format('M j, Y') : 'TBA' }}</div>
                      <div><i class="fi fi-rr-marker"></i> {{ $comp->location ?? 'Online' }}</div>
                      <div><i class="fi fi-rr-money-bill-wave"></i> {{ $comp->isFree() ? 'FREE' : 'IDR ' . number_format($comp->registration_fee, 0, ',', '.') }}</div>
                      @if($isExtended && $comp->extended_registration_close_at)
                          <div style="color: #fbbf24; font-size: 0.75rem; grid-column: span 2; display: flex; align-items: center; gap: 0.35rem; font-weight: 600;">
                              <i class="fi fi-rr-clock"></i> Extended to {{ $comp->extended_registration_close_at->format('M j, Y H:i') }} WIB
                          </div>
                      @endif
                  </div>
                  
                  <div class="dash-action-row">
                      <a href="{{ route('competition.show', $comp->slug) }}" class="btn-dash-secondary">View Details &nbsp;<i class="fi fi-rr-arrow-small-right"></i></a>
                      @if(! $isOpen)
                          <button disabled class="btn-dash-primary disabled-btn" style="opacity: 0.6; cursor: not-allowed; background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.1);">
                              {{ $btnLabel }}
                          </button>
                      @elseif(!$userReg)
                          <a href="{{ route('competition.register', $comp->slug) }}" class="btn-dash-primary">Register Now</a>
                      @elseif(in_array($userReg->status, ['rejected', 'cancelled']))
                          <a href="{{ route('competition.register', $comp->slug) }}" class="btn-dash-primary">Register Again</a>
                      @elseif(in_array($userReg->status, ['approved', 'verified']))
                          <button disabled class="btn-dash-primary disabled-btn" style="opacity: 0.5;">Registered</button>
                      @else
                          <button disabled class="btn-dash-primary disabled-btn" style="opacity: 0.5;">Under Review</button>
                      @endif
                  </div>
              </div>
              @endforeach
          </div>
          @else
          <div class="dash-card" style="text-align: center; color: var(--text-secondary);">
              <i class="fi fi-rr-box-open" style="font-size: 2rem; opacity: 0.5; margin-bottom: 0.5rem; display: block;"></i>
              <p>There are no competitions currently open for registration.</p>
              <a href="{{ url('/') }}#competitions" class="btn-primary" style="display: inline-block; margin-top: 1rem;">View All Events</a>
          </div>
          @endif
      </div>

      <!-- ANNOUNCEMENTS -->
      <div class="dash-card announcements-card" style="margin-top: 1.5rem;">
          <h3 class="card-title"><i class="fi fi-rr-megaphone"></i> Latest Announcements</h3>
          @if($announcements->count() > 0)
              <ul class="announcement-list">
                  @foreach($announcements as $announcement)
                  <li>
                      <div class="ann-header">
                          <strong class="ann-title">{{ $announcement->title }}</strong>
                          <span class="ann-date">{{ $announcement->published_at->format('M j, Y') }}</span>
                      </div>
                      <p class="ann-content">{{ $announcement->content }}</p>
                  </li>
                  @endforeach
              </ul>
          @else
              <p style="color: var(--text-tertiary); font-size: 0.9rem;">No new announcements at this time.</p>
          @endif
      </div>

    </div>
  </main>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
      // Mobile menu toggle
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

      // Dashboard Countdown Logic
      document.addEventListener('DOMContentLoaded', () => {
          const cdEls = document.querySelectorAll('.dash-countdown');
          cdEls.forEach(cdEl => {
              const targetTime = new Date(cdEl.dataset.time).getTime();
              const daysEl = cdEl.querySelector('.d-days');
              const hoursEl = cdEl.querySelector('.d-hours');
              const minsEl = cdEl.querySelector('.d-mins');

              function update() {
                  const now = new Date().getTime();
                  const distance = targetTime - now;
                  if (distance < 0) return;

                  daysEl.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                  hoursEl.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                  minsEl.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
              }
              update();
              setInterval(update, 60000);
          });
      });
  </script>
</body>
</html>
