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

<header><?php include 'components/nav.php'; ?></header>

<!-- HERO -->
<div class="galeri-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>

  <?php if (!empty($member['foto'])): ?>
  <div class="galeri-hero-member-foto">
    <img src="<?= htmlspecialchars($member['foto']) ?>" alt="<?= htmlspecialchars($member['nama_member']) ?>"/>
    <div class="galeri-hero-member-glow"></div>
  </div>
  <?php endif; ?>

  <div class="galeri-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      ✦ <?= htmlspecialchars($event['tipe']) ?>
    </div>
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
  <span><?= htmlspecialchars($flash['msg']) ?></span>
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
            <input type="text" name="caption" placeholder="Tulis caption singkat..." maxlength="500"/>
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

  <?php if (empty($fotos)): ?>
    <div class="galeri-empty">
      <div class="galeri-empty-icon">📷</div>
      <h3>Belum Ada Foto</h3>
      <p>Jadilah yang pertama upload foto <?= htmlspecialchars($member['nama_member']) ?> di event ini!</p>
    </div>
  <?php else: ?>

    <div class="galeri-section-header">
      <div class="galeri-section-title"><span>📸</span> Koleksi Foto</div>
      <div class="galeri-event-count"><?= count($fotos) ?> file</div>
    </div>

    <div class="masonry-grid" id="masonryGrid">
      <?php foreach ($fotos as $idx => $f):
        $komentar = $komentarsPerFoto[$f['id_foto']] ?? [];
      ?>
      <div class="masonry-item" style="--item-index:<?= $idx ?>;"
           onclick="openFotoModal(<?= $idx ?>)">

        <?php if ($f['tipe_file'] === 'video'): ?>
          <div class="masonry-video-thumb">
            <video src="<?= htmlspecialchars($f['file_path']) ?>"
                   class="masonry-video" preload="metadata"></video>
            <div class="masonry-video-play">▶</div>
          </div>
        <?php else: ?>
          <img src="<?= htmlspecialchars($f['file_path']) ?>"
               alt="<?= htmlspecialchars($f['caption'] ?? '') ?>"
               class="masonry-img" loading="lazy"/>
        <?php endif; ?>

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

<!-- MODAL FOTO -->
<div class="foto-modal-backdrop" id="fotoModalBackdrop" onclick="closeFotoModal()">
  <div class="foto-modal" onclick="event.stopPropagation()">

    <div class="fmodal-media-side">
      <button class="fmodal-close" onclick="closeFotoModal()">×</button>
      <button class="fmodal-nav fmodal-prev" id="fmodalPrev" onclick="navigateModal(-1)">‹</button>
      <button class="fmodal-nav fmodal-next" id="fmodalNext" onclick="navigateModal(1)">›</button>
      <div class="fmodal-media-wrap" id="fmodalMediaWrap"></div>
      <div class="fmodal-type-badge" id="fmodalTypeBadge"></div>
    </div>

    <div class="fmodal-info-side">
      <div class="fmodal-uploader-row">
        <div class="fmodal-avatar" id="fmodalAvatar"></div>
        <div>
          <div class="fmodal-uploader-name" id="fmodalUploaderName"></div>
          <div class="fmodal-upload-time"   id="fmodalUploadTime"></div>
        </div>
        <div class="fmodal-hapus-wrap" id="fmodalHapusWrap"></div>
      </div>
      <div class="fmodal-caption" id="fmodalCaption"></div>
      <div class="fmodal-divider"></div>
      <div class="fmodal-kom-title">💬 Komentar</div>
      <div class="fmodal-kom-list" id="fmodalKomList"></div>

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
    </div>
  </div>
</div>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script>
const FOTOS     = <?= json_encode(array_values($fotos), JSON_UNESCAPED_UNICODE) ?>;
const KOMENTARS = <?= json_encode(array_map(fn($f) => $komentarsPerFoto[$f['id_foto']] ?? [], $fotos), JSON_UNESCAPED_UNICODE) ?>;
const USER_ID   = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
const USER_ROLE = <?= json_encode($_SESSION['role']    ?? 'guest') ?>;
const ID_EVENT  = <?= $event['id_event'] ?>;
const ID_MEMBER = <?= $member['id_member'] ?>;
</script>
<script src="public/js/home.js"></script>
<script src="public/js/galeri.js"></script>
</body>
</html>