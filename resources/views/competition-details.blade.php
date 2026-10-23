<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $competition->name }} - Details - InnoElectrica 26</title>
  
  @include('dashboard.head-assets')
  @include('competitions.details-styles')
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

</body>

</html>
