<?php
// app/view/admin/index.php
$pageTitle = 'Dashboard';
include __DIR__ . '/layout.php';
?>

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon pink">👩‍🎤</div>
    <div>
      <div class="stat-value"><?= $totalMember ?></div>
      <div class="stat-label">Total Member</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon lav">📅</div>
    <div>
      <div class="stat-value"><?= $totalJadwal ?></div>
      <div class="stat-label">Total Jadwal</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon peach">📝</div>
    <div>
      <div class="stat-value"><?= $totalPost ?></div>
      <div class="stat-label">Total Post</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon mint">🖼️</div>
    <div>
      <div class="stat-value"><?= $totalGaleriEvent ?? 0 ?></div>
      <div class="stat-label">Event Galeri</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon pink">📸</div>
    <div>
      <div class="stat-value"><?= $totalGaleriFoto ?? 0 ?></div>
      <div class="stat-label">Total Foto/Video</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon lav">💬</div>
    <div>
      <div class="stat-value"><?= $totalSaran ?? 0 ?></div>
      <div class="stat-label">Kotak Saran</div>
    </div>
  </div>
</div>

<!-- QUICK ACTIONS -->
<div class="sc">
  <div class="sc-head"><h2>⚡ Aksi Cepat</h2></div>
  <div class="quick-actions">
    <a href="index.php?act=admin-member-create"  class="btn btn-primary">+ Tambah Member</a>
    <a href="index.php?act=admin-jadwal-create"  class="btn btn-secondary">+ Tambah Jadwal</a>
    <a href="index.php?act=admin-jadwal-preview" class="btn btn-secondary">🔄 Sync Jadwal</a>
    <a href="index.php?act=admin-post-create"    class="btn btn-secondary">+ Tulis Post</a>
    <a href="index.php?act=admin-galeri-create"  class="btn btn-secondary">+ Event Galeri</a>
    <a href="index.php?act=admin-saran"          class="btn btn-secondary">💬 Lihat Saran</a>
  </div>
</div>

<!-- UPCOMING EVENTS -->
<div class="sc">
  <div class="sc-head">
    <h2>📅 Event Mendatang</h2>
    <a href="index.php?act=admin-jadwal" class="btn btn-sm btn-secondary">Lihat Semua</a>
  </div>
  <?php if (empty($upcoming)): ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>Belum ada jadwal mendatang.</p>
    </div>
  <?php else: ?>
    <div class="event-list">
      <?php foreach ($upcoming as $ev):
        $dt = new DateTime($ev['tanggal_jadwal']); ?>
      <div class="event-item">
        <div class="event-date">
          <div class="event-day"><?= $dt->format('d') ?></div>
          <div class="event-mon"><?= $dt->format('M') ?></div>
        </div>
        <div class="event-info">
          <div class="event-name"><?= htmlspecialchars($ev['nama_acara']) ?></div>
          <div class="event-meta">
            📍 <?= htmlspecialchars($ev['lokasi']) ?>
            <?php if ($ev['waktu_jadwal']): ?>
              · 🕐 <?= substr($ev['waktu_jadwal'], 0, 5) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/layout_end.php'; ?>