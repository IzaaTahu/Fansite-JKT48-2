<?php
/**
 * Hapus emoji/simbol dekoratif dari teks — terutama judul berita.
 *
 * Ini bukan fix tampilan, ini safety net di level kode: judul artikel
 * datang dari database (ditulis admin lewat panel posting), bukan dari
 * markup ini. Nggak peduli berapa sering emoji nempel di judul pas
 * nulis berita, publik nggak akan pernah lihat itu tampil — fungsi ini
 * yang nyaring di titik render, sekali untuk semua.
 *
 * Kalau project ini punya file functions.php / helpers.php terpusat,
 * pindahin fungsi ini ke sana supaya bisa dipakai ulang di home.php
 * (latest-section juga nampilin judul dari sumber yang sama).
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
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
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
      <!-- POIN 1 (lanjutan): sparkle SVG sebelumnya masih kebaca sebagai
           dekorasi, sama kategorinya dengan unicode ✦ yang udah dibuang.
           Disederhanakan total — dot pulsing ini fungsional (nandain
           "live/baru"), bukan ornamen, jadi dipertahankan sendirian. -->
      JKT48 News
    </div>
    <h1>Berita & <em>Update</em></h1>
    <p>Info terbaru seputar JKT48 — konser, rilis single, dan aktivitas member.</p>
  </div>
  <div class="berita-hero-deco">📰✨💖🎵</div>
</div>

<!-- SEARCH -->
<div class="berita-controls">
  <div class="berita-search-wrap">
    <span class="search-icon">🔍</span>
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
      <div class="berita-empty-icon">📭</div>
      <h3>Belum Ada Berita</h3>
      <p>Admin belum memposting berita. Cek lagi nanti ya!</p>
    </div>

  <?php else:
    $featured = $posts[0];
    // POIN 1: strip emoji dari judul SEBELUM dipakai di mana pun —
    // attribute data-title, htmlspecialchars(), maupun json_encode()
    // buat modal. Satu titik bersih, semua turunan otomatis ikut bersih.
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
          <div class="featured-img-placeholder">📰</div>
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
            <span class="featured-cta-arrow">→</span>
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
              <div class="berita-card-thumb-ph">📄</div>
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

          <div class="berita-card-arrow">→</div>
          <div class="berita-card-shimmer"></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="berita-no-result" id="noResult" style="display:none;">
      <div class="berita-empty-icon">🔍</div>
      <h3>Berita Tidak Ditemukan</h3>
      <p>Coba kata kunci yang berbeda.</p>
    </div>

  <?php endif; ?>
</section>

<!-- MODAL -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="berita-modal" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal()">×</button>

    <div class="bmodal-foto-wrap" id="bmodalFotoWrap" style="display:none;">
      <img id="bmodalFoto" src="" alt="" class="bmodal-foto"/>
      <div class="bmodal-foto-overlay"></div>
    </div>

    <div class="bmodal-main">
      <div class="bmodal-header">
        <div class="bmodal-badge">📰 Berita</div>
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
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/berita.js"></script>
</body>
</html>