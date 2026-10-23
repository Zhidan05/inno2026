<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - {{ $competition->name }} - InnoElectrica 26</title>
  
  @include('dashboard.head-assets')
  @include('competitions.registration-styles')
</head>

<body class="bg-[#050816] text-slate-100 min-h-screen">

  @include('partials.navbar')

  <main class="dashboard-main">
    <div class="dash-container" style="max-width: 800px; margin: 0 auto;">
      
      <header class="dash-header" style="margin-bottom: 2rem;">
        <div class="dash-greeting">
          <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem; display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('dashboard') }}" style="color: var(--accent-blue-light); text-decoration: none;">Dashboard</a> 
            <span>/</span> 
            <span>Registration</span>
          </div>
          <h1 style="color: var(--text-primary); font-size: 2rem; margin-bottom: 0.25rem;">
            Register for <br/> <span style="color: var(--accent-blue-light);">{{ $competition->name }}</span>
          </h1>
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
            <!-- 1. PARTICIPATION MODE -->
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

            <!-- 2. TEAM DETAILS -->
            @include('competitions.team-members-form', ['competition' => $competition])

            <!-- 3. PAYMENT PROOF / FEE -->
            @include('competitions.payment-proof-form', ['competition' => $competition])

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; flex-wrap: wrap;">
              <a href="{{ route('dashboard') }}" class="btn-secondary" style="flex: 1; min-width: 150px; max-width: 200px;">Cancel</a>
              <button type="submit" class="btn-primary" style="flex: 1; min-width: 200px; max-width: 250px; padding: 0.75rem 1.5rem; font-size: 1rem;">Submit Registration</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </main>

  @include('competitions.registration-scripts', ['competition' => $competition])

</body>

</html>
