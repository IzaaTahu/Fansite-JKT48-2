<?php
/**
 * Ikon halaman ini — bahasa visual sama dengan halaman lain:
 * kawaii-duotone, fill="currentColor", viewBox 0 0 24 24.
 */
$heart = '<path d="M20.84 3.61a5.5 5.5 0 0 0-7.78 0L12 4.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 20.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>';

// Hubungi Kami — chat bubble
$ICO_CHAT = '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 4h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4V6a2 2 0 0 1 2-2Z" opacity=".85"/><circle cx="8" cy="11" r="1.2" opacity=".5"/><circle cx="12" cy="11" r="1.2" opacity=".5"/><circle cx="16" cy="11" r="1.2" opacity=".5"/></svg>';

// Sosial media — phone/device
$ICO_PHONE = '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="7" y="2" width="10" height="20" rx="2.5" opacity=".3"/><rect x="7" y="2" width="10" height="15.5" rx="2.5" opacity=".85"/><circle cx="12" cy="19.3" r="1.1"/></svg>';

// Kotak saran — envelope/mail
$ICO_MAIL = '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2.5" opacity=".3"/><path d="M3 6.5 12 13l9-6.5" stroke="white" stroke-width="1.6" fill="none" opacity=".9"/><rect x="2" y="5" width="20" height="14" rx="2.5" fill="none" stroke="currentColor" stroke-width="0" opacity="0"/></svg>';

// Tombol kirim — paper plane
$ICO_SEND = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 11.5 21 3l-6.5 18-3.3-7.2L3 11.5Z" opacity=".9"/><path d="M11.2 13.8 21 3" stroke="white" stroke-width="1" opacity=".5"/></svg>';

// Ilustrasi kanan — envelope besar
$ICO_MAIL_LG = '<svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="3" opacity=".25"/><path d="M3 6.5 12 13l9-6.5" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>';

// Lock — privasi
$ICO_LOCK = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="5" y="11" width="14" height="9" rx="2" opacity=".85"/><path d="M8 11V8a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="2" fill="none"/></svg>';

// Heart-hand — dibaca dengan sepenuh hati
$ICO_HEART_SM = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">'.$heart.'</svg>';

// Lightning — respon cepat
$ICO_BOLT = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/></svg>';

function bersihkan_emoji(string $teks): string {
  $pattern = '/[\x{1F1E0}-\x{1F1FF}\x{1F300}-\x{1F5FF}\x{1F600}-\x{1F64F}'
           . '\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}'
           . '\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}'
           . '\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}'
           . '\x{2B00}-\x{2BFF}\x{2190}-\x{21FF}\x{2300}-\x{23FF}'
           . '\x{25A0}-\x{25FF}\x{FE0F}\x{200D}]/u';
  $teks = preg_replace($pattern, '', $teks);
  return trim(preg_replace('/\s+/', ' ', $teks));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/kontak.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Cormorant+Garamond:wght@300;400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>
<header><?php include 'components/nav.php'; ?></header>

<!-- HERO -->
<div class="kontak-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="kontak-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      Hubungi Kami
    </div>
    <h1>Kontak &amp; <span class="hero-h1-accent">Saran</span></h1>
    <p>Temukan kami di sosial media atau kirimkan saran untuk fansite ini.</p>
  </div>
</div>

<section class="kontak-section">

  <!-- SOSMED -->
  <div class="kontak-block">
    <div class="kontak-block-header">
      <div class="block-header-badge"><?= $ICO_PHONE ?> Sosial Media</div>
      <h2>Temukan Kami</h2>
      <p>Follow dan ikuti update terbaru JKT48 Fansite di sosial media kami.</p>
    </div>

    <div class="sosmed-grid">
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
        <div class="sosmed-arrow">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </div>
      </a>

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
        <div class="sosmed-arrow">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </div>
      </a>

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
        <div class="sosmed-arrow">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </div>
      </a>
    </div>
  </div>

  <!-- KOTAK SARAN -->
  <div class="kontak-block">
    <div class="kontak-block-header">
      <div class="block-header-badge"><?= $ICO_CHAT ?> Feedback</div>
      <h2>Kotak Saran</h2>
      <p>Ada masukan, kritik, atau saran untuk fansite ini? Aku sangat terbuka! Saranmu membantu fansite ini jadi lebih baik.</p>
    </div>

    <?php if ($flash): ?>
    <div class="saran-flash saran-flash-<?= $flash['type'] ?>" id="saranFlash">
      <span><?= htmlspecialchars($flash['msg']) ?></span>
      <button onclick="this.parentElement.remove()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
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
          <span class="saran-btn-icon"><?= $ICO_SEND ?></span>
        </button>
      </form>

      <div class="saran-illo">
        <div class="saran-illo-card">
          <div class="saran-illo-icon"><?= $ICO_MAIL_LG ?></div>
          <p>Setiap saran sangat berarti untuk pengembangan fansite ini!</p>
          <div class="saran-illo-divider"></div>
          <div class="saran-illo-stats">
            <div class="illo-stat">
              <span class="illo-stat-icon"><?= $ICO_LOCK ?></span>
              <span>Pesanmu privat, hanya dibaca admin</span>
            </div>
            <div class="illo-stat">
              <span class="illo-stat-icon"><?= $ICO_HEART_SM ?></span>
              <span>Semua saran dibaca dengan sepenuh hati</span>
            </div>
            <div class="illo-stat">
              <span class="illo-stat-icon"><?= $ICO_BOLT ?></span>
              <span>Respon cepat untuk saran terpilih</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">&#9829;</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/kontak.js"></script>
</body>
</html>