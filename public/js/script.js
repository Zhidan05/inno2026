/* =====================================================
   InnoElectrica 26 — script.js
   ===================================================== */

/* =====================================================
   1. NAVBAR — scroll class + hamburger
   ===================================================== */
(function initNavbar() {
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('navLinks');

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  });

  hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('open');
  });

  // Close menu on link click
  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => navLinks.classList.remove('open'));
  });
})();


/* =====================================================
   2. PARTICLE CANVAS — hero background
   ===================================================== */
(function initParticles() {
  const canvas = document.getElementById('particleCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  let W, H, particles = [];
  const COUNT = 80;

  function resize() {
    W = canvas.width = canvas.offsetWidth;
    H = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const colors = ['rgba(48,58,228,', 'rgba(63,128,239,', 'rgba(255,194,9,'];

  class Particle {
    constructor() { this.reset(true); }
    reset(initial) {
      this.x = Math.random() * W;
      this.y = initial ? Math.random() * H : H + 10;
      this.r = Math.random() * 2 + 0.5;
      this.vx = (Math.random() - 0.5) * 0.4;
      this.vy = -(Math.random() * 0.6 + 0.15);
      this.alpha = Math.random() * 0.6 + 0.2;
      this.color = colors[Math.floor(Math.random() * colors.length)];
      this.life = 0;
      this.maxLife = Math.random() * 300 + 200;
    }
    update() {
      this.x += this.vx;
      this.y += this.vy;
      this.life++;
      if (this.life > this.maxLife || this.y < -10) this.reset(false);
    }
    draw() {
      const t = this.life / this.maxLife;
      const a = this.alpha * (t < 0.1 ? t / 0.1 : t > 0.85 ? (1 - t) / 0.15 : 1);
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
      ctx.fillStyle = this.color + a + ')';
      ctx.fill();
    }
  }

  for (let i = 0; i < COUNT; i++) particles.push(new Particle());

  // Connection lines between nearby particles
  function drawConnections() {
    const maxDist = 110;
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const d = Math.sqrt(dx * dx + dy * dy);
        if (d < maxDist) {
          const a = (1 - d / maxDist) * 0.12;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = `rgba(63,128,239,${a})`;
          ctx.lineWidth = 0.7;
          ctx.stroke();
        }
      }
    }
  }

  function loop() {
    ctx.clearRect(0, 0, W, H);
    drawConnections();
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(loop);
  }
  loop();
})();


/* =====================================================
   3. COUNTDOWN TIMER
   ===================================================== */
(function initCountdown() {
  // Event date: August 15, 2026
  const EVENT_DATE = new Date('2026-08-15T08:00:00');

  const dEl = document.getElementById('cd-days');
  const hEl = document.getElementById('cd-hours');
  const mEl = document.getElementById('cd-mins');
  const sEl = document.getElementById('cd-secs');

  function pad(n) { return String(n).padStart(2, '0'); }

  function tick() {
    const now = new Date();
    const diff = EVENT_DATE - now;

    if (diff <= 0) {
      dEl.textContent = hEl.textContent = mEl.textContent = sEl.textContent = '00';
      return;
    }

    const days = Math.floor(diff / 86400000);
    const hours = Math.floor((diff % 86400000) / 3600000);
    const mins = Math.floor((diff % 3600000) / 60000);
    const secs = Math.floor((diff % 60000) / 1000);

    dEl.textContent = pad(days);
    hEl.textContent = pad(hours);
    mEl.textContent = pad(mins);
    sEl.textContent = pad(secs);
  }

  tick();
  setInterval(tick, 1000);
})();


/* =====================================================
   4. GALLERY CAROUSEL — infinite auto-scroll
   ===================================================== */
(function initCarousel() {
  const track = document.getElementById('carouselTrack');
  if (!track) return;

  // Duplicate cards for seamless loop
  const origCards = Array.from(track.children);
  origCards.forEach(card => {
    const clone = card.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.appendChild(clone);
  });

  let pos = 0;
  const spd = 0.6; // px per frame
  let paused = false;

  function getSetWidth() {
    // Width of one full set of original cards
    const card = track.querySelector('.gallery-card');
    const gap = 24; // 1.5rem gap
    const count = origCards.length;
    return (card.offsetWidth + gap) * count;
  }

  function loop() {
    if (!paused) {
      pos += spd;
      const setW = getSetWidth();
      if (pos >= setW) pos -= setW;
      track.style.transform = `translateX(${-pos}px)`;
    }
    requestAnimationFrame(loop);
  }

  // Pause on hover
  track.addEventListener('mouseenter', () => { paused = true; });
  track.addEventListener('mouseleave', () => { paused = false; });

  // Touch support
  let touchStartX = 0;
  track.addEventListener('touchstart', e => {
    touchStartX = e.touches[0].clientX;
    paused = true;
  }, { passive: true });
  track.addEventListener('touchend', e => {
    const dx = e.changedTouches[0].clientX - touchStartX;
    pos -= dx;
    paused = false;
  }, { passive: true });

  requestAnimationFrame(loop);
})();


/* =====================================================
   5. SCROLL REVEAL — fade-up on scroll
   ===================================================== */
(function initReveal() {
  // Add reveal class to target elements
  const selectors = [
    '.comp-card',
    '.glass-card',
    '.gallery-card',
    '.section-header',
  ];

  selectors.forEach(sel => {
    document.querySelectorAll(sel).forEach(el => {
      el.classList.add('reveal');
    });
  });

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();


/* =====================================================
   6. SMOOTH SCROLL for nav links
   ===================================================== */
(function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      const offset = 70; // navbar height
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });
})();


/* =====================================================
   7. ACTIVE NAV LINK highlight on scroll
   ===================================================== */
(function initActiveNav() {
  const sections = document.querySelectorAll('section[id]');
  const links = document.querySelectorAll('.nav-link:not(.nav-login)');

  function onScroll() {
    const scrollY = window.scrollY + 100;
    let current = '';
    sections.forEach(sec => {
      if (scrollY >= sec.offsetTop) current = sec.id;
    });
    links.forEach(link => {
      const href = link.getAttribute('href').replace('#', '');
      link.style.color = href === current ? 'var(--gold)' : '';
    });
  }

  window.addEventListener('scroll', onScroll, { passive: true });
})();