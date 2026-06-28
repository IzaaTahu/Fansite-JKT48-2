<?php
/**
 * Ikon yang dipakai di halaman ini — subset dari set yang sama
 * di nav.php dan jadwal.php. Kalau tampilannya beda, itu berarti
 * ada dua sumber kebenaran yang harus digabung.
 * Same bahasa: kawaii-duotone, fill="currentColor", viewBox 0 0 24 24.
 */
$heart = '<path d="M20.84 3.61a5.5 5.5 0 0 0-7.78 0L12 4.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 20.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>';

// Kalender — reuse persis dari nav.php
$ICO_CALENDAR = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="3" opacity=".28"/><rect x="3" y="5" width="18" height="6.2" rx="3" opacity="1"/><circle cx="8" cy="4" r="1.3" opacity=".55"/><circle cx="16" cy="4" r="1.3" opacity=".55"/><g transform="translate(8.3,12.6) scale(.3)">'.$heart.'</g></svg>';

// Pin lokasi — reuse dari jadwal.php
$ICO_PIN = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c-4.1 0-7.5 3.2-7.5 7.5C4.5 15 12 22 12 22s7.5-7 7.5-12.5C19.5 5.2 16.1 2 12 2Z"/><circle cx="12" cy="9.3" r="2.6" opacity=".35"/></svg>';

// Users/generasi — reuse dari nav.php (ikon member/users)
$ICO_GEN = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="8.6" cy="8" r="3" opacity=".4"/><path d="M3.2 19c0-3.3 2.4-5.5 5.4-5.5S14 15.7 14 19" opacity=".4"/><circle cx="15.3" cy="8.6" r="3.4"/><path d="M8.7 19.5c0-3.6 2.9-6 6.6-6s6.6 2.4 6.6 6"/></svg>';

// Oshi/hati — untuk tombol oshimen dan badge
$ICO_HEART_SM = '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">'.$heart.'</svg>';
$ICO_CROWN    = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="3.6" r="1.8"/><path d="M12 5.2 18.6 16.2 5.4 16.2Z" opacity=".5"/><rect x="8.4" y="16.2" width="7.2" height="2.4" rx="1" opacity=".85"/></svg>';

// Kamera — foto casual/resmi note (ganti "📸 Foto casual")
$ICO_CAMERA = '<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2.5" opacity=".4"/><circle cx="12" cy="14" r="4"/><circle cx="12" cy="14" r="2.2" opacity=".35"/><path d="M9 7l1.5-3h3L15 7Z" opacity=".7"/><circle cx="18" cy="10" r="1.2" opacity=".6"/></svg>';

// Search — untuk empty state (ganti 🔍)
$ICO_SEARCH = '<svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" opacity=".3"/><circle cx="10.5" cy="10.5" r="4" opacity=".7"/><path d="M15.5 15.5 21 21" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" fill="none" opacity=".6"/></svg>';

// User — empty state member
$ICO_USER_LG = '<svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="4" opacity="1"/><path d="M4 21c0-4.4 3.6-7.4 8-7.4s8 3 8 7.4" opacity=".4"/></svg>';

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
  <title>Member — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/member.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="member-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="hero-orb hero-orb-3"></div>

  <div class="member-hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      <!-- Sparkle unicode ✦ dibuang — sama kasusnya dengan berita.php -->
      JKT48 Members
    </div>
    <h1>Kenali Para <em>Member</em></h1>
    <p>Temukan member favoritmu dan lihat profil lengkap mereka.</p>
    <div class="hero-stats">
      <div class="hero-stat-item">
        <span class="hero-stat-num"><?= count($members ?? []) ?></span>
        <span class="hero-stat-label">Member Aktif</span>
      </div>
      <div class="hero-stat-divider"></div>
      <div class="hero-stat-item">
        <span class="hero-stat-num"><?= count(array_unique(array_column($members ?? [], 'gen'))) ?></span>
        <span class="hero-stat-label">Generasi</span>
      </div>
    </div>
  </div>
</div>

<!-- FILTER & SEARCH -->
<div class="member-controls">
  <div class="member-search-wrap">
    <div class="search-icon">
      <!-- Ganti emoji 🔍 -->
      <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <circle cx="10.5" cy="10.5" r="6.5" opacity=".3"/>
        <circle cx="10.5" cy="10.5" r="4" opacity=".7"/>
        <path d="M15.5 15.5 21 21" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" fill="none" opacity=".6"/>
      </svg>
    </div>
    <input type="text" id="searchInput"
           placeholder="Cari nama member..."
           oninput="filterCards()"/>
    <button class="search-clear" id="searchClear" onclick="clearSearch()" style="display:none;">×</button>
  </div>
  <div class="member-filter-wrap">
    <span class="filter-label">Generasi</span>
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
      <div class="member-empty-icon"><?= $ICO_USER_LG ?></div>
      <h3>Belum Ada Data Member</h3>
      <p>Admin belum menambahkan member. Cek lagi nanti ya!</p>
    </div>
  <?php else: ?>

    <div class="member-toolbar">
      <div class="member-count" id="memberCount">
        Menampilkan <strong><?= count($members) ?></strong> member
      </div>
    </div>

    <div class="member-grid" id="memberGrid">
      <?php foreach ($members as $i => $m): ?>
      <div class="member-card"
           data-gen="<?= htmlspecialchars($m['gen']) ?>"
           data-name="<?= strtolower(htmlspecialchars($m['nama_member'])) ?>"
           style="--card-index: <?= $i ?>;"
           onclick="openModal(<?= htmlspecialchars(json_encode(array_merge($m, ['deskripsi' => bersihkan_emoji($m['deskripsi'] ?? '')])), ENT_QUOTES) ?>)">

        <div class="card-shimmer"></div>

        <div class="card-photo-wrap">
          <?php if (!empty($m['foto'])): ?>
            <img src="<?= htmlspecialchars($m['foto']) ?>"
                 alt="<?= htmlspecialchars($m['nama_member']) ?>"
                 class="card-photo"
                 loading="lazy"/>
          <?php else: ?>
            <div class="card-photo-placeholder">
              <!-- Ganti emoji 👤 -->
              <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"
                   style="color: var(--pk-mid);" aria-hidden="true">
                <circle cx="12" cy="8" r="4" opacity="1"/>
                <path d="M4 21c0-4.4 3.6-7.4 8-7.4s8 3 8 7.4" opacity=".4"/>
              </svg>
            </div>
          <?php endif; ?>

          <div class="card-gen-badge"><?= htmlspecialchars($m['gen']) ?></div>

          <div class="card-hover-overlay">
            <div class="card-hover-content">
              <!-- Ganti emoji ✨ di hover state -->
              <svg class="card-hover-icon" width="13" height="13" viewBox="0 0 24 24"
                   fill="white" aria-hidden="true">
                <path d="M12 2c.6 5.2 4.4 7.7 9.5 9.5-5.1 1.8-8.9 4.3-9.5 9.5-.6-5.2-4.4-7.7-9.5-9.5C7.6 9.7 11.4 7.2 12 2z"/>
              </svg>
              <span class="card-hover-text">Lihat Profil</span>
              <span class="card-hover-arrow">→</span>
            </div>
          </div>
        </div>

        <div class="card-info">
          <div class="card-name"><?= htmlspecialchars($m['nama_member']) ?></div>
          <div class="card-asal">
            <!-- Ganti emoji 📍 di card -->
            <span class="card-asal-icon"><?= $ICO_PIN ?></span>
            <?= htmlspecialchars($m['asal']) ?>
          </div>
        </div>

        <div class="card-corner-accent"></div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="member-no-result" id="noResult" style="display:none;">
      <div class="member-empty-icon"><?= $ICO_SEARCH ?></div>
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
      <!-- Kiri: Foto -->
      <div class="modal-photo-side">
        <div class="modal-photo-glow"></div>
        <div class="modal-photo-wrap" id="modalPhotoWrap"></div>
        <div class="modal-gen-tag" id="modalGen"></div>
        <!-- Foto note — emoji 📸 diganti SVG kamera -->
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
            <!-- Ganti emoji 📅 -->
            <span class="modal-stat-icon"><?= $ICO_CALENDAR ?></span>
            <div>
              <div class="modal-stat-label">Tanggal Lahir</div>
              <div class="modal-stat-val" id="modalTglLahir"></div>
            </div>
          </div>
          <div class="modal-stat">
            <!-- Ganti emoji 📍 -->
            <span class="modal-stat-icon"><?= $ICO_PIN ?></span>
            <div>
              <div class="modal-stat-label">Asal</div>
              <div class="modal-stat-val" id="modalAsal"></div>
            </div>
          </div>
          <div class="modal-stat">
            <!-- Ganti emoji ✨ -->
            <span class="modal-stat-icon"><?= $ICO_GEN ?></span>
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

        <div id="modalOshiWrap" style="display:none;">
          <form method="POST" action="index.php?act=update-oshimen">
            <input type="hidden" name="id_member" id="modalOshiId"/>
            <!-- Teks tombol oshimen di-set JS, tapi kita siapin data-icon
                 supaya JS bisa inject SVG yang sesuai (lihat member.js) -->
            <button type="submit" class="modal-oshi-btn" id="modalOshiBtn"
                    data-icon-heart="<?= htmlspecialchars($ICO_HEART_SM) ?>"
                    data-icon-crown="<?= htmlspecialchars($ICO_CROWN) ?>">
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

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/member.js"></script>
<script>
  const currentOshiId = <?= json_encode($_SESSION['oshimen'] ?? null) ?>;
  const isLoggedIn    = <?= json_encode(isset($_SESSION['user_id'])) ?>;
  // SVG kamera untuk foto-note (dipakai member.js saat render note)
  const ICO_CAMERA = <?= json_encode($ICO_CAMERA) ?>;
</script>
</body>
</html>