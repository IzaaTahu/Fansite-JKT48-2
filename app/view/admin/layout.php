<?php
// app/view/admin/_layout.php
// __DIR__ = lokasi file ini sendiri (app/view/admin/)
// naik 3 level untuk dapat ROOT project

$ROOT  = dirname(__DIR__, 3); // app/view/admin -> app/view -> app -> ROOT
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — JKT48</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="public/css/admin.css"/>
</head>
<body>

<?php include __DIR__ . '/../../../components/side.php'; ?>

<div class="main-wrap">
  <header class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle">☰</button>
    <h1 class="page-title"><?= htmlspecialchars($pageTitle ?? '') ?></h1>
    <span class="topbar-greeting">Halo, <?= htmlspecialchars($_SESSION['nama'] ?? '') ?> 👋</span>
  </header>

  <?php if ($flash): ?>
  <div class="flash flash-<?= $flash['type'] ?>" id="adminFlash">
    <?= htmlspecialchars($flash['msg']) ?>
    <button class="flash-close" onclick="this.parentElement.remove()">×</button>
  </div>
  <?php endif; ?>

  <main class="content">