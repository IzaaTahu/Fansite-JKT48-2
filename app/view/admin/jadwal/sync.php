<?php
// app/view/admin/jadwal/sync.php
// Variabel dari controller: $scraped, $year, $month

$pageTitle = 'Sync Jadwal dari JKT48.com';
include __DIR__ . '/../layout.php';

$BULAN_ID = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',     4=>'April',
    5=>'Mei',     6=>'Juni',     7=>'Juli',       8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',  12=>'Desember',
];
$TIPE_ICON = [
    'Theater Show' => '🎭', 'Off Air'      => '🎪',
    'On Air'       => '📡', 'Event'        => '🎉',
    'Meet & Greet' => '🤝', 'Lainnya'      => '📌',
];
$HARI_ID = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
?>

<!-- Pilih bulan -->
<div class="sc">
  <div class="sc-head">
    <h2>🔄 Sync Jadwal dari JKT48.com</h2>
    <a href="index.php?act=admin-jadwal" class="btn btn-sm btn-secondary">← Kembali</a>
  </div>

  <p style="color:var(--txt-light);margin:0 0 1.2rem;font-size:.9rem;">
    Import otomatis jadwal dari jkt48.com ke database. Data yang sudah ada tidak akan digandakan.
  </p>

  <!-- Form pilih bulan -->
  <form method="GET" action="index.php"
        style="display:flex;gap:.6rem;align-items:flex-end;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="hidden" name="act" value="admin-jadwal-preview"/>

    <div class="form-group" style="margin:0;">
      <label style="font-size:.82rem;margin-bottom:.3rem;display:block;">Bulan</label>
      <select name="month" style="min-width:130px;">
        <?php for ($m = 1; $m <= 12; $m++): ?>
          <option value="<?= $m ?>" <?= $m === $month ? 'selected' : '' ?>>
            <?= $BULAN_ID[$m] ?>
          </option>
        <?php endfor; ?>
      </select>
    </div>

    <div class="form-group" style="margin:0;">
      <label style="font-size:.82rem;margin-bottom:.3rem;display:block;">Tahun</label>
      <input type="number" name="year" value="<?= $year ?>"
             min="2012" max="<?= date('Y') + 1 ?>" style="width:90px;"/>
    </div>

    <button type="submit" class="btn btn-secondary" style="align-self:flex-end;">
      🔍 Preview
    </button>
  </form>

  <!-- ── ERROR ── -->
  <?php if (!empty($scraped['error'])): ?>
    <div class="empty-state" style="background:#fce4ec;border-radius:12px;padding:1.5rem;">
      <div class="empty-icon">❌</div>
      <p style="color:#b71c1c;font-weight:700;"><?= htmlspecialchars($scraped['error']) ?></p>
      <p style="color:#c62828;font-size:.85rem;margin:0;">
        Kemungkinan server InfinityFree tidak bisa konek ke jkt48.com.
        Coba lagi nanti atau
        <a href="https://jkt48.com/calendar/list/y/<?= $year ?>/m/<?= $month ?>/d/1?lang=id"
           target="_blank" style="color:#880e4f;">cek langsung di jkt48.com</a>.
      </p>
    </div>

  <!-- ── KOSONG ── -->
  <?php elseif (empty($scraped['items'])): ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>
        Tidak ada jadwal dari jkt48.com untuk
        <strong><?= $BULAN_ID[$month] ?> <?= $year ?></strong>.
      </p>
    </div>

  <!-- ── ADA DATA ── -->
  <?php else: ?>

    <p style="font-size:.88rem;color:var(--txt-light);margin-bottom:1rem;">
      Ditemukan <strong><?= count($scraped['items']) ?> jadwal</strong>
      dari <strong><?= $BULAN_ID[$month] ?> <?= $year ?></strong>.
      Duplikat otomatis dilewati.
    </p>

    <!-- Preview list -->
    <div class="table-wrap" style="margin-bottom:1.2rem;">
      <table>
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama Acara</th>
            <th>Tipe</th>
            <th>Waktu</th>
            <th>Lokasi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($scraped['items'] as $item):
            $dt   = new DateTime($item['tanggal_jadwal']);
            $tipe = $item['tipe'] ?? 'Lainnya';
            $icon = $TIPE_ICON[$tipe] ?? '📌';
          ?>
          <tr>
            <td style="white-space:nowrap;">
              <?= $dt->format('d M Y') ?><br>
              <small style="color:var(--txt-light);">
                <?= $HARI_ID[(int)$dt->format('w')] ?>
              </small>
            </td>
            <td><strong><?= htmlspecialchars($item['nama_acara']) ?></strong></td>
            <td>
              <span class="badge badge-mint">
                <?= $icon ?> <?= htmlspecialchars($tipe) ?>
              </span>
            </td>
            <td><?= $dt->format('H:i') ?> WIB</td>
            <td style="font-size:.85rem;color:var(--txt-light);">
              <?= htmlspecialchars($item['lokasi']) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Tombol konfirmasi -->
    <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
      <form method="POST" action="index.php?act=admin-jadwal-sync">
        <input type="hidden" name="year"  value="<?= $year ?>"/>
        <input type="hidden" name="month" value="<?= $month ?>"/>
        <button type="submit" class="btn btn-primary"
                onclick="return confirm('Import <?= count($scraped['items']) ?> jadwal ke database?')">
          ✅ Import Sekarang
        </button>
      </form>
      <a href="index.php?act=admin-jadwal" class="btn btn-secondary">Batalkan</a>
    </div>

  <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>