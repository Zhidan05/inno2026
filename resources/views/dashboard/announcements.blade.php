@props(['announcements' => []])

<!-- ANNOUNCEMENTS -->
<div class="dash-card announcements-card" style="margin-top: 1.5rem;">
  <h3 class="card-title"><i class="fi fi-rr-megaphone"></i> Latest Announcements</h3>
  @if(count($announcements) > 0)
    <ul class="announcement-list">
      @foreach($announcements as $announcement)
      <li>
        <div class="ann-header">
          <strong class="ann-title">{{ $announcement->title }}</strong>
          <span class="ann-date">{{ $announcement->published_at->format('M j, Y') }}</span>
        </div>
        <p class="ann-content">{{ $announcement->content }}</p>
      </li>
      @endforeach
    </ul>
  @else
    <p style="color: var(--text-tertiary); font-size: 0.9rem;">No new announcements at this time.</p>
  @endif
</div>
