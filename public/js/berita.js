/* ==============================
   BERITA PAGE — berita.js
   Tidak ada perubahan dari versi sebelumnya. Strip emoji judul
   ditangani di server (berita.php) sebelum data di-json_encode,
   jadi p.judul yang sampai ke sini sudah otomatis bersih.
   ============================== */

// ── MODAL ──────────────────────────────────────────
function openModal(p) {
  const fotoWrap = document.getElementById('bmodalFotoWrap');
  const fotoImg  = document.getElementById('bmodalFoto');
  if (p.foto) {
    fotoImg.src            = p.foto;
    fotoImg.alt            = p.judul;
    fotoWrap.style.display = '';
  } else {
    fotoImg.src            = '';
    fotoWrap.style.display = 'none';
  }
  document.getElementById('bmodalTitle').textContent = p.judul;
  // Author + avatar
  const penulis  = p.nama_penulis || 'Admin';
  const avatarEl = document.getElementById('bmodalAuthorAvatar');
  if (avatarEl) avatarEl.textContent = penulis.charAt(0).toUpperCase();
  document.getElementById('bmodalAuthor').textContent = penulis;
  // Tanggal
  const d = new Date(p.tanggal_terbit);
  document.getElementById('bmodalDate').textContent =
    d.toLocaleDateString('id-ID', {
      weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
    });
  document.getElementById('bmodalBody').innerHTML = p.isi;
  document.getElementById('modalBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
  const modalBody = document.querySelector('.bmodal-body');
  if (modalBody) modalBody.scrollTop = 0;
}
function closeModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
  document.body.style.overflow = '';
}
// ── SEARCH ─────────────────────────────────────────
function filterBerita() {
  const q        = document.getElementById('searchInput').value.toLowerCase();
  const featured = document.getElementById('featuredCard');
  const clearBtn = document.getElementById('searchClear');
  if (clearBtn) clearBtn.style.display = q ? 'flex' : 'none';
  let anyVisible = false;
  if (featured) {
    const show = featured.dataset.title.includes(q);
    featured.style.display = show ? '' : 'none';
    if (show) anyVisible = true;
  }
  document.querySelectorAll('.berita-card').forEach(card => {
    const show = card.dataset.title.includes(q);
    card.style.display = show ? '' : 'none';
    if (show) anyVisible = true;
  });
  const noResult = document.getElementById('noResult');
  if (noResult) noResult.style.display = anyVisible ? 'none' : 'block';
}
function clearSearch() {
  const input = document.getElementById('searchInput');
  if (input) { input.value = ''; input.focus(); }
  const clearBtn = document.getElementById('searchClear');
  if (clearBtn) clearBtn.style.display = 'none';
  filterBerita();
}
// ── KEYBOARD ───────────────────────────────────────
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});
// ── SCROLL REVEAL ──────────────────────────────────
function initScrollReveal() {
  if (!('IntersectionObserver' in window)) return;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.berita-card').forEach(card => {
    card.style.animationPlayState = 'paused';
    observer.observe(card);
  });
}
document.addEventListener('DOMContentLoaded', initScrollReveal);