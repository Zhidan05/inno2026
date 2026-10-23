<script src="{{ asset('js/script.js') }}"></script>
<script>
  // Dashboard Countdown Logic
  document.addEventListener('DOMContentLoaded', () => {
    const cdEls = document.querySelectorAll('.dash-countdown');
    cdEls.forEach(cdEl => {
      const targetTime = new Date(cdEl.dataset.time).getTime();
      const daysEl = cdEl.querySelector('.d-days');
      const hoursEl = cdEl.querySelector('.d-hours');
      const minsEl = cdEl.querySelector('.d-mins');

      function update() {
        const now = new Date().getTime();
        const distance = targetTime - now;
        if (distance < 0) return;

        if (daysEl) daysEl.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
        if (hoursEl) hoursEl.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        if (minsEl) minsEl.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
      }
      update();
      setInterval(update, 60000);
    });
  });
</script>
