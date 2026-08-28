<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - {{ $competition->name }} - InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
      .form-section {
          background: rgba(0,0,0,0.2);
          border: 1px solid var(--border-subtle);
          padding: 1.5rem;
          border-radius: 8px;
          margin-bottom: 1.5rem;
      }
      .form-section-title {
          font-family: var(--font-display);
          color: var(--accent-blue-light);
          margin-bottom: 1rem;
          font-size: 1.1rem;
          border-bottom: 1px solid rgba(255,255,255,0.05);
          padding-bottom: 0.5rem;
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
      .hidden {
          display: none !important;
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
      </ul>
    </div>
  </nav>

  <main class="dashboard-main">
    <div class="dash-container" style="max-width: 600px;">
      
      <header class="dash-header">
        <div class="dash-greeting">
            <h1>Register for {{ $competition->name }}</h1>
            <p style="color: var(--text-secondary); font-size: 0.9rem;">Fee: IDR {{ number_format($competition->registration_fee, 0, ',', '.') }}</p>
        </div>
      </header>

      @if($errors->any())
        <div class="status-alert alert-rejected">
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
          
          <div class="dash-card">
              
              <!-- REGISTRATION MODE -->
              <div class="form-section">
                  <h4 class="form-section-title">1. Participation Mode</h4>
                  <div class="radio-group">
                      @if($competition->registration_type === 'individual' || $competition->registration_type === 'individual_or_team')
                      <label class="radio-option">
                          <input type="radio" name="registration_mode" value="solo" {{ old('registration_mode') == 'solo' || $competition->registration_type == 'individual' ? 'checked' : '' }} onchange="toggleTeamSection()">
                          <span class="radio-label">Solo</span>
                      </label>
                      @endif

                      @if($competition->registration_type === 'team' || $competition->registration_type === 'individual_or_team')
                      <label class="radio-option">
                          <input type="radio" name="registration_mode" value="team" {{ old('registration_mode') == 'team' || $competition->registration_type == 'team' ? 'checked' : '' }} onchange="toggleTeamSection()">
                          <span class="radio-label">Team</span>
                      </label>
                      @endif
                  </div>
              </div>

              <!-- TEAM DETAILS (HIDDEN FOR SOLO) -->
              <div class="form-section hidden" id="teamSection">
                  <h4 class="form-section-title">2. Team Details</h4>
                  
                  <div class="form-group">
                      <label class="form-label" for="team_name">Team Name</label>
                      <input id="team_name" name="team_name" type="text" class="form-input" value="{{ old('team_name') }}">
                  </div>

                  <div style="margin-bottom: 1rem;">
                      <label class="form-label">Team Members (Max: {{ $competition->max_team_members }})</label>
                      <p style="font-size: 0.8rem; color: var(--text-tertiary); margin-bottom: 0.5rem;">
                          You ({{ Auth::user()->name }}) are automatically Member 1 (Team Leader).
                      </p>
                      
                      <div id="membersContainer">
                          <!-- Dynamic Members appended here -->
                      </div>
                      
                      <button type="button" class="add-member-btn" id="addMemberBtn" onclick="addMember()">+ Add Member</button>
                  </div>
              </div>

              <!-- PAYMENT PROOF -->
              <div class="form-section">
                  <h4 class="form-section-title">3. Payment Proof</h4>
                  <p style="font-size: 0.8rem; color: var(--text-tertiary); margin-bottom: 1rem;">
                      Please transfer IDR {{ number_format($competition->registration_fee, 0, ',', '.') }} to the committee's bank account before uploading the receipt.<br>
                      <strong>Bank XYZ - 123456789 (a.n InnoElectrica)</strong>
                  </p>
                  
                  <div class="form-group">
                      <label class="form-label" for="proof_of_payment">Upload Receipt (PDF/JPG/PNG, max 2MB)</label>
                      <input id="proof_of_payment" name="proof_of_payment" type="file" accept=".pdf,.jpg,.jpeg,.png" required style="color: var(--text-secondary); width: 100%;">
                  </div>
              </div>

              <button type="submit" class="btn-primary" style="width: 100%; border:none; cursor:pointer;">Submit Registration</button>
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
</body>
</html>
