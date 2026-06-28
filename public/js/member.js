/* ==============================
   MEMBER PAGE — member.js
   ==============================
   Perubahan dari versi sebelumnya:
   - openModal: tombol oshimen sekarang inject SVG dari data-icon-heart
     dan data-icon-crown (disimpan di elemen button oleh PHP).
   - openModal: foto-note sekarang inject SVG kamera (ICO_CAMERA dari PHP)
     + teks, dan toggle class "visible" yang dikontrol CSS (display:flex).
   - TIDAK ADA perubahan di animasi, filter, keyboard, atau scroll reveal.
   ============================== */

// ── STATE ───────────────────────────────────────────
let activeGen    = 'all';
let activeSearch = '';

// ── FILTER & SEARCH ────────────────────────────────
function setFilter(btn) {
  document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  activeGen = btn.dataset.gen;
  applyFilter();
}

function filterCards() {
  const input = document.getElementById('searchInput');
  activeSearch = input.value.toLowerCase();

  const clearBtn = document.getElementById('searchClear');
  if (clearBtn) clearBtn.style.display = activeSearch ? 'flex' : 'none';

  applyFilter();
}

function clearSearch() {
  const input = document.getElementById('searchInput');
  if (input) {
    input.value = '';
    activeSearch = '';
    document.getElementById('searchClear').style.display = 'none';
    input.focus();
  }
  applyFilter();
}

function applyFilter() {
  const cards = document.querySelectorAll('.member-card');
  let visible = 0;

  cards.forEach((card) => {
    const matchGen  = activeGen === 'all' || card.dataset.gen === activeGen;
    const matchName = card.dataset.name.includes(activeSearch);
    const show      = matchGen && matchName;

    if (show) {
      card.style.display = '';
      card.style.animationDelay = `${visible * 40}ms`;
      visible++;
    } else {
      card.style.display = 'none';
    }
  });

  const countEl = document.getElementById('memberCount');
  if (countEl) countEl.innerHTML = `Menampilkan <strong>${visible}</strong> member`;

  const noResult = document.getElementById('noResult');
  const grid     = document.getElementById('memberGrid');
  if (noResult) noResult.style.display = visible === 0 ? 'block' : 'none';
  if (grid)     grid.style.display     = visible === 0 ? 'none'  : '';
}

// ── MODAL ──────────────────────────────────────────
function openModal(m) {
  const photoWrap = document.getElementById('modalPhotoWrap');
  const fotoNote  = document.getElementById('modalFotoNote');
  const backdrop  = document.getElementById('modalBackdrop');

  const fotoPopup = m.foto_casual || m.foto;

  if (fotoPopup) {
    photoWrap.innerHTML = `
      <img src="${fotoPopup}"
           alt="${m.nama_member}"
           class="modal-photo"
           onerror="this.style.display='none'"/>
    `;
    if (fotoNote) {
      // Ganti emoji 📸 — ICO_CAMERA dipassin dari PHP lewat var global
      const cameraIcon = typeof ICO_CAMERA !== 'undefined' ? ICO_CAMERA : '';
      const label = m.foto_casual ? 'Foto casual' : 'Foto resmi';
      fotoNote.innerHTML = cameraIcon + ' ' + label;
      fotoNote.classList.add('visible');
    }
  } else {
    photoWrap.innerHTML = `
      <div class="modal-photo-placeholder">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="currentColor"
             style="color: var(--pk-mid);" aria-hidden="true">
          <circle cx="12" cy="8" r="4" opacity="1"/>
          <path d="M4 21c0-4.4 3.6-7.4 8-7.4s8 3 8 7.4" opacity=".4"/>
        </svg>
      </div>
    `;
    if (fotoNote) fotoNote.classList.remove('visible');
  }

  document.getElementById('modalName').textContent    = m.nama_member;
  document.getElementById('modalGen').textContent     = m.gen;
  document.getElementById('modalGenStat').textContent = m.gen;
  document.getElementById('modalAsal').textContent    = m.asal;
  document.getElementById('modalDesc').textContent    = m.deskripsi || '—';

  const tglEl = document.getElementById('modalTglLahir');
  if (tglEl) {
    if (m.tanggal_lahir) {
      const d = new Date(m.tanggal_lahir);
      tglEl.textContent = d.toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric'
      });
    } else {
      tglEl.textContent = '—';
    }
  }

  // Oshimen button — SVG diambil dari data-attribute yang disimpan PHP
  if (typeof isLoggedIn !== 'undefined' && isLoggedIn) {
    const oshiWrap = document.getElementById('modalOshiWrap');
    const oshiId   = document.getElementById('modalOshiId');
    const oshiBtn  = document.getElementById('modalOshiBtn');

    if (oshiWrap) oshiWrap.style.display = 'block';
    if (oshiId)   oshiId.value           = m.id_member;

    if (oshiBtn) {
      const isCurrentOshi = currentOshiId &&
        parseInt(currentOshiId) === parseInt(m.id_member);

      const iconHeart = oshiBtn.dataset.iconHeart || '';
      const iconCrown = oshiBtn.dataset.iconCrown || '';

      if (isCurrentOshi) {
        oshiBtn.innerHTML = iconCrown + ' Ini Oshimenmu!';
        oshiBtn.classList.add('is-oshi');
        oshiBtn.disabled = true;
      } else {
        oshiBtn.innerHTML = iconHeart + ' Jadikan Oshimen';
        oshiBtn.classList.remove('is-oshi');
        oshiBtn.disabled = false;
      }
    }
  }

  backdrop.classList.add('open');

  const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
  if (scrollBarWidth > 0) document.body.style.paddingRight = `${scrollBarWidth}px`;
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  const backdrop = document.getElementById('modalBackdrop');
  if (backdrop) backdrop.classList.remove('open');
  document.body.style.overflow     = '';
  document.body.style.paddingRight = '';
}

// ── KEYBOARD ───────────────────────────────────────
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});

// ── SCROLL ANIMATION (Intersection Observer) ────────
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

  document.querySelectorAll('.member-card').forEach(card => {
    card.style.animationPlayState = 'paused';
    observer.observe(card);
  });
}

// ── INIT ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  initScrollReveal();
});