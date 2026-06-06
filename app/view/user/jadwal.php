<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jadwal — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/jadwal.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,500&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>

<!-- NAVBAR -->
<header>
  <?php include 'components/nav.php'; ?>
</header>

<!-- HERO -->
<div class="jadwal-hero">
  <div class="jadwal-hero-content">
    <div class="hero-badge">✦ JKT48 Schedule</div>
    <h1>Jadwal <em>Event</em></h1>
    <p>Pantau semua jadwal acara JKT48 — theater show, off air, on air, dan event spesial.</p>
  </div>
  <div class="jadwal-hero-deco">📅✨🎤💖</div>
</div>

<!-- FILTER TIPE -->
<div class="jadwal-controls">
  <div class="filter-pills">
    <button class="filter-pill active" data-tipe="all" onclick="setTipeFilter(this)">Semua</button>
    <button class="filter-pill" data-tipe="Theater Show"  onclick="setTipeFilter(this)">🎭 Theater Show</button>
    <button class="filter-pill" data-tipe="Off Air"       onclick="setTipeFilter(this)">🎪 Off Air</button>
    <button class="filter-pill" data-tipe="On Air"        onclick="setTipeFilter(this)">📡 On Air</button>
    <button class="filter-pill" data-tipe="Event"         onclick="setTipeFilter(this)">🎉 Event</button>
    <button class="filter-pill" data-tipe="Meet & Greet"  onclick="setTipeFilter(this)">🤝 Meet &amp; Greet</button>
    <button class="filter-pill" data-tipe="Lainnya"       onclick="setTipeFilter(this)">📌 Lainnya</button>
  </div>
</div>

<!-- JADWAL LIST -->
<section class="jadwal-section">
  <?php if (empty($grouped)): ?>
    <div class="jadwal-empty">
      <div class="jadwal-empty-icon">📭</div>
      <h3>Belum Ada Jadwal</h3>
      <p>Admin belum menambahkan jadwal. Cek lagi nanti ya!</p>
    </div>

  <?php else: ?>

    <?php
    $BULAN_ID = [
      '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
      '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
      '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
    ];

    $TIPE_ICON = [
      'Theater Show' => '🎭',
      'Off Air'      => '🎪',
      'On Air'       => '📡',
      'Event'        => '🎉',
      'Meet & Greet' => '🤝',
      'Lainnya'      => '📌',
    ];

    $TIPE_COLOR = [
      'Theater Show' => 'tipe-pink',
      'Off Air'      => 'tipe-lav',
      'On Air'       => 'tipe-mint',
      'Event'        => 'tipe-peach',
      'Meet & Greet' => 'tipe-rose',
      'Lainnya'      => 'tipe-gray',
    ];

    foreach ($grouped as $monthKey => $items):
      [$tahun, $bulan] = explode('-', $monthKey);
      $now = new DateTime();
      $monthDt = new DateTime($monthKey . '-01');
      $isPastMonth = $monthDt < new DateTime(date('Y-m') . '-01');
    ?>

    <div class="jadwal-month-group" data-month="<?= $monthKey ?>">
      <!-- Header bulan -->
      <div class="month-header <?= $isPastMonth ? 'past' : '' ?>">
        <div class="month-date-block">
          <span class="month-name"><?= $BULAN_ID[$bulan] ?? $bulan ?></span>
          <span class="month-year"><?= $tahun ?></span>
        </div>
        <?php if ($isPastMonth): ?>
          <span class="month-past-badge">Sudah Berlalu</span>
        <?php endif; ?>
      </div>

      <!-- Items bulan ini -->
      <div class="jadwal-list">
        <?php foreach ($items as $j):
          $dt      = new DateTime($j['tanggal_jadwal']);
          $isPast  = $dt < new DateTime();
          $icon    = $TIPE_ICON[$j['tipe'] ?? 'Lainnya'] ?? '📌';
          $color   = $TIPE_COLOR[$j['tipe'] ?? 'Lainnya'] ?? 'tipe-gray';
        ?>
        <div class="jadwal-row <?= $isPast ? 'is-past' : '' ?>"
             data-tipe="<?= htmlspecialchars($j['tipe'] ?? 'Lainnya') ?>"
             onclick="openModal(<?= htmlspecialchars(json_encode($j), ENT_QUOTES) ?>)">

          <!-- Tanggal -->
          <div class="jrow-date">
            <div class="jrow-day"><?= $dt->format('d') ?></div>
            <div class="jrow-dow"><?= ['Min','Sen','Sel','Rab','Kam','Jum','Sab'][$dt->format('w')] ?></div>
          </div>

          <!-- Garis tengah -->
          <div class="jrow-line">
            <div class="jrow-dot <?= $isPast ? 'dot-past' : 'dot-active' ?>"></div>
          </div>

          <!-- Info -->
          <div class="jrow-body">
            <div class="jrow-top">
              <span class="jrow-tipe-badge <?= $color ?>">
                <?= $icon ?> <?= htmlspecialchars($j['tipe'] ?? 'Lainnya') ?>
              </span>
              <?php if ($isPast): ?>
                <span class="jrow-selesai">Selesai</span>
              <?php else: ?>
                <span class="jrow-upcoming">Upcoming</span>
              <?php endif; ?>
            </div>
            <div class="jrow-nama"><?= htmlspecialchars($j['nama_acara']) ?></div>
            <div class="jrow-meta">
              <span>🕐 <?= $dt->format('H:i') ?> WIB
                <?php if ($j['waktu_jadwal']): ?>
                  – <?= substr($j['waktu_jadwal'], 0, 5) ?> WIB
                <?php endif; ?>
              </span>
              <span class="jrow-sep">·</span>
              <span>📍 <?= htmlspecialchars($j['lokasi']) ?></span>
            </div>
          </div>

          <!-- Arrow -->
          <div class="jrow-arrow">→</div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <?php endforeach; ?>

    <!-- No result filter -->
    <div class="jadwal-no-result" id="noResult" style="display:none;">
      <div class="jadwal-empty-icon">🔍</div>
      <h3>Tidak Ada Jadwal</h3>
      <p>Tidak ada jadwal dengan tipe ini.</p>
    </div>

  <?php endif; ?>
</section>

<!-- ── MODAL DETAIL ── -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="jadwal-modal" id="jadwalModal" onclick="event.stopPropagation()">

    <button class="modal-close" onclick="closeModal()">×</button>

    <!-- KIRI: Foto poster -->
    <div class="jmodal-foto-wrap" id="jmodalFotoWrap">
      <img id="jmodalFoto" src="" alt="" class="jmodal-foto"/>
      <div class="jmodal-foto-overlay"></div>
      <div class="jmodal-tipe-over" id="jmodalTipeOver"></div>
    </div>

    <!-- KANAN: Semua info -->
    <div class="jmodal-info-side">

      <!-- Header -->
      <div class="jmodal-header">
        <div class="jmodal-tipe-badge" id="jmodalTipe"></div>
        <h2 class="jmodal-title" id="jmodalTitle"></h2>
      </div>

      <div class="jmodal-divider"></div>

      <!-- Detail grid -->
      <div class="jmodal-details">
        <div class="jdetail-item">
          <div class="jdetail-icon">📅</div>
          <div>
            <div class="jdetail-label">Tanggal</div>
            <div class="jdetail-val" id="jmodalTanggal"></div>
          </div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon">🕐</div>
          <div>
            <div class="jdetail-label">Waktu</div>
            <div class="jdetail-val" id="jmodalWaktu"></div>
          </div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon">📍</div>
          <div>
            <div class="jdetail-label">Lokasi</div>
            <div class="jdetail-val" id="jmodalLokasi"></div>
          </div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon">🎭</div>
          <div>
            <div class="jdetail-label">Tipe Acara</div>
            <div class="jdetail-val" id="jmodalTipeVal"></div>
          </div>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="jmodal-desc-wrap" id="jmodalDescWrap" style="display:none;">
        <div class="jmodal-desc-title">📋 Info Tambahan</div>
        <p class="jmodal-desc" id="jmodalDesc"></p>
      </div>

      <!-- Footer -->
      <div class="jmodal-footer">
        <button class="jmodal-close-btn" onclick="closeModal()">Tutup</button>
      </div>

    </div><!-- end .jmodal-info-side -->
  </div>
</div>

<!-- FOOTER -->
<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">♥</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script>
const HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const BULAN = ['Januari','Februari','Maret','April','Mei','Juni',
               'Juli','Agustus','September','Oktober','November','Desember'];
const TIPE_ICON = {
  'Theater Show':'🎭','Off Air':'🎪','On Air':'📡',
  'Event':'🎉','Meet & Greet':'🤝','Lainnya':'📌'
};

function openModal(j) {
  const fotoWrap = document.getElementById('jmodalFotoWrap');
  const fotoImg  = document.getElementById('jmodalFoto');
  const modal    = document.getElementById('jadwalModal');

  if (j.foto) {
    fotoImg.src = j.foto;
    fotoImg.alt = j.nama_acara;
    fotoWrap.classList.remove('no-foto');
    modal.classList.remove('no-foto');
    document.getElementById('jmodalTipeOver').textContent =
      (TIPE_ICON[j.tipe] || '📌') + ' ' + (j.tipe || 'Lainnya');
  } else {
    // Tidak ada foto — sembunyikan kolom kiri
    fotoWrap.classList.add('no-foto');
    modal.classList.add('no-foto');
  }

  // Judul & tipe
  document.getElementById('jmodalTitle').textContent = j.nama_acara;
  document.getElementById('jmodalTipe').textContent  =
    (TIPE_ICON[j.tipe] || '📌') + ' ' + (j.tipe || 'Lainnya');
  document.getElementById('jmodalTipeVal').textContent = j.tipe || 'Lainnya';

  // Tanggal
  const dt   = new Date(j.tanggal_jadwal);
  const tgl  = HARI[dt.getDay()] + ', ' + dt.getDate() + ' ' +
               BULAN[dt.getMonth()] + ' ' + dt.getFullYear();
  document.getElementById('jmodalTanggal').textContent = tgl;

  // Waktu
  const jamMulai = dt.toTimeString().slice(0, 5) + ' WIB';
  const jamSelesai = j.waktu_jadwal
    ? ' – ' + j.waktu_jadwal.slice(0, 5) + ' WIB'
    : '';
  document.getElementById('jmodalWaktu').textContent = jamMulai + jamSelesai;

  // Lokasi
  document.getElementById('jmodalLokasi').textContent = j.lokasi;

  // Deskripsi
  const descWrap = document.getElementById('jmodalDescWrap');
  if (j.deskripsi && j.deskripsi.trim()) {
    document.getElementById('jmodalDesc').innerHTML = j.deskripsi.replace(/\n/g, '<br>');
    descWrap.style.display = 'block';
  } else {
    descWrap.style.display = 'none';
  }

  document.getElementById('modalBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
  document.querySelector('.jadwal-modal').scrollTop = 0;
}

function closeModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Filter tipe
let activeTipe = 'all';

function setTipeFilter(btn) {
  document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  activeTipe = btn.dataset.tipe;
  applyFilter();
}

function applyFilter() {
  const rows   = document.querySelectorAll('.jadwal-row');
  const groups = document.querySelectorAll('.jadwal-month-group');
  let totalVisible = 0;

  groups.forEach(group => {
    let groupVisible = 0;
    group.querySelectorAll('.jadwal-row').forEach(row => {
      const show = activeTipe === 'all' || row.dataset.tipe === activeTipe;
      row.style.display = show ? '' : 'none';
      if (show) groupVisible++;
    });
    // Sembunyikan group kalau semua itemnya hidden
    group.style.display = groupVisible > 0 ? '' : 'none';
    totalVisible += groupVisible;
  });

  document.getElementById('noResult').style.display = totalVisible === 0 ? 'block' : 'none';
}
</script>
</body>
</html>