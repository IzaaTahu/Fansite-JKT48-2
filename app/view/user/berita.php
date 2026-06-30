<?php
/**
 * Strip emoji dari judul berita sebelum render.
 * Kalau project punya functions.php terpusat, pindahin ke sana.
 */
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
  <title>Berita — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/berita.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Cormorant+Garamond:wght@300;400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="berita-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="berita-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      JKT48 News
    </div>
    <h1>Berita &amp; <span class="hero-h1-accent">Update</span></h1>
    <p>Info terbaru seputar JKT48 — konser, rilis single, dan aktivitas member.</p>
  </div>
</div>

<!-- SEARCH -->
<div class="berita-controls">
  <div class="berita-search-wrap">
    <span class="search-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
    </span>
    <input type="text" id="searchInput"
           placeholder="Cari judul berita..."
           oninput="filterBerita()"/>
    <button class="search-clear" id="searchClear" onclick="clearSearch()" style="display:none;">×</button>
  </div>
</div>

<!-- CONTENT -->
<section class="berita-section">
  <?php if (empty($posts)): ?>
    <div class="berita-empty">
      <div class="berita-empty-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
      </div>
      <h3>Belum Ada Berita</h3>
      <p>Admin belum memposting berita. Cek lagi nanti ya!</p>
    </div>

  <?php else:
    $featured = $posts[0];
    $featured['judul'] = bersihkan_emoji($featured['judul']);
    $rest = array_slice($posts, 1);
  ?>

    <!-- FEATURED POST -->
    <div class="berita-featured"
         id="featuredCard"
         data-title="<?= strtolower(htmlspecialchars($featured['judul'])) ?>"
         onclick="openModal(<?= htmlspecialchars(json_encode($featured), ENT_QUOTES) ?>)">

      <div class="featured-img-wrap">
        <?php if (!empty($featured['foto'])): ?>
          <img src="<?= htmlspecialchars($featured['foto']) ?>"
               alt="<?= htmlspecialchars($featured['judul']) ?>"
               class="featured-img"/>
        <?php else: ?>
          <div class="featured-img-placeholder">
            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
          </div>
        <?php endif; ?>
        <div class="featured-img-overlay"></div>
      </div>

      <div class="featured-body">
        <div class="featured-top">
          <div class="featured-badge">
            <span class="featured-badge-dot"></span>
            Terbaru
          </div>
          <div class="featured-date">
            <?= (new DateTime($featured['tanggal_terbit']))->format('d M Y') ?>
          </div>
        </div>
        <h2 class="featured-title"><?= htmlspecialchars($featured['judul']) ?></h2>
        <p class="featured-excerpt">
          <?= htmlspecialchars(mb_substr(strip_tags($featured['isi']), 0, 220)) ?>…
        </p>
        <div class="featured-footer">
          <div class="featured-author">
            <div class="author-avatar">
              <?= strtoupper(substr($featured['nama_penulis'] ?? 'A', 0, 1)) ?>
            </div>
            <span><?= htmlspecialchars($featured['nama_penulis'] ?? 'Admin') ?></span>
          </div>
          <div class="featured-cta">
            Baca Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="featured-cta-arrow"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </div>
        </div>
      </div>
    </div>

    <!-- GRID BERITA LAINNYA -->
    <?php if (!empty($rest)): ?>
    <div class="berita-grid-wrap">
      <div class="berita-grid-header">
        <h3 class="berita-grid-title">Berita Lainnya</h3>
        <div class="berita-grid-line"></div>
      </div>
      <div class="berita-grid" id="beritaGrid">
        <?php foreach ($rest as $i => $p): $p['judul'] = bersihkan_emoji($p['judul']); ?>
        <div class="berita-card"
             data-title="<?= strtolower(htmlspecialchars($p['judul'])) ?>"
             style="--card-index: <?= $i ?>;"
             onclick="openModal(<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>)">

          <div class="berita-card-thumb">
            <?php if (!empty($p['foto'])): ?>
              <img src="<?= htmlspecialchars($p['foto']) ?>"
                   alt="<?= htmlspecialchars($p['judul']) ?>"
                   loading="lazy"/>
            <?php else: ?>
              <div class="berita-card-thumb-ph">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
              </div>
            <?php endif; ?>
          </div>

          <div class="berita-card-body">
            <div class="berita-card-title"><?= htmlspecialchars($p['judul']) ?></div>
            <div class="berita-card-excerpt">
              <?= htmlspecialchars(mb_substr(strip_tags($p['isi']), 0, 110)) ?>…
            </div>
            <div class="berita-card-meta">
              <div class="author-avatar author-avatar-sm">
                <?= strtoupper(substr($p['nama_penulis'] ?? 'A', 0, 1)) ?>
              </div>
              <span><?= htmlspecialchars($p['nama_penulis'] ?? 'Admin') ?></span>
              <span class="meta-dot">·</span>
              <span><?= (new DateTime($p['tanggal_terbit']))->format('d M Y') ?></span>
            </div>
          </div>

          <div class="berita-card-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </div>
          <div class="berita-card-shimmer"></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="berita-no-result" id="noResult" style="display:none;">
      <div class="berita-empty-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      </div>
      <h3>Berita Tidak Ditemukan</h3>
      <p>Coba kata kunci yang berbeda.</p>
    </div>

  <?php endif; ?>
</section>

<!-- MODAL -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="berita-modal" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
    </button>

    <div class="bmodal-foto-wrap" id="bmodalFotoWrap" style="display:none;">
      <img id="bmodalFoto" src="" alt="" class="bmodal-foto"/>
      <div class="bmodal-foto-overlay"></div>
    </div>

    <div class="bmodal-main">
      <div class="bmodal-header">
        <div class="bmodal-badge">Berita</div>
        <h2 class="bmodal-title" id="bmodalTitle"></h2>
        <div class="bmodal-meta">
          <div class="author-avatar author-avatar-sm" id="bmodalAuthorAvatar"></div>
          <span id="bmodalAuthor"></span>
          <span class="meta-dot">·</span>
          <span id="bmodalDate"></span>
        </div>
      </div>
      <div class="bmodal-divider"></div>
      <div class="bmodal-body" id="bmodalBody"></div>
      <div class="bmodal-footer">
        <button class="bmodal-close-btn" onclick="closeModal()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">&#9829;</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/berita.js"></script>
</body>
</html>