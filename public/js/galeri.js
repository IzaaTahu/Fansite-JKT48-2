/* ==============================
   GALERI — galeri.js
   Handles: index, event, foto pages
   ============================== */

// ── FLASH AUTO DISMISS ─────────────────────────────
const flash = document.getElementById('galeriFlash');
if (flash) {
  flash.style.transition = 'opacity .4s, transform .4s';
  setTimeout(() => {
    flash.style.opacity   = '0';
    flash.style.transform = 'translateY(-8px)';
    setTimeout(() => flash.remove(), 400);
  }, 4000);
}

// ── UPLOAD PANEL ───────────────────────────────────
function toggleUpload() {
  const form = document.getElementById('uploadForm');
  const btn  = document.getElementById('uploadToggle');
  if (!form || !btn) return;
  const open = form.style.display === 'none';
  form.style.display = open ? 'block' : 'none';
  btn.textContent    = open ? '× Tutup' : '+ Upload';
  if (open) form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function previewFile(input) {
  const wrap = document.getElementById('uploadPreview');
  const img  = document.getElementById('previewImg');
  const vid  = document.getElementById('previewVid');
  if (!input.files?.[0] || !wrap) return;

  const file = input.files[0];
  const url  = URL.createObjectURL(file);
  wrap.style.display = 'block';

  if (file.type.startsWith('image/')) {
    img.src = url; img.style.display = 'block';
    vid.style.display = 'none';
  } else {
    vid.src = url; vid.style.display = 'block';
    img.style.display = 'none';
  }
}

// ── FOTO MODAL (halaman foto.php saja) ─────────────
let currentIdx = 0;

function openFotoModal(idx) {
  if (typeof FOTOS === 'undefined') return;
  currentIdx = idx;
  renderModal(idx);
  document.getElementById('fotoModalBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function renderModal(idx) {
  const f   = FOTOS[idx];
  const kom = KOMENTARS[idx] ?? [];

  // Media
  const wrap = document.getElementById('fmodalMediaWrap');
  if (f.tipe_file === 'video') {
    wrap.innerHTML = `<video src="${f.file_path}" controls class="fmodal-video"></video>`;
    document.getElementById('fmodalTypeBadge').innerHTML  = '🎥 Fancam';
    document.getElementById('fmodalTypeBadge').className  = 'fmodal-type-badge badge-video';
  } else {
    wrap.innerHTML = `<img src="${f.file_path}" alt="${f.caption ?? ''}" class="fmodal-img"/>`;
    document.getElementById('fmodalTypeBadge').innerHTML  = '📸 Foto';
    document.getElementById('fmodalTypeBadge').className  = 'fmodal-type-badge badge-foto';
  }

  // Uploader
  const initials = (f.nama_uploader ?? 'U').charAt(0).toUpperCase();
  document.getElementById('fmodalAvatar').textContent       = initials;
  document.getElementById('fmodalUploaderName').textContent = f.nama_uploader ?? 'User';

  const d = new Date(f.dibuat_pada);
  document.getElementById('fmodalUploadTime').textContent =
    d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' }) +
    ', ' + d.toTimeString().slice(0,5);

  // Caption
  const capEl = document.getElementById('fmodalCaption');
  capEl.textContent   = f.caption ?? '';
  capEl.style.display = f.caption ? 'block' : 'none';

  // Hapus btn
  const hapusWrap = document.getElementById('fmodalHapusWrap');
  const isOwner   = USER_ID && parseInt(USER_ID) === parseInt(f.id_user);
  const isAdmin   = USER_ROLE === 'admin';
  hapusWrap.innerHTML = (isOwner || isAdmin)
    ? `<a href="index.php?act=galeri-hapus-foto&id=${f.id_foto}&event=${ID_EVENT}&member=${ID_MEMBER}"
          class="fmodal-hapus-btn"
          onclick="return confirm('Hapus foto ini?')">🗑️ Hapus</a>`
    : '';

  // Komentar
  const komList = document.getElementById('fmodalKomList');
  if (kom.length === 0) {
    komList.innerHTML = '<div class="fmodal-no-kom">Belum ada komentar. Jadilah yang pertama! 💬</div>';
  } else {
    komList.innerHTML = kom.map(k => {
      const kIsOwner = USER_ID && parseInt(USER_ID) === parseInt(k.id_user);
      const kIsAdmin = USER_ROLE === 'admin';
      const kd       = new Date(k.dibuat_pada);
      const kdStr    = kd.toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric'})
                     + ', ' + kd.toTimeString().slice(0,5);
      const hapusKom = (kIsOwner || kIsAdmin)
        ? `<a href="index.php?act=galeri-hapus-komentar&id=${k.id_komentar}&id_foto=${f.id_foto}&event=${ID_EVENT}&member=${ID_MEMBER}"
              class="kom-hapus" onclick="return confirm('Hapus komentar?')">×</a>`
        : '';
      return `
        <div class="fmodal-kom-item">
          <div class="fmodal-kom-av">${(k.nama_user ?? 'U').charAt(0).toUpperCase()}</div>
          <div class="fmodal-kom-body">
            <div class="fmodal-kom-head">
              <span class="fmodal-kom-name">${k.nama_user ?? 'User'}</span>
              <span class="fmodal-kom-time">${kdStr}</span>
              ${hapusKom}
            </div>
            <div class="fmodal-kom-isi">${k.isi.replace(/\n/g,'<br>')}</div>
          </div>
        </div>`;
    }).join('');
  }

  // Update hidden id_foto di form komentar
  const komFotoId = document.getElementById('fmodalKomFotoId');
  if (komFotoId) komFotoId.value = f.id_foto;

  // Prev/Next visibility
  document.getElementById('fmodalPrev').style.visibility = idx > 0 ? 'visible' : 'hidden';
  document.getElementById('fmodalNext').style.visibility = idx < FOTOS.length - 1 ? 'visible' : 'hidden';

  // Reset scroll
  const infoSide = document.querySelector('.fmodal-info-side');
  if (infoSide) infoSide.scrollTop = 0;
  komList.scrollTop = komList.scrollHeight;
}

function navigateModal(dir) {
  const next = currentIdx + dir;
  if (next < 0 || next >= FOTOS.length) return;
  currentIdx = next;

  // Pause video sebelum navigate
  const vid = document.querySelector('.fmodal-video');
  if (vid) vid.pause?.();

  renderModal(currentIdx);
}

function closeFotoModal() {
  const backdrop = document.getElementById('fotoModalBackdrop');
  if (backdrop) backdrop.classList.remove('open');
  document.body.style.overflow = '';
  const vid = document.querySelector('.fmodal-video');
  if (vid) vid.pause?.();
}

// ── KEYBOARD SHORTCUTS ─────────────────────────────
document.addEventListener('keydown', e => {
  const modalOpen = document.getElementById('fotoModalBackdrop')
                    ?.classList.contains('open');
  if (!modalOpen) return;
  if (e.key === 'Escape')      closeFotoModal();
  if (e.key === 'ArrowLeft')   navigateModal(-1);
  if (e.key === 'ArrowRight')  navigateModal(1);
});

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

  document.querySelectorAll(
    '.event-card, .member-galeri-card, .masonry-item'
  ).forEach(el => {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
  });
}