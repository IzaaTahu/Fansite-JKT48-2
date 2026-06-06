<?php
// app/view/admin/member/form.php
$isEdit     = isset($member);
$pageTitle  = $isEdit ? 'Edit Member' : 'Tambah Member';
$formAction = $isEdit
    ? "index.php?act=admin-member-update&id={$member['id_member']}"
    : "index.php?act=admin-member-store";

$GENS = [
    "Gen 1","Gen 2","Gen 3","Gen 4","Gen 5","Gen 6","Gen 7",
    "Gen 8","Gen 9","Gen 10","Gen 11","Gen 12","Gen 13","Gen 14", "Gen 1 JKT48V", "Gen 2 JKT48V"
];

include __DIR__ . '/../layout.php'; // ← FIXED: pakai _layout.php bukan layout.php
?>

<div class="sc">
  <div class="sc-head">
    <h2><?= $isEdit ? '✏️ Edit Member' : '➕ Tambah Member Baru' ?></h2>
    <a href="index.php?act=admin-member" class="btn btn-sm btn-secondary">← Kembali</a>
  </div>

  <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data">
    <div class="form-wrap">

      <!-- Nama & Tanggal Lahir -->
      <div class="form-grid-2">
        <div class="form-group">
          <label>Nama Member <span class="req">*</span></label>
          <input type="text" name="nama_member"
                 value="<?= htmlspecialchars($member['nama_member'] ?? '') ?>"
                 placeholder="Nama lengkap member" required/>
        </div>
        <div class="form-group">
          <label>Tanggal Lahir <span class="req">*</span></label>
          <input type="date" name="tanggal_lahir"
                 value="<?= htmlspecialchars($member['tanggal_lahir'] ?? '') ?>" required/>
        </div>
      </div>

      <!-- Generasi & Asal -->
      <div class="form-grid-2">
        <div class="form-group">
          <label>Generasi <span class="req">*</span></label>
          <select name="gen" required>
            <option value="">— Pilih Generasi —</option>
            <?php foreach ($GENS as $g): ?>
            <option value="<?= $g ?>"
              <?= (isset($member['gen']) && $member['gen'] === $g) ? 'selected' : '' ?>>
              <?= $g ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Asal <span class="req">*</span></label>
          <input type="text" name="asal"
                 value="<?= htmlspecialchars($member['asal'] ?? '') ?>"
                 placeholder="Kota asal" required/>
        </div>
      </div>

      <!-- Dual foto side by side -->
      <div class="form-grid-2">

        <!-- Foto Kabesha (card depan) -->
        <div class="form-group">
          <label>
            📸 Foto Kabesha
            <span style="font-size:11px;font-weight:400;color:var(--txt-light);">
              — tampil di card
            </span>
          </label>
          <input type="file" name="foto_kabesha" accept="image/*"
                 onchange="previewImg(this, 'previewKabesha')"/>
          <span class="form-hint">JPG/PNG/WEBP, maks 2MB. Foto resmi/kabesha.</span>

          <!-- Preview + status foto lama -->
          <?php if (!empty($member['foto'])): ?>
            <div style="margin-top:8px;font-size:12px;color:var(--txt-light);">
              Foto saat ini:
            </div>
            <img src="<?= htmlspecialchars($member['foto']) ?>"
                 alt="Kabesha saat ini"
                 style="width:80px;height:100px;object-fit:cover;border-radius:10px;
                        border:2px solid var(--pk-mid);margin-top:4px;display:block;"/>
            <div style="font-size:11px;color:var(--txt-light);margin-top:4px;">
              Upload baru hanya jika ingin mengganti.
            </div>
          <?php endif; ?>

          <img id="previewKabesha" class="img-preview" alt="Preview Kabesha"/>
        </div>

        <!-- Foto Casual (popup) -->
        <div class="form-group">
          <label>
            🤳 Foto Casual
            <span style="font-size:11px;font-weight:400;color:var(--txt-light);">
              — tampil di popup
            </span>
          </label>
          <input type="file" name="foto_casual" accept="image/*"
                 onchange="previewImg(this, 'previewCasual')"/>
          <span class="form-hint">JPG/PNG/WEBP, maks 2MB. Bisa dari IG/Twitter member.</span>

          <!-- Preview + status foto lama -->
          <?php if (!empty($member['foto_casual'])): ?>
            <div style="margin-top:8px;font-size:12px;color:var(--txt-light);">
              Foto casual saat ini:
            </div>
            <img src="<?= htmlspecialchars($member['foto_casual']) ?>"
                 alt="Casual saat ini"
                 style="width:80px;height:100px;object-fit:cover;border-radius:10px;
                        border:2px solid var(--pk-mid);margin-top:4px;display:block;"/>
            <div style="font-size:11px;color:var(--txt-light);margin-top:4px;">
              Upload baru hanya jika ingin mengganti.
            </div>
          <?php endif; ?>

          <img id="previewCasual" class="img-preview" alt="Preview Casual"/>
        </div>

      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label>Deskripsi / Bio <span class="req">*</span></label>
        <textarea name="deskripsi" placeholder="Bio singkat member..." required
        ><?= htmlspecialchars($member['deskripsi'] ?? '') ?></textarea>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?= $isEdit ? '💾 Simpan Perubahan' : '✅ Tambahkan Member' ?>
        </button>
        <a href="index.php?act=admin-member" class="btn btn-secondary">Batal</a>
      </div>

    </div>
  </form>
</div>

<!-- Fix previewImg supaya bisa terima 2 target berbeda -->
<script>
function previewImg(input, targetId) {
  const preview = document.getElementById(targetId);
  if (!preview || !input.files?.[0]) return;
  const reader = new FileReader();
  reader.onload = (e) => {
    preview.src = e.target.result;
    preview.classList.add('show');
  };
  reader.readAsDataURL(input.files[0]);
}
</script>

<?php include __DIR__ . '/../layout_end.php'; // ← FIXED: _layout_end.php ?>