<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terms and Conditions - InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap"
    rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
    /* Adjust spacing for standalone pages */
    body { padding-top: 80px; }
    .page-content { max-width: 1000px; margin: 0 auto; padding: 4rem 2rem; color: rgba(255,255,255,0.8); }
    .page-content h1 { font-family: 'Orbitron', sans-serif; font-size: 2.5rem; margin-bottom: 1rem; color: #fff; }
    .page-content h2 { font-size: 1.5rem; margin-top: 2.5rem; margin-bottom: 1rem; color: #FFC209; }
    .page-content p { margin-bottom: 1.5rem; line-height: 1.6; font-family: 'Exo 2', sans-serif; }
    .page-content ul { margin-bottom: 1.5rem; padding-left: 1.5rem; font-family: 'Exo 2', sans-serif; }
    .page-content li { margin-bottom: 0.5rem; }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar" id="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" style="height: 40px; width: auto; border-radius: 50%; margin-right: 8px;">
        <span class="logo-text">IEE</span>
        <span class="logo-year">2026</span>
      </div>
      <ul class="nav-links" id="navLinks">
        <li><a href="{{ url('/') }}#competitions" class="nav-link">Competitions</a></li>
        <li><a href="{{ url('/') }}#gallery" class="nav-link">Gallery</a></li>
        <li><a href="{{ url('/') }}#about" class="nav-link">Contact</a></li>
        @auth
            <li><a href="{{ route('dashboard') }}" class="nav-link nav-login">Dashboard</a></li>
        @else
            @if (Route::has('login'))
                <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="nav-link nav-login">Register</a></li>
                @endif
            @endif
        @endauth
      </ul>
      <div class="nav-hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>
    </div>
  </nav>

  <!-- CONTENT -->
  <main class="page-content">
      <h1>Terms and Conditions</h1>
      <p>Last updated: {{ date('F Y') }}</p>
      
      <h2>1. Introduction</h2>
      <p>Welcome to InnoElectrica Expo 2026. By registering for our competitions or accessing our portal, you agree to be bound by these Terms and Conditions.</p>

      <h2>2. Competition Rules</h2>
      <ul style="list-style-type: disc;">
          <li>All participants must be officially registered and verified by our committee.</li>
          <li>Submissions must be original work created specifically for this event.</li>
          <li>The judge's decision is final and binding in all matters relating to the competitions.</li>
          <li>Any form of plagiarism or cheating will result in immediate disqualification.</li>
      </ul>

      <h2>3. User Accounts</h2>
      <p>You are responsible for maintaining the confidentiality of your account credentials. Any activity occurring under your account is your responsibility.</p>

      <h2>4. Intellectual Property</h2>
      <p>Participants retain ownership of their submissions. However, by participating, you grant InnoElectrica Expo the right to showcase your project in our gallery, social media, and promotional materials.</p>
      
      <h2>5. Changes to Terms</h2>
      <p>We reserve the right to modify these terms at any time. Participants will be notified of any significant changes.</p>
      
      <div style="margin-top: 3rem; text-align: center;">
          <a href="{{ url('/') }}" style="color: #FFC209; text-decoration: none; font-weight: bold;">&larr; Back to Home</a>
      </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-logo">
        <img src="{{ asset('images/Logo.png') }}" alt="InnoElectrica Logo" style="height: 30px; width: auto; border-radius: 50%; margin-right: 10px;">
        <span>InnoElectrica Expo <strong>26</strong></span>
      </div>
      <p class="footer-copy">
        &copy; InnoElectrica Expo 2026. All rights reserved. <br>
        Uicons by <a href="https://www.flaticon.com/uicons">Flaticon</a>
      </p>
      <div class="footer-links">
        <a href="{{ route('privacy') }}">Privacy</a>
        <a href="{{ route('terms') }}">Terms</a>
        <a href="{{ url('/') }}#about">Contact</a>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
