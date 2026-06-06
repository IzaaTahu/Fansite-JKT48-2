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

<!-- NAVBAR (sama persis dengan home) -->
<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO BANNER -->
<div class="mypage-hero">
  <div class="mypage-hero-content">
    <p class="mypage-hero-greet">Halo, <?= htmlspecialchars($_SESSION['nama']) ?> 👋</p>
    <h1 class="mypage-hero-title">Selamat Datang<br>di <em>My Page</em></h1>
    <p class="mypage-hero-sub">Kelola profil dan pilih oshi member favoritmu!</p>
  </div>
  <div class="mypage-hero-deco">
    <span>🌸</span><span>✨</span><span>🎵</span><span>💖</span>
  </div>
</div>

<?php if ($flash): ?>
<div class="mp-flash mp-flash-<?= $flash['type'] ?>" id="mpFlash">
  <?= htmlspecialchars($flash['msg']) ?>
  <button onclick="this.parentElement.remove()">×</button>
</div>
<?php endif; ?>

<div class="mypage-layout">

  <!-- ── KOLOM KIRI: Profil User ─────────────────── -->
  <aside class="mp-sidebar">

    <!-- Kartu Profil -->
    <div class="mp-card mp-profile-card">
      <div class="mp-profile-avatar">
        <?= strtoupper(substr($userDetail['nama'], 0, 1)) ?>
      </div>
      <div class="mp-profile-name"><?= htmlspecialchars($userDetail['nama']) ?></div>
      <div class="mp-profile-email"><?= htmlspecialchars($userDetail['email']) ?></div>
      <div class="mp-profile-badge">
        <?= $userDetail['ROLE'] === 'admin' ? '⭐ Administrator' : '🌸 Member' ?>
      </div>
    </div>

    <!-- Edit Nama -->
    <div class="mp-card">
      <div class="mp-card-title">✏️ Edit Profil</div>
      <form method="POST" action="index.php?act=update-profile">
        <div class="mp-form-group">
          <label>Nama Tampilan</label>
          <input type="text" name="nama"
                 value="<?= htmlspecialchars($userDetail['nama']) ?>"
                 placeholder="Nama kamu..." required/>
        </div>
        <button type="submit" class="mp-btn mp-btn-primary">Simpan →</button>
      </form>
    </div>

    <!-- Info Akun -->
    <div class="mp-card">
      <div class="mp-card-title">🔒 Info Akun</div>
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
    </div>

  </aside>

  <!-- ── KOLOM KANAN: Oshimen ────────────────────── -->
  <main class="mp-main">

    <!-- Oshimen aktif -->
    <div class="mp-card mp-oshi-showcase">
      <div class="mp-card-title">💖 Member Kesukaanmu (Oshimen)</div>

      <?php if (!empty($userDetail['oshimen_nama'])): ?>
        <div class="mp-oshi-active">
          <div class="mp-oshi-img-wrap">
            <?php if (!empty($userDetail['oshimen_foto'])): ?>
              <img src="<?= htmlspecialchars($userDetail['oshimen_foto']) ?>"
                   alt="<?= htmlspecialchars($userDetail['oshimen_nama']) ?>"/>
            <?php else: ?>
              <div class="mp-oshi-placeholder">👤</div>
            <?php endif; ?>
            <div class="mp-oshi-badge-gen"><?= htmlspecialchars($userDetail['oshimen_gen']) ?></div>
          </div>
          <div class="mp-oshi-detail">
            <div class="mp-oshi-label">Oshimu saat ini</div>
            <div class="mp-oshi-name"><?= htmlspecialchars($userDetail['oshimen_nama']) ?></div>
            <div class="mp-oshi-asal">📍 <?= htmlspecialchars($userDetail['oshimen_asal'] ?? '') ?></div>
            <div class="mp-oshi-gen-tag"><?= htmlspecialchars($userDetail['oshimen_gen']) ?></div>
            <form method="POST" action="index.php?act=update-oshimen" style="margin-top:12px;">
              <input type="hidden" name="id_member" value=""/>
              <button type="submit" class="mp-btn mp-btn-ghost"
                      onclick="return confirm('Hapus oshimen sekarang?')"
                      formnovalidate>
                🗑️ Hapus Oshimen
              </button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <div class="mp-oshi-empty">
          <div class="mp-oshi-empty-icon">🔍</div>
          <p>Kamu belum memilih oshimen.<br>Pilih member favoritmu di bawah!</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Pilih Oshimen -->
    <div class="mp-card">
      <div class="mp-card-title">👩‍🎤 Pilih Member Favorit</div>

      <!-- Search filter -->
      <div class="mp-search-wrap">
        <input type="text" id="memberSearch" placeholder="🔍 Cari nama member..."
               oninput="filterMembers(this.value)"/>
      </div>

      <?php if (empty($members)): ?>
        <div class="mp-empty">
          <p>Belum ada data member. Minta admin untuk menambahkan dulu ya!</p>
        </div>
      <?php else: ?>
        <div class="mp-member-grid" id="memberGrid">
          <?php foreach ($members as $m):
            $isAktif = (int)($userDetail['oshimen'] ?? 0) === (int)$m['id_member'];
          ?>
          <div class="mp-member-item <?= $isAktif ? 'is-oshi' : '' ?>"
               data-name="<?= strtolower(htmlspecialchars($m['nama_member'])) ?>">

            <div class="mp-member-photo">
              <?php if (!empty($m['foto'])): ?>
                <img src="<?= htmlspecialchars($m['foto']) ?>"
                     alt="<?= htmlspecialchars($m['nama_member']) ?>"/>
              <?php else: ?>
                <div class="mp-photo-placeholder">👤</div>
              <?php endif; ?>
              <?php if ($isAktif): ?>
                <div class="mp-oshi-crown">👑</div>
              <?php endif; ?>
            </div>

            <div class="mp-member-info">
              <div class="mp-member-name"><?= htmlspecialchars($m['nama_member']) ?></div>
              <div class="mp-member-gen"><?= htmlspecialchars($m['gen']) ?></div>
            </div>

            <?php if (!$isAktif): ?>
            <form method="POST" action="index.php?act=update-oshimen" class="mp-oshi-form">
              <input type="hidden" name="id_member" value="<?= $m['id_member'] ?>"/>
              <button type="submit" class="mp-btn-choose">Pilih 💗</button>
            </form>
            <?php else: ?>
              <div class="mp-oshi-active-tag">✓ Oshimu</div>
            <?php endif; ?>

          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </main>
</div>

<!-- FOOTER -->
<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script>
// Auto-dismiss flash
const flash = document.getElementById('mpFlash');
if (flash) {
  setTimeout(() => { flash.style.opacity='0'; setTimeout(()=>flash.remove(),400); }, 4000);
  flash.style.transition = 'opacity .4s';
}

// Filter member
function filterMembers(q) {
  const items = document.querySelectorAll('.mp-member-item');
  q = q.toLowerCase();
  items.forEach(el => {
    el.style.display = el.dataset.name.includes(q) ? '' : 'none';
  });
}
</script>

</body>
</html>