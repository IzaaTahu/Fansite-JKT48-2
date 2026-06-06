<?php
// app/view/admin/galeri/form.php
$isEdit     = isset($event);
$pageTitle  = $isEdit ? 'Edit Event Galeri' : 'Tambah Event Galeri';
$formAction = $isEdit
    ? "index.php?act=admin-galeri-update&id={$event['id_event']}"
    : "index.php?act=admin-galeri-store";

$TIPES = ['Theater Show','Off Air','On Air','Event','Meet & Greet','Lainnya'];

include __DIR__ . '/../layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2><?= $isEdit ? '✏️ Edit Event Galeri' : '➕ Tambah Event Galeri' ?></h2>
    <a href="index.php?act=admin-galeri" class="btn btn-sm btn-secondary">← Kembali</a>
  </div>

  <form method="POST" action="<?= $formAction ?>">
    <div class="form-wrap">

      <!-- Nama Event -->
      <div class="form-group">
        <label>Nama Event <span class="req">*</span></label>
        <input type="text" name="nama_event"
               value="<?= htmlspecialchars($event['nama_event'] ?? '') ?>"
               placeholder="Contoh: Itadaki Love, Off Air Surabaya, Anniversary Concert..."
               required/>
      </div>

      <!-- Tipe & Tanggal -->
      <div class="form-grid-2">
        <div class="form-group">
          <label>Tipe Acara <span class="req">*</span></label>
          <select name="tipe" required>
            <?php foreach ($TIPES as $t): ?>
            <option value="<?= $t ?>"
              <?= (isset($event['tipe']) && $event['tipe'] === $t) ? 'selected' : '' ?>>
              <?= $t ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Tanggal Event <span class="req">*</span></label>
          <input type="date" name="tanggal"
                 value="<?= htmlspecialchars($event['tanggal'] ?? '') ?>"
                 required/>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label>
          Deskripsi
          <span style="font-size:11px;font-weight:400;color:var(--txt-light);">— opsional</span>
        </label>
        <textarea name="deskripsi"
                  placeholder="Info tambahan tentang event ini, misal: setlist, lokasi, dll."
        ><?= htmlspecialchars($event['deskripsi'] ?? '') ?></textarea>
        <span class="form-hint">
          Ditampilkan sebagai keterangan di halaman galeri event.
        </span>
      </div>

      <!-- Info box -->
      <div style="background:var(--pk-light);border-radius:12px;padding:14px 16px;
                  font-size:13px;color:var(--txt-mid);line-height:1.7;
                  border:1.5px solid var(--pk-mid);">
        💡 Setelah event dibuat, user yang sudah login bisa upload foto dan fancam
        ke event ini melalui halaman Galeri.
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?= $isEdit ? '💾 Simpan Perubahan' : '✅ Buat Event Galeri' ?>
        </button>
        <a href="index.php?act=admin-galeri" class="btn btn-secondary">Batal</a>
      </div>

    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>