<?php
// app/view/admin/member/index.php
$pageTitle = 'Manajemen Member';
include __DIR__ . '/../layout.php';

$gc = [
  'Gen 1'=>'pink','Gen 2'=>'lav','Gen 3'=>'peach','Gen 4'=>'mint',
  'Gen 5'=>'pink','Gen 6'=>'lav','Gen 7'=>'peach','Gen 8'=>'mint',
  'Gen 9'=>'pink','Gen 10'=>'lav','Gen 11'=>'peach','Gen 12'=>'mint',
  'Gen 13'=>'pink','Gen 14'=>'lav',
];
?>
<div class="sc">
  <div class="sc-head">
    <h2>👩‍🎤 Daftar Member</h2>
    <a href="index.php?act=admin-member-create" class="btn btn-primary">+ Tambah Member</a>
  </div>
  <div class="table-wrap">
    <?php if (empty($members)): ?>
      <div class="empty-state">
        <div class="empty-icon">👩‍🎤</div>
        <p>Belum ada data member.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th><th>Foto</th><th>Nama</th><th>Generasi</th>
          <th>Asal</th><th>Tgl Lahir</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($members as $i => $m): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <?php if ($m['foto']): ?>
              <img src="<?= htmlspecialchars($m['foto']) ?>" class="thumb"
                   alt="<?= htmlspecialchars($m['nama_member']) ?>"/>
            <?php else: ?>
              <div class="thumb-ph">👤</div>
            <?php endif; ?>
          </td>
          <td><strong><?= htmlspecialchars($m['nama_member']) ?></strong></td>
          <td>
            <span class="badge badge-<?= $gc[$m['gen']] ?? 'pink' ?>">
              <?= htmlspecialchars($m['gen']) ?>
            </span>
          </td>
          <td><?= htmlspecialchars($m['asal']) ?></td>
          <td><?= date('d M Y', strtotime($m['tanggal_lahir'])) ?></td>
          <td>
            <div class="td-actions">
              <a href="index.php?act=admin-member-edit&id=<?= $m['id_member'] ?>"
                 class="btn btn-sm btn-secondary">✏️ Edit</a>
              <a href="index.php?act=admin-member-delete&id=<?= $m['id_member'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Hapus member <?= htmlspecialchars(addslashes($m['nama_member'])) ?>?')">
                 🗑️ Hapus
              </a>
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