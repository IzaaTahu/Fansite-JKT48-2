<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Galeri Foto — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/galeri.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>
<div class="floaties" id="floaties"></div>

<!-- NAVBAR -->
<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="galeri-hero">
  <div class="galeri-hero-content">
    <div class="hero-badge">✦ Fan Gallery</div>
    <h1>Galeri <em>Foto & Video</em></h1>
    <p>Koleksi foto dan fancam dari para fansite &amp; fan photographer JKT48.</p>
  </div>
  <div class="galeri-hero-deco">📸✨🎥💖</div>
</div>

<!-- BREADCRUMB -->
<div class="galeri-breadcrumb">
  <span class="bc-active">📁 Semua Event</span>
</div>

<!-- FLASH -->
<?php if ($flash): ?>
<div class="galeri-flash galeri-flash-<?= $flash['type'] ?>" id="galeriFlash">
  <?= htmlspecialchars($flash['msg']) ?>
  <button onclick="this.parentElement.remove()">×</button>
</div>
<?php endif; ?>

<!-- EVENT GRID -->
<section class="galeri-section">
  <?php if (empty($events)): ?>
    <div class="galeri-empty">
      <div class="galeri-empty-icon">📭</div>
      <h3>Belum Ada Event</h3>
      <p>Admin belum membuat event galeri. Cek lagi nanti ya!</p>
    </div>
  <?php else: ?>
    <div class="event-grid">
      <?php
      $TIPE_ICON = [
        'Theater Show'=>'🎭','Off Air'=>'🎪','On Air'=>'📡',
        'Event'=>'🎉','Meet & Greet'=>'🤝','Lainnya'=>'📌',
      ];
      $TIPE_COLOR = [
        'Theater Show'=>'tipe-pink','Off Air'=>'tipe-lav','On Air'=>'tipe-mint',
        'Event'=>'tipe-peach','Meet & Greet'=>'tipe-rose','Lainnya'=>'tipe-gray',
      ];
      foreach ($events as $ev):
        $icon  = $TIPE_ICON[$ev['tipe']]  ?? '📌';
        $color = $TIPE_COLOR[$ev['tipe']] ?? 'tipe-gray';
        $dt    = new DateTime($ev['tanggal']);
      ?>
      <a href="index.php?act=galeri-event&event=<?= $ev['id_event'] ?>" class="event-card">
        <div class="event-card-top">
          <div class="event-icon-wrap <?= $color ?>"><?= $icon ?></div>
          <div class="event-tipe-badge <?= $color ?>"><?= htmlspecialchars($ev['tipe']) ?></div>
        </div>
        <div class="event-card-body">
          <div class="event-card-name"><?= htmlspecialchars($ev['nama_event']) ?></div>
          <div class="event-card-date">📅 <?= $dt->format('d M Y') ?></div>
        </div>
        <div class="event-card-stats">
          <span>🖼️ <?= $ev['total_foto'] ?> file</span>
          <span>👩‍🎤 <?= $ev['total_member'] ?> member</span>
        </div>
        <div class="event-card-arrow">Lihat Galeri →</div>
      </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script>
const flash = document.getElementById('galeriFlash');
if (flash) setTimeout(() => { flash.style.transition='opacity .4s'; flash.style.opacity='0'; setTimeout(()=>flash.remove(),400); }, 4000);
</script>
</body>
</html>