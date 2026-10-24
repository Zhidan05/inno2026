@props(['competition'])

<script>
  const maxMembers = {{ ($competition->max_team_members ?? 1) - 1 }}; // Exclude leader
  let memberCount = 0;

  function toggleTeamSection() {
    const checkedRadio = document.querySelector('input[name="registration_mode"]:checked');
    if (!checkedRadio) return;
    const mode = checkedRadio.value;
    const teamSection = document.getElementById('teamSection');
    if (!teamSection) return;
    if (mode === 'team') {
      teamSection.classList.remove('hidden');
    } else {
      teamSection.classList.add('hidden');
    }
  }

  function addMember() {
    if (memberCount >= maxMembers) return;
    
    const container = document.getElementById('membersContainer');
    if (!container) return;
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
    if (!btn) return;
    if (memberCount >= maxMembers) {
      btn.style.display = 'none';
    } else {
      btn.style.display = 'block';
    }
  }

  // Init on load
  document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('input[name="registration_mode"]:checked')) {
      toggleTeamSection();
    }
    checkMax();
  });
</script>
<script src="{{ asset('js/script.js') }}"></script>
