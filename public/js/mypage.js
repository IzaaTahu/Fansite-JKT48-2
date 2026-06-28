/* ==============================
   MY PAGE — mypage.js
   ============================== */

// ── FLASH AUTO DISMISS ─────────────────────────────
const flash = document.getElementById('mpFlash');
if (flash) {
  flash.style.transition = 'opacity .4s, transform .4s';
  setTimeout(() => {
    flash.style.opacity   = '0';
    flash.style.transform = 'translateY(-8px)';
    setTimeout(() => flash.remove(), 400);
  }, 4500);
}

// ── MEMBER SEARCH ──────────────────────────────────
function filterMembers(q) {
  q = q.toLowerCase().trim();

  const clearBtn  = document.getElementById('searchClear');
  if (clearBtn) clearBtn.style.display = q ? 'flex' : 'none';

  const items   = document.querySelectorAll('.mp-member-item');
  const noResult = document.getElementById('noMember');
  let visible   = 0;

  items.forEach((el, i) => {
    const show = el.dataset.name.includes(q);
    el.style.display = show ? '' : 'none';
    if (show) {
      // Re-stagger animation saat filter
      el.style.setProperty('--i', visible);
      visible++;
    }
  });

  // Update count
  const countEl = document.getElementById('memberCount');
  if (countEl) countEl.textContent = visible + ' member';

  if (noResult) noResult.style.display = visible === 0 ? 'block' : 'none';
  const grid = document.getElementById('memberGrid');
  if (grid)   grid.style.display = visible === 0 ? 'none' : '';
}

function clearSearch() {
  const input = document.getElementById('memberSearch');
  if (input) { input.value = ''; input.focus(); }
  const clearBtn = document.getElementById('searchClear');
  if (clearBtn) clearBtn.style.display = 'none';
  filterMembers('');
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
  }, { threshold: 0.08 });

  document.querySelectorAll('.mp-member-item').forEach(card => {
    card.style.animationPlayState = 'paused';
    observer.observe(card);
  });
}

// ── SMOOTH SCROLL ke member grid ───────────────────
document.querySelectorAll('a[href="#member-grid-section"]').forEach(a => {
  a.addEventListener('click', e => {
    e.preventDefault();
    const target = document.getElementById('member-grid-section');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      // Focus ke search input setelah scroll
      setTimeout(() => {
        const input = document.getElementById('memberSearch');
        if (input) input.focus();
      }, 600);
    }
  });
});