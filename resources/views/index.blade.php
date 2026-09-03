<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnoElectrica 26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap"
    rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
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
        <li><a href="#competitions" class="nav-link">Competitions</a></li>
        <li><a href="#gallery" class="nav-link">Gallery</a></li>
        <li><a href="#about" class="nav-link">Contact</a></li>
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

  <!-- HERO -->
  <section class="hero" id="home">
    <canvas id="particleCanvas"></canvas>
    <div class="hero-grid-overlay"></div>
    <div class="electric-lines">
      <svg class="elec-svg" viewBox="0 0 1440 900" preserveAspectRatio="none">
        <path class="eline e1" d="M-50 200 Q200 100 400 300 Q600 500 900 200 Q1100 0 1490 250" />
        <path class="eline e2" d="M-50 600 Q300 400 600 600 Q900 800 1200 500 Q1350 350 1490 550" />
        <path class="eline e3" d="M200 -10 Q400 300 300 500 Q200 700 450 900" />
        <path class="eline e4" d="M1100 -10 Q900 200 1050 450 Q1200 700 950 910" />
      </svg>
    </div>
    <div class="hero-orbs">
      <div class="orb orb1"></div>
      <div class="orb orb2"></div>
      <div class="orb orb3"></div>
    </div>
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-dot"></span>
        Engineering Excellence · 2026
      </div>
      <h1 class="hero-title">
        <span class="title-line1">InnoElectrica</span><span class="title-line2">EXPO</span>
        <span class="title-year">2026</span>
      </h1>
      <p class="hero-tagline">Where Innovation Ignites &amp; the Future is Engineered</p>
      <p class="hero-sub">Push the limits of smart systems, electrical innovation, and engineering excellence. The
        premier university technology competition of 2026.</p>
      <div class="hero-cta">
        <a href="#competitions" class="btn-primary">Explore Competitions</a>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-ghost">Go to Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="btn-ghost">Register Now</a>
        @endauth
      </div>
      <div class="countdown-wrapper">
        <div class="countdown-label">Event Countdown</div>
        <div class="countdown" id="countdown">
          <div class="count-block"><span id="cd-days">00</span><small>Days</small></div>
          <div class="count-sep">:</div>
          <div class="count-block"><span id="cd-hours">00</span><small>Hours</small></div>
          <div class="count-sep">:</div>
          <div class="count-block"><span id="cd-mins">00</span><small>Mins</small></div>
          <div class="count-sep">:</div>
          <div class="count-block"><span id="cd-secs">00</span><small>Secs</small></div>
        </div>
      </div>
    </div>
    <div class="scroll-indicator">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- COMPETITIONS -->
  <section class="competitions" id="competitions">
    <div class="section-header">
      <span class="section-tag">// EVENTS</span>
      <h2 class="section-title">Competitions</h2>
      <p class="section-sub">Five arenas of innovation. One ultimate challenge.</p>
    </div>

    <div class="timeline-container">
      <svg class="timeline-path-svg" id="timelineSvg" viewBox="0 0 200 1200" preserveAspectRatio="none">
        <path id="timelinePathDef"
          d="M100 0 L100 1200"
          fill="none" stroke="url(#pathGrad)" stroke-width="3" />
        <defs>
          <linearGradient id="pathGrad" x1="0" y1="0" x2="0" y2="1" gradientUnits="objectBoundingBox">
            <stop offset="0%" stop-color="#303AE4" />
            <stop offset="100%" stop-color="#FFC209" />
          </linearGradient>
        </defs>

      </svg>

      @forelse($competitions ?? [] as $index => $competition)
      <div class="comp-card-wrap" data-side="{{ $index % 2 == 0 ? 'left' : 'right' }}">
        <div class="comp-card">
          <div class="card-icon"><i class="{{ $competition['icon'] ?? 'fi fi-rr-star' }}"></i></div>
          <div class="card-body">
            <h3>{{ $competition['name'] ?? 'Competition' }}</h3>
            <p>{{ $competition['description'] ?? '' }}</p>
            <a href="{{ route('competition.register', $competition->slug ?? '') }}" class="btn-card">Register Now →</a>
          </div>
        </div>
      </div>
      @empty
      <div class="no-data-message" style="text-align: center; width: 100%; padding: 40px; color: rgba(255, 255, 255, 0.7); position: relative; z-index: 2;">
          <h3>No competitions announced yet.</h3>
          <p>Stay tuned! Competitions will be updated soon.</p>
      </div>
      @endforelse
    </div>
  </section>

  <!-- GALLERY -->
  <section class="gallery" id="gallery">
    <!-- Decorative elements -->
    <div class="gallery-deco-grid"></div>
    <div class="gallery-deco-glow"></div>
    <div class="gallery-deco-corner gallery-deco-corner--tl"></div>
    <div class="gallery-deco-corner gallery-deco-corner--br"></div>
    <div class="gallery-deco-arc"></div>

    <div class="section-header">
      <span class="section-tag">// MOMENTS</span>
      <h2 class="section-title">Gallery</h2>
      <p class="section-sub">Highlights from past InnoElectrica editions.</p>
    </div>
    <div class="carousel-outer">
      @if(empty($galleries) || count($galleries) === 0)
        <div class="no-data-message" style="text-align: center; width: 100%; padding: 40px; color: rgba(255, 255, 255, 0.7);">
          <h3>No gallery available.</h3>
          <p>Memories are being collected!</p>
        </div>
      @else
        <div class="carousel-track" id="carouselTrack">
          <!-- Cards duplicated in JS for infinite loop -->
          @foreach($galleries as $gallery)
          <div class="gallery-card" data-title="{{ $gallery['title'] ?? 'Gallery Image' }}">
            <div class="gallery-img" style="background-image: url('{{ \Illuminate\Support\Facades\Storage::url($gallery['image'] ?? '') }}'); background-size: cover; background-position: center;"></div>
            <div class="gallery-overlay"><span>{{ $gallery['title'] ?? '' }}</span></div>
          </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  <!-- ABOUT / CONTACT -->
  <section class="about" id="about">
    <div class="about-bg-glow"></div>
    <!-- Decorative elements -->
    <div class="about-deco-grid"></div>
    <div class="about-deco-corner about-deco-corner--tl"></div>
    <div class="about-deco-corner about-deco-corner--br"></div>
    <div class="about-deco-arc about-deco-arc--left"></div>
    <div class="about-deco-arc about-deco-arc--right"></div>
    <div class="section-header">
      <span class="section-tag">// INFORMATION</span>
      <h2 class="section-title">About & Contact</h2>
      <p class="section-sub">Everything you need to know about InnoElectrica 26.</p>
    </div>

    <div class="about-grid">

      <!-- Sponsors -->
      <div class="about-card glass-card span2">
        <div class="about-card-icon"><i class="fi fi-rr-handshake"></i></div>
        <h3>Sponsors</h3>
        @if(empty($sponsors) || count($sponsors) === 0)
            <p style="color: rgba(255,255,255,0.7); margin-top: 15px;">No sponsors yet. Be the first to support us!</p>
        @else
            <div class="logo-grid sponsor-grid">
              @foreach($sponsors as $sponsor)
              <div class="logo-item sponsor {{ !empty($sponsor['is_gold']) ? 'gold-sponsor' : '' }}">
                  @if(!empty($sponsor['logo']))
                      <img src="{{ \Illuminate\Support\Facades\Storage::url($sponsor['logo']) }}" alt="{{ $sponsor['name'] ?? 'Sponsor' }}" style="max-width: 100%; max-height: 100%;">
                  @else
                      {{ $sponsor['name'] ?? 'Open' }}
                  @endif
              </div>
              @endforeach
            </div>
        @endif
      </div>

      <!-- Media Partners -->
      <div class="about-card glass-card span">
        <div class="about-card-icon"><i class="fi fi-rr-newspaper"></i></div>
        <h3>Media Partners</h3>
        @if(empty($mediaPartners) || count($mediaPartners) === 0)
            <p style="color: rgba(255,255,255,0.7); margin-top: 15px;">No media partners yet.</p>
        @else
            <div class="logo-grid">
              @foreach($mediaPartners as $partner)
              <div class="logo-item">
                  @if(!empty($partner['logo']))
                      <img src="{{ \Illuminate\Support\Facades\Storage::url($partner['logo']) }}" alt="{{ $partner['name'] ?? 'Media Partner' }}" style="max-width: 100%; max-height: 100%;">
                  @else
                      {{ $partner['name'] ?? 'Open' }}
                  @endif
              </div>
              @endforeach
            </div>
        @endif
      </div>

      <!-- Contact -->
      <div class="about-card glass-card">
        <div class="about-card-icon"><i class="fi fi-rr-satellite-dish"></i></div>
        <h3>Contact Us</h3>
            <ul class="contact-list">
              <li>
                <span class="ci-icon"><i class="fi fi-rr-envelope"></i></span>
                <div>
                  <small>Email</small>
                  <a href="mailto:innoelectrica@unri.ac.id">innoelectrica@unri.ac.id</a>
                </div>
              </li>
              <li>
                <span class="ci-icon"><i class="fi fi-rr-camera"></i></span>
                <div>
                  <small>Instagram</small>
                  <a href="https://instagram.com/ieee_unri">@ieee_unri</a>
                </div>
              </li>
              <li>
                <span class="ci-icon"><i class="fi fi-rr-phone-call"></i></span>
                <div>
                  <small>Phone (WhatsApp)</small>
                  <a href="tel:+628123456789">+62 812-3456-7890</a>
                </div>
              </li>
            </ul>
      </div>

      <!-- Organizer -->
      <div class="about-card glass-card">
        <div class="about-card-icon"><i class="fi fi-rr-bank"></i></div>
        <h3>Organizer</h3>
            <p class="organizer-name">IEEE Student Branch Universitas Riau</p>
            <p class="organizer-faculty">Faculty of Engineering, Universitas Riau</p>
            <div class="organizer-badge">Official Branch</div>
      </div>

      <!-- Location -->
      <div class="about-card glass-card">
        <div class="about-card-icon"><i class="fi fi-rr-map-marker"></i></div>
        <h3>Location</h3>
            <p class="location-name">Fakultas Teknik Universitas Riau</p>
            <p class="location-detail">Kampus Bina Widya, Pekanbaru<br>Riau, Indonesia 28293</p>
            <div class="location-date">
              <span class="ld-label">Event Format</span>
              <span class="ld-value">Hybrid (Online & Offline)</span>
            </div>
      </div>


    </div>
  </section>

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
        <a href="#about">Contact</a>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>