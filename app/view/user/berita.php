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

<!-- NAVBAR -->
<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="berita-hero">
  <div class="berita-hero-content">
    <div class="hero-badge">✦ JKT48 News</div>
    <h1>Berita & <em>Update</em></h1>
    <p>Info terbaru seputar JKT48 — konser, rilis single, dan aktivitas member.</p>
  </div>
  <div class="berita-hero-deco">📰✨💖🎵</div>
</div>

<!-- SEARCH -->
<div class="berita-controls">
  <input type="text" id="searchInput"
         placeholder="🔍 Cari judul berita..."
         oninput="filterBerita()"/>
</div>

<!-- CONTENT -->
<section class="berita-section">
  <?php if (empty($posts)): ?>
    <div class="berita-empty">
      <div class="berita-empty-icon">📭</div>
      <h3>Belum Ada Berita</h3>
      <p>Admin belum memposting berita. Cek lagi nanti ya!</p>
    </div>

  <?php else: ?>
    <?php
      $featured = $posts[0];
      $rest     = array_slice($posts, 1);
    ?>

    <!-- ── FEATURED POST ── -->
    <div class="berita-featured"
         id="featuredCard"
         data-title="<?= strtolower(htmlspecialchars($featured['judul'])) ?>"
         onclick="openModal(<?= htmlspecialchars(json_encode($featured), ENT_QUOTES) ?>)">

      <!-- Foto featured -->
      <div class="featured-img-wrap">
        <?php if (!empty($featured['foto'])): ?>
          <img src="<?= htmlspecialchars($featured['foto']) ?>"
               alt="<?= htmlspecialchars($featured['judul']) ?>"
               class="featured-img"/>
        <?php else: ?>
          <div class="featured-img-placeholder">
            <span>📰</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Teks -->
      <div class="featured-body">
        <div class="featured-badge">📌 Terbaru</div>
        <h2 class="featured-title"><?= htmlspecialchars($featured['judul']) ?></h2>
        <p class="featured-excerpt">
          <?= htmlspecialchars(mb_substr(strip_tags($featured['isi']), 0, 220)) ?>…
        </p>
        <div class="featured-meta">
          <span>✍️ <?= htmlspecialchars($featured['nama_penulis'] ?? 'Admin') ?></span>
          <span class="meta-dot">·</span>
          <span><?= (new DateTime($featured['tanggal_terbit']))->format('d M Y') ?></span>
        </div>
        <div class="featured-cta">Baca Selengkapnya →</div>
      </div>
    </div>

    <!-- ── GRID BERITA LAINNYA ── -->
    <?php if (!empty($rest)): ?>
    <div class="berita-grid-wrap">
      <h3 class="berita-grid-title">Berita Lainnya</h3>
      <div class="berita-grid" id="beritaGrid">
        <?php foreach ($rest as $p): ?>
        <div class="berita-card"
             data-title="<?= strtolower(htmlspecialchars($p['judul'])) ?>"
             onclick="openModal(<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>)">

          <!-- Thumbnail -->
          <div class="berita-card-thumb">
            <?php if (!empty($p['foto'])): ?>
              <img src="<?= htmlspecialchars($p['foto']) ?>"
                   alt="<?= htmlspecialchars($p['judul']) ?>"/>
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
              <span>✍️ <?= htmlspecialchars($p['nama_penulis'] ?? 'Admin') ?></span>
              <span class="meta-dot">·</span>
              <span><?= (new DateTime($p['tanggal_terbit']))->format('d M Y') ?></span>
            </div>
          </div>

          <div class="berita-card-arrow">→</div>
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

<!-- ── MODAL POPUP ── -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="berita-modal" onclick="event.stopPropagation()">

    <button class="modal-close" onclick="closeModal()">×</button>

    <!-- Foto sisi kiri -->
    <div class="bmodal-foto-wrap" id="bmodalFotoWrap" style="display:none;">
      <img id="bmodalFoto" src="" alt="" class="bmodal-foto"/>
      <div class="bmodal-foto-overlay"></div>
    </div>

    <div class="bmodal-main">
      <!-- Header teks -->
      <div class="bmodal-header" id="bmodalHeader">
        <div class="bmodal-badge">📰 Berita</div>
        <h2 class="bmodal-title" id="bmodalTitle"></h2>
        <div class="bmodal-meta">
          <span id="bmodalAuthor"></span>
          <span class="meta-dot">·</span>
          <span id="bmodalDate"></span>
        </div>
      </div>

      <div class="bmodal-divider"></div>

      <!-- Isi -->
      <div class="bmodal-body" id="bmodalBody"></div>

      <!-- Footer -->
      <div class="bmodal-footer">
        <button class="bmodal-close-btn" onclick="closeModal()">Tutup</button>
      </div>
    </div>

  </div>
</div>

<!-- FOOTER -->
<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script>
function openModal(p) {
  const fotoWrap = document.getElementById('bmodalFotoWrap');
  const fotoImg  = document.getElementById('bmodalFoto');

  if (p.foto) {
    fotoImg.src = p.foto;
    fotoImg.alt = p.judul;
    fotoWrap.style.display = '';
  } else {
    fotoImg.src = '';
    fotoImg.alt = '';
    fotoWrap.style.display = 'none';
  }

  // Teks
  document.getElementById('bmodalTitle').textContent  = p.judul;
  document.getElementById('bmodalAuthor').textContent = '✍️ ' + (p.nama_penulis || 'Admin');

  const d = new Date(p.tanggal_terbit);
  document.getElementById('bmodalDate').textContent =
    d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });

  document.getElementById('bmodalBody').innerHTML = p.isi;

  document.getElementById('modalBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
  document.querySelector('.berita-modal').scrollTop = 0;
}

function closeModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Search
function filterBerita() {
  const q        = document.getElementById('searchInput').value.toLowerCase();
  const featured = document.getElementById('featuredCard');
  let anyVisible = false;

  if (featured) {
    const show = featured.dataset.title.includes(q);
    featured.style.display = show ? '' : 'none';
    if (show) anyVisible = true;
  }

  document.querySelectorAll('.berita-card').forEach(card => {
    const show = card.dataset.title.includes(q);
    card.style.display = show ? '' : 'none';
    if (show) anyVisible = true;
  });

  document.getElementById('noResult').style.display = anyVisible ? 'none' : 'block';
}
</script>
</body>
</html>