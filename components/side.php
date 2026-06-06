<?php
// app/components/side.php
$act = $_GET['act'] ?? '';
?>
<link rel="stylesheet" href="public/css/admin.css"/>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo">J</div>
    <span class="brand-name">JKT48 Admin</span>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-group">
      <span class="nav-label">Menu Utama</span>

      <a href="index.php?act=admin"
         class="nav-item <?= $act === 'admin' ? 'active' : '' ?>">
        <span class="nav-icon">🏠</span> Dashboard
      </a>

      <a href="index.php?act=admin-member"
         class="nav-item <?= str_starts_with($act, 'admin-member') ? 'active' : '' ?>">
        <span class="nav-icon">👩‍🎤</span> Member
      </a>

      <a href="index.php?act=admin-jadwal"
         class="nav-item <?= str_starts_with($act, 'admin-jadwal') ? 'active' : '' ?>">
        <span class="nav-icon">📅</span> Jadwal
      </a>

      <a href="index.php?act=admin-post"
         class="nav-item <?= str_starts_with($act, 'admin-post') ? 'active' : '' ?>">
        <span class="nav-icon">📝</span> Post / Berita
      </a>

      <a href="index.php?act=admin-galeri"
         class="nav-item <?= str_starts_with($act, 'admin-galeri') ? 'active' : '' ?>">
        <span class="nav-icon">🖼️</span> Galeri Foto
      </a>
    </div>

    <div class="nav-group">
      <span class="nav-label">Interaksi</span>

      <a href="index.php?act=admin-saran"
         class="nav-item <?= str_starts_with($act, 'admin-saran') ? 'active' : '' ?>">
        <span class="nav-icon">💬</span> Kotak Saran
      </a>
    </div>

    <div class="nav-group">
      <span class="nav-label">Lainnya</span>

      <a href="index.php?act=home" class="nav-item" target="_blank">
        <span class="nav-icon">🌐</span> Lihat Fansite
      </a>

      <a href="index.php?act=logout" class="nav-item nav-out">
        <span class="nav-icon">🚪</span> Logout
      </a>
    </div>
  </nav>

  <div class="sidebar-user">
    <div class="user-avatar"><?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)) ?></div>
    <div class="user-info">
      <span class="user-name"><?= htmlspecialchars($_SESSION['nama'] ?? '') ?></span>
      <span class="user-role">Administrator</span>
    </div>
  </div>
</aside>