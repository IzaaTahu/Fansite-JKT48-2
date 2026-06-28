<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- ══════════════════════════════════════
     FULLSCREEN HERO
     ══════════════════════════════════════ -->
<section class="hero-fullscreen">
  <div class="hero-sticky">

    <div class="hero-bg">
      <video class="hero-bg-video" autoplay muted loop playsinline>
        <source src="public/video/hero.mp4" type="video/mp4">
      </video>
      <div class="hero-bg-tint"></div>
      <div class="hero-bg-overlay" id="heroOverlay"></div>
      <div class="hero-bg-grain"></div>
    </div>

    <div class="hero-fs-content" id="heroContent">
      <div class="hero-fs-left">
        <h1 class="hero-fs-title">
          <span class="hero-fs-line1">Selamat Datang</span>
          <span class="hero-fs-line2">di <span class="hero-fs-accent">Fansite</span></span>
          <span class="hero-fs-line3">JKT48</span>
        </h1>
        <p class="hero-fs-sub">
          Tempat berkumpulnya para Wota untuk berbagi info, cerita, dan dukungan bersama.
        </p>
        <div class="hero-fs-actions">
          <a href="index.php?act=member" class="hero-btn-primary">
            Jelajahi Member
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="btn-arrow-icon"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
          </a>
          <a href="index.php?act=jadwal" class="hero-btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            Lihat Jadwal
          </a>
        </div>
      </div>

      <!-- Kartu member kanan -->
      <div class="hero-fs-right">
        <div class="hero-member-card">
          <div class="hmc-inner">
            <img src="public/images/member/Team Dream/Kabesha/freya_jayawardana.jpg"
                 alt="Freya Jayawardana" class="hmc-photo"/>
            <div class="hmc-info">
              <div class="hmc-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                Kapten JKT48
              </div>
              <div class="hmc-name">Freya Jayawardana</div>
              <div class="hmc-quote">
                "Terangi harimu dengan senyuman karamelku. Hai, aku Freya!!"
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="hero-scroll-hint" id="heroScrollHint">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════
     COUNTDOWN + STATS
     ══════════════════════════════════════ -->
<?php
$nextEvent = null;
if (!empty($upcoming)) {
  foreach ($upcoming as $ev) {
    $evDt = new DateTime($ev['tanggal_jadwal']);
    if ($evDt > new DateTime()) { $nextEvent = $ev; break; }
  }
}
?>

<div class="info-bar">
  <?php if ($nextEvent): ?>
  <?php $evDt = new DateTime($nextEvent['tanggal_jadwal']); ?>
  <div class="countdown-block" id="countdownBlock"
       data-target="<?= $evDt->format('c') ?>">
    <div class="countdown-label">
      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12a5 5 0 0 0 5 5 8 8 0 0 1 5 2 8 8 0 0 1 5-2 5 5 0 0 0 5-5V7h-5a8 8 0 0 0-5 2 8 8 0 0 0-5-2H2Z"/><path d="M6 11c1.5 0 3 .5 3 2-2 0-3 0-3-2Z"/><path d="M18 11c-1.5 0-3 .5-3 2 2 0 3 0 3-2Z"/></svg>
      Next Event
    </div>
    <div class="countdown-event-name"><?= htmlspecialchars($nextEvent['nama_acara']) ?></div>
    <div class="countdown-timer">
      <div class="cd-unit"><span class="cd-num" id="cdDays">--</span><span class="cd-text">Hari</span></div>
      <div class="cd-sep">:</div>
      <div class="cd-unit"><span class="cd-num" id="cdHours">--</span><span class="cd-text">Jam</span></div>
      <div class="cd-sep">:</div>
      <div class="cd-unit"><span class="cd-num" id="cdMins">--</span><span class="cd-text">Menit</span></div>
      <div class="cd-sep">:</div>
      <div class="cd-unit"><span class="cd-num" id="cdSecs">--</span><span class="cd-text">Detik</span></div>
    </div>
  </div>
  <?php endif; ?>

  <div class="stats-block">
    <div class="stat-item">
      <span class="stat-num"><?= count($posts ?? []) ?></span>
      <span class="stat-label">Berita</span>
    </div>
    <div class="stat-sep"></div>
    <div class="stat-item">
      <span class="stat-num"><?= count($upcoming ?? []) ?>+</span>
      <span class="stat-label">Event</span>
    </div>
    <div class="stat-sep"></div>
    <div class="stat-item">
      <span class="stat-num">48</span>
      <span class="stat-label">Member</span>
    </div>
    <div class="stat-sep"></div>
    <div class="stat-item">
      <span class="stat-num">&#8734;</span>
      <span class="stat-label">Wota</span>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     SLIDESHOW
     ══════════════════════════════════════ -->
