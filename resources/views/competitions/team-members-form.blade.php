@props(['competition'])

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
