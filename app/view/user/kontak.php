<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/kontak.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="kontak-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>

  <div class="kontak-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      ✦ Hubungi Kami
    </div>
    <h1>Kontak & <em>Saran</em></h1>
    <p>Temukan kami di sosial media atau kirimkan saran untuk fansite ini.</p>
  </div>
  <div class="kontak-hero-deco">💬✨💖📱</div>
</div>

<section class="kontak-section">

  <!-- SOSMED -->
  <div class="kontak-block">
    <div class="kontak-block-header">
      <div class="block-header-badge">📱 Sosial Media</div>
      <h2>Temukan Kami</h2>
      <p>Follow dan ikuti update terbaru JKT48 Fansite di sosial media kami.</p>
    </div>

    <div class="sosmed-grid">

      <!-- Instagram -->
      <a href="https://instagram.com/maaeeenggg/" target="_blank" rel="noopener"
         class="sosmed-card sosmed-ig" style="--card-index:0;">
        <div class="sosmed-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke="currentColor" stroke-width="2"/>
            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/>
            <circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/>
          </svg>
        </div>
        <div class="sosmed-info">
          <div class="sosmed-name">Instagram</div>
          <div class="sosmed-handle">@maaeeenggg</div>
        </div>
        <div class="sosmed-arrow">↗</div>
      </a>

      <!-- X / Twitter -->
      <a href="https://x.com/Takeru_90" target="_blank" rel="noopener"
         class="sosmed-card sosmed-x" style="--card-index:1;">
        <div class="sosmed-icon-wrap">
          <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
          </svg>
        </div>
        <div class="sosmed-info">
          <div class="sosmed-name">X (Twitter)</div>
          <div class="sosmed-handle">@Takeru_90</div>
        </div>
        <div class="sosmed-arrow">↗</div>
      </a>

      <!-- TikTok -->
      <a href="https://tiktok.com/@siszz.0" target="_blank" rel="noopener"
         class="sosmed-card sosmed-tiktok" style="--card-index:2;">
        <div class="sosmed-icon-wrap">
          <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/>
          </svg>
        </div>
        <div class="sosmed-info">
          <div class="sosmed-name">TikTok</div>
          <div class="sosmed-handle">@siszz.0</div>
        </div>
        <div class="sosmed-arrow">↗</div>
      </a>

    </div>
  </div>

  <!-- KOTAK SARAN -->
  <div class="kontak-block">
    <div class="kontak-block-header">
      <div class="block-header-badge">💬 Feedback</div>
      <h2>Kotak Saran</h2>
      <p>Ada masukan, kritik, atau saran untuk fansite ini? Aku sangat terbuka! Saranmu membantu fansite ini jadi lebih baik. 🌸</p>
    </div>

    <?php if ($flash): ?>
    <div class="saran-flash saran-flash-<?= $flash['type'] ?>" id="saranFlash">
      <span><?= htmlspecialchars($flash['msg']) ?></span>
      <button onclick="this.parentElement.remove()">×</button>
    </div>
    <?php endif; ?>

    <div class="saran-form-wrap">
      <form method="POST" action="index.php?act=kirim-saran" class="saran-form">

        <div class="saran-form-group">
          <label for="nama">Nama Kamu <span class="req">*</span></label>
          <input type="text" id="nama" name="nama"
                 placeholder="Boleh nama asli atau nickname..."
                 maxlength="200" required
                 value="<?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '' ?>"/>
        </div>

        <div class="saran-form-group">
          <label for="pesan">Saran / Masukan <span class="req">*</span></label>
          <textarea id="pesan" name="pesan"
                    placeholder="Ceritakan apa yang bisa diperbaiki, fitur yang ingin ditambah, atau apapun yang ada di pikiranmu..."
                    maxlength="2000" required></textarea>
          <div class="saran-char-count">
            <span id="charCount">0</span> / 2000 karakter
          </div>
        </div>

        <button type="submit" class="saran-submit-btn">
          <span>Kirim Saran</span>
          <span class="saran-btn-icon">💌</span>
        </button>

      </form>

      <!-- Ilustrasi kanan -->
      <div class="saran-illo">
        <div class="saran-illo-card">
          <div class="saran-illo-icon">💌</div>
          <p>Setiap saran sangat berarti untuk pengembangan fansite ini!</p>
          <div class="saran-illo-divider"></div>
          <div class="saran-illo-stats">
            <div class="illo-stat">
              <span class="illo-stat-icon">🔒</span>
              <span>Pesanmu privat, hanya dibaca admin</span>
            </div>
            <div class="illo-stat">
              <span class="illo-stat-icon">💝</span>
              <span>Semua saran dibaca dengan sepenuh hati</span>
            </div>
            <div class="illo-stat">
              <span class="illo-stat-icon">⚡</span>
              <span>Respon cepat untuk saran terpilih</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/kontak.js"></script>
</body>
</html>