/* ==============================
   JKT48 FANSITE — home.js
   ============================== */

// ── NAVBAR SCROLL EFFECT ───────────────────────────
(function () {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  function onScroll() {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();

// ── HERO SCROLL REVEAL ─────────────────────────────
(function () {
  const heroSection = document.querySelector('.hero-fullscreen');
  const overlay     = document.getElementById('heroOverlay');
  const content     = document.getElementById('heroContent');
  const scrollHint  = document.getElementById('heroScrollHint');
  if (!heroSection || !overlay || !content) return;

  const heroHeight = () => heroSection.offsetHeight;
  const viewportH  = () => window.innerHeight;

  function onScroll() {
    const scrollY    = window.scrollY;
    const extraScroll = heroHeight() - viewportH(); // jarak scroll dalam sticky area
    let progress = extraScroll > 0 ? scrollY / extraScroll : 0;
    progress = Math.min(Math.max(progress, 0), 1);

    overlay.style.opacity = progress;

    content.style.opacity   = progress;
    content.style.transform = `translateY(${30 * (1 - progress)}px)`;

    if (scrollHint) {
      scrollHint.style.opacity = 1 - progress * 2; // hilang lebih cepat
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  onScroll();
})();

(function () {
  const video = document.querySelector('.hero-bg-video');
  if (!video) return;
  video.addEventListener('loadeddata', () => video.classList.add('loaded'));
})();

(function () {
  const slidesEl  = document.getElementById('slides');
  const progWrap  = document.getElementById('slideProgress');
  const currentEl = document.getElementById('slideCurrentNum');
  if (!slidesEl) return;

  const total = slidesEl.children.length;
  let current = 0;
  let timer;

  if (progWrap) {
    for (let i = 0; i < total; i++) {
      const dot = document.createElement('div');
      dot.className = 'slide-prog-dot' + (i === 0 ? ' active' : '');
      dot.addEventListener('click', () => { goTo(i); reset(); });
      progWrap.appendChild(dot);
    }
  }

  function goTo(n) {
    current = (n + total) % total;
    slidesEl.style.transform = `translateX(-${current * 100}%)`;

    // Update sidebar dots
    if (progWrap) {
      progWrap.querySelectorAll('.slide-prog-dot').forEach((d, i) => {
        d.classList.toggle('active', i === current);
      });
    }

    // Update counter
    if (currentEl) {
      currentEl.textContent = String(current + 1).padStart(2, '0');
    }
  }

  function reset() {
    clearInterval(timer);
    timer = setInterval(() => goTo(current + 1), 4500);
  }

  window.slidePrev = () => { goTo(current - 1); reset(); };
  window.slideNext = () => { goTo(current + 1); reset(); };

  // Touch swipe
  let startX = 0;
  slidesEl.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
  slidesEl.addEventListener('touchend', e => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) { goTo(diff > 0 ? current + 1 : current - 1); reset(); }
  });

  goTo(0);
  reset();
})();

// ── COUNTDOWN TIMER ────────────────────────────────
(function () {
  const block = document.getElementById('countdownBlock');
  if (!block) return;

  const target    = new Date(block.dataset.target);
  const daysEl    = document.getElementById('cdDays');
  const hoursEl   = document.getElementById('cdHours');
  const minsEl    = document.getElementById('cdMins');
  const secsEl    = document.getElementById('cdSecs');

  function pad(n) { return String(n).padStart(2, '0'); }

  function flipNum(el, newVal) {
    if (el.textContent !== newVal) {
      el.classList.remove('flip');
      void el.offsetWidth; // reflow
      el.classList.add('flip');
      el.textContent = newVal;
    }
  }

  function tick() {
    const now  = new Date();
    const diff = target - now;

    if (diff <= 0) {
      // Event sudah berlalu
      [daysEl, hoursEl, minsEl, secsEl].forEach(el => { if (el) el.textContent = '00'; });
      return;
    }

    const days  = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const mins  = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const secs  = Math.floor((diff % (1000 * 60)) / 1000);

    if (daysEl)  flipNum(daysEl,  pad(days));
    if (hoursEl) flipNum(hoursEl, pad(hours));
    if (minsEl)  flipNum(minsEl,  pad(mins));
    if (secsEl)  flipNum(secsEl,  pad(secs));
  }

  tick();
  setInterval(tick, 1000);
})();

// ── NAVBAR ACTIVE LINK ─────────────────────────────
(function () {
  const params = new URLSearchParams(window.location.search);
  const act    = params.get('act') || 'home';

  document.querySelectorAll('.navbar-menu a').forEach(link => {
    const href = link.getAttribute('href') || '';
    const lAct = new URLSearchParams(href.split('?')[1] || '').get('act') || 'home';
    link.classList.toggle('active', lAct === act);
  });
})();

// ── SCROLL REVEAL ──────────────────────────────────
(function () {
  if (!('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('reveal-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll(
    '.feat-card, .latest-card, .info-bar, .song-card, .slideshow-section'
  ).forEach(el => {
    el.classList.add('reveal-hidden');
    observer.observe(el);
  });
})();

// ── SMOOTH SCROLL ──────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
  });
});