<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

  <!-- FLOATING DECORATIONS -->
  <div class="floaties" id="floaties"></div>

  <!-- NAVBAR — standalone, tidak pakai include side.php -->
  <header>
    <?php include 'components/nav.php'; ?>
  </header>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-left">
      <div class="hero-badge">✦ Official Fan Community</div>
      <h1>Selamat Datang di<br><em>Fansite JKT48</em></h1>
      <p class="hero-subtitle">Tempat berkumpulnya para Wota untuk berbagi info, cerita, dan dukungan bersama.</p>
      <a href="index.php?act=member" class="hero-cta">Jelajahi Sekarang ↗</a>
    </div>
    <div class="hero-right">
      <div class="captain-card">
        <div class="captain-img-wrap">
          <img src="public/images/member/Team Dream/Kabesha/freya_jayawardana.jpg" alt="Freya Jayawardana - Kapten JKT48" />
        </div>
        <div class="captain-name">Freya Jayawardana</div>
        <div class="captain-role">Kapten JKT48</div>
        <div class="captain-quote-bubble">
          "Gadis koleris yang suka berimajinasi, terangi harimu dengan senyuman karamelku. Hai, aku Freya!!"
        </div>
      </div>
    </div>
  </section>

  <!-- SLIDESHOW -->
  <section class="slideshow-section">
    <div class="section-header">
      <h2>Event &amp; Aktivitas</h2>
      <span class="section-pill">Terbaru</span>
    </div>
    <div class="slide-wrap">
      <div class="slides" id="slides">
        <div class="slide-frame">
          <a href="#"><img src="public/images/pengumuman-mengenai-timetable-jkt48-personal-meet-and-greet-festival-love-dream-passion-df75e1.png" alt="Event 1" /></a>
          <div class="slide-overlay"><span class="slide-label">Meet &amp; Greet Festival Love Dream Passion</span></div>
        </div>
        <div class="slide-frame">
          <a href="#"><img src="public/images/jtrustbank.webp" alt="Event 2" /></a>
          <div class="slide-overlay"><span class="slide-label">J Trust Bank × JKT48</span></div>
        </div>
        <div class="slide-frame">
          <a href="#"><img src="public/images/jkt48v.jpg" alt="Event 3" /></a>
          <div class="slide-overlay"><span class="slide-label">JKT48V</span></div>
        </div>
        <div class="slide-frame">
          <a href="#"><img src="public/images/valkyrie.jpg" alt="Event 4" /></a>
          <div class="slide-overlay"><span class="slide-label">Valkyrie</span></div>
        </div>
        <div class="slide-frame">
          <a href="#"><img src="public/images/ofc.jpg" alt="Event 5" /></a>
          <div class="slide-overlay"><span class="slide-label">Official Event</span></div>
        </div>
        <div class="slide-frame">
          <a href="#"><img src="public/images/tokped.jpg" alt="Event 6" /></a>
          <div class="slide-overlay"><span class="slide-label">Tokopedia × JKT48</span></div>
        </div>
      </div>
    </div>
    <div class="dots" id="dots"></div>
  </section>

  <!-- FEATURE CARDS -->
  <section class="features-section">
    <div class="section-header">
      <h2>Jelajahi Fansite</h2>
    </div>
    <div class="cards-grid">
      <a href="index.php?act=berita" class="feat-card">
        <div class="feat-icon news-icon">📰</div>
        <h3>Berita Terbaru</h3>
        <p>Informasi terkini seputar JKT48 — konser, rilis single, dan update resmi.</p>
        <span class="feat-arrow">Baca selengkapnya →</span>
      </a>
      <a href="index.php?act=galeri" class="feat-card">
        <div class="feat-icon gallery-icon">🖼️</div>
        <h3>Galeri Foto</h3>
        <p>Koleksi foto-foto eksklusif member JKT48 dari berbagai event.</p>
        <span class="feat-arrow">Lihat galeri →</span>
      </a>
      <a href="index.php?act=jadwal" class="feat-card">
        <div class="feat-icon schedule-icon">📅</div>
        <h3>Jadwal Event</h3>
        <p>Agenda dan jadwal event JKT48 terbaru agar kamu tidak ketinggalan.</p>
        <span class="feat-arrow">Cek jadwal →</span>
      </a>
    </div>
  </section>

  <!-- SONG OF THE DAY -->
  <section class="song-section">
    <div class="section-header centered">
      <h2>Lagu Hari Ini</h2>
    </div>
    <div class="song-card">
      <div class="song-meta">
        <span class="song-badge">🎵 Now Playing</span>
        <span class="song-title">Flying High</span>
      </div>
      <div class="video-frame">
        <video controls>
          <source src="public/video/flying small.mp4" type="video/mp4">
          Browser kamu tidak mendukung video HTML5.
        </video>
      </div>
      <p class="song-desc">
        Flying High adalah lagu original kedua JKT48 yang dirilis pada 17 Juni 2022. Dengan nuansa EDM dan hip‑hop yang cerah, serta lirik bahasa Inggris penuh, lagu ini menyampaikan semangat optimis untuk melayang lebih tinggi. MV-nya yang diambil di lokasi ikonik Tokyo memperkuat estetika modern dan koreografi energik senbatsu JKT48. Cocok jadi suasana penuh semangat di hari kamu!
      </p>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
  </footer>

  <script src="public/js/home.js"></script>
</body>
</html>