<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keluar — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/logout.css"/>
</head>
<body>
  <div class="logout-wrapper">
    <div class="logout-card">
      <div class="icon-check">
        <svg viewBox="0 0 24 24" width="40" height="40">
          <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
      </div>

      <h1>Yakin ingin <span>keluar?</span></h1>
      <p>Jangan lupa kembali lagi untuk update terbaru JKT48 dan aktivitas seru lainnya!</p>
      <p class="slogan">Sampai ketemu lagi! <span>— Tim JKT48 Fansite</span></p>

      <div class="btn-group">
        <form action="index.php?act=logout" method="POST">
          <button type="submit" name="confirm_logout" class="btn-outline">Ya, Logout</button>
        </form>
        <a href="index.php?act=<?= isset($_SESSION['role']) && $_SESSION['role']==='admin' ? 'admin' : 'user' ?>"
           class="btn-solid">Batal, Kembali</a>
      </div>
    </div>
  </div>
</body>
</html>