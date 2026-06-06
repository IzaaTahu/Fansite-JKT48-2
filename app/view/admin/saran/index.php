<?php
// app/view/admin/saran/index.php
$pageTitle = 'Kotak Saran';
include __DIR__ . '/../../admin/layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2>💬 Kotak Saran</h2>
    <span class="badge badge-pink" style="font-size:13px;padding:5px 14px;">
      <?= $totalSaran ?> saran masuk
    </span>
  </div>

  <div class="table-wrap">
    <?php if (empty($sarans)): ?>
      <div class="empty-state">
        <div class="empty-icon">📭</div>
        <p>Belum ada saran yang masuk.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Pesan</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sarans as $i => $s): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><strong><?= htmlspecialchars($s['nama']) ?></strong></td>
          <td style="max-width:340px;font-size:13px;color:#7b3f6e;line-height:1.6;">
            <?= nl2br(htmlspecialchars($s['pesan'])) ?>
          </td>
          <td style="white-space:nowrap;font-size:12px;color:#b06898;">
            <?= date('d M Y', strtotime($s['dibuat_pada'])) ?><br>
            <span style="font-size:11px;"><?= date('H:i', strtotime($s['dibuat_pada'])) ?> WIB</span>
          </td>
          <td>
            <a href="index.php?act=admin-saran-delete&id=<?= $s['id_saran'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Hapus saran dari <?= htmlspecialchars(addslashes($s['nama'])) ?>?')">
               🗑️ Hapus
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/../../admin/layout_end.php'; ?>