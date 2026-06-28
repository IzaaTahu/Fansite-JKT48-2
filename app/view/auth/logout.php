<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keluar — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/logout.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

  <div class="logout-orb orb-1"></div>
  <div class="logout-orb orb-2"></div>

  <div class="logout-wrapper">
    <div class="logout-card">

      <div class="icon-wrap">
        <div class="icon-ring"></div>
        <div class="icon-emoji">👋</div>
      </div>

      <h1>Yakin ingin <em>keluar?</em></h1>
      <p>Jangan lupa kembali lagi untuk update terbaru JKT48 dan aktivitas seru lainnya!</p>

      <div class="slogan">
        <span class="slogan-icon">💗</span>
        Sampai ketemu lagi! <strong>— Tim JKT48 Fansite</strong>
      </div>

      <div class="btn-group">
        <form action="index.php?act=logout" method="POST">
          <button type="submit" name="confirm_logout" class="btn-outline">Ya, Logout</button>
        </form>
        <a href="index.php?act=<?= isset($_SESSION['role']) && $_SESSION['role']==='admin' ? 'admin' : 'user' ?>"
           class="btn-solid">Batal, Kembali</a>
      </div>
    </div>
  </div>
<script src="public/js/logout.js"></script>
</body>
</html>