<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $competition->name }} - Details - InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
      :root {
          --bg-primary: #050811;
          --bg-secondary: #0a0f1d;
          --bg-tertiary: #111827;
          --surface: #111827;
          --surface-elevated: #1f2937;
          --border-subtle: rgba(255, 255, 255, 0.05);
          --border-default: rgba(255, 255, 255, 0.1);
      }
      body {
          background-color: var(--bg-primary);
      }
      .navbar {
          background: rgba(5, 8, 17, 0.8) !important;
          border-bottom: 1px solid var(--border-default) !important;
      }
      .details-block {
          border: 1px solid var(--border-subtle);
          border-radius: 12px;
          overflow: hidden;
          margin-bottom: 2rem;
          background: rgba(0,0,0,0.1);
      }
      .det-header {
          background: rgba(255,255,255,0.02);
          padding: 1rem 1.5rem;
          border-bottom: 1px solid var(--border-subtle);
      }
      .det-header h2 {
          font-family: var(--font-display);
          font-size: 1.2rem;
          color: var(--accent-blue-light);
      }
      .det-body {
          padding: 1.5rem;
      }
      .info-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 1.5rem;
          margin-bottom: 1.5rem;
      }
      .info-item {
          background: var(--surface);
          border: 1px solid var(--border-default);
          padding: 1rem;
          border-radius: 8px;
      }
      .info-label {
          color: var(--text-secondary);
          font-size: 0.85rem;
          margin-bottom: 0.25rem;
          display: block;
      }
      .info-value {
          color: var(--text-primary);
          font-weight: 600;
          font-size: 1rem;
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
  </style>
</head>

<body>
  <nav class="navbar" id="navbar" style="background: rgba(4, 10, 67, 0.95); backdrop-filter: blur(10px);">
    <div class="nav-container">
      <a href="{{ url('/') }}" class="nav-logo">
        <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" style="height: 40px; width: auto; border-radius: 50%; margin-right: 8px;">
        <span class="logo-text">IEE</span>
        <span class="logo-year">2026</span>
      </a>
      <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
        @auth
        <li><a href="{{ route('profile.edit') }}" class="nav-link">Profile</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <a href="#" class="nav-link nav-login" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
            </form>
        </li>
        @else
        <li><a href="{{ route('login') }}" class="nav-link nav-login">Login</a></li>
        @endauth
      </ul>
      <div class="nav-hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>
    </div>
  </nav>

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
          <div class="det-header">
              <h2>Competition Details</h2>
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
                  
                  @if($competition->status === 'registration_open')
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
                      <button disabled class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; opacity: 0.5; cursor: not-allowed; text-align: center;">Registration Closed</button>
                  @endif
              </div>
          </div>
      </div>

    </div>
  </main>
  
  <script>
    document.getElementById('hamburger').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('active');
    });
  </script>
</body>
</html>
