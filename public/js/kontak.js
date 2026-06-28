/* ==============================
   KONTAK PAGE — kontak.js
   ============================== */

// ── FLASH AUTO DISMISS ─────────────────────────────
const flash = document.getElementById('saranFlash');
if (flash) {
  setTimeout(() => {
    flash.style.transition = 'opacity .4s, transform .4s';
    flash.style.opacity    = '0';
    flash.style.transform  = 'translateY(-8px)';
    setTimeout(() => flash.remove(), 400);
  }, 5000);
}

// ── CHAR COUNTER ───────────────────────────────────
const textarea  = document.getElementById('pesan');
const charCount = document.getElementById('charCount');

if (textarea && charCount) {
  textarea.addEventListener('input', () => {
    const len = textarea.value.length;
    charCount.textContent = len;

    if (len > 1800) {
      charCount.style.color = '#e53935';
      charCount.style.fontWeight = '800';
    } else if (len > 1500) {
      charCount.style.color = '#e91e8c';
      charCount.style.fontWeight = '700';
    } else {
      charCount.style.color = '#b06898';
      charCount.style.fontWeight = '600';
    }
  });
}

// ── FORM SUBMIT ANIMATION ──────────────────────────
const form      = document.querySelector('.saran-form');
const submitBtn = document.querySelector('.saran-submit-btn');

if (form && submitBtn) {
  form.addEventListener('submit', () => {
    submitBtn.style.opacity   = '.7';
    submitBtn.style.transform = 'scale(.97)';
    submitBtn.disabled        = true;

    const icon = submitBtn.querySelector('.saran-btn-icon');
    if (icon) {
      icon.style.animation = 'sendPulse .4s ease infinite alternate';
    }
  });
}

// ── SCROLL REVEAL ──────────────────────────────────
if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.sosmed-card').forEach(card => {
    card.style.animationPlayState = 'paused';
    observer.observe(card);
  });
}