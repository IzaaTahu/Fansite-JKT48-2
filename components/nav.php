<?php // app/components/nav.php
$act = $_GET['act'] ?? 'home';
?>
<link rel="stylesheet" href="public/css/nav.css"/>

<nav class="navbar">
      <div class="navbar-left">
        <div class="nav-logo">J</div>
        <span class="site-title">JKT48 Fansite</span>
      </div>

  <div class="nav-center">
    <ul class="nav-links">
      <li><a href="index.php?act=home"     class="<?= $act==='home'     ? 'active':'' ?>">Beranda</a></li>
      <li><a href="index.php?act=berita"   class="<?= $act==='berita'   ? 'active':'' ?>">Berita</a></li>
      <li><a href="index.php?act=jadwal"   class="<?= $act==='jadwal'   ? 'active':'' ?>">Jadwal</a></li>
      <li><a href="index.php?act=member"   class="<?= $act==='member'   ? 'active':'' ?>">Member</a></li>
      <li><a href="index.php?act=kontak"   class="<?= $act==='kontak'   ? 'active':'' ?>">Kontak</a></li>
    </ul>
  </div>

  <div class="nav-right">
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Sudah login: tampilkan My Page + avatar -->
      <?php if (!empty($_SESSION['oshimen_foto'])): ?>
        <img src="<?= htmlspecialchars($_SESSION['oshimen_foto']) ?>"
             class="oshi-mini" title="Oshimu: <?= htmlspecialchars($_SESSION['oshimen_nama'] ?? '') ?>"/>
      <?php endif; ?>
      <a href="index.php?act=mypage" class="profile-pill <?= $act==='mypage'?'active':'' ?>">
        <div class="pill-avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
        <div class="pill-info">
          <span class="pill-label">My Page</span>
          <span class="pill-name"><?= htmlspecialchars($_SESSION['nama']) ?></span>
        </div>
      </a>
      <a href="index.php?act=logout" class="nav-logout-btn">Logout</a>
    <?php else: ?>
      <!-- Belum login -->
      <a href="index.php?act=login" class="btn-login-nav">Login</a>
    <?php endif; ?>
  </div>

  <!-- Hamburger Menu Button -->
  <input type="checkbox" id="nav-toggle" class="nav-toggle">
  <label for="nav-toggle" class="hamburger" aria-label="Toggle navigation">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </label>

  <!-- Mobile Menu -->
  <div class="mobile-menu">
    <ul class="nav-links-mobile">
      <li><a href="index.php?act=home"     class="<?= $act==='home'     ? 'active':'' ?>">Beranda</a></li>
      <li><a href="index.php?act=berita"   class="<?= $act==='berita'   ? 'active':'' ?>">Berita</a></li>
      <li><a href="index.php?act=jadwal"   class="<?= $act==='jadwal'   ? 'active':'' ?>">Jadwal</a></li>
      <li><a href="index.php?act=member"   class="<?= $act==='member'   ? 'active':'' ?>">Member</a></li>
      <li><a href="index.php?act=kontak"   class="<?= $act==='kontak'   ? 'active':'' ?>">Kontak</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="index.php?act=mypage" class="<?= $act==='mypage'?'active':'' ?>">My Page</a></li>
        <li><a href="index.php?act=logout">Logout</a></li>
      <?php else: ?>
        <li><a href="index.php?act=login">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>