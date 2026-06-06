<?php
// app/view/admin/jadwal/index.php
$pageTitle = 'Manajemen Jadwal';
include __DIR__ . '/../layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2>📅 Daftar Jadwal</h2>
    <div style="display:flex;gap:.6rem;align-items:center;flex-wrap:wrap;">
      <a href="index.php?act=admin-jadwal-preview" class="btn btn-secondary">
        🔄 Sync dari JKT48.com
      </a>
      <a href="index.php?act=admin-jadwal-create" class="btn btn-primary">
        + Tambah Jadwal
      </a>
    </div>
  </div>

  <div class="table-wrap">
    <?php if (empty($jadwals)): ?>
      <div class="empty-state">
        <div class="empty-icon">📭</div>
        <p>Belum ada jadwal.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th><th>Nama Acara</th><th>Tanggal</th>
          <th>Waktu</th><th>Lokasi</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($jadwals as $i => $j):
          $dt   = new DateTime($j['tanggal_jadwal']);
          $past = $dt < new DateTime();
        ?>
        <tr style="<?= $past ? 'opacity:.55;' : '' ?>">
          <td><?= $i + 1 ?></td>
          <td>
            <strong><?= htmlspecialchars($j['nama_acara']) ?></strong>
            <span class="badge <?= $past ? 'badge-peach' : 'badge-mint' ?>"
                  style="margin-left:6px;">
              <?= $past ? 'Selesai' : 'Upcoming' ?>
            </span>
            <?php if (!empty($j['deskripsi']) && str_contains($j['deskripsi'], 'jkt48.com')): ?>
              <span class="badge badge-peach" style="margin-left:4px;font-size:10px;">
                📥 auto
              </span>
            <?php endif; ?>
          </td>
          <td><?= $dt->format('d M Y') ?></td>
          <td><?= $j['waktu_jadwal'] ? substr($j['waktu_jadwal'], 0, 5) . ' WIB' : '—' ?></td>
          <td><?= htmlspecialchars($j['lokasi']) ?></td>
          <td>
            <div class="td-actions">
              <a href="index.php?act=admin-jadwal-edit&id=<?= $j['id_jadwal'] ?>"
                 class="btn btn-sm btn-secondary">✏️ Edit</a>
              <a href="index.php?act=admin-jadwal-delete&id=<?= $j['id_jadwal'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Hapus jadwal ini?')">🗑️ Hapus</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>