<!-- HEADER & ALERTS -->
<header class="dash-header">
  <div class="dash-greeting">
    <h1>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h1>
  </div>
</header>

@if(session('success'))
  <div class="status-alert alert-approved" style="margin-bottom: 1.5rem;">
    <strong>SUCCESS</strong>
    <p>{{ session('success') }}</p>
  </div>
@endif

@if(session('error'))
  <div class="status-alert alert-rejected" style="margin-bottom: 1.5rem;">
    <strong>ERROR</strong>
    <p>{{ session('error') }}</p>
  </div>
@endif
