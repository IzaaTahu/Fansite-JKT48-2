<?php
$BULAN_ID = [
  '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
  '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
  '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
];

$TIPE_ICON = [
  'Theater Show' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 3c2 1 3.5 3 3.5 6.5S5 19 3 21h4c2.5 0 4-3 4-8.5S9.5 5 7 3Z" opacity=".5"/><path d="M21 3c-2 1-3.5 3-3.5 6.5S19 19 21 21h-4c-2.5 0-4-3-4-8.5S14.5 5 17 3Z"/><rect x="9" y="20.4" width="6" height="1.6" rx=".8" opacity=".5"/></svg>',
  'Off Air'      => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M6.5 10.5a1 1 0 0 1 2 0 3.5 3.5 0 0 0 7 0 1 1 0 0 1 2 0 5.5 5.5 0 0 1-4.5 5.42V19h2.2a1 1 0 0 1 0 2H8.8a1 1 0 0 1 0-2H11v-3.08A5.5 5.5 0 0 1 6.5 10.5Z" opacity=".5"/></svg>',
  'On Air'       => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2.5" y="4.5" width="19" height="13" rx="2"/><rect x="5.5" y="7.2" width="13" height="7.6" rx=".8" opacity=".4"/><rect x="10" y="18" width="4" height="2.2" rx=".6" opacity=".7"/><rect x="7" y="20.6" width="10" height="1.6" rx=".8" opacity=".7"/></svg>',
  'Event'        => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="4" y="10.5" width="16" height="9.5" rx="1.3"/><rect x="3.3" y="7.3" width="17.4" height="3.6" rx="1" opacity=".85"/><rect x="11" y="7.3" width="2" height="12.7" opacity=".4"/><path d="M12 7.3c-.7-2.8-3.6-3.8-3.6-1.6 0 1.6 1.8 1.6 3.6 1.6Z" opacity=".7"/><path d="M12 7.3c.7-2.8 3.6-3.8 3.6-1.6 0 1.6-1.8 1.6-3.6 1.6Z" opacity=".7"/></svg>',
  'Meet & Greet' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="8.6" cy="8" r="3" opacity=".4"/><path d="M3.2 19c0-3.3 2.4-5.5 5.4-5.5S14 15.7 14 19" opacity=".4"/><circle cx="15.3" cy="8.6" r="3.4"/><path d="M8.7 19.5c0-3.6 2.9-6 6.6-6s6.6 2.4 6.6 6"/></svg>',
  'Lainnya'      => '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6 3h12a1 1 0 0 1 1 1v16.2c0 .8-.9 1.3-1.6.9L12 17.5l-5.4 3.6c-.7.4-1.6-.1-1.6-.9V4a1 1 0 0 1 1-1Z"/></svg>',
];

$TIPE_COLOR = [
  'Theater Show' => 'tipe-pink','Off Air' => 'tipe-lav',
  'On Air' => 'tipe-mint','Event' => 'tipe-peach',
  'Meet & Greet' => 'tipe-rose','Lainnya' => 'tipe-gray',
];

$heart = '<path d="M20.84 3.61a5.5 5.5 0 0 0-7.78 0L12 4.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 20.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>';
$ICO_CALENDAR = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="3" opacity=".28"/><rect x="3" y="5" width="18" height="6.2" rx="3" opacity="1"/><circle cx="8" cy="4" r="1.3" opacity=".55"/><circle cx="16" cy="4" r="1.3" opacity=".55"/><g transform="translate(8.3,12.6) scale(.3)">'.$heart.'</g></svg>';
$ICO_CLOCK    = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" opacity=".25"/><path d="M12 6.5a1 1 0 0 1 1 1V12l3.2 1.9a1 1 0 1 1-1 1.7L11.3 13a1.3 1.3 0 0 1-.6-1.1V7.5a1 1 0 0 1 1-1Z"/></svg>';
$ICO_PIN      = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c-4.1 0-7.5 3.2-7.5 7.5C4.5 15 12 22 12 22s7.5-7 7.5-12.5C19.5 5.2 16.1 2 12 2Z"/><circle cx="12" cy="9.3" r="2.6" opacity=".35"/></svg>';
$ICO_TAG      = '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.5 3.5h6A1.5 1.5 0 0 1 19 5v6l-8.3 8.3a1.5 1.5 0 0 1-2.1 0l-5.9-5.9a1.5 1.5 0 0 1 0-2.1L11.5 3.5Z"/><circle cx="15" cy="8" r="1.6" opacity=".4"/></svg>';
$ICO_INFO     = '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="5.5" width="14" height="17" rx="2" opacity=".32"/><rect x="4" y="3.5" width="14" height="17" rx="2" opacity="1"/><rect x="7" y="9" width="8" height="1.7" rx=".85" opacity=".4"/><rect x="7" y="13" width="6" height="1.7" rx=".85" opacity=".4"/><g transform="translate(12.6,4.6) scale(.22)">'.$heart.'</g></svg>';

function bersihkan_emoji(string $teks): string {
  $pattern = '/[\x{1F1E0}-\x{1F1FF}\x{1F300}-\x{1F5FF}\x{1F600}-\x{1F64F}'
           . '\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}'
           . '\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}'
           . '\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}'
           . '\x{2B00}-\x{2BFF}\x{2190}-\x{21FF}\x{2300}-\x{23FF}'
           . '\x{25A0}-\x{25FF}\x{FE0F}\x{200D}]/u';
  $teks = preg_replace($pattern, '', $teks);
  return trim(preg_replace('/\s+/', ' ', $teks));
}

function bersihkan_emoji_preserve_newlines(string $teks): string {
  $pattern = '/[\x{1F1E0}-\x{1F1FF}\x{1F300}-\x{1F5FF}\x{1F600}-\x{1F64F}'
           . '\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}'
           . '\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}'
           . '\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}'
           . '\x{2B00}-\x{2BFF}\x{2190}-\x{21FF}\x{2300}-\x{23FF}'
           . '\x{25A0}-\x{25FF}\x{FE0F}\x{200D}]/u';
  $teks = preg_replace($pattern, '', $teks);
  $lines = explode("\n", $teks);
  $lines = array_map(fn($l) => trim(preg_replace('/\s+/', ' ', $l)), $lines);
  return implode("\n", $lines);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jadwal — JKT48 Fansite</title>
  <link rel="stylesheet" href="public/css/home.css"/>
  <link rel="stylesheet" href="public/css/jadwal.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Cormorant+Garamond:wght@300;400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
</head>
<body>

<div class="floaties" id="floaties"></div>
<header><?php include 'components/nav.php'; ?></header>

<!-- HERO -->
<div class="jadwal-hero">
  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>
  <div class="jadwal-hero-content">
    <div class="hero-badge"><span class="hero-badge-dot"></span> JKT48 Schedule</div>
    <h1>Jadwal <span class="hero-h1-accent">Event</span></h1>
    <p>Pantau semua jadwal acara JKT48 — theater show, off air, on air, dan event spesial.</p>
  </div>
</div>

<!-- MONTH NAVIGATOR + FILTER -->
<div class="jadwal-controls">
  <div class="month-nav">
    <button class="month-nav-btn" id="btnPrev" onclick="changeMonth(-1)">‹</button>
    <div class="month-nav-label" id="monthLabel">—</div>
    <button class="month-nav-btn" id="btnNext" onclick="changeMonth(1)">›</button>
  </div>
  <div class="filter-pills">
    <button class="filter-pill active" data-tipe="all" onclick="setTipeFilter(this)">Semua</button>
    <?php foreach ($TIPE_ICON as $tipeName => $svg): ?>
    <button class="filter-pill" data-tipe="<?= htmlspecialchars($tipeName) ?>" onclick="setTipeFilter(this)">
      <span class="filter-pill-icon"><?= $svg ?></span><?= htmlspecialchars($tipeName) ?>
    </button>
    <?php endforeach; ?>
  </div>
</div>

<!-- JADWAL LIST -->
<section class="jadwal-section">
  <?php if (empty($grouped)): ?>
    <div class="jadwal-empty">
      <div class="jadwal-empty-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/></svg>
      </div>
      <h3>Belum Ada Jadwal</h3>
      <p>Admin belum menambahkan jadwal. Cek lagi nanti ya!</p>
    </div>
  <?php else: ?>
    <?php $allMonths = array_keys($grouped); ?>
    <script>const ALL_MONTHS = <?= json_encode($allMonths) ?>;</script>
    <div id="jadwalContainer">
      <?php foreach ($grouped as $monthKey => $items):
        [$tahun, $bulan] = explode('-', $monthKey);
        $monthDt = new DateTime($monthKey . '-01');
        $isPastMonth = $monthDt < new DateTime(date('Y-m') . '-01');
      ?>
      <div class="jadwal-month-group" data-month="<?= $monthKey ?>" style="display:none;">
        <div class="jadwal-list">
          <?php foreach ($items as $j):
            $dt    = new DateTime($j['tanggal_jadwal']);
            $isPast = $dt < new DateTime();
            $icon  = $TIPE_ICON[$j['tipe'] ?? 'Lainnya'] ?? $TIPE_ICON['Lainnya'];
            $color = $TIPE_COLOR[$j['tipe'] ?? 'Lainnya'] ?? 'tipe-gray';
          ?>
          <div class="jadwal-row <?= $isPast ? 'is-past' : '' ?>"
               data-tipe="<?= htmlspecialchars($j['tipe'] ?? 'Lainnya') ?>"
               onclick="openModal(<?= htmlspecialchars(json_encode(array_merge($j, ['nama_acara' => bersihkan_emoji($j['nama_acara']), 'lokasi' => bersihkan_emoji($j['lokasi'] ?? ''), 'deskripsi' => bersihkan_emoji_preserve_newlines($j['deskripsi'] ?? '')]), ENT_QUOTES)); ?>)">
            <div class="jrow-date">
              <div class="jrow-day"><?= $dt->format('d') ?></div>
              <div class="jrow-dow"><?= ['Min','Sen','Sel','Rab','Kam','Jum','Sab'][$dt->format('w')] ?></div>
            </div>
            <div class="jrow-line">
              <div class="jrow-dot <?= $isPast ? 'dot-past' : 'dot-active' ?>"></div>
            </div>
            <div class="jrow-body">
              <div class="jrow-top">
                <span class="jrow-tipe-badge <?= $color ?>">
                  <span class="jrow-tipe-icon"><?= $icon ?></span><?= htmlspecialchars($j['tipe'] ?? 'Lainnya') ?>
                </span>
                <?php if ($isPast): ?>
                  <span class="jrow-selesai">Selesai</span>
                <?php else: ?>
                  <span class="jrow-upcoming">Upcoming</span>
                <?php endif; ?>
              </div>
              <div class="jrow-nama"><?= htmlspecialchars($j['nama_acara']) ?></div>
              <div class="jrow-meta">
                <span class="jrow-meta-group">
                  <span class="jrow-meta-icon"><?= $ICO_CLOCK ?></span>
                  <?= $dt->format('H:i') ?> WIB
                  <?php if ($j['waktu_jadwal']): ?>– <?= substr($j['waktu_jadwal'], 0, 5) ?> WIB<?php endif; ?>
                </span>
                <span class="jrow-sep">·</span>
                <span class="jrow-meta-group">
                  <span class="jrow-meta-icon"><?= $ICO_PIN ?></span>
                  <?= htmlspecialchars($j['lokasi']) ?>
                </span>
              </div>
            </div>
            <div class="jrow-arrow">→</div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="jadwal-no-result" id="noResult" style="display:none;">
        <div class="jadwal-empty-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <h3>Tidak Ada Jadwal</h3>
        <p>Tidak ada jadwal dengan tipe ini.</p>
      </div>
      <div class="jadwal-empty" id="noMonth" style="display:none;">
        <div class="jadwal-empty-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f48fb1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        </div>
        <h3>Belum Ada Jadwal</h3>
        <p>Belum ada jadwal untuk bulan ini.</p>
      </div>
    </div>
  <?php endif; ?>
</section>

<!-- MODAL -->
<div class="modal-backdrop" id="modalBackdrop" onclick="closeModal()">
  <div class="jadwal-modal" id="jadwalModal" onclick="event.stopPropagation()">
    <button class="modal-close" onclick="closeModal()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
    </button>
    <div class="jmodal-foto-wrap" id="jmodalFotoWrap">
      <img id="jmodalFoto" src="" alt="" class="jmodal-foto"/>
      <div class="jmodal-foto-overlay"></div>
      <div class="jmodal-tipe-over" id="jmodalTipeOver"></div>
    </div>
    <div class="jmodal-info-side">
      <div class="jmodal-header">
        <div class="jmodal-tipe-badge" id="jmodalTipe"></div>
        <h2 class="jmodal-title" id="jmodalTitle"></h2>
      </div>
      <div class="jmodal-divider"></div>
      <div class="jmodal-details">
        <div class="jdetail-item">
          <div class="jdetail-icon"><?= $ICO_CALENDAR ?></div>
          <div><div class="jdetail-label">Tanggal</div><div class="jdetail-val" id="jmodalTanggal"></div></div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon"><?= $ICO_CLOCK ?></div>
          <div><div class="jdetail-label">Waktu</div><div class="jdetail-val" id="jmodalWaktu"></div></div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon"><?= $ICO_PIN ?></div>
          <div><div class="jdetail-label">Lokasi</div><div class="jdetail-val" id="jmodalLokasi"></div></div>
        </div>
        <div class="jdetail-item">
          <div class="jdetail-icon"><?= $ICO_TAG ?></div>
          <div><div class="jdetail-label">Tipe Acara</div><div class="jdetail-val" id="jmodalTipeVal"></div></div>
        </div>
      </div>
      <div class="jmodal-desc-wrap" id="jmodalDescWrap" style="display:none;">
        <div class="jmodal-desc-title">
          <span class="jdesc-title-icon"><?= $ICO_INFO ?></span> Info Tambahan
        </div>
        <p class="jmodal-desc" id="jmodalDesc"></p>
      </div>
      <div class="jmodal-footer">
        <button class="jmodal-close-btn" onclick="closeModal()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<footer>
  <p>Fansite JKT48 &copy; 2025 — Dibuat dengan <span class="heart">&#9829;</span> oleh komunitas penggemar.</p>
</footer>

<script src="public/js/home.js"></script>
<script src="public/js/jadwal.js"></script>
</body>
</html>