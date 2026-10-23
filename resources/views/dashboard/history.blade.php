@props(['registrationHistory' => []])

<!-- REGISTRATION HISTORY -->
@if(count($registrationHistory) > 0)
<div class="dash-card" style="margin-top: 2rem;">
  <h3 style="color: var(--text-primary); font-family: var(--font-display); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fi fi-rr-time-past"></i> Registration History
  </h3>
  <div class="history-list">
    @foreach($registrationHistory as $index => $historyReg)
    <div class="history-item" style="border: 1px solid var(--border-subtle); background: rgba(0,0,0,0.2); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.5rem;">
        <strong style="color: var(--text-primary);">Attempt #{{ count($registrationHistory) - $index }} - {{ $historyReg->competition->name }}</strong>
        <span class="dash-status-badge badge-{{ $historyReg->status }}" style="font-size: 0.75rem; padding: 0.2rem 0.5rem;">
          {{ strtoupper(str_replace('_', ' ', $historyReg->status)) }}
        </span>
      </div>
      <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
        <strong>Submitted:</strong> {{ $historyReg->created_at->format('M j, Y H:i') }}
      </div>
      @if($historyReg->verification_notes)
      <div style="font-size: 0.85rem; color: var(--text-secondary); background: rgba(255,255,255,0.02); padding: 0.5rem; border-radius: 4px; border-left: 2px solid #ff4d4d;">
        <strong>Moderator Note:</strong><br>
        {{ $historyReg->verification_notes }}
      </div>
      @endif
    </div>
    @endforeach
  </div>
</div>
@endif
