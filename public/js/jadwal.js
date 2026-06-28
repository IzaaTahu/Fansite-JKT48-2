/* ==============================
   JADWAL PAGE — jadwal.js
   ============================== */

// ── CONSTANTS ──────────────────────────────────────
const HARI  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const BULAN_NAMA = [
  'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
];

// Icon tipe acara — SVG kawaii-duotone, sama bahasa visual dengan navbar.
// Dipakai untuk badge tipe di modal (jmodalTipe, jmodalTipeOver).
// Versi yang sama (PHP) dipakai untuk filter pill & badge di list —
// dua implementasi, satu desain, supaya konsisten lintas server/client.
const TIPE_ICON = {
  'Theater Show' : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 3c2 1 3.5 3 3.5 6.5S5 19 3 21h4c2.5 0 4-3 4-8.5S9.5 5 7 3Z" opacity=".5"/><path d="M21 3c-2 1-3.5 3-3.5 6.5S19 19 21 21h-4c-2.5 0-4-3-4-8.5S14.5 5 17 3Z"/><rect x="9" y="20.4" width="6" height="1.6" rx=".8" opacity=".5"/></svg>',
  'Off Air'      : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M6.5 10.5a1 1 0 0 1 2 0 3.5 3.5 0 0 0 7 0 1 1 0 0 1 2 0 5.5 5.5 0 0 1-4.5 5.42V19h2.2a1 1 0 0 1 0 2H8.8a1 1 0 0 1 0-2H11v-3.08A5.5 5.5 0 0 1 6.5 10.5Z" opacity=".5"/></svg>',
  'On Air'       : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2.5" y="4.5" width="19" height="13" rx="2"/><rect x="5.5" y="7.2" width="13" height="7.6" rx=".8" opacity=".4"/><rect x="10" y="18" width="4" height="2.2" rx=".6" opacity=".7"/><rect x="7" y="20.6" width="10" height="1.6" rx=".8" opacity=".7"/></svg>',
  'Event'        : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="4" y="10.5" width="16" height="9.5" rx="1.3"/><rect x="3.3" y="7.3" width="17.4" height="3.6" rx="1" opacity=".85"/><rect x="11" y="7.3" width="2" height="12.7" opacity=".4"/><path d="M12 7.3c-.7-2.8-3.6-3.8-3.6-1.6 0 1.6 1.8 1.6 3.6 1.6Z" opacity=".7"/><path d="M12 7.3c.7-2.8 3.6-3.8 3.6-1.6 0 1.6-1.8 1.6-3.6 1.6Z" opacity=".7"/></svg>',
  'Meet & Greet' : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="8.6" cy="8" r="3" opacity=".4"/><path d="M3.2 19c0-3.3 2.4-5.5 5.4-5.5S14 15.7 14 19" opacity=".4"/><circle cx="15.3" cy="8.6" r="3.4"/><path d="M8.7 19.5c0-3.6 2.9-6 6.6-6s6.6 2.4 6.6 6"/></svg>',
  'Lainnya'      : '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6 3h12a1 1 0 0 1 1 1v16.2c0 .8-.9 1.3-1.6.9L12 17.5l-5.4 3.6c-.7.4-1.6-.1-1.6-.9V4a1 1 0 0 1 1-1Z"/></svg>',
};

// Escape teks sebelum digabung ke innerHTML (sekarang kita pakai innerHTML
// supaya SVG ikon bisa dirender, jadi nama tipe yang digabungkan di
// sampingnya perlu di-escape manual — defense-in-depth, bukan karena
// datanya tidak dipercaya).
function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

// ── STATE ───────────────────────────────────────────
let currentMonthIndex = 0;
let activeTipe        = 'all';

// ── MONTH NAV ───────────────────────────────────────
function initMonthNav() {
  // FIX: sebelumnya cek `window.ALL_MONTHS` — tapi ALL_MONTHS dideklarasi
  // pakai `const` di <script> inline, dan top-level const/let TIDAK PERNAH
  // nempel ke objek `window` (beda dari `var`). Jadi window.ALL_MONTHS
  // selalu undefined, guard ini selalu true, function selalu berhenti di
  // sini — bulan default gak pernah ke-set. Pakai typeof biar aman dari
  // ReferenceError kalau variabelnya beneran belum ada.
  if (typeof ALL_MONTHS === 'undefined' || !ALL_MONTHS.length) return;

  // Default: bulan sekarang, atau bulan terdekat berikutnya
  const now    = new Date();
  const nowKey = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0');

  let idx = ALL_MONTHS.indexOf(nowKey);
  if (idx === -1) {
    idx = ALL_MONTHS.findIndex(m => m >= nowKey);
    if (idx === -1) idx = ALL_MONTHS.length - 1;
  }

  currentMonthIndex = idx;
  showMonth(currentMonthIndex, null);
}

function changeMonth(dir) {
  const newIdx = currentMonthIndex + dir;
  if (newIdx < 0 || newIdx >= ALL_MONTHS.length) return;

  const slideDir = dir > 0 ? 'slide-left' : 'slide-right';
  showMonth(newIdx, slideDir);
}

function showMonth(idx, animation) {
  currentMonthIndex = idx;
  const monthKey    = ALL_MONTHS[idx];
  const [tahun, bln] = monthKey.split('-');

  // Update label
  document.getElementById('monthLabel').textContent =
    BULAN_NAMA[parseInt(bln) - 1] + ' ' + tahun;

  // Disable/enable tombol nav
  document.getElementById('btnPrev').disabled = idx === 0;
  document.getElementById('btnNext').disabled = idx === ALL_MONTHS.length - 1;

  // Sembunyikan semua group
  document.querySelectorAll('.jadwal-month-group').forEach(g => {
    g.style.display = 'none';
    g.classList.remove('slide-in-left', 'slide-in-right');
  });

  // Tampilkan group yang sesuai
  const target  = document.querySelector(`.jadwal-month-group[data-month="${monthKey}"]`);
  const noMonth = document.getElementById('noMonth');

  if (target) {
    noMonth.style.display = 'none';
    target.style.display  = 'block';

    if (animation) {
      const animClass = animation === 'slide-left' ? 'slide-in-right' : 'slide-in-left';
      target.classList.add(animClass);
      setTimeout(() => target.classList.remove(animClass), 400);
    }
  } else {
    noMonth.style.display = 'block';
  }

  applyFilter();
}

// ── FILTER TIPE ────────────────────────────────────
function setTipeFilter(btn) {
  document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  activeTipe = btn.dataset.tipe;
  applyFilter();
}

function applyFilter() {
  const monthKey = ALL_MONTHS[currentMonthIndex];
  const target   = document.querySelector(`.jadwal-month-group[data-month="${monthKey}"]`);
  if (!target) return;

  let visible = 0;
  target.querySelectorAll('.jadwal-row').forEach(row => {
    const show = activeTipe === 'all' || row.dataset.tipe === activeTipe;
    row.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  document.getElementById('noResult').style.display =
    (visible === 0 && target.style.display !== 'none') ? 'block' : 'none';
}

// ── MODAL ──────────────────────────────────────────
function openModal(j) {
  const fotoWrap = document.getElementById('jmodalFotoWrap');
  const fotoImg  = document.getElementById('jmodalFoto');
  const modal    = document.getElementById('jadwalModal');

  const tipeName = j.tipe || 'Lainnya';
  const tipeIcon = TIPE_ICON[tipeName] || TIPE_ICON['Lainnya'];
  const tipeHtml = '<span class="jtipe-icon">' + tipeIcon + '</span>' + escapeHtml(tipeName);

  if (j.foto) {
    fotoImg.src = j.foto;
    fotoImg.alt = j.nama_acara;
    fotoWrap.classList.remove('no-foto');
    modal.classList.remove('no-foto');
    document.getElementById('jmodalTipeOver').innerHTML = tipeHtml;
  } else {
    fotoWrap.classList.add('no-foto');
    modal.classList.add('no-foto');
  }

  document.getElementById('jmodalTitle').textContent    = j.nama_acara;
  document.getElementById('jmodalTipe').innerHTML       = tipeHtml;
  document.getElementById('jmodalTipeVal').textContent  = tipeName;
  document.getElementById('jmodalLokasi').textContent   = j.lokasi;

  // Tanggal
  const dt  = new Date(j.tanggal_jadwal);
  document.getElementById('jmodalTanggal').textContent =
    HARI[dt.getDay()] + ', ' + dt.getDate() + ' ' +
    BULAN_NAMA[dt.getMonth()] + ' ' + dt.getFullYear();

  // Waktu
  const jamMulai   = dt.toTimeString().slice(0, 5) + ' WIB';
  const jamSelesai = j.waktu_jadwal ? ' – ' + j.waktu_jadwal.slice(0, 5) + ' WIB' : '';
  document.getElementById('jmodalWaktu').textContent = jamMulai + jamSelesai;

  // Deskripsi
  const descWrap = document.getElementById('jmodalDescWrap');
  if (j.deskripsi && j.deskripsi.trim()) {
    // Split by double newline (paragraph break) → join with <br><br>
    // Dalam tiap paragraf, single newline → <br>
    document.getElementById('jmodalDesc').innerHTML = j.deskripsi
      .split(/\n{2,}/)
      .map(paragraph => paragraph.split('\n').join('<br>'))
      .join('<br><br>');
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

// ── KEYBOARD SHORTCUT ──────────────────────────────
document.addEventListener('keydown', e => {
  if (e.key === 'Escape')      closeModal();
  if (e.key === 'ArrowLeft')   changeMonth(-1);
  if (e.key === 'ArrowRight')  changeMonth(1);
});

// ── INIT ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', initMonthNav);