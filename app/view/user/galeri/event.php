<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($event['nama_event']) ?> — Galeri JKT48</title>
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
  <div class="galeri-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      ✦ <?= htmlspecialchars($event['tipe']) ?>
    </div>
    <h1><?= htmlspecialchars($event['nama_event']) ?></h1>
    <p>📅 <?= (new DateTime($event['tanggal']))->format('d M Y') ?>
      <?php if ($event['deskripsi']): ?>
        &nbsp;·&nbsp; <?= htmlspecialchars($event['deskripsi']) ?>
      <?php endif; ?>
    </p>
  </div>
  <div class="galeri-hero-deco">📸✨🎥💖</div>
</div>

<!-- BREADCRUMB -->
<div class="galeri-breadcrumb">
  <a href="index.php?act=galeri" class="bc-link">📁 Semua Event</a>
  <span class="bc-sep">›</span>
  <span class="bc-active">👩‍🎤 Pilih Member</span>
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
        <div class="upload-panel-sub">Pilih member dulu, lalu upload fotomu untuk event ini.</div>
      </div>
      <button class="upload-toggle-btn" id="uploadToggle" onclick="toggleUpload()">+ Upload</button>
    </div>
    <div class="upload-form-wrap" id="uploadForm" style="display:none;">
      <form method="POST" action="index.php?act=galeri-upload" enctype="multipart/form-data">
        <input type="hidden" name="id_event" value="<?= $event['id_event'] ?>"/>
        <div class="upload-grid">
          <div class="upload-field">
            <label>Member <span class="req">*</span></label>
            <select name="id_member" required>
              <option value="">— Pilih Member —</option>
              <?php foreach ($allMembers as $m): ?>
              <option value="<?= $m['id_member'] ?>"><?= htmlspecialchars($m['nama_member']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="upload-field">
            <label>File (Foto/Video) <span class="req">*</span></label>
            <input type="file" name="file" accept="image/*,video/mp4,video/quicktime,video/webm"
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

  <?php if (empty($members)): ?>
    <div class="galeri-empty">
      <div class="galeri-empty-icon">📷</div>
      <h3>Belum Ada Foto</h3>
      <p>Jadilah yang pertama upload foto untuk event ini!</p>
    </div>
  <?php else: ?>
    <div class="galeri-section-header">
      <div class="galeri-section-title"><span>👩‍🎤</span> Pilih Member</div>
      <div class="galeri-event-count"><?= count($members) ?> member</div>
    </div>
    <div class="member-galeri-grid">
      <?php foreach ($members as $i => $m): ?>
      <a href="index.php?act=galeri-foto&event=<?= $event['id_event'] ?>&member=<?= $m['id_member'] ?>"
         class="member-galeri-card" style="--card-index:<?= $i ?>;">
        <div class="mgc-photo">
          <?php if (!empty($m['foto'])): ?>
            <img src="<?= htmlspecialchars($m['foto']) ?>" alt="<?= htmlspecialchars($m['nama_member']) ?>" loading="lazy"/>
          <?php else: ?>
            <div class="mgc-photo-ph">👤</div>
          <?php endif; ?>
          <div class="mgc-overlay">
            <span class="mgc-view">Lihat Foto →</span>
          </div>
          <div class="mgc-count">
            <span>🖼️</span> <?= $m['total_foto'] ?> file
          </div>
        </div>
        <div class="mgc-info">
          <div class="mgc-name"><?= htmlspecialchars($m['nama_member']) ?></div>
          <div class="mgc-gen"><?= htmlspecialchars($m['gen']) ?></div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</section>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/galeri.js"></script>
</body>
</html>