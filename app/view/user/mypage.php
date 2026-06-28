<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Page — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/mypage.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- ── HERO BANNER ── -->
<div class="mypage-hero">
  <div class="hero-orb orb-1"></div>
  <div class="hero-orb orb-2"></div>
  <div class="hero-orb orb-3"></div>

  <!-- Avatar besar di kanan -->
  <div class="mypage-hero-avatar-wrap">
    <div class="hero-avatar-ring"></div>
    <div class="mypage-hero-avatar">
      <?= strtoupper(substr($userDetail['nama'], 0, 1)) ?>
    </div>
    <?php if (!empty($userDetail['oshimen_foto'])): ?>
      <div class="hero-oshi-bubble">
        <img src="<?= htmlspecialchars($userDetail['oshimen_foto']) ?>"
             alt="<?= htmlspecialchars($userDetail['oshimen_nama']) ?>"/>
        <span class="hero-oshi-heart">💗</span>
      </div>
    <?php endif; ?>
  </div>

  <div class="mypage-hero-content">
    <div class="hero-greeting">
      <span class="greeting-wave">👋</span>
      Halo, <strong><?= htmlspecialchars(explode(' ', $userDetail['nama'])[0]) ?></strong>!
    </div>
    <h1>My <em>Page</em></h1>
    <p>Kelola profil dan pilih oshi member favoritmu.</p>

    <?php if (!empty($userDetail['oshimen_nama'])): ?>
    <div class="hero-oshi-tag">
      <span class="oshi-tag-label">Oshimu</span>
      <span class="oshi-tag-heart">💗</span>
      <span class="oshi-tag-name"><?= htmlspecialchars($userDetail['oshimen_nama']) ?></span>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Flash message -->
<?php if ($flash): ?>
<div class="mp-flash mp-flash-<?= $flash['type'] ?>" id="mpFlash">
  <span><?= htmlspecialchars($flash['msg']) ?></span>
  <button onclick="this.parentElement.remove()">×</button>
</div>
<?php endif; ?>

<!-- ── MAIN LAYOUT ── -->
<div class="mypage-layout">

  <!-- ── KOLOM KIRI ── -->
  <aside class="mp-sidebar">

    <!-- Profil Card -->
    <div class="mp-card mp-profile-card">
      <div class="mp-profile-top">
        <div class="mp-profile-avatar">
          <?= strtoupper(substr($userDetail['nama'], 0, 1)) ?>
          <div class="mp-avatar-ring"></div>
        </div>
        <div class="mp-profile-badge">
          <?= $userDetail['ROLE'] === 'admin' ? '⭐ Admin' : '🌸 Wota' ?>
        </div>
      </div>
      <div class="mp-profile-name"><?= htmlspecialchars($userDetail['nama']) ?></div>
      <div class="mp-profile-email">
        <span>📧</span> <?= htmlspecialchars($userDetail['email']) ?>
      </div>
    </div>

    <!-- Edit Profil -->
    <div class="mp-card">
      <div class="mp-card-header">
        <span class="mp-card-icon">✏️</span>
        <span class="mp-card-title">Edit Profil</span>
      </div>
      <form method="POST" action="index.php?act=update-profile" class="mp-form">
        <div class="mp-form-group">
          <label>Nama Tampilan</label>
          <input type="text" name="nama"
                 value="<?= htmlspecialchars($userDetail['nama']) ?>"
                 placeholder="Nama kamu..." required/>
        </div>
        <button type="submit" class="mp-btn-primary">
          Simpan <span>→</span>
        </button>
      </form>
    </div>

    <!-- Info Akun -->
    <div class="mp-card">
      <div class="mp-card-header">
        <span class="mp-card-icon">🔒</span>
        <span class="mp-card-title">Info Akun</span>
      </div>
      <div class="mp-info-list">
        <div class="mp-info-row">
          <span class="mp-info-label">Email</span>
          <span class="mp-info-val"><?= htmlspecialchars($userDetail['email']) ?></span>
        </div>
        <div class="mp-info-row">
          <span class="mp-info-label">Role</span>
          <span class="mp-info-val mp-role-<?= $userDetail['ROLE'] ?>">
            <?= ucfirst($userDetail['ROLE']) ?>
          </span>
        </div>
        <div class="mp-info-row">
          <span class="mp-info-label">Status</span>
          <span class="mp-info-val mp-status-active">● Aktif</span>
        </div>
      </div>
    </div>

  </aside>

  <!-- ── KOLOM KANAN ── -->
  <main class="mp-main">

    <!-- Oshimen Showcase -->
    <div class="mp-card mp-oshi-card">
      <div class="mp-card-header">
        <span class="mp-card-icon">💖</span>
        <span class="mp-card-title">Oshimenmu</span>
      </div>

      <?php if (!empty($userDetail['oshimen_nama'])): ?>
      <div class="mp-oshi-showcase">
        <!-- Foto -->
        <div class="mp-oshi-photo-wrap">
          <?php if (!empty($userDetail['oshimen_foto'])): ?>
            <img src="<?= htmlspecialchars($userDetail['oshimen_foto']) ?>"
                 alt="<?= htmlspecialchars($userDetail['oshimen_nama']) ?>"
                 class="mp-oshi-photo"/>
          <?php else: ?>
            <div class="mp-oshi-photo-ph">👤</div>
          <?php endif; ?>
          <div class="mp-oshi-gen-badge"><?= htmlspecialchars($userDetail['oshimen_gen']) ?></div>
          <div class="mp-oshi-crown-anim">👑</div>
        </div>

        <!-- Info -->
        <div class="mp-oshi-info">
          <div class="mp-oshi-sublabel">Oshi pilihanmu saat ini</div>
          <div class="mp-oshi-name"><?= htmlspecialchars($userDetail['oshimen_nama']) ?></div>
          <?php if (!empty($userDetail['oshimen_asal'])): ?>
            <div class="mp-oshi-meta">📍 <?= htmlspecialchars($userDetail['oshimen_asal']) ?></div>
          <?php endif; ?>
          <div class="mp-oshi-gen-pill"><?= htmlspecialchars($userDetail['oshimen_gen']) ?></div>

          <div class="mp-oshi-quote">
            "Dukung terus idolamu dari hati terdalam! 🌸"
          </div>

          <form method="POST" action="index.php?act=update-oshimen" style="margin-top:16px;">
            <input type="hidden" name="id_member" value=""/>
            <button type="submit" class="mp-btn-ghost"
                    onclick="return confirm('Yakin mau hapus oshimen?')" formnovalidate>
              🗑️ Ganti Oshimen
            </button>
          </form>
        </div>
      </div>

      <?php else: ?>
      <div class="mp-oshi-empty">
        <div class="mp-oshi-empty-visual">
          <div class="empty-circle">
            <span class="empty-icon">🔍</span>
          </div>
          <div class="empty-sparkles">✨</div>
        </div>
        <h3>Belum Ada Oshimen</h3>
        <p>Pilih member favoritmu dari daftar di bawah!</p>
        <a href="#member-grid-section" class="mp-btn-primary" style="text-decoration:none;display:inline-flex;">
          Pilih Sekarang 💗
        </a>
      </div>
      <?php endif; ?>
    </div>

    <!-- Member Grid -->
    <div class="mp-card" id="member-grid-section">
      <div class="mp-card-header">
        <div style="display:flex;align-items:center;gap:8px;">
          <span class="mp-card-icon">🌸</span>
          <span class="mp-card-title">Pilih Member Favorit</span>
        </div>
        <div class="mp-member-count" id="memberCount">
          <?= count($members) ?> member
        </div>
      </div>

      <!-- Search -->
      <div class="mp-search-wrap">
        <span class="mp-search-icon">🔍</span>
        <input type="text" id="memberSearch"
               placeholder="Cari nama member..."
               oninput="filterMembers(this.value)"/>
        <button class="mp-search-clear" id="searchClear"
                onclick="clearSearch()" style="display:none;">×</button>
      </div>

      <?php if (empty($members)): ?>
        <div class="mp-empty">
          <p>Belum ada data member.</p>
        </div>
      <?php else: ?>
      <div class="mp-member-grid" id="memberGrid">
        <?php foreach ($members as $i => $m):
          $isAktif = (int)($userDetail['oshimen'] ?? 0) === (int)$m['id_member'];
        ?>
        <div class="mp-member-item <?= $isAktif ? 'is-oshi' : '' ?>"
             data-name="<?= strtolower(htmlspecialchars($m['nama_member'])) ?>"
             style="--i:<?= $i ?>;">

          <div class="mp-member-photo-wrap">
            <?php if (!empty($m['foto'])): ?>
              <img src="<?= htmlspecialchars($m['foto']) ?>"
                   alt="<?= htmlspecialchars($m['nama_member']) ?>"
                   class="mp-member-photo" loading="lazy"/>
            <?php else: ?>
              <div class="mp-photo-ph">👤</div>
            <?php endif; ?>

            <?php if ($isAktif): ?>
              <div class="mp-oshi-crown-badge">👑</div>
            <?php endif; ?>

            <!-- Hover overlay -->
            <div class="mp-member-overlay">
              <?php if (!$isAktif): ?>
              <form method="POST" action="index.php?act=update-oshimen">
                <input type="hidden" name="id_member" value="<?= $m['id_member'] ?>"/>
                <button type="submit" class="mp-choose-btn">
                  💗 Jadikan Oshi
                </button>
              </form>
              <?php else: ?>
                <div class="mp-is-oshi-overlay">✓ Oshimu!</div>
              <?php endif; ?>
            </div>
          </div>

          <div class="mp-member-info">
            <div class="mp-member-name"><?= htmlspecialchars($m['nama_member']) ?></div>
            <div class="mp-member-gen"><?= htmlspecialchars($m['gen']) ?></div>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

      <div class="mp-no-member" id="noMember" style="display:none;">
        <p>🔍 Member tidak ditemukan.</p>
      </div>
      <?php endif; ?>
    </div>

  </main>
</div>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/mypage.js"></script>
</body>
</html>