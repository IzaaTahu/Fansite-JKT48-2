<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/login.css"/>
</head>
<body>
  <div class="container">
    <img src="public/images/logo.webp" style="width:80px;display:block;margin:0 auto 20px;"/>
    <div class="card">
      <div class="card-header">Masuk ke Akun Kamu</div>

      <?php if (isset($error))   echo "<div class='alert-danger'>$error</div>"; ?>
      <?php if (isset($success)) echo "<div class='alert-success'>$success</div>"; ?>

      <form action="index.php?act=login-process" method="POST">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required autocomplete="email"/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password_pengguna" class="form-control" placeholder="••••••••" required/>
        </div>
        <button type="submit" class="btn">Masuk →</button>
      </form>
      <hr/>
      <a href="index.php?act=register" class="text-center">Belum punya akun? Daftar sekarang</a>
    </div>
  </div>
</body>
</html>