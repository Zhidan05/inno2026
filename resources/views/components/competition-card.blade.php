@props(['competition', 'index' => 0, 'compCount' => 1])

@php
  // Helper: Distinct Minimalist Lucide Icons for each competition
  $getCompIconSvg = function($title, $slug = '') {
    $key = strtolower(($title ?? '') . ' ' . ($slug ?? ''));
    if (str_contains($key, 'code') || str_contains($key, 'program') || str_contains($key, 'algoritma') || str_contains($key, 'it')) {
      // Code Terminal
      return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>';
    } elseif (str_contains($key, 'paper') || str_contains($key, 'future') || str_contains($key, 'tulis') || str_contains($key, 'ilmiah') || str_contains($key, 'esai')) {
      // Research Document / Scientific Node
      return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>';
    } elseif (str_contains($key, 'race') || str_contains($key, 'line') || str_contains($key, 'robot') || str_contains($key, 'follower')) {
      // Autonomous Robot / Track Sensor
      return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="12" cy="5" r="2"></circle><path d="M12 7v4"></path><line x1="8" y1="16" x2="8.01" y2="16"></line><line x1="16" y1="16" x2="16.01" y2="16"></line></svg>';
    } elseif (str_contains($key, 'visual') || str_contains($key, 'poster') || str_contains($key, 'desain') || str_contains($key, 'design')) {
      // Design Layers / Graphic Vector
      return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 17 22 12"></polyline></svg>';
    } else {
      // Hardware / Prototype / General Trophy
      return '<svg class="w-6 h-6 stroke-cyan-400 fill-none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path></svg>';
    }
  };

  $regType = $competition->registration_type ?? 'individual_or_team';
  $typeBadge = match($regType) {
    'individual' => 'SOLO',
    'team' => 'TEAM',
    'individual_or_team' => 'SOLO / TEAM',
    default => strtoupper(str_replace('_', ' ', $regType)),
  };

  $teamMax = (int) ($competition->max_team_members ?? 1);
  $teamLabel = match($regType) {
    'individual' => '1 Member (Solo)',
    'team' => 'Max ' . $teamMax . ' Members',
    'individual_or_team' => $teamMax > 1 ? '1 - ' . $teamMax . ' Members' : '1 Member',
    default => 'Max ' . $teamMax . ' Members',
  };

  $fee = (float) ($competition->registration_fee ?? 0);
  $feeFormatted = $fee > 0 ? 'IDR ' . number_format($fee, 0, ',', '.') : 'Free';

  $isExtended = $competition->isExtended();
  $status = $competition->status ?? 'draft';
  $isOpen = $competition->isRegistrationOpen();
  $statusLabel = $isExtended
    ? 'Registration Extended'
    : match($status) {
      'extended' => 'Registration Extended',
      'registration_open' => 'Registration Open',
      'upcoming' => 'Upcoming',
      'ongoing' => 'Ongoing',
      'registration_closed' => 'Registration Closed',
      'completed' => 'Competition Ended',
      'results_published' => 'Results Announced',
      default => ucfirst(str_replace('_', ' ', $status)),
    };

  $statusBadgeClass = ($isExtended || $status === 'extended')
    ? 'bg-amber-500/15 text-amber-300 border-amber-400/30'
    : match($status) {
      'registration_open' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
      'upcoming' => 'bg-amber-500/15 text-amber-300 border-amber-500/30',
      'ongoing' => 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
      'registration_closed' => 'bg-rose-500/15 text-rose-300 border-rose-500/30',
      'completed' => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
      'results_published' => 'bg-purple-500/15 text-purple-300 border-purple-500/30',
      default => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
    };

  $subType = $competition->submission_type ?? 'none';
  $submissionLabel = match($subType) {
    'file' => 'Document / File Upload',
    'link' => 'Online URL / Link',
    'both' => 'Document File & URL Link',
    default => null,
  };

  // Collect ONLY real timeline dates present in database
  $timeline = [];
  if (!empty($competition->registration_open_at)) {
    $timeline[] = [
      'phase' => 'Registration Opens',
      'date' => $competition->registration_open_at->format('d M Y, H:i') . ' WIB',
    ];
  }
  if (!empty($competition->registration_close_at)) {
    $timeline[] = [
      'phase' => 'Registration Closes',
      'date' => $competition->registration_close_at->format('d M Y, H:i') . ' WIB',
      'is_extended' => $isExtended,
      'extended_date' => ($isExtended && $competition->extended_registration_close_at) ? $competition->extended_registration_close_at->format('d M Y, H:i') . ' WIB' : null,
    ];
  }
  if (!empty($competition->competition_start_at)) {
    $timeline[] = [
      'phase' => 'Competition Begins',
      'date' => $competition->competition_start_at->format('d M Y, H:i') . ' WIB',
    ];
  }
  if (!empty($competition->competition_end_at)) {
    $timeline[] = [
      'phase' => 'Competition Ends',
      'date' => $competition->competition_end_at->format('d M Y, H:i') . ' WIB',
    ];
  }

  $registerUrl = $isOpen ? route('competition.register', $competition->slug ?? '') : null;
  $extendedDateLabel = ($isExtended && $competition->extended_registration_close_at)
    ? 'Extended to ' . $competition->extended_registration_close_at->translatedFormat('l, d F Y')
    : null;

  // Schedule Info Bar Configuration (consistent across all competition statuses)
  if ($isExtended && $competition->extended_registration_close_at) {
    $scheduleBarClass = 'bg-amber-500/10 border-amber-400/25 text-amber-300';
    $scheduleIconClass = 'text-amber-400';
    $scheduleText = 'Extended to ' . $competition->extended_registration_close_at->translatedFormat('l, d F Y');
  } elseif ($isOpen || $status === 'registration_open') {
    $scheduleBarClass = 'bg-emerald-500/10 border-emerald-400/20 text-emerald-300';
    $scheduleIconClass = 'text-emerald-400';
    $scheduleText = $competition->registration_close_at 
      ? 'Closes on ' . $competition->registration_close_at->translatedFormat('l, d F Y')
      : 'Open for registration';
  } elseif ($status === 'completed' || $status === 'results_published') {
    $scheduleBarClass = 'bg-white/[0.03] border-white/10 text-slate-400';
    $scheduleIconClass = 'text-slate-400';
    $scheduleText = $competition->competition_end_at 
      ? 'Ended on ' . $competition->competition_end_at->translatedFormat('l, d F Y')
      : 'Ended on ' . ($competition->effective_registration_close_at?->translatedFormat('l, d F Y') ?? 'concluded');
  } elseif ($status === 'upcoming') {
    $scheduleBarClass = 'bg-cyan-500/10 border-cyan-400/20 text-cyan-300';
    $scheduleIconClass = 'text-cyan-400';
    $scheduleText = $competition->registration_open_at
      ? 'Opens on ' . $competition->registration_open_at->translatedFormat('l, d F Y')
      : 'Opening soon';
  } else {
    // Registration Closed / Ongoing / default
    $scheduleBarClass = 'bg-slate-800/60 border-white/10 text-slate-400';
    $scheduleIconClass = 'text-slate-400';
    $closedDate = $competition->effective_registration_close_at ?? $competition->registration_close_at;
    $scheduleText = $closedDate 
      ? 'Registration closed on ' . $closedDate->translatedFormat('d F Y')
      : 'Registration closed';
  }

  // Disabled button text: avoid repeating 'Competition Ended' when badge already says 'Competition Ended'
  $disabledButtonLabel = match($status) {
    'completed', 'results_published' => 'Registration Closed',
    'upcoming' => 'Upcoming',
    default => ($statusLabel === 'Competition Ended' ? 'Registration Closed' : $statusLabel),
  };

  $payload = [
    'name' => $competition->name ?? 'Competition',
    'slug' => $competition->slug ?? '',
    'description' => $competition->description ?? '',
    'team' => $teamLabel,
    'fee' => $feeFormatted,
    'badge' => $typeBadge,
    'status' => $statusLabel,
    'isExtended' => $isExtended,
    'extendedDateLabel' => $extendedDateLabel,
    'statusBadgeClass' => $statusBadgeClass,
    'location' => $competition->location ?? '',
    'submission' => $submissionLabel,
    'timeline' => $timeline,
    'isOpen' => $isOpen,
    'registerUrl' => $registerUrl,
  ];

  // Symmetrical dynamic grid column spans
  $colSpanClass = 'lg:col-span-2';
  if ($compCount === 1) {
    $colSpanClass = 'lg:col-span-6 max-w-xl mx-auto';
  } elseif ($compCount === 2) {
    $colSpanClass = 'lg:col-span-3';
  } elseif ($compCount === 4) {
    $colSpanClass = 'lg:col-span-3';
  } elseif ($compCount === 5) {
    $colSpanClass = ($index < 3) ? 'lg:col-span-2' : 'lg:col-span-3';
  } else {
    $colSpanClass = 'lg:col-span-2';
  }
@endphp

<div 
  class="{{ $colSpanClass }} comp-card-item spotlight-card relative rounded-2xl p-6 sm:p-7 flex flex-col justify-between group overflow-hidden transition-all duration-300 hover:-translate-y-1.5 cursor-pointer bg-[#070F2B]/75 hover:bg-[#0A1438]/90 border border-blue-500/20 hover:border-cyan-400/50 backdrop-blur-xl shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:shadow-[0_20px_40px_-15px_rgba(37,99,235,0.35)]"
  onclick="openExpandableCard(this)"
  data-comp="{{ json_encode($payload) }}"
>
  <!-- Top Card Accent Line -->
  <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent group-hover:via-cyan-300 transition-all"></div>
  
  <div>
    <!-- Card Header: Icon + Status & Type Badges -->
    <div class="flex items-center justify-between gap-3 mb-5">
      <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/15 to-cyan-500/10 border border-cyan-400/25 flex items-center justify-center text-cyan-300 group-hover:scale-105 group-hover:border-cyan-300/50 group-hover:shadow-[0_0_20px_rgba(56,189,248,0.25)] transition-all shrink-0">
        {!! $getCompIconSvg($competition->name ?? '', $competition->slug ?? '') !!}
      </div>
      <div class="flex items-center gap-2 min-w-0">
        <span class="px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wide border whitespace-nowrap {{ $statusBadgeClass }}">
          {{ $statusLabel }}
        </span>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase bg-blue-950/60 text-cyan-300 border border-cyan-500/25 whitespace-nowrap shrink-0">
          <svg class="w-3 h-3 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span>{{ $typeBadge }}</span>
        </span>
      </div>
    </div>

    <!-- Title & Real Description from Database -->
    <div class="min-h-[3.5rem] sm:min-h-[3.75rem] flex items-start">
      <h3 class="font-['Space_Grotesk'] font-bold text-xl sm:text-2xl text-white group-hover:text-cyan-300 transition-colors tracking-tight leading-snug">
        {{ $competition->name ?? 'Competition' }}
      </h3>
    </div>

    <!-- Description container with consistent min-height & clean 3-line clamp -->
    <div class="mt-2.5 mb-3 min-h-[4.5rem]">
      @if(!empty($competition->description))
        <p 
          class="text-xs sm:text-sm text-slate-400"
          style="padding: 0 !important; margin: 0 !important; line-height: 1.5rem; max-height: 4.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"
        >
          {{ $competition->description }}
        </p>
      @endif
    </div>
  </div>

  <!-- Card Footer: Stats & Expandable Action Buttons -->
  <div class="pt-4 border-t border-white/[0.08]">
    <!-- Consistent Schedule Info Bar for All Statuses -->
    <div class="flex items-center gap-2 px-3.5 py-2 mb-3 rounded-xl border text-xs font-medium {{ $scheduleBarClass }}">
      <svg class="w-4 h-4 shrink-0 {{ $scheduleIconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <span class="truncate">{{ $scheduleText }}</span>
    </div>

    <div class="grid grid-cols-2 gap-2.5 mb-4">
      <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
        <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Team Format</span>
        <span class="text-xs sm:text-sm font-semibold text-slate-200 mt-0.5 truncate">
          {{ $teamLabel }}
        </span>
      </div>
      <div class="rounded-xl bg-white/[0.03] border border-white/[0.06] p-2.5 sm:p-3 flex flex-col justify-center">
        <span class="font-['JetBrains_Mono'] text-[10px] uppercase tracking-wider text-slate-400 font-medium">Fee</span>
        <span class="text-xs sm:text-sm font-bold text-[#FACC15] font-['Space_Grotesk'] mt-0.5 truncate">
          {{ $feeFormatted }}
        </span>
      </div>
    </div>

    <!-- Dual Action: View Details (Expands) & Direct Register -->
    <div class="flex items-center gap-2">
      <button 
        type="button" 
        onclick="openExpandableCard(this.closest('.comp-card-item'))"
        class="flex-1 py-2.5 px-3 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 hover:text-white border border-white/10 font-['Space_Grotesk'] font-semibold text-xs transition-colors text-center cursor-pointer"
      >
        View Details
      </button>
      @if($isOpen)
        <a 
          href="{{ route('competition.register', $competition->slug ?? '') }}" 
          onclick="event.stopPropagation()"
          class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-['Space_Grotesk'] font-bold text-xs text-center shadow-[0_4px_16px_rgba(37,99,235,0.3)] hover:shadow-[0_6px_22px_rgba(56,189,248,0.4)] transition-all duration-200 active:scale-[0.98] group/btn"
        >
          <span>Register</span>
          <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </a>
      @else
        <button 
          type="button" 
          disabled 
          onclick="event.stopPropagation()"
          class="flex-1 py-2.5 px-3 rounded-xl bg-white/[0.04] text-slate-400 border border-white/10 font-['Space_Grotesk'] font-medium text-xs text-center cursor-not-allowed opacity-75"
        >
          {{ $disabledButtonLabel }}
        </button>
      @endif
    </div>
  </div>
</div>
