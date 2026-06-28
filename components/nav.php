<?php // app/components/nav.php
$act = $_GET['act'] ?? 'home';
?>
<link rel="stylesheet" href="public/css/nav.css"/>
<nav class="navbar">
  <div class="navbar-glow"></div>

  <!-- KIRI: Logo + Title -->
  <a href="index.php?act=home" class="navbar-brand">
    <div class="nav-logo">
      <span class="nav-logo-text">J</span>
      <div class="nav-logo-ring"></div>
    </div>
    <div class="brand-text">
      <span class="brand-name">JKT48</span>
      <span class="brand-sub">Fansite</span>
    </div>
  </a>

  <!-- TENGAH: Nav links -->
  <div class="nav-center">
    <ul class="nav-links">
      <?php
      $navItems = [
        'home'   => [
          'label' => 'Beranda',
          'icon'  => '<svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>'
        ],
        'berita' => [
          'label' => 'Berita',
          'icon'  => '<svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>'
        ],
        'jadwal' => [
          'label' => 'Jadwal',
          'icon'  => '<svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>'
        ],
        'member' => [
          'label' => 'Member',
          'icon'  => '<svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
        ],
        'kontak' => [
          'label' => 'Kontak',
          'icon'  => '<svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>'
        ],
      ];
      foreach ($navItems as $key => $item):
        $isActive = $act === $key;
      ?>
      <li>
        <a href="index.php?act=<?= $key ?>"
           class="nav-link <?= $isActive ? 'active' : '' ?>">
          <?= $item['icon'] ?>
          <span class="nav-link-label"><?= $item['label'] ?></span>
          <?php if ($isActive): ?>
            <span class="nav-link-dot"></span>
          <?php endif; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <!-- KANAN: Auth -->
  <div class="nav-right">
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Oshi mini -->
      <?php if (!empty($_SESSION['oshimen_foto'])): ?>
        <div class="oshi-wrap" title="Oshimu: <?= htmlspecialchars($_SESSION['oshimen_nama'] ?? '') ?>">
          <img src="<?= htmlspecialchars($_SESSION['oshimen_foto']) ?>" class="oshi-mini"/>
          <span class="oshi-heart">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#e91e8c" stroke="#e91e8c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
          </span>
        </div>
      <?php endif; ?>

      <!-- Profile pill -->
      <a href="index.php?act=mypage"
         class="profile-pill <?= $act === 'mypage' ? 'active' : '' ?>">
        <div class="pill-avatar">
          <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
          <div class="pill-avatar-ring"></div>
        </div>
        <div class="pill-info">
          <span class="pill-label">My Page</span>
          <span class="pill-name"><?= htmlspecialchars($_SESSION['nama']) ?></span>
        </div>
      </a>
      <a href="index.php?act=logout" class="nav-logout-btn">Logout</a>

    <?php else: ?>
      <a href="index.php?act=login"    class="btn-login-nav">Login</a>
      <a href="index.php?act=register" class="btn-register-nav">Daftar</a>
    <?php endif; ?>
  </div>

  <!-- Hamburger (mobile) -->
  <input type="checkbox" id="nav-toggle" class="nav-toggle"/>
  <label for="nav-toggle" class="hamburger" aria-label="Toggle navigation">
    <span class="bar bar-1"></span>
    <span class="bar bar-2"></span>
    <span class="bar bar-3"></span>
  </label>

  <!-- Mobile menu -->
  <div class="mobile-menu">
    <ul class="nav-links-mobile">
      <?php foreach ($navItems as $key => $item): ?>
      <li>
        <a href="index.php?act=<?= $key ?>"
           class="<?= $act === $key ? 'active' : '' ?>">
          <?= $item['icon'] ?>
          <?= $item['label'] ?>
        </a>
      </li>
      <?php endforeach; ?>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li>
          <a href="index.php?act=mypage" class="<?= $act==='mypage'?'active':'' ?>">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
            My Page
          </a>
        </li>
        <li><a href="index.php?act=logout" class="mobile-logout">Logout</a></li>
      <?php else: ?>
        <li>
          <a href="index.php?act=login">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
            Login
          </a>
        </li>
        <li>
          <a href="index.php?act=register">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            Daftar
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>