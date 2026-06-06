<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($member['nama_member']) ?> — <?= htmlspecialchars($event['nama_event']) ?></title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/galeri.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>
<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="galeri-hero">
  <div class="galeri-hero-content">
    <div class="hero-badge">✦ <?= htmlspecialchars($event['tipe']) ?></div>
    <h1><?= htmlspecialchars($member['nama_member']) ?></h1>
    <p>📅 <?= (new DateTime($event['tanggal']))->format('d M Y') ?>
       &nbsp;·&nbsp; <?= htmlspecialchars($event['nama_event']) ?></p>
  </div>
  <div class="galeri-hero-deco">📸✨🎥💖</div>
</div>

<!-- BREADCRUMB -->
<div class="galeri-breadcrumb">
  <a href="index.php?act=galeri" class="bc-link">📁 Semua Event</a>
  <span class="bc-sep">›</span>
  <a href="index.php?act=galeri-event&event=<?= $event['id_event'] ?>" class="bc-link">
    <?= htmlspecialchars($event['nama_event']) ?>
  </a>
  <span class="bc-sep">›</span>
  <span class="bc-active">📸 <?= htmlspecialchars($member['nama_member']) ?></span>
</div>

<!-- FLASH -->
<?php if ($flash): ?>
<div class="galeri-flash galeri-flash-<?= $flash['type'] ?>" id="galeriFlash">
  <?= htmlspecialchars($flash['msg']) ?>
  <button onclick="this.parentElement.remove()">×</button>
</div>
<?php endif; ?>

<section class="galeri-section">

  <!-- Upload panel -->
  <?php if (isset($_SESSION['user_id'])): ?>
  <div class="upload-panel">
    <div class="upload-panel-head">
      <div>
        <div class="upload-panel-title">📤 Upload Foto / Fancam</div>
        <div class="upload-panel-sub">
          Upload foto atau fancam <?= htmlspecialchars($member['nama_member']) ?> di event ini.
        </div>
      </div>
      <button class="upload-toggle-btn" id="uploadToggle" onclick="toggleUpload()">+ Upload</button>
    </div>
    <div class="upload-form-wrap" id="uploadForm" style="display:none;">
      <form method="POST" action="index.php?act=galeri-upload" enctype="multipart/form-data">
        <input type="hidden" name="id_event"  value="<?= $event['id_event'] ?>"/>
        <input type="hidden" name="id_member" value="<?= $member['id_member'] ?>"/>
        <div class="upload-grid">
          <div class="upload-field full">
            <label>File (Foto/Video) <span class="req">*</span></label>
            <input type="file" name="file"
                   accept="image/*,video/mp4,video/quicktime,video/webm"
                   required onchange="previewFile(this)"/>
            <div class="upload-hint">Foto: JPG/PNG/WEBP maks 10MB · Video: MP4/MOV/WEBM maks 100MB</div>
          </div>
          <div class="upload-field full">
            <label>Caption <span style="font-weight:400;color:#b06898;">(opsional)</span></label>
            <input type="text" name="caption"
                   placeholder="Tulis caption singkat..." maxlength="500"/>
          </div>
        </div>
        <div class="upload-preview-wrap" id="uploadPreview" style="display:none;">
          <img id="previewImg" src="" alt="" style="display:none;"/>
          <video id="previewVid" controls style="display:none;"></video>
        </div>
        <div class="upload-actions">
          <button type="submit" class="btn-upload-submit">🚀 Upload Sekarang</button>
          <button type="button" class="btn-upload-cancel" onclick="toggleUpload()">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <?php else: ?>
  <div class="upload-login-hint">
    📸 <a href="index.php?act=login">Login</a> untuk upload foto atau fancam ke galeri ini.
  </div>
  <?php endif; ?>

  <!-- Grid foto -->
  <?php if (empty($fotos)): ?>
    <div class="galeri-empty">
      <div class="galeri-empty-icon">📷</div>
      <h3>Belum Ada Foto</h3>
      <p>Jadilah yang pertama upload foto <?= htmlspecialchars($member['nama_member']) ?> di event ini!</p>
    </div>
  <?php else: ?>

    <div class="foto-count"><?= count($fotos) ?> file ditemukan</div>

    <!-- MASONRY GRID -->
    <div class="masonry-grid" id="masonryGrid">
      <?php foreach ($fotos as $idx => $f):
        $komentar = $komentarsPerFoto[$f['id_foto']] ?? [];
        $isOwner  = isset($_SESSION['user_id']) && (int)$f['id_user'] === (int)$_SESSION['user_id'];
        $isAdmin  = isset($_SESSION['role'])    && $_SESSION['role']  === 'admin';
      ?>
      <div class="masonry-item"
           onclick="openFotoModal(<?= $idx ?>)"
           title="<?= htmlspecialchars($f['caption'] ?? $f['nama_uploader'] ?? '') ?>">

        <?php if ($f['tipe_file'] === 'video'): ?>
          <div class="masonry-video-thumb">
            <video src="<?= htmlspecialchars($f['file_path']) ?>"
                   class="masonry-video" preload="metadata"></video>
            <div class="masonry-video-play">▶</div>
          </div>
        <?php else: ?>
          <img src="<?= htmlspecialchars($f['file_path']) ?>"
               alt="<?= htmlspecialchars($f['caption'] ?? '') ?>"
               class="masonry-img"
               loading="lazy"/>
        <?php endif; ?>

        <!-- Hover overlay -->
        <div class="masonry-hover">
          <?php if ($f['caption']): ?>
            <div class="masonry-caption"><?= htmlspecialchars(mb_substr($f['caption'], 0, 60)) ?></div>
          <?php endif; ?>
          <div class="masonry-meta-row">
            <span class="masonry-uploader">👤 <?= htmlspecialchars($f['nama_uploader'] ?? 'User') ?></span>
            <span class="masonry-komcount">💬 <?= count($komentar) ?></span>
          </div>
        </div>

      </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>
</section>

<!-- ══ MODAL SPLIT LAYOUT ══ -->
<div class="foto-modal-backdrop" id="fotoModalBackdrop" onclick="closeFotoModal()">
  <div class="foto-modal" onclick="event.stopPropagation()">

    <!-- KIRI: Media -->
    <div class="fmodal-media-side" id="fmodalMediaSide">
      <button class="fmodal-close" onclick="closeFotoModal()">×</button>

      <!-- Navigasi prev/next -->
      <button class="fmodal-nav fmodal-prev" id="fmodalPrev" onclick="navigateModal(-1)">‹</button>
      <button class="fmodal-nav fmodal-next" id="fmodalNext" onclick="navigateModal(1)">›</button>

      <div class="fmodal-media-wrap" id="fmodalMediaWrap">
        <!-- diisi JS -->
      </div>

      <div class="fmodal-type-badge" id="fmodalTypeBadge"></div>
    </div>

    <!-- KANAN: Info + Komentar -->
    <div class="fmodal-info-side">

      <!-- Uploader -->
      <div class="fmodal-uploader-row">
        <div class="fmodal-avatar" id="fmodalAvatar"></div>
        <div>
          <div class="fmodal-uploader-name" id="fmodalUploaderName"></div>
          <div class="fmodal-upload-time"   id="fmodalUploadTime"></div>
        </div>
        <div class="fmodal-hapus-wrap" id="fmodalHapusWrap"></div>
      </div>

      <!-- Caption -->
      <div class="fmodal-caption" id="fmodalCaption"></div>

      <div class="fmodal-divider"></div>

      <!-- Komentar list -->
      <div class="fmodal-kom-title">💬 Komentar</div>
      <div class="fmodal-kom-list" id="fmodalKomList">
        <!-- diisi JS -->
      </div>

      <!-- Form komentar -->
      <?php if (isset($_SESSION['user_id'])): ?>
      <div class="fmodal-kom-form">
        <div class="fmodal-kom-avatar">
          <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
        </div>
        <form method="POST" action="index.php?act=galeri-komentar"
              class="fmodal-kom-input-wrap" id="fmodalKomForm">
          <input type="hidden" name="id_foto"   id="fmodalKomFotoId"/>
          <input type="hidden" name="id_event"  value="<?= $event['id_event'] ?>"/>
          <input type="hidden" name="id_member" value="<?= $member['id_member'] ?>"/>
          <input type="text" name="isi" placeholder="Tulis komentar..."
                 required maxlength="500" id="fmodalKomInput"/>
          <button type="submit">Kirim</button>
        </form>
      </div>
      <?php else: ?>
      <div class="fmodal-kom-login">
        <a href="index.php?act=login">Login</a> untuk berkomentar.
      </div>
      <?php endif; ?>

    </div><!-- end .fmodal-info-side -->
  </div>
</div>

<!-- FOOTER -->
<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script>
// ── Data semua foto dari PHP → JS ──────────────────────────────
const FOTOS = <?= json_encode(array_values($fotos), JSON_UNESCAPED_UNICODE) ?>;
const KOMENTARS = <?= json_encode(array_map(fn($f) => $komentarsPerFoto[$f['id_foto']] ?? [], $fotos), JSON_UNESCAPED_UNICODE) ?>;
const USER_ID   = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
const USER_ROLE = <?= json_encode($_SESSION['role']    ?? 'guest') ?>;
const ID_EVENT  = <?= $event['id_event'] ?>;
const ID_MEMBER = <?= $member['id_member'] ?>;

let currentIdx = 0;

// ── Buka modal ──────────────────────────────────────────────────
function openFotoModal(idx) {
  currentIdx = idx;
  renderModal(idx);
  document.getElementById('fotoModalBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function renderModal(idx) {
  const f   = FOTOS[idx];
  const kom = KOMENTARS[idx] ?? [];

  // ── Media ──
  const wrap = document.getElementById('fmodalMediaWrap');
  if (f.tipe_file === 'video') {
    wrap.innerHTML = `<video src="${f.file_path}" controls class="fmodal-video"></video>`;
    document.getElementById('fmodalTypeBadge').innerHTML = '🎥 Fancam';
    document.getElementById('fmodalTypeBadge').className = 'fmodal-type-badge badge-video';
  } else {
    wrap.innerHTML = `<img src="${f.file_path}" alt="${f.caption ?? ''}" class="fmodal-img"/>`;
    document.getElementById('fmodalTypeBadge').innerHTML = '📸 Foto';
    document.getElementById('fmodalTypeBadge').className = 'fmodal-type-badge badge-foto';
  }

  // ── Uploader ──
  const initials = (f.nama_uploader ?? 'U').charAt(0).toUpperCase();
  document.getElementById('fmodalAvatar').textContent      = initials;
  document.getElementById('fmodalUploaderName').textContent = f.nama_uploader ?? 'User';

  // Format tanggal
  const d = new Date(f.dibuat_pada);
  document.getElementById('fmodalUploadTime').textContent =
    d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' }) +
    ', ' + d.toTimeString().slice(0,5);

  // ── Caption ──
  const capEl = document.getElementById('fmodalCaption');
  capEl.textContent = f.caption ?? '';
  capEl.style.display = f.caption ? 'block' : 'none';

  // ── Tombol hapus ──
  const hapusWrap = document.getElementById('fmodalHapusWrap');
  const isOwner   = USER_ID && parseInt(USER_ID) === parseInt(f.id_user);
  const isAdmin   = USER_ROLE === 'admin';
  if (isOwner || isAdmin) {
    hapusWrap.innerHTML = `
      <a href="index.php?act=galeri-hapus-foto&id=${f.id_foto}&event=${ID_EVENT}&member=${ID_MEMBER}"
         class="fmodal-hapus-btn"
         onclick="return confirm('Hapus foto ini?')">🗑️ Hapus</a>`;
  } else {
    hapusWrap.innerHTML = '';
  }

  // ── Komentar list ──
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
      const hapus    = (kIsOwner || kIsAdmin)
        ? `<a href="index.php?act=galeri-hapus-komentar&id=${k.id_komentar}&id_foto=${f.id_foto}&event=${ID_EVENT}&member=${ID_MEMBER}"
              class="kom-hapus" onclick="return confirm('Hapus komentar ini?')">×</a>`
        : '';
      return `
        <div class="fmodal-kom-item">
          <div class="fmodal-kom-av">${(k.nama_user ?? 'U').charAt(0).toUpperCase()}</div>
          <div class="fmodal-kom-body">
            <div class="fmodal-kom-head">
              <span class="fmodal-kom-name">${k.nama_user ?? 'User'}</span>
              <span class="fmodal-kom-time">${kdStr}</span>
              ${hapus}
            </div>
            <div class="fmodal-kom-isi">${k.isi.replace(/\n/g,'<br>')}</div>
          </div>
        </div>`;
    }).join('');
  }

  // Update hidden id_foto di form komentar
  const komFotoId = document.getElementById('fmodalKomFotoId');
  if (komFotoId) komFotoId.value = f.id_foto;

  // Scroll komentar ke bawah
  komList.scrollTop = komList.scrollHeight;

  // ── Navigasi prev/next ──
  document.getElementById('fmodalPrev').style.visibility = idx > 0 ? 'visible' : 'hidden';
  document.getElementById('fmodalNext').style.visibility = idx < FOTOS.length - 1 ? 'visible' : 'hidden';

  // ── Reset scroll info side ──
  document.querySelector('.fmodal-info-side').scrollTop = 0;
}

function navigateModal(dir) {
  const next = currentIdx + dir;
  if (next < 0 || next >= FOTOS.length) return;
  currentIdx = next;
  renderModal(currentIdx);
}

function closeFotoModal() {
  document.getElementById('fotoModalBackdrop').classList.remove('open');
  document.body.style.overflow = '';
  // Pause video kalau ada
  const vid = document.querySelector('.fmodal-video');
  if (vid) vid.pause?.();
}

// Keyboard nav
document.addEventListener('keydown', e => {
  if (!document.getElementById('fotoModalBackdrop').classList.contains('open')) return;
  if (e.key === 'Escape')     closeFotoModal();
  if (e.key === 'ArrowLeft')  navigateModal(-1);
  if (e.key === 'ArrowRight') navigateModal(1);
});

// ── Upload panel ────────────────────────────────────────────────
function toggleUpload() {
  const form = document.getElementById('uploadForm');
  const btn  = document.getElementById('uploadToggle');
  const open = form.style.display === 'none';
  form.style.display = open ? 'block' : 'none';
  btn.textContent    = open ? '× Tutup' : '+ Upload';
}

function previewFile(input) {
  const wrap = document.getElementById('uploadPreview');
  const img  = document.getElementById('previewImg');
  const vid  = document.getElementById('previewVid');
  if (!input.files?.[0]) return;
  const url  = URL.createObjectURL(input.files[0]);
  wrap.style.display = 'block';
  if (input.files[0].type.startsWith('image/')) {
    img.src = url; img.style.display = 'block'; vid.style.display = 'none';
  } else {
    vid.src = url; vid.style.display = 'block'; img.style.display = 'none';
  }
}

// Flash auto-dismiss
const flash = document.getElementById('galeriFlash');
if (flash) setTimeout(() => {
  flash.style.transition = 'opacity .4s';
  flash.style.opacity    = '0';
  setTimeout(() => flash.remove(), 400);
}, 4000);
</script>
</body>
</html>