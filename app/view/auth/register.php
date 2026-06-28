<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/register.css"/>
</head>
<body>
  <div class="login-wrapper">

    <!-- ===== LEFT PANEL: Features ===== -->
    <div class="left-panel">
      <div class="left-content">

        <div class="left-logo-wrap">
          <div class="nav-logo-ring"></div>
          <div class="left-logo-inner">J</div>
        </div>

        <h1 class="left-title">JKT48 Fansite</h1>
        <p class="left-desc">
          Buat akun gratis dan mulai nikmati semua fitur eksklusif yang sudah menunggumu!
        </p>

        <div class="features-grid">
          <div class="feature-card" style="--i:0">
            <div class="feature-icon">📰</div>
            <span>Berita ala Fans</span>
          </div>
          <div class="feature-card" style="--i:1">
            <div class="feature-icon">📅</div>
            <span>Jadwal Lengkap</span>
          </div>
          <div class="feature-card" style="--i:2">
            <div class="feature-icon">🌸</div>
            <span>Profil 66 Member</span>
          </div>
          <div class="feature-card" style="--i:3">
            <div class="feature-icon">📷</div>
            <span>Galeri Fan &amp; Fancam</span>
          </div>
          <div class="feature-card" style="--i:4">
            <div class="feature-icon">⏰</div>
            <span>Countdown Event</span>
          </div>
          <div class="feature-card" style="--i:5">
            <div class="feature-icon">🎬</div>
            <span>Video &amp; MV Terbaru</span>
          </div>
          <div class="feature-card" style="--i:6">
            <div class="feature-icon">🎵</div>
            <span>Lagu Hari Ini</span>
          </div>
          <div class="feature-card" style="--i:7">
            <div class="feature-icon">💌</div>
            <span>Kontak &amp; Saran</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== RIGHT PANEL: Register Form ===== -->
    <div class="right-panel">
      <div class="form-wrapper">
        <h2 class="card-header">Buat Akun Baru</h2>
        <p class="sub-text">
          Sudah punya akun?
          <a href="index.php?act=login">Masuk sekarang</a>
        </p>

        <?php if (isset($error)) echo "<div class='alert-danger'>$error</div>"; ?>

        <form id="registerForm" action="index.php?act=register-process" method="POST">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control"
                   placeholder="Nama lengkapmu" required autocomplete="name"/>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="contoh@email.com" required autocomplete="email"/>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-password-wrap">
              <input type="password" id="password" name="password_pengguna"
                     class="form-control" placeholder="Min. 6 karakter" required/>
              <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password">
                <svg class="eye-icon eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <svg class="eye-icon eye-off hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                  <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                  <line x1="1" y1="1" x2="23" y2="23"/>
                </svg>
              </button>
            </div>
            <!-- password strength bar -->
            <div class="pw-strength-wrap" id="pwStrengthWrap">
              <div class="pw-strength-bar" id="pwStrengthBar"></div>
            </div>
            <span class="pw-strength-label" id="pwStrengthLabel"></span>
          </div>
          <button type="submit" class="btn" id="submitBtn">Daftar ✨</button>
        </form>

        <hr/>
        <a href="index.php" class="back-link">← Kembali ke Homepage</a>
      </div>
    </div>

  </div>

  <script>
    // 1. Toggle show/hide password
    const togglePw = document.getElementById('togglePw');
    const pwInput  = document.getElementById('password');
    const eyeOpen  = togglePw.querySelector('.eye-open');
    const eyeOff   = togglePw.querySelector('.eye-off');

    togglePw.addEventListener('click', () => {
      const isHidden = pwInput.type === 'password';
      pwInput.type   = isHidden ? 'text' : 'password';
      eyeOpen.classList.toggle('hidden', isHidden);
      eyeOff.classList.toggle('hidden', !isHidden);
      togglePw.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });

    // 2. Password strength indicator
    const bar   = document.getElementById('pwStrengthBar');
    const label = document.getElementById('pwStrengthLabel');
    const wrap  = document.getElementById('pwStrengthWrap');

    const levels = [
      { min: 0,  max: 0,  width: '0%',   color: '',          text: ''            },
      { min: 1,  max: 5,  width: '25%',  color: '#ef5350',   text: 'Terlalu pendek' },
      { min: 6,  max: 7,  width: '50%',  color: '#ff9800',   text: 'Lemah'       },
      { min: 8,  max: 10, width: '75%',  color: '#66bb6a',   text: 'Cukup kuat'  },
      { min: 11, max: 99, width: '100%', color: '#e91e8c',   text: 'Kuat 💪'     },
    ];

    pwInput.addEventListener('input', () => {
      const len = pwInput.value.length;
      const lvl = levels.find(l => len >= l.min && len <= l.max) || levels[0];
      bar.style.width       = lvl.width;
      bar.style.background  = lvl.color;
      label.textContent     = lvl.text;
      label.style.color     = lvl.color;
      wrap.style.opacity    = len > 0 ? '1' : '0';
    });

    // 3. Loading state on submit
    document.getElementById('registerForm').addEventListener('submit', () => {
      const btn = document.getElementById('submitBtn');
      btn.disabled    = true;
      btn.textContent = 'Mendaftar...';
      btn.classList.add('btn-loading');
    });
  </script>
  <script>
    (function(){
      var s=[
        {w:6,h:6,t:"3%", l:"3%", d:"0s"},
        {w:4,h:4,t:"6%", l:"8%", d:".7s"},
        {w:5,h:5,t:"2%", l:"92%",d:".3s"},
        {w:3,h:3,t:"8%", l:"96%",d:"1.2s"},
        {w:7,h:7,t:"91%",l:"2%", d:".5s"},
        {w:4,h:4,t:"96%",l:"7%", d:"1.8s"},
        {w:6,h:6,t:"93%",l:"94%",d:"1s"},
        {w:3,h:3,t:"97%",l:"88%",d:".2s"},
        {w:5,h:5,t:"2%", l:"48%",d:"1.5s"},
        {w:4,h:4,t:"96%",l:"52%",d:".8s"},
        {w:3,h:3,t:"45%",l:"1%", d:"2s"},
        {w:5,h:5,t:"52%",l:"98%",d:"1.3s"}
      ];
      s.forEach(function(o){
        var e=document.createElement("div");
        e.className="sparkle";
        e.style.cssText="width:"+o.w+"px;height:"+o.h+"px;top:"+o.t+";left:"+o.l+";animation-delay:"+o.d;
        document.body.appendChild(e);
      });
    })();
  </script>
</body>
</html>