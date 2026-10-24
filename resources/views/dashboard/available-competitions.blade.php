@props(['availableCompetitions' => [], 'latestRegistrations' => []])

<!-- AVAILABLE COMPETITIONS -->
<div id="available-competitions" style="margin-top: 2rem;">
  <h3 style="color: var(--text-primary); font-family: var(--font-display); margin-bottom: 1rem;">Available Competitions</h3>
  @if(count($availableCompetitions) > 0)
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
