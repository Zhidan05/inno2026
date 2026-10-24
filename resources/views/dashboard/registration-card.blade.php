@props(['registration'])

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
