<!-- INTERACTION SCRIPTS: Spotlight, Countdown, Clipboard, Aceternity Expandable Card, Stars, SideRays -->
<script>
  // 1. Raycast / Linear Spotlight Cursor Tracker
  document.querySelectorAll('.spotlight-card').forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
    card.addEventListener('mouseleave', () => {
      card.style.setProperty('--mouse-x', `-999px`);
      card.style.setProperty('--mouse-y', `-999px`);
    });
  });

  // 2. Dynamic Countdown HUD Timer
  (function initCountdownTimer() {
    const targetStr = window.__COUNTDOWN_TARGET;
    if (!targetStr) return;

    const targetDate = new Date(targetStr).getTime();
    if (isNaN(targetDate)) return;

    const dEl = document.getElementById('cd-days');
    const hEl = document.getElementById('cd-hours');
    const mEl = document.getElementById('cd-mins');
    const sEl = document.getElementById('cd-secs');

    if (!dEl || !hEl || !mEl || !sEl) return;

    function pad(val) {
      return String(val).padStart(2, '0');
    }

    function updateClock() {
      const diff = targetDate - Date.now();
      if (diff <= 0) {
        dEl.textContent = '00';
        hEl.textContent = '00';
        mEl.textContent = '00';
        sEl.textContent = '00';
        return;
      }

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const secs = Math.floor((diff % (1000 * 60)) / 1000);

      dEl.textContent = pad(days);
      hEl.textContent = pad(hours);
      mEl.textContent = pad(mins);
      sEl.textContent = pad(secs);
    }

    updateClock();
    setInterval(updateClock, 1000);
  })();

  // 3. Copy to Clipboard with Visual Toast
  function copyToClipboard(text, btnElement) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(showToastAlert);
    } else {
      const textarea = document.createElement('textarea');
      textarea.value = text;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
      showToastAlert();
    }
  }

  function showToastAlert() {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    if (toast) {
      if (toastMsg) toastMsg.textContent = 'Copied to clipboard';
      toast.classList.remove('translate-y-12', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
      setTimeout(() => {
        toast.classList.add('translate-y-12', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
      }, 2400);
    }
  }

  // 4. Aceternity-Style Expandable Competition Card (Shared-Element Morphing Transition via FLIP)
  let activeExpandableCardEl = null;
  let isExpandableAnimating = false;

  function openExpandableCard(cardEl) {
    if (!cardEl || isExpandableAnimating) return;
    const dataStr = cardEl.getAttribute('data-comp');
    if (!dataStr) return;

    try {
      const data = JSON.parse(dataStr);
      activeExpandableCardEl = cardEl;

      // 1. Populate text and metadata into modal
      const titleEl = document.getElementById('exp-title');
      if (titleEl) titleEl.textContent = data.name || 'Competition';
      
      // Description
      const descEl = document.getElementById('exp-description');
      const descWrapper = document.getElementById('exp-desc-wrapper');
      if (descEl && descWrapper) {
        if (data.description && data.description.trim().length > 0) {
          descEl.textContent = data.description;
          descWrapper.classList.remove('hidden');
        } else {
          descWrapper.classList.add('hidden');
        }
      }

      // Badges & Status
      const badgeEl = document.getElementById('exp-badge');
      if (badgeEl) badgeEl.textContent = data.badge || '';
      const feeBadgeEl = document.getElementById('exp-fee-badge');
      if (feeBadgeEl) feeBadgeEl.textContent = data.fee || 'Free';
      
      const statusEl = document.getElementById('exp-status');
      if (statusEl) {
        statusEl.textContent = data.status || '';
        statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold border backdrop-blur-md whitespace-nowrap ' + (data.statusBadgeClass || 'bg-slate-500/15 text-slate-300 border-slate-500/30');
      }

      // Extended Info Banner
      const expExtBanner = document.getElementById('exp-extended-banner');
      if (expExtBanner) {
        if (data.isExtended && data.extendedDateLabel) {
          const extDateEl = document.getElementById('exp-extended-date');
          if (extDateEl) extDateEl.textContent = data.extendedDateLabel;
          expExtBanner.classList.remove('hidden');
        } else {
          expExtBanner.classList.add('hidden');
        }
      }

      // Formats & Fees
      const teamEl = document.getElementById('exp-team');
      if (teamEl) teamEl.textContent = data.team || '-';
      const feeEl = document.getElementById('exp-fee');
      if (feeEl) feeEl.textContent = data.fee || 'Free';

      // Location (Only if present in DB)
      const locWrapper = document.getElementById('exp-location-wrapper');
      if (locWrapper) {
        if (data.location && data.location.trim().length > 0) {
          const locEl = document.getElementById('exp-location');
          if (locEl) locEl.textContent = data.location;
          locWrapper.classList.remove('hidden');
        } else {
          locWrapper.classList.add('hidden');
        }
      }

      // Submission Type (Only if present in DB)
      const subWrapper = document.getElementById('exp-submission-wrapper');
      if (subWrapper) {
        if (data.submission && data.submission.trim().length > 0) {
          const subEl = document.getElementById('exp-submission');
          if (subEl) subEl.textContent = data.submission;
          subWrapper.classList.remove('hidden');
        } else {
          subWrapper.classList.add('hidden');
        }
      }

      // Render Real Timeline Dates from DB
      const timelineWrapper = document.getElementById('exp-timeline-wrapper');
      const timelineList = document.getElementById('exp-timeline-list');
      if (timelineList && timelineWrapper) {
        timelineList.innerHTML = '';
        if (data.timeline && data.timeline.length > 0) {
          data.timeline.forEach(item => {
            const div = document.createElement('div');
            if (item.is_extended && item.extended_date) {
              div.className = 'rounded-xl bg-amber-500/10 border border-amber-400/30 p-2.5 flex flex-col col-span-1 sm:col-span-2 shadow-[0_0_15px_rgba(245,158,11,0.12)]';
              div.innerHTML = `
                <div class="flex items-center justify-between gap-1 mb-0.5">
                  <span class="text-[11px] text-amber-300 font-semibold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    ${item.phase}
                  </span>
                  <span class="text-[9px] uppercase tracking-wider font-bold text-amber-300 bg-amber-400/20 border border-amber-400/30 px-1.5 py-0.5 rounded-full font-['JetBrains_Mono']">Extended</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-0.5">
                  <span class="text-xs line-through opacity-50 text-slate-400 font-['JetBrains_Mono']">${item.date}</span>
                  <span class="text-xs font-bold text-amber-300 font-['JetBrains_Mono']">${item.extended_date}</span>
                </div>
              `;
            } else {
              div.className = 'rounded-xl bg-white/[0.02] border border-white/[0.05] p-2.5 flex flex-col';
              div.innerHTML = `<span class="text-[11px] text-slate-400 font-medium">${item.phase}</span><span class="text-xs font-semibold text-slate-200 mt-0.5">${item.date}</span>`;
            }
            timelineList.appendChild(div);
          });
          timelineWrapper.classList.remove('hidden');
        } else {
          timelineWrapper.classList.add('hidden');
        }
      }

      // Register Action Button (Aceternity CTA)
      const regBtn = document.getElementById('exp-register-btn');
      if (regBtn) {
        if (data.isOpen && data.registerUrl) {
          regBtn.href = data.registerUrl;
          regBtn.innerHTML = '<span>Register Now</span><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
          regBtn.className = 'exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white shadow-[0_4px_16px_rgba(37,99,235,0.4)] transition-all shrink-0 cursor-pointer inline-flex items-center gap-1.5';
        } else {
          regBtn.removeAttribute('href');
          const disabledBtnText = (data.status === 'Competition Ended' || data.status === 'Results Announced') ? 'Registration Closed' : (data.status || 'Registration Closed');
          regBtn.innerHTML = `<span>${disabledBtnText}</span>`;
          regBtn.className = 'exp-fade-item px-4 py-2.5 text-xs sm:text-sm rounded-full font-bold bg-slate-800/80 text-slate-400 border border-white/5 transition-all shrink-0 cursor-not-allowed inline-flex items-center gap-1.5';
        }
      }

      // Copy icon from card into modal banner
      const sourceIcon = cardEl.querySelector('.w-12.h-12 svg');
      const iconContainer = document.getElementById('exp-icon-container');
      if (sourceIcon && iconContainer) {
        iconContainer.innerHTML = sourceIcon.outerHTML;
        const svg = iconContainer.querySelector('svg');
        if (svg) {
          svg.setAttribute('class', 'w-8 h-8 text-cyan-300');
        }
      }

      // 2. Prepare FLIP Animation
      const backdrop = document.getElementById('expandable-card-backdrop');
      const container = document.getElementById('expandable-card-container');
      const dialog = document.getElementById('expandable-card-dialog');
      if (!backdrop || !container || !dialog) return;

      const fadeItems = dialog.querySelectorAll('.exp-fade-item');

      // Hide inner reveal items initially
      fadeItems.forEach(el => {
        el.style.opacity = '0';
        el.style.pointerEvents = 'none';
        el.style.transition = 'none';
      });

      // Activate container & backdrop
      backdrop.classList.remove('opacity-0', 'pointer-events-none');
      backdrop.classList.add('pointer-events-auto');
      backdrop.style.opacity = '0';

      container.classList.remove('opacity-0', 'pointer-events-none');
      container.classList.add('pointer-events-auto');
      container.style.opacity = '1';

      // Measure origin bounding box (FIRST) and target bounding box (LAST)
      const originRect = cardEl.getBoundingClientRect();

      dialog.style.transition = 'none';
      dialog.style.transform = 'none';
      const targetRect = dialog.getBoundingClientRect();

      if (targetRect.width <= 0 || targetRect.height <= 0) {
        backdrop.style.opacity = '1';
        fadeItems.forEach(el => { el.style.opacity = '1'; el.style.pointerEvents = 'auto'; });
        document.body.style.overflow = 'hidden';
        return;
      }

      // INVERT: Calculate position & scale deltas to fit card exactly
      const deltaX = originRect.left - targetRect.left;
      const deltaY = originRect.top - targetRect.top;
      const scaleX = originRect.width / targetRect.width;
      const scaleY = originRect.height / targetRect.height;

      dialog.style.transformOrigin = '0 0';
      dialog.style.transform = `translate3d(${deltaX}px, ${deltaY}px, 0) scale(${scaleX}, ${scaleY})`;
      dialog.style.borderRadius = '16px';

      // Hide origin card in grid (it "becomes" the expanding dialog)
      cardEl.style.opacity = '0';
      document.body.style.overflow = 'hidden';
      isExpandableAnimating = true;

      // PLAY: Smoothly expand to target modal position with Framer Motion spring physics
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          dialog.style.transition = 'transform 420ms cubic-bezier(0.16, 1, 0.3, 1), border-radius 420ms cubic-bezier(0.16, 1, 0.3, 1)';
          dialog.style.transform = 'translate3d(0, 0, 0) scale(1, 1)';
          dialog.style.borderRadius = '24px';

          backdrop.style.transition = 'opacity 380ms cubic-bezier(0.16, 1, 0.3, 1)';
          backdrop.style.opacity = '1';

          // Reveal CTA button, close button, and inner body details with stagger
          setTimeout(() => {
            fadeItems.forEach(el => {
              el.style.transition = 'opacity 240ms ease';
              el.style.opacity = '1';
              el.style.pointerEvents = 'auto';
            });
            isExpandableAnimating = false;
          }, 140);
        });
      });

    } catch (err) {
      console.error('Error opening expandable card:', err);
      isExpandableAnimating = false;
    }
  }

  function closeExpandableCard() {
    if (!activeExpandableCardEl || isExpandableAnimating) return;
    isExpandableAnimating = true;

    const backdrop = document.getElementById('expandable-card-backdrop');
    const container = document.getElementById('expandable-card-container');
    const dialog = document.getElementById('expandable-card-dialog');
    if (!backdrop || !container || !dialog) {
      isExpandableAnimating = false;
      return;
    }

    const fadeItems = dialog.querySelectorAll('.exp-fade-item');

    // 1. Immediately fade out revealed items
    fadeItems.forEach(el => {
      el.style.transition = 'opacity 90ms ease';
      el.style.opacity = '0';
      el.style.pointerEvents = 'none';
    });

    // 2. Measure current positions and morph back into the source card
    const currentOriginRect = activeExpandableCardEl.getBoundingClientRect();
    const currentTargetRect = dialog.getBoundingClientRect();

    const deltaX = currentOriginRect.left - currentTargetRect.left;
    const deltaY = currentOriginRect.top - currentTargetRect.top;
    const scaleX = currentOriginRect.width / currentTargetRect.width;
    const scaleY = currentOriginRect.height / currentTargetRect.height;

    dialog.style.transition = 'transform 360ms cubic-bezier(0.16, 1, 0.3, 1), border-radius 360ms cubic-bezier(0.16, 1, 0.3, 1)';
    dialog.style.transform = `translate3d(${deltaX}px, ${deltaY}px, 0) scale(${scaleX}, ${scaleY})`;
    dialog.style.borderRadius = '16px';

    backdrop.style.transition = 'opacity 320ms cubic-bezier(0.16, 1, 0.3, 1)';
    backdrop.style.opacity = '0';

    // 3. Complete closing cleanup
    setTimeout(() => {
      if (activeExpandableCardEl) {
        activeExpandableCardEl.style.opacity = '1';
        activeExpandableCardEl = null;
      }

      container.classList.add('opacity-0', 'pointer-events-none');
      container.classList.remove('pointer-events-auto');
      container.style.opacity = '0';

      backdrop.classList.add('opacity-0', 'pointer-events-none');
      backdrop.classList.remove('pointer-events-auto');

      dialog.style.transform = 'none';
      dialog.style.transition = 'none';

      document.body.style.overflow = '';
      isExpandableAnimating = false;
    }, 360);
  }

  // ESC key listener to close expandable card
  window.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeExpandableCard();
    }
  });

  // 5. Aceternity Stars Background (Twinkling Starfield)
  (function initStarsBackground() {
    const canvas = document.getElementById('starsCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let w = canvas.width = canvas.offsetWidth;
    let h = canvas.height = canvas.offsetHeight;

    function resize() {
      w = canvas.width = canvas.offsetWidth;
      h = canvas.height = canvas.offsetHeight;
      generate();
    }
    window.addEventListener('resize', resize);

    let stars = [];
    function generate() {
      stars = [];
      const count = Math.floor(w * h * 0.00018);
      for (let i = 0; i < count; i++) {
        stars.push({
          x: Math.random() * w,
          y: Math.random() * h,
          r: Math.random() * 0.8 + 0.35,
          opacity: Math.random() * 0.5 + 0.3,
          twinkleSpeed: Math.random() > 0.3 ? Math.random() * 0.6 + 0.4 : null
        });
      }
    }
    generate();

    function render() {
      ctx.clearRect(0, 0, w, h);
      const now = Date.now() * 0.001;
      for (let i = 0; i < stars.length; i++) {
        const s = stars[i];
        let op = s.opacity;
        if (s.twinkleSpeed !== null) {
          op = 0.25 + Math.abs(Math.sin(now / s.twinkleSpeed)) * 0.75;
        }
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(248, 250, 252, ${op})`;
        ctx.fill();
      }
      requestAnimationFrame(render);
    }
    render();
  })();

  // 6. Aceternity Shooting Stars (Dynamic Gradient Streaks)
  (function initShootingStars() {
    const group = document.getElementById('shootingStarsGroup');
    if (!group) return;

    const minSpeed = 10;
    const maxSpeed = 26;
    const minDelay = 1400;
    const maxDelay = 3800;

    function getRandomStart() {
      const side = Math.floor(Math.random() * 4);
      const w = window.innerWidth;
      const h = window.innerHeight;
      const offset = Math.random() * w;
      switch (side) {
        case 0: return { x: offset, y: -20, angle: 45 };
        case 1: return { x: w + 20, y: Math.random() * h * 0.6, angle: 135 };
        case 2: return { x: offset, y: h + 20, angle: 225 };
        case 3: return { x: -20, y: Math.random() * h * 0.6, angle: 45 };
        default: return { x: offset, y: -20, angle: 45 };
      }
    }

    function spawnStar() {
      const start = getRandomStart();
      const speed = Math.random() * (maxSpeed - minSpeed) + minSpeed;
      const isGold = Math.random() > 0.75;
      const gradId = isGold ? 'url(#shootingStarGoldGradient)' : 'url(#shootingStarGradient)';
      const star = {
        x: start.x,
        y: start.y,
        angle: start.angle,
        speed: speed,
        scale: 1,
        distance: 0,
        element: document.createElementNS('http://www.w3.org/2000/svg', 'rect')
      };

      star.element.setAttribute('height', '1.6');
      star.element.setAttribute('fill', gradId);
      group.appendChild(star.element);

      function move() {
        star.x += star.speed * Math.cos(star.angle * Math.PI / 180);
        star.y += star.speed * Math.sin(star.angle * Math.PI / 180);
        star.distance += star.speed;
        star.scale = 1 + star.distance / 85;

        const width = 14 * star.scale;
        star.element.setAttribute('x', star.x);
        star.element.setAttribute('y', star.y);
        star.element.setAttribute('width', width);
        star.element.setAttribute('transform', `rotate(${star.angle}, ${star.x + width / 2}, ${star.y + 0.8})`);

        if (star.x < -60 || star.x > window.innerWidth + 60 || star.y < -60 || star.y > window.innerHeight + 60) {
          if (star.element.parentNode === group) {
            group.removeChild(star.element);
          }
        } else {
          requestAnimationFrame(move);
        }
      }
      requestAnimationFrame(move);

      const nextDelay = Math.random() * (maxDelay - minDelay) + minDelay;
      setTimeout(spawnStar, nextDelay);
    }

    spawnStar();
  })();

  // 7. React Bits - SideRays WebGL2 Shimmering Rays
  (function initSideRays() {
    const container = document.getElementById('sideRaysContainer');
    const canvas = document.getElementById('sideRaysCanvas');
    if (!container || !canvas) return;

    const gl = canvas.getContext('webgl2', {
      alpha: true,
      premultipliedAlpha: true,
      antialias: false,
      depth: false,
      stencil: false,
      powerPreference: 'high-performance'
    });
    if (!gl) return;

    const PIXEL_BUDGET = 2.4e6;
    const TAU = Math.PI * 2;

    const ORIGINS = {
      'top-right': { flipX: 0, flipY: 0, side: 0 },
      'top-left': { flipX: 1, flipY: 0, side: 0 },
      'bottom-right': { flipX: 0, flipY: 1, side: 0 },
      'bottom-left': { flipX: 1, flipY: 1, side: 0 },
      right: { flipX: 0, flipY: 0, side: 1 },
      left: { flipX: 1, flipY: 0, side: 1 }
    };

    const VERTEX = `#version 300 es
    const vec2 corners[3] = vec2[3](vec2(-1.0, -1.0), vec2(3.0, -1.0), vec2(-1.0, 3.0));
    void main() {
      gl_Position = vec4(corners[gl_VertexID], 0.0, 1.0);
    }`;

    const FRAGMENT = `#version 300 es
    precision highp float;
    uniform vec2 uResolution;
    uniform float uTime;
    uniform vec3 uColorA;
    uniform vec3 uColorB;
    uniform float uBlend;
    uniform float uIntensity;
    uniform float uSpread;
    uniform float uDensity;
    uniform float uSharpness;
    uniform float uFalloff;
    uniform float uGlow;
    uniform float uSaturation;
    uniform float uDust;
    uniform float uOpacity;
    uniform float uReveal;
    uniform float uLight;
    uniform vec3 uFrame;
    uniform float uAim;
    uniform vec3 uFocus;
    uniform float uSway;
    out vec4 fragColor;

    float hash(vec2 p) {
      p = fract(p * vec2(123.34, 456.21));
      p += dot(p, p + 45.32);
      return fract(p.x * p.y);
    }

    float noise(vec2 p) {
      vec2 i = floor(p);
      vec2 f = p - i;
      vec2 w = f * f * f * (f * (f * 6.0 - 15.0) + 10.0);
      float a = hash(i);
      float b = hash(i + vec2(1.0, 0.0));
      float c = hash(i + vec2(0.0, 1.0));
      float d = hash(i + vec2(1.0, 1.0));
      return mix(mix(a, b, w.x), mix(c, d, w.x), w.y);
    }

    float shafts(float u, float t, float seed, float aa) {
      float sway = (0.4 * sin(t * 0.31 + seed) + 0.24 * sin(t * 0.17 + seed * 2.3)) * uSway;
      float n = 0.7 * noise(vec2(u + sway + seed, t * 0.3)) + 0.3 * noise(vec2(u * 2.4 + sway * 1.5 + seed * 1.7, t * 0.45 + 3.0));
      float width = mix(0.5, 0.1, uSharpness);
      float s = mix(smoothstep(0.5 - width, 0.5 + width, n), 0.5, aa);
      return mix(0.05, 1.0, s);
    }

    float motes(vec2 p, float cell, float t, float seed) {
      p += vec2(t * 0.021, -t * 0.013) + seed * 7.31;
      vec2 grid = p / cell;
      vec2 id = floor(grid);
      vec2 f = grid - id;
      float h = hash(id + seed);
      if (h > 0.5) return 0.0;
      vec2 center = 0.25 + 0.5 * vec2(hash(id + 1.7 + seed), hash(id + 3.1 + seed));
      center += 0.1 * vec2(sin(t * 0.7 + h * 31.0), cos(t * 0.6 + h * 23.0));
      float size = mix(0.035, 0.09, hash(id + 5.3 + seed));
      float edge = length(fwidth(grid)) * 0.7;
      float twinkle = 0.55 + 0.45 * sin(t * 1.9 + h * 41.0);
      return (1.0 - smoothstep(size - edge, size + edge, length(f - center))) * twinkle;
    }

    void main() {
      float aspect = uResolution.x / uResolution.y;
      vec2 q = (gl_FragCoord.xy - 0.5 * uResolution) / uResolution.y;
      if (uFrame.x > 0.5) q.x = -q.x;
      if (uFrame.y > 0.5) q.y = -q.y;
      vec2 source = uFrame.z > 0.5 ? vec2(aspect * 0.5 + 0.42, 0.3) : vec2(aspect * 0.5 + 0.1, 0.62);
      float heading = (uFrame.z > 0.5 ? 3.42 : -2.48) + uAim + 0.035 * sin(uTime * 0.21) * uSway;
      vec2 v = q - source;
      float r = length(v);
      float angle = mod(atan(v.y, v.x) - heading + 3.14159265, 6.28318531) - 3.14159265;
      float t = uTime;
      float u = angle * uDensity;
      float aa = smoothstep(0.12, 0.45, fwidth(u));
      float offset = uSpread * 0.22;
      float fanA = exp(-pow((angle + offset) / uSpread, 2.0) * 1.4);
      float fanB = exp(-pow((angle - offset) / (uSpread * 1.15), 2.0) * 1.4);
      float focus = 1.0 + uFocus.z * exp(-pow((angle - uFocus.x) / uFocus.y, 2.0));
      float lightA = fanA * shafts(u, t, 0.0, aa) * focus;
      float lightB = fanB * shafts(u * 0.83, t * 0.6, 17.0, aa) * focus;
      float reach = 1.0 / (1.0 + pow(r / 0.4, uFalloff));
      vec3 glowColor = mix(uColorA, uColorB, uBlend);
      vec3 light = (uColorA * lightA * (1.0 - uBlend) + uColorB * lightB * uBlend) * 2.0 * reach;
      light += glowColor * uGlow * exp(-pow(r / 0.4, 2.0));
      if (uDust > 0.0) {
        float sparkle = motes(q, 0.06, t, 0.0) + 0.7 * motes(q, 0.038, t * 0.8, 9.0);
        light += mix(glowColor, vec3(1.0), 0.6) * sparkle * (lightA + lightB) * reach * uDust * 2.5;
      }
      light *= uIntensity * (1.0 - smoothstep(uReveal * 2.6 - 0.45, uReveal * 2.6, r)) * smoothstep(0.0, 0.35, uReveal);
      float gray = dot(light, vec3(0.2126, 0.7152, 0.0722));
      light = max(mix(vec3(gray), light, uSaturation), 0.0);
      float peak = max(light.r, max(light.g, light.b));
      float grain = (fract(52.9829189 * fract(dot(gl_FragCoord.xy, vec2(0.06711056, 0.00583715)))) - 0.5) / 255.0;
      if (uLight > 0.5) {
        vec3 ink = pow(light / max(peak, 1e-4), vec3(2.0)) * 0.75;
        float alpha = clamp(pow(1.0 - exp(-peak * 2.6), 2.5) * 0.9 * uOpacity + grain, 0.0, 1.0);
        fragColor = vec4(pow(ink, vec3(1.0 / 2.2)) * alpha, alpha);
        return;
      }
      float mapped = 1.0 - exp(-peak);
      vec3 tone = light * (mapped / max(peak, 1e-4));
      tone = mix(tone, vec3(mapped), smoothstep(0.7, 1.0, mapped) * 0.55);
      vec3 shown = clamp(tone * uOpacity, 0.0, 1.0);
      float alpha = max(shown.r, max(shown.g, shown.b));
      vec3 color = clamp(shown * alpha + grain, 0.0, 1.0);
      fragColor = vec4(min(color, vec3(alpha)), alpha);
    }
    `;

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
    const wrapAngle = angle => ((((angle + Math.PI) % TAU) + TAU) % TAU) - Math.PI;

    const parseColor = value => {
      const text = String(value || '').trim();
      const hex = /^#?([0-9a-f]{3}|[0-9a-f]{6})$/i.exec(text);
      if (hex) {
        const full = hex[1].length === 3 ? hex[1].replace(/./g, digit => digit + digit) : hex[1];
        return [0, 2, 4].map(index => parseInt(full.slice(index, index + 2), 16) / 255);
      }
      const rgb = /^rgba?\(\s*([\d.]+)[\s,]+([\d.]+)[\s,]+([\d.]+)/i.exec(text);
      if (rgb) return [rgb[1], rgb[2], rgb[3]].map(channel => clamp(parseFloat(channel) / 255, 0, 1));
      return [1, 1, 1];
    };

    const geometryFor = (frame, aspect) => ({
      source: frame.side ? [aspect * 0.5 + 0.42, 0.3] : [aspect * 0.5 + 0.1, 0.62],
      heading: frame.side ? 3.42 : -2.48
    });

    const compile = (glCtx, type, source) => {
      const shader = glCtx.createShader(type);
      if (!shader) return null;
      glCtx.shaderSource(shader, source);
      glCtx.compileShader(shader);
      if (!glCtx.getShaderParameter(shader, glCtx.COMPILE_STATUS)) {
        console.error(glCtx.getShaderInfoLog(shader));
        glCtx.deleteShader(shader);
        return null;
      }
      return shader;
    };

    const link = glCtx => {
      const vertex = compile(glCtx, glCtx.VERTEX_SHADER, VERTEX);
      const fragment = compile(glCtx, glCtx.FRAGMENT_SHADER, FRAGMENT);
      const program = vertex && fragment ? glCtx.createProgram() : null;
      if (!vertex || !fragment || !program) {
        if (vertex) glCtx.deleteShader(vertex);
        if (fragment) glCtx.deleteShader(fragment);
        return null;
      }
      glCtx.attachShader(program, vertex);
      glCtx.attachShader(program, fragment);
      glCtx.linkProgram(program);
      glCtx.deleteShader(vertex);
      glCtx.deleteShader(fragment);
      if (!glCtx.getProgramParameter(program, glCtx.LINK_STATUS)) {
        console.error(glCtx.getProgramInfoLog(program));
        glCtx.deleteProgram(program);
        return null;
      }
      const uniforms = {};
      const count = glCtx.getProgramParameter(program, glCtx.ACTIVE_UNIFORMS);
      for (let index = 0; index < count; index++) {
        const info = glCtx.getActiveUniform(program, index);
        if (info) uniforms[info.name] = glCtx.getUniformLocation(program, info.name);
      }
      return { program, uniforms };
    };

    const shader = link(gl);
    if (!shader) return;

    const props = {
      rayColor1: '#FFC46B',
      rayColor2: '#96c8ff',
      blend: 0.6,
      origin: 'top-right',
      speed: 2.5,
      intensity: 2,
      spread: 2,
      density: 5,
      sharpness: 0.5,
      tilt: 0,
      falloff: 1.6,
      glow: 1,
      saturation: 1,
      dust: 0,
      followMouse: true,
      mouseInfluence: 0.5,
      intro: true,
      lightMode: false,
      opacity: 1,
      maxRatio: 2
    };

    const settings = {
      colorA: parseColor(props.rayColor1),
      colorB: parseColor(props.rayColor2),
      blend: clamp(props.blend, 0, 1),
      frame: ORIGINS[props.origin] ?? ORIGINS['top-right'],
      speed: Math.max(0, props.speed) * 0.4,
      intensity: Math.max(0, props.intensity) * 0.75,
      spread: clamp(props.spread, 0.1, 8) * 0.225,
      density: clamp(props.density, 1, 40),
      sharpness: clamp(props.sharpness, 0, 1),
      tilt: (clamp(props.tilt, -180, 180) * Math.PI) / 180,
      falloff: clamp(props.falloff, 0.2, 6),
      glow: Math.max(0, props.glow) * 1.2,
      saturation: Math.max(0, props.saturation),
      dust: clamp(props.dust, 0, 1),
      followMouse: props.followMouse,
      mouseInfluence: clamp(props.mouseInfluence, 0, 1),
      intro: props.intro,
      light: props.lightMode,
      opacity: clamp(props.opacity, 0, 1),
      maxRatio: clamp(props.maxRatio, 0.5, 3)
    };

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const vao = gl.createVertexArray();
    const size = { width: 1, height: 1 };
    const pointer = { x: 0, y: 0, inside: false };
    const aim = { value: 0, velocity: 0 };
    const focus = { angle: 0, strength: 0 };
    let time = Math.random() * 100;
    let reveal = settings.intro && !reduced ? 0 : 1;
    let raf = 0;
    let last = 0;
    let visible = true;
    let pageVisible = document.visibilityState !== 'hidden';
    let lost = false;

    const resize = () => {
      const rect = container.getBoundingClientRect();
      const cssWidth = Math.max(1, rect.width);
      const cssHeight = Math.max(1, rect.height);
      const ratio = Math.min(
        window.devicePixelRatio || 1,
        settings.maxRatio,
        Math.sqrt(PIXEL_BUDGET / (cssWidth * cssHeight))
      );
      const width = Math.max(1, Math.round(cssWidth * ratio));
      const height = Math.max(1, Math.round(cssHeight * ratio));
      if (canvas.width !== width || canvas.height !== height) {
        canvas.width = width;
        canvas.height = height;
      }
      size.width = cssWidth;
      size.height = cssHeight;
    };

    const pointerAngle = s => {
      let x = (pointer.x - size.width / 2) / size.height;
      let y = (size.height / 2 - pointer.y) / size.height;
      if (s.frame.flipX) x = -x;
      if (s.frame.flipY) y = -y;
      const { source, heading } = geometryFor(s.frame, size.width / size.height);
      return wrapAngle(Math.atan2(y - source[1], x - source[0]) - heading - s.tilt);
    };

    const frame = now => {
      raf = 0;
      if (lost) return;
      const s = settings;
      const dt = clamp((now - last) / 1000 || 0, 0, 0.05);
      last = Math.max(last, now);
      time += dt * s.speed * (reduced ? 0.3 : 1);
      if (reveal < 1) reveal = Math.min(1, reveal + dt / 1.6);

      const tracking = s.followMouse && pointer.inside && !reduced;
      const pointed = tracking ? pointerAngle(s) : 0;
      const target = tracking ? clamp(pointed, -s.spread, s.spread) * s.mouseInfluence : 0;
      const focusTarget = tracking ? s.mouseInfluence : 0;
      const ease = 1 - Math.exp(-dt * 6);
      if (tracking) focus.angle += (clamp(pointed - aim.value, -s.spread * 1.5, s.spread * 1.5) - focus.angle) * ease;
      focus.strength += (focusTarget - focus.strength) * ease;
      const stiffness = 18;
      const damping = 2 * Math.sqrt(stiffness);
      aim.velocity += ((target - aim.value) * stiffness - aim.velocity * damping) * dt;
      aim.value += aim.velocity * dt;

      gl.viewport(0, 0, canvas.width, canvas.height);
      gl.useProgram(shader.program);
      gl.bindVertexArray(vao);
      const u = shader.uniforms;
      gl.uniform2f(u.uResolution, canvas.width, canvas.height);
      gl.uniform1f(u.uTime, time);
      gl.uniform3f(u.uColorA, s.colorA[0], s.colorA[1], s.colorA[2]);
      gl.uniform3f(u.uColorB, s.colorB[0], s.colorB[1], s.colorB[2]);
      gl.uniform1f(u.uBlend, s.blend);
      gl.uniform1f(u.uIntensity, s.intensity);
      gl.uniform1f(u.uSpread, s.spread);
      gl.uniform1f(u.uDensity, s.density);
      gl.uniform1f(u.uSharpness, s.sharpness);
      gl.uniform1f(u.uFalloff, s.falloff);
      gl.uniform1f(u.uGlow, s.glow);
      gl.uniform1f(u.uSaturation, s.saturation);
      gl.uniform1f(u.uDust, s.dust);
      gl.uniform1f(u.uOpacity, s.opacity);
      gl.uniform1f(u.uReveal, 1 - Math.pow(1 - reveal, 3));
      gl.uniform1f(u.uLight, s.light ? 1 : 0);
      gl.uniform3f(u.uFrame, s.frame.flipX, s.frame.flipY, s.frame.side);
      gl.uniform1f(u.uAim, s.tilt + aim.value);
      gl.uniform3f(u.uFocus, focus.angle, Math.max(0.06, s.spread * 0.25), focus.strength * 1.4);
      gl.uniform1f(u.uSway, reduced ? 0 : 1);
      gl.drawArrays(gl.TRIANGLES, 0, 3);

      const settling =
        Math.abs(target - aim.value) > 1e-4 ||
        Math.abs(aim.velocity) > 1e-4 ||
        Math.abs(focusTarget - focus.strength) > 1e-3;
      const busy = (s.speed > 0 && !reduced) || reveal < 1 || settling;
      if (busy && visible && pageVisible) raf = requestAnimationFrame(frame);
    };

    const wake = () => {
      if (raf || lost || !visible || !pageVisible) return;
      last = performance.now();
      raf = requestAnimationFrame(frame);
    };

    const onPointerMove = event => {
      const rect = container.getBoundingClientRect();
      pointer.x = event.clientX - rect.left;
      pointer.y = event.clientY - rect.top;
      pointer.inside =
        event.clientX >= rect.left &&
        event.clientX <= rect.right &&
        event.clientY >= rect.top &&
        event.clientY <= rect.bottom;
      wake();
    };
    const onLeave = () => {
      pointer.inside = false;
      wake();
    };
    const onPointerUp = event => {
      if (event.pointerType !== 'mouse') onLeave();
    };
    window.addEventListener('pointermove', onPointerMove, { passive: true });
    window.addEventListener('pointerup', onPointerUp, { passive: true });
    window.addEventListener('pointercancel', onPointerUp, { passive: true });
    document.documentElement.addEventListener('pointerleave', onLeave);

    const onLost = event => {
      event.preventDefault();
      lost = true;
      cancelAnimationFrame(raf);
      raf = 0;
    };
    const onRestored = () => {
      lost = false;
      wake();
    };
    canvas.addEventListener('webglcontextlost', onLost);
    canvas.addEventListener('webglcontextrestored', onRestored);

    const resizeObserver = new ResizeObserver(() => {
      resize();
      wake();
    });
    resizeObserver.observe(container);

    const intersection = new IntersectionObserver(entries => {
      visible = entries.some(entry => entry.isIntersecting);
      wake();
    });
    intersection.observe(container);

    const onVisibility = () => {
      pageVisible = document.visibilityState !== 'hidden';
      wake();
    };
    document.addEventListener('visibilitychange', onVisibility);

    resize();
    wake();
  })();
</script>
