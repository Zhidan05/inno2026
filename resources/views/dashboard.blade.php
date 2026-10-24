<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - InnoElectrica 26</title>
  
  @include('dashboard.head-assets')
  @include('dashboard.styles')
</head>

<body class="bg-[#050816] text-slate-100 min-h-screen">

  @include('partials.navbar')

  <main class="dashboard-main">
    <div class="dash-container">
      @include('dashboard.header')

      @if($latestRegistrations->count() > 0)
        @foreach($latestRegistrations as $registration)
          @include('dashboard.registration-card', ['registration' => $registration])
        @endforeach
      @else
        @include('dashboard.empty-state')
      @endif

      @include('dashboard.history', ['registrationHistory' => $registrationHistory])
      @include('dashboard.available-competitions', [
        'availableCompetitions' => $availableCompetitions,
        'latestRegistrations' => $latestRegistrations
      ])
      @include('dashboard.announcements', ['announcements' => $announcements])
    </div>
  </main>

  @include('dashboard.scripts')

</body>

</html>
