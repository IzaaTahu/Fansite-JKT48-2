<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Member — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/member.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<!-- NAVBAR -->
<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="member-hero">
  <div class="member-hero-content">
    <div class="hero-badge">✦ JKT48 Members</div>
    <h1>Kenali Para <em>Member</em></h1>
    <p>Temukan member favoritmu dan lihat profil lengkap mereka.</p>
  </div>
  <div class="member-hero-deco">🌸✨💖🎵⭐</div>
</div>

<!-- FILTER & SEARCH -->
<div class="member-controls">
  <div class="member-search-wrap">
    <input type="text" id="searchInput"
           placeholder="🔍 Cari nama member..."
           oninput="filterCards()"/>
  </div>
  <div class="member-filter-wrap">
    <span class="filter-label">Filter Generasi:</span>
    <div class="filter-pills">
      <button class="filter-pill active" data-gen="all" onclick="setFilter(this)">Semua</button>
      <?php
        $gens = array_unique(array_column($members, 'gen'));
        sort($gens);
        foreach ($gens as $g): ?>
        <button class="filter-pill" data-gen="<?= htmlspecialchars($g) ?>"
                onclick="setFilter(this)"><?= htmlspecialchars($g) ?></button>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- MEMBER GRID -->
<section class="member-section">
  <?php if (empty($members)): ?>
    <div class="member-empty">
      <div class="member-empty-icon">👩‍🎤</div>
      <h3>Belum Ada Data Member</h3>
      <p>Admin belum menambahkan member. Cek lagi nanti ya!</p>
    </div>
  <?php else: ?>
    <div class="member-count" id="memberCount">
      Menampilkan <strong><?= count($members) ?></strong> member
    </div>

    <div class="member-grid" id="memberGrid">
      <?php foreach ($members as $m): ?>
      <div class="member-card"
           data-gen="<?= htmlspecialchars($m['gen']) ?>"
           data-name="<?= strtolower(htmlspecialchars($m['nama_member'])) ?>"
           onclick="openModal(<?= htmlspecialchars(json_encode($m), ENT_QUOTES) ?>)">

        <div class="card-photo-wrap">
          <?php if (!empty($m['foto'])): ?>
            <!-- Card depan: foto kabesha/resmi -->
            <img src="<?= htmlspecialchars($m['foto']) ?>"
                 alt="<?= htmlspecialchars($m['nama_member']) ?>"
                 class="card-photo"/>
          <?php else: ?>
            <div class="card-photo-placeholder">👤</div>
          <?php endif; ?>
          <div class="card-gen-badge"><?= htmlspecialchars($m['gen']) ?></div>
          <div class="card-hover-overlay">
            <span class="card-hover-text">Lihat Profil →</span>
          </div>
        </div>

        <div class="card-info">
          <div class="card-name"><?= htmlspecialchars($m['nama_member']) ?></div>
          <div class="card-asal">📍 <?= htmlspecialchars($m['asal']) ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="member-no-result" id="noResult" style="display:none;">
      <div class="member-empty-icon">🔍</div>
      <h3>Member Tidak Ditemukan</h3>
      <p>Coba kata kunci atau filter yang berbeda.</p>
    </div>
  <?php endif; ?>
</section>

<!-- MODAL POPUP -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="modal-box" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal()">×</button>

    <div class="modal-inner">
      <!-- Kiri: Foto casual -->
      <div class="modal-photo-side">
        <div class="modal-photo-wrap" id="modalPhotoWrap"></div>
        <div class="modal-gen-tag" id="modalGen"></div>

        <!-- Indikator foto casual -->
        <div class="modal-foto-note" id="modalFotoNote"></div>
      </div>

      <!-- Kanan: Info -->
      <div class="modal-info-side">
        <div class="modal-name-wrap">
          <p class="modal-label">Nama Member</p>
          <h2 class="modal-name" id="modalName"></h2>
        </div>

        <div class="modal-stats">
          <div class="modal-stat">
            <span class="modal-stat-icon">📅</span>
            <div>
              <div class="modal-stat-label">Tanggal Lahir</div>
              <div class="modal-stat-val" id="modalTglLahir"></div>
            </div>
          </div>
          <div class="modal-stat">
            <span class="modal-stat-icon">📍</span>
            <div>
              <div class="modal-stat-label">Asal</div>
              <div class="modal-stat-val" id="modalAsal"></div>
            </div>
          </div>
          <div class="modal-stat">
            <span class="modal-stat-icon">✨</span>
            <div>
              <div class="modal-stat-label">Generasi</div>
              <div class="modal-stat-val" id="modalGenStat"></div>
            </div>
          </div>
        </div>

        <div class="modal-desc-wrap">
          <p class="modal-label">Bio</p>
          <p class="modal-desc" id="modalDesc"></p>
        </div>

        <!-- Tombol oshimen (hanya kalau sudah login) -->
        <div id="modalOshiWrap" style="display:none;">
          <form method="POST" action="index.php?act=update-oshimen">
            <input type="hidden" name="id_member" id="modalOshiId"/>
            <button type="submit" class="modal-oshi-btn" id="modalOshiBtn">
              💗 Jadikan Oshimen
            </button>
          </form>
        </div>

        <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="modal-login-hint">
          <a href="index.php?act=login">Login</a> untuk menjadikan member ini oshimenmu!
        </div>
        <?php endif; ?>
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
const currentOshiId = <?= json_encode($_SESSION['oshimen'] ?? null) ?>;
const isLoggedIn    = <?= json_encode(isset($_SESSION['user_id'])) ?>;

function openModal(m) {
  const photoWrap = document.getElementById('modalPhotoWrap');
  const fotoNote  = document.getElementById('modalFotoNote');

  // Popup pakai foto_casual kalau ada, fallback ke foto kabesha
  const fotoPopup = m.foto_casual || m.foto;

  if (fotoPopup) {
    photoWrap.innerHTML = `<img src="${fotoPopup}" alt="${m.nama_member}" class="modal-photo"/>`;
    // Kasih keterangan kecil kalau foto yang tampil
    if (m.foto_casual) {
      fotoNote.textContent = '📸 Foto casual';
      fotoNote.style.display = 'block';
    } else {
      fotoNote.textContent = '📸 Foto resmi';
      fotoNote.style.display = 'block';
    }
  } else {
    photoWrap.innerHTML = `<div class="modal-photo-placeholder">👤</div>`;
    fotoNote.style.display = 'none';
  }

  document.getElementById('modalName').textContent    = m.nama_member;
  document.getElementById('modalGen').textContent     = m.gen;
  document.getElementById('modalGenStat').textContent = m.gen;
  document.getElementById('modalAsal').textContent    = m.asal;
  document.getElementById('modalDesc').textContent    = m.deskripsi;

  if (m.tanggal_lahir) {
    const d = new Date(m.tanggal_lahir);
    document.getElementById('modalTglLahir').textContent =
      d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
  }

  if (isLoggedIn) {
    document.getElementById('modalOshiWrap').style.display = 'block';
    document.getElementById('modalOshiId').value           = m.id_member;
    const btn = document.getElementById('modalOshiBtn');
    if (currentOshiId && parseInt(currentOshiId) === parseInt(m.id_member)) {
      btn.innerHTML  = '👑 Ini Oshimenmu!';
      btn.classList.add('is-oshi');
      btn.disabled   = true;
    } else {
      btn.innerHTML  = '💗 Jadikan Oshimen';
      btn.classList.remove('is-oshi');
      btn.disabled   = false;
    }
  }

  document.getElementById('modalBackdrop').classList.add('open');
  const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
  if (scrollBarWidth > 0) {
    document.body.style.paddingRight = `${scrollBarWidth}px`;
  }
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
  document.body.style.overflow = '';
  document.body.style.paddingRight = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

let activeGen = 'all', activeSearch = '';

function setFilter(btn) {
  document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  activeGen = btn.dataset.gen;
  applyFilter();
}

function filterCards() {
  activeSearch = document.getElementById('searchInput').value.toLowerCase();
  applyFilter();
}

function applyFilter() {
  const cards = document.querySelectorAll('.member-card');
  let visible = 0;
  cards.forEach(card => {
    const show = (activeGen === 'all' || card.dataset.gen === activeGen)
              && card.dataset.name.includes(activeSearch);
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('memberCount').innerHTML =
    `Menampilkan <strong>${visible}</strong> member`;
  document.getElementById('noResult').style.display    = visible === 0 ? 'block' : 'none';
  document.getElementById('memberGrid').style.display  = visible === 0 ? 'none'  : '';
}
</script>
</body>
</html>