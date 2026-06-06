<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/login.css"/>
</head>
<body>
  <div class="container">
    <img src="public/images/logo.webp" style="width:80px;display:block;margin:0 auto 20px;"/>
    <div class="card">
      <div class="card-header">Buat Akun Baru</div>

      <?php if (isset($error)) echo "<div class='alert-danger'>$error</div>"; ?>

      <form action="index.php?act=register-process" method="POST">
        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="nama" class="form-control" placeholder="Nama lengkapmu" required/>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password_pengguna" class="form-control" placeholder="Min. 6 karakter" required/>
        </div>
        <button type="submit" class="btn">Daftar ✨</button>
      </form>
      <hr/>
      <a href="index.php?act=login" class="text-center">Sudah punya akun? Masuk</a>
    </div>
  </div>
</body>
</html>