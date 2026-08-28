<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar" id="navbar" style="background: rgba(4, 10, 67, 0.95); backdrop-filter: blur(10px);">
    <div class="nav-container">
      <a href="{{ url('/') }}" class="nav-logo">
        <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" style="height: 40px; width: auto; border-radius: 50%; margin-right: 8px;">
        <span class="logo-text">IEE</span>
        <span class="logo-year">2026</span>
      </a>
      <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
        <li><a href="{{ route('profile.edit') }}" class="nav-link active">Profile</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <a href="#" class="nav-link nav-login" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
            </form>
        </li>
      </ul>
      <div class="nav-hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>
    </div>
  </nav>

  <main class="dashboard-main">
    <div class="dash-container">
      
      <header class="dash-header">
        <div class="dash-greeting">
            <h1>Participant Profile</h1>
        </div>
      </header>

      <div class="dash-grid">
          
          <div class="dash-card">
              <h3 class="card-title"><i class="fi fi-rr-user"></i> Profile Information</h3>
              
              @php
                  $registration = \App\Models\Registration::where('user_id', Auth::id())->first();
                  $isLocked = $registration && $registration->status === 'approved';
              @endphp

              @if($isLocked)
                  <div class="status-alert alert-approved" style="margin-bottom: 2rem;">
                      <strong>PROFILE LOCKED</strong>
                      <p>Your registration is verified. Critical identity fields cannot be changed. Contact the committee for support.</p>
                  </div>
              @endif

              <form method="post" action="{{ route('profile.update') }}">
                  @csrf
                  @method('patch')

                  <div class="form-group">
                      <label class="form-label" for="name">Full Name</label>
                      <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autocomplete="name" {{ $isLocked ? 'readonly' : '' }}>
                      @error('name') <span class="form-error">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group">
                      <label class="form-label" for="email">Email Address</label>
                      <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" {{ $isLocked ? 'readonly' : '' }}>
                      @error('email') <span class="form-error">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group">
                      <label class="form-label" for="phone">Phone / WhatsApp</label>
                      <input id="phone" name="phone" type="text" class="form-input" value="{{ old('phone', $user->phone) }}" required {{ $isLocked ? 'readonly' : '' }}>
                      @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                  </div>

                  <div class="form-group">
                      <label class="form-label" for="institution">Institution / University</label>
                      <input id="institution" name="institution" type="text" class="form-input" value="{{ old('institution', $user->institution) }}" required {{ $isLocked ? 'readonly' : '' }}>
                      @error('institution') <span class="form-error">{{ $message }}</span> @enderror
                  </div>
                  
                  @if($registration)
                  <div class="form-group">
                      <label class="form-label" for="competition">Competition</label>
                      <input id="competition" type="text" class="form-input" value="{{ $registration->competition->name }}" readonly disabled>
                  </div>
                  @endif

                  @if(session('status') === 'profile-updated')
                      <p class="form-error" style="color: #00ff80; margin-bottom: 1rem;">Profile successfully updated.</p>
                  @endif

                  @if(!$isLocked)
                  <div>
                      <button type="submit" class="btn-primary" style="border:none; cursor:pointer;">Save Changes</button>
                  </div>
                  @endif
              </form>
          </div>

      </div>
    </div>
  </main>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
