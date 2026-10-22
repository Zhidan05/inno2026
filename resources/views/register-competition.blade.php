<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - {{ $competition->name }} - InnoElectrica 26</title>
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
      .registration-block {
          border: 1px solid var(--border-subtle);
          border-radius: 12px;
          overflow: hidden;
          margin-bottom: 2rem;
          background: rgba(0,0,0,0.1);
      }
      .reg-header {
          background: rgba(255,255,255,0.02);
          padding: 1rem 1.5rem;
          border-bottom: 1px solid var(--border-subtle);
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      .reg-header h2 {
          font-family: var(--font-display);
          font-size: 1.2rem;
          color: var(--accent-blue-light);
      }
      .reg-body {
          padding: 1.5rem;
      }
      .form-section-title {
          font-family: var(--font-display);
          color: var(--accent-blue-light);
          margin-bottom: 1rem;
          font-size: 1.05rem;
          border-bottom: 1px solid rgba(255,255,255,0.05);
          padding-bottom: 0.5rem;
          display: flex;
          align-items: center;
          gap: 0.5rem;
      }
      .radio-group {
          display: flex;
          gap: 1rem;
      }
      .radio-option {
          flex: 1;
          background: var(--surface);
          border: 1px solid var(--border-default);
          border-radius: 8px;
          padding: 1rem;
          cursor: pointer;
          transition: 0.3s;
          text-align: center;
      }
      .radio-option:hover {
          border-color: var(--accent-blue);
      }
      .radio-option input[type="radio"] {
          display: none;
      }
      .radio-option input[type="radio"]:checked + .radio-label {
          color: var(--accent-yellow);
          font-weight: bold;
      }
      .radio-option:has(input[type="radio"]:checked) {
          border-color: var(--accent-yellow);
          background: rgba(255, 194, 9, 0.1);
      }
      .radio-label {
          color: var(--text-secondary);
          font-family: var(--font-display);
          display: block;
          pointer-events: none;
      }
      .member-block {
          background: rgba(255,255,255,0.02);
          padding: 1rem;
          border-radius: 6px;
          margin-bottom: 1rem;
          border-left: 3px solid var(--accent-blue);
      }
      .remove-member-btn {
          background: rgba(255, 77, 77, 0.1);
          color: #ff4d4d;
          border: 1px solid rgba(255, 77, 77, 0.3);
          padding: 0.25rem 0.5rem;
          border-radius: 4px;
          font-size: 0.75rem;
          cursor: pointer;
          margin-top: 0.5rem;
          transition: background-color 0.2s;
      }
      .remove-member-btn:hover {
          background: rgba(255, 77, 77, 0.2);
      }
      .add-member-btn {
          background: transparent;
          color: var(--accent-blue-light);
          border: 1px dashed var(--accent-blue);
          padding: 0.75rem;
          width: 100%;
          border-radius: 6px;
          cursor: pointer;
          font-family: var(--font-display);
          transition: 0.3s;
      }
      .add-member-btn:hover {
          background: rgba(63, 128, 239, 0.1);
      }
      .btn-secondary {
          background: transparent;
          color: var(--text-secondary);
          border: 1px solid var(--border-default);
          padding: 0.75rem 1.5rem;
          border-radius: 8px;
          font-family: var(--font-display);
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          text-decoration: none;
          display: inline-block;
          text-align: center;
      }
      .btn-secondary:hover {
          border-color: var(--text-primary);
          color: var(--text-primary);
      }
      .form-input {
          background: var(--surface);
          border: 1px solid var(--border-default);
          color: var(--text-primary);
          padding: 0.75rem 1rem;
          border-radius: 8px;
          width: 100%;
          transition: border-color 0.2s;
      }
      .form-input:focus {
          border-color: var(--accent-blue);
          outline: none;
      }
      .form-label {
          color: var(--text-secondary);
          font-size: 0.9rem;
          margin-bottom: 0.5rem;
          display: block;
      }
      .file-upload-wrapper {
          border: 1px dashed var(--border-default);
          padding: 1.5rem;
          border-radius: 8px;
          background: rgba(255,255,255,0.02);
          text-align: center;
          transition: border-color 0.3s;
      }
      .file-upload-wrapper:hover {
          border-color: var(--accent-blue);
      }
      .hidden {
          display: none !important;
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
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors relative py-1 group" style="text-decoration: none;">
          Profile
          <span class="absolute bottom-0 left-0 w-0 group-hover:w-full h-[2px] bg-cyan-400 transition-all duration-200"></span>
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
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Dashboard
        </a>
        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-200 hover:text-cyan-400 hover:bg-white/5 px-4 py-3 rounded-xl transition-all block" style="text-decoration: none;">
          Profile
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
    <div class="dash-container" style="max-width: 800px; margin: 0 auto;">
      
      <header class="dash-header" style="margin-bottom: 2rem;">
        <div class="dash-greeting">
            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem; display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('dashboard') }}" style="color: var(--accent-blue-light); text-decoration: none;">Dashboard</a> 
                <span>/</span> 
                <span>Registration</span>
            </div>
            <h1 style="color: var(--text-primary); font-size: 2rem; margin-bottom: 0.25rem;">Register for <br/> <span style="color: var(--accent-blue-light);">{{ $competition->name }}</span></h1>
        </div>
      </header>

      @if($errors->any())
        <div class="status-alert alert-rejected" style="margin-bottom: 1.5rem;">
            <strong>REGISTRATION ERROR</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem; color: #ff4d4d; font-size: 0.85rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form action="{{ route('competition.register.store', $competition->slug) }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="registration-block">
              <div class="reg-header">
                  <h2>Registration Details</h2>
              <div style="font-family: var(--font-display); font-size: 0.9rem; color: var(--text-secondary);">
                      Fee: {{ $competition->isFree() ? 'FREE' : 'IDR ' . number_format($competition->registration_fee, 0, ',', '.') }}
                  </div>
              </div>
              <div class="reg-body">
                  <!-- REGISTRATION MODE -->
                  <div class="dash-card" style="margin-bottom: 1.5rem;">
                      <h4 class="form-section-title"><i class="fi fi-rr-users-alt"></i> 1. Participation Mode</h4>
                      <div class="radio-group">
                          @if($competition->registration_type === 'individual' || $competition->registration_type === 'individual_or_team')
                          <label class="radio-option">
                              <input type="radio" name="registration_mode" value="solo" {{ old('registration_mode') == 'solo' || $competition->registration_type == 'individual' ? 'checked' : '' }} onchange="toggleTeamSection()">
                              <span class="radio-label"><i class="fi fi-rr-user" style="margin-right: 0.5rem;"></i>Solo</span>
                          </label>
                          @endif

                          @if($competition->registration_type === 'team' || $competition->registration_type === 'individual_or_team')
                          <label class="radio-option">
                              <input type="radio" name="registration_mode" value="team" {{ old('registration_mode') == 'team' || $competition->registration_type == 'team' ? 'checked' : '' }} onchange="toggleTeamSection()">
                              <span class="radio-label"><i class="fi fi-rr-users" style="margin-right: 0.5rem;"></i>Team</span>
                          </label>
                          @endif
                      </div>
                  </div>

                  <!-- TEAM DETAILS (HIDDEN FOR SOLO) -->
                  <div class="dash-card hidden" id="teamSection" style="margin-bottom: 1.5rem;">
                      <h4 class="form-section-title"><i class="fi fi-rr-users-class"></i> 2. Team Details</h4>
                      
                      <div class="form-group" style="margin-bottom: 1.5rem;">
                          <label class="form-label" for="team_name">Team Name</label>
                          <input id="team_name" name="team_name" type="text" class="form-input" value="{{ old('team_name') }}" placeholder="Enter your team's name">
                      </div>

                      <div>
                          <label class="form-label">Team Members (Max: {{ $competition->max_team_members }})</label>
                          <p style="font-size: 0.8rem; color: var(--text-tertiary); margin-bottom: 1rem;">
                              <i class="fi fi-rr-info" style="margin-right: 0.25rem;"></i> You ({{ Auth::user()->name }}) are automatically Member 1 (Team Leader).
                          </p>
                          
                          <div id="membersContainer">
                              <!-- Dynamic Members appended here -->
                          </div>
                          
                          <button type="button" class="add-member-btn" id="addMemberBtn" onclick="addMember()">+ Add Member</button>
                      </div>
                  </div>

                  <!-- PAYMENT PROOF -->
                  @if($competition->requiresPayment())
                  <div class="dash-card" style="margin-bottom: 1.5rem;">
                      <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Payment Proof</h4>
                      
                      <div class="member-block" style="border-left-color: var(--accent-gold); margin-bottom: 1.5rem;">
                          <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Payment Instructions</div>
                          <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                              Please transfer <strong>IDR {{ number_format($competition->registration_fee, 0, ',', '.') }}</strong> to:<br>
                              <strong style="color: var(--accent-gold);">Bank XYZ - 123456789 (Account Name: InnoElectrica)</strong><br>
                              Upload the transfer receipt below to complete your registration.
                          </p>
                      </div>
                      
                      <div class="form-group">
                          <label class="form-label" for="proof_of_payment">Upload Receipt</label>
                          <div class="file-upload-wrapper">
                              <p style="font-size: 0.85rem; color: var(--text-tertiary); margin-bottom: 1rem;">PDF, JPG, PNG — Max 2 MB</p>
                              <input id="proof_of_payment" name="proof_of_payment" type="file" accept=".pdf,.jpg,.jpeg,.png" required style="color: var(--text-secondary); width: 100%; max-width: 300px; margin: 0 auto; display: block;">
                          </div>
                      </div>
                  </div>
                  @else
                  <div class="dash-card" style="margin-bottom: 1.5rem;">
                      <h4 class="form-section-title"><i class="fi fi-rr-receipt"></i> 3. Registration Fee</h4>
                      <div class="member-block" style="border-left-color: #10b981; margin-bottom: 0;">
                          <div style="font-weight: 600; color: #10b981; margin-bottom: 0.25rem;">FREE</div>
                          <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                              No proof of payment is required for this competition.
                          </p>
                      </div>
                  </div>
                  @endif

                  <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; flex-wrap: wrap;">
                      <a href="{{ route('dashboard') }}" class="btn-secondary" style="flex: 1; min-width: 150px; max-width: 200px;">Cancel</a>
                      <button type="submit" class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; padding: 0.75rem 1.5rem; font-size: 1rem;">Submit Registration</button>
                  </div>
              </div>
          </div>
      </form>

    </div>
  </main>

  <script>
      const maxMembers = {{ $competition->max_team_members - 1 }}; // Exclude leader
      let memberCount = 0;

      function toggleTeamSection() {
          const mode = document.querySelector('input[name="registration_mode"]:checked').value;
          const teamSection = document.getElementById('teamSection');
          if (mode === 'team') {
              teamSection.classList.remove('hidden');
          } else {
              teamSection.classList.add('hidden');
          }
      }

      function addMember() {
          if (memberCount >= maxMembers) return;
          
          const container = document.getElementById('membersContainer');
          const div = document.createElement('div');
          div.className = 'member-block';
          div.id = `memberBlock_${memberCount}`;
          
          div.innerHTML = `
              <div style="font-weight:bold; font-size: 0.85rem; color: var(--text-secondary); margin-bottom:0.5rem;">Member ${memberCount + 2}</div>
              <div class="form-group" style="margin-bottom: 0.5rem;">
                  <input type="text" name="members[${memberCount}][name]" class="form-input" placeholder="Full Name" required>
              </div>
              <div class="form-group" style="margin-bottom: 0.5rem;">
                  <input type="text" name="members[${memberCount}][nim]" class="form-input" placeholder="NIM / Student ID" required>
              </div>
              <button type="button" class="remove-member-btn" onclick="removeMember(${memberCount})">Remove</button>
          `;
          
          container.appendChild(div);
          memberCount++;
          
          checkMax();
      }

      function removeMember(id) {
          const block = document.getElementById(`memberBlock_${id}`);
          if (block) {
              block.remove();
              memberCount--;
              checkMax();
          }
      }

      function checkMax() {
          const btn = document.getElementById('addMemberBtn');
          if (memberCount >= maxMembers) {
              btn.style.display = 'none';
          } else {
              btn.style.display = 'block';
          }
      }

      // Init on load
      document.addEventListener('DOMContentLoaded', () => {
          if(document.querySelector('input[name="registration_mode"]:checked')) {
              toggleTeamSection();
          }
          checkMax();
      });
  </script>
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
