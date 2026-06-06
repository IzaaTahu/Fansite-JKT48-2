<?php
// app/view/admin/galeri/index.php
$pageTitle = 'Manajemen Galeri';
include __DIR__ . '/../layout.php';

$TIPE_ICON = [
  'Theater Show'=>'🎭','Off Air'=>'🎪','On Air'=>'📡',
  'Event'=>'🎉','Meet & Greet'=>'🤝','Lainnya'=>'📌',
];
$TIPE_COLOR = [
  'Theater Show'=>'badge-pink','Off Air'=>'badge-lav','On Air'=>'badge-mint',
  'Event'=>'badge-peach','Meet & Greet'=>'badge-pink','Lainnya'=>'badge-lav',
];
?>

<div class="sc">
  <div class="sc-head">
    <h2>🖼️ Event Galeri</h2>
    <a href="index.php?act=admin-galeri-create" class="btn btn-primary">+ Tambah Event</a>
  </div>

  <div class="table-wrap">
    <?php if (empty($events)): ?>
      <div class="empty-state">
        <div class="empty-icon">🖼️</div>
        <p>Belum ada event galeri. Tambahkan event dulu agar user bisa upload foto.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Event</th>
          <th>Tipe</th>
          <th>Tanggal</th>
          <th>Total File</th>
          <th>Member</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $i => $ev):
          $icon  = $TIPE_ICON[$ev['tipe']]  ?? '📌';
          $color = $TIPE_COLOR[$ev['tipe']] ?? 'badge-lav';
          $dt    = new DateTime($ev['tanggal']);
        ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <strong><?= htmlspecialchars($ev['nama_event']) ?></strong>
            <?php if ($ev['deskripsi']): ?>
              <div style="font-size:12px;color:var(--txt-light);margin-top:2px;">
                <?= htmlspecialchars(mb_substr($ev['deskripsi'], 0, 60)) ?>…
              </div>
            <?php endif; ?>
          </td>
          <td>
            <span class="badge <?= $color ?>">
              <?= $icon ?> <?= htmlspecialchars($ev['tipe']) ?>
            </span>
          </td>
          <td><?= $dt->format('d M Y') ?></td>
          <td>
            <span style="font-weight:700;color:var(--pk-accent);">
              <?= $ev['total_foto'] ?>
            </span>
            <span style="font-size:12px;color:var(--txt-light);"> file</span>
          </td>
          <td>
            <span style="font-weight:700;color:var(--txt-mid);">
              <?= $ev['total_member'] ?>
            </span>
            <span style="font-size:12px;color:var(--txt-light);"> member</span>
          </td>
          <td>
            <div class="td-actions">
              <!-- Lihat galeri user -->
              <a href="index.php?act=galeri-event&event=<?= $ev['id_event'] ?>"
                 class="btn btn-sm btn-secondary" target="_blank"
                 title="Lihat galeri ini">👁️ Lihat</a>
              <!-- Edit -->
              <a href="index.php?act=admin-galeri-edit&id=<?= $ev['id_event'] ?>"
                 class="btn btn-sm btn-secondary">✏️ Edit</a>
              <!-- Hapus -->
              <a href="index.php?act=admin-galeri-delete&id=<?= $ev['id_event'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Hapus event <?= htmlspecialchars(addslashes($ev['nama_event'])) ?>?\n\nSemua foto dan komentar di event ini akan ikut terhapus!')">
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

<!-- Info box -->
<div style="background:var(--pk-light);border-radius:14px;padding:16px 20px;
            font-size:13px;color:var(--txt-mid);line-height:1.7;
            border:1.5px solid var(--pk-mid);">
  <strong>ℹ️ Cara kerja Galeri:</strong><br>
  1. Admin buat event di sini (nama, tipe, tanggal).<br>
  2. User yang sudah login bisa upload foto/fancam ke event tersebut, pilih member yang difoto.<br>
  3. Pengunjung bisa lihat galeri dan berkomentar. Foto hanya bisa dihapus oleh pengupload atau admin.
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>