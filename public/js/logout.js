/* ==============================
   LOGOUT PAGE — logout.js
   ============================== */

// ── LOADING STATE SAAT LOGOUT ──────────────────────
const logoutForm = document.querySelector('.btn-group form');
const logoutBtn  = document.querySelector('.btn-outline');

if (logoutForm && logoutBtn) {
  logoutForm.addEventListener('submit', () => {
    logoutBtn.disabled    = true;
    logoutBtn.style.opacity = '.7';
    logoutBtn.textContent = 'Logging out...';
  });
}

// ── ICON CLICK — sedikit easter egg ────────────────
const iconEmoji = document.querySelector('.icon-emoji');
if (iconEmoji) {
  iconEmoji.addEventListener('click', () => {
    iconEmoji.style.animation = 'none';
    void iconEmoji.offsetWidth; // reflow
    iconEmoji.style.animation = 'waveHand .6s ease-in-out 2';
  });
}