<section class="slideshow-section">
  <div class="section-header">
    <h2>Seputar JKT48</h2>
    <span class="section-pill">Terbaru</span>
  </div>

  <div class="slideshow-wrap">
    <div class="slide-main" id="slideMain">
      <div class="slides" id="slides">
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/QtdsUJxiwNM" title="[MV] Dekat Namun Jauh - JKT48 Team Passion" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/n3EpgnAqlvE" title="[MV] WAKAKA PEOPLE - JKT48 Team Dream" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/9iWB3ZuXOz8" title="[MV] 12 Seconds - JKT48 Team Love" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/88HhRpQIMcs" title="Shonichi Special Setlist Passion 200% - JKT48 Team Passion" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/JJHDaxE6-4g" title="Shonichi Special Setlist Dream Bakudan - JKT48 Team Dream" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="slide-frame">
          <iframe width="815" height="458" src="https://www.youtube.com/embed/_R8561X2GIg" title="Shonichi Special Setlist ITADAKI LOVE - JKT48 Team Love" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>

      <button class="slide-btn slide-btn-prev" onclick="slidePrev()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
      </button>
      <button class="slide-btn slide-btn-next" onclick="slideNext()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
      </button>
    </div>

    <div class="slide-sidebar">
      <div class="slide-progress-wrap" id="slideProgress"></div>
      <div class="slide-counter">
        <span id="slideCurrentNum">01</span>
        <span class="slide-counter-sep">/</span>
        <span class="slide-counter-total">06</span>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     EDITORIAL — JELAJAHI FANSITE
     ══════════════════════════════════════ -->
<section class="editorial-section">
  <div class="editorial-inner">

    <div class="editorial-header">
      <span class="editorial-eyebrow">Navigasi</span>
      <h2 class="editorial-title">Jelajahi<br><em>Fansite</em></h2>
      <p class="editorial-sub">Semua yang kamu butuhkan, dalam satu tempat.</p>
    </div>

    <div class="editorial-list">
      <a href="index.php?act=berita" class="editorial-item">
        <span class="editorial-num">01</span>
        <div class="editorial-item-body">
          <span class="editorial-item-name">Berita</span>
          <span class="editorial-item-desc">Informasi terkini seputar JKT48 — konser, rilis single, dan update resmi langsung dari sumber terpercaya.</span>
        </div>
        <span class="editorial-item-cta">
          Baca
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
        </span>
      </a>

      <a href="index.php?act=galeri" class="editorial-item">
        <span class="editorial-num">02</span>
        <div class="editorial-item-body">
          <span class="editorial-item-name">Galeri</span>
          <span class="editorial-item-desc">Koleksi foto eksklusif member JKT48 dari berbagai event, konser, dan momen spesial.</span>
        </div>
        <span class="editorial-item-cta">
          Lihat
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
        </span>
      </a>

      <a href="index.php?act=jadwal" class="editorial-item">
        <span class="editorial-num">03</span>
        <div class="editorial-item-body">
          <span class="editorial-item-name">Jadwal</span>
          <span class="editorial-item-desc">Agenda dan jadwal event JKT48 terbaru. Jangan sampai ketinggalan pertunjukan favoritmu.</span>
        </div>
        <span class="editorial-item-cta">
          Cek
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
        </span>
      </a>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════
     BERITA TERBARU
     ══════════════════════════════════════ -->
<?php
// Strip emoji dari string — bersihkan judul sebelum ditampilkan di card
function strip_emoji(string $str): string {
  $str = preg_replace(
    '/[\x{1F000}-\x{1FFFF}]|[\x{2600}-\x{27BF}]|[\x{FE00}-\x{FE0F}]|[\x{20D0}-\x{20FF}]|\x{200D}/u',
    '',
    $str
  );
  return trim($str);
}
?>
<?php if (!empty($posts)): ?>
<section class="latest-section">
  <div class="section-header">
    <h2>Berita Terbaru</h2>
    <a href="index.php?act=berita" class="section-link">Lihat semua →</a>
  </div>
  <div class="latest-grid">
    <?php foreach (array_slice($posts, 0, 3) as $i => $p):
      $dt    = new DateTime($p['tanggal_terbit']);
      $judul = strip_emoji($p['judul']);
      $foto     = !empty($p['foto']) ? htmlspecialchars($p['foto'], ENT_QUOTES) : '';
      $bgStyle  = $foto ? "background-image: url('{$foto}');" : '';
      $thumbStyle = $foto ? "background-image: url('{$foto}');" : '';
    ?>
    <div class="latest-card"
         style="--card-index:<?= $i ?>; <?= $bgStyle ?>"
         onclick="window.location='index.php?act=berita'">
      <div class="latest-card-thumb" style="<?= $thumbStyle ?>"></div>
      <div class="latest-card-overlay"></div>
      <?php if (empty($p['foto'])): ?>
        <div class="latest-card-no-img"></div>
      <?php endif; ?>
      <div class="latest-card-body">
        <div class="latest-card-date"><?= $dt->format('d M Y') ?></div>
        <div class="latest-card-title"><?= htmlspecialchars($judul) ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════════════════
     SONG OF THE DAY
     ══════════════════════════════════════ -->
<section class="song-section">
  <div class="section-header centered">
    <h2>Lagu Hari Ini</h2>
  </div>
  <div class="song-card">
    <div class="song-top">
      <span class="song-badge">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        Now Playing
      </span>
      <span class="song-title">Flying High</span>
    </div>
    <div class="video-frame">
      <iframe width="815" height="458" src="https://www.youtube.com/embed/eq0s1atl_K0" title="[MV] Flying High - JKT48" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
    <p class="song-desc">
      Flying High adalah lagu original kedua JKT48 yang dirilis pada 17 Juni 2022. Dengan nuansa EDM dan hip-hop yang cerah, lagu ini menyampaikan semangat optimis untuk melayang lebih tinggi. Cocok jadi semangat harimu!
    </p>
  </div>
</section>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">&#9829;</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
</body>
</html>