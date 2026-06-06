<?php
// app/view/admin/post/index.php
$pageTitle = 'Manajemen Post';
include __DIR__ . '/../layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2>📝 Daftar Post / Berita</h2>
    <a href="index.php?act=admin-post-create" class="btn btn-primary">+ Tulis Post</a>
  </div>
  <div class="table-wrap">
    <?php if (empty($posts)): ?>
      <div class="empty-state">
        <div class="empty-icon">📭</div>
        <p>Belum ada post.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th><th>Judul</th><th>Penulis</th>
          <th>Terbit</th><th>Cuplikan</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $i => $p): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><strong><?= htmlspecialchars($p['judul']) ?></strong></td>
          <td><?= htmlspecialchars($p['nama_penulis'] ?? '—') ?></td>
          <td><?= date('d M Y', strtotime($p['tanggal_terbit'])) ?></td>
          <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;
                     white-space:nowrap;color:#7b3f6e;font-size:13px;">
            <?= htmlspecialchars(mb_substr(strip_tags($p['isi']), 0, 70)) ?>…
          </td>
          <td>
            <div class="td-actions">
              <a href="index.php?act=admin-post-edit&id=<?= $p['id_post'] ?>"
                 class="btn btn-sm btn-secondary">✏️ Edit</a>
              <a href="index.php?act=admin-post-delete&id=<?= $p['id_post'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Hapus post ini?')">🗑️ Hapus</a>
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