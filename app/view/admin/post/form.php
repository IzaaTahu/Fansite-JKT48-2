<?php
// app/view/admin/post/form.php
$isEdit     = isset($post);
$pageTitle  = $isEdit ? 'Edit Post' : 'Tulis Post Baru';
$formAction = $isEdit
    ? "index.php?act=admin-post-update&id={$post['id_post']}"
    : "index.php?act=admin-post-store";

include __DIR__ . '/../layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2><?= $isEdit ? '✏️ Edit Post' : '✍️ Tulis Post Baru' ?></h2>
    <a href="index.php?act=admin-post" class="btn btn-sm btn-secondary">← Kembali</a>
  </div>

  <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data">
    <div class="form-wrap">

      <!-- Judul -->
      <div class="form-group">
        <label>Judul Post <span class="req">*</span></label>
        <input type="text" name="judul"
               value="<?= htmlspecialchars($post['judul'] ?? '') ?>"
               placeholder="Masukkan judul berita..." required/>
      </div>

      <!-- Foto -->
      <div class="form-group">
        <label>
          🖼️ Foto Berita
          <span style="font-size:11px;font-weight:400;color:var(--txt-light);">
            — tampil di card & popup (opsional)
          </span>
        </label>
        <input type="file" name="foto" accept="image/*" onchange="previewImg(this)"/>
        <span class="form-hint">JPG/PNG/WEBP, maks 3MB. Biarkan kosong jika tidak ingin ada foto.</span>

        <?php if (!empty($post['foto'])): ?>
          <!-- Foto yang sudah ada -->
          <div style="margin-top:10px;">
            <div style="font-size:12px;color:var(--txt-light);margin-bottom:6px;">Foto saat ini:</div>
            <img src="<?= htmlspecialchars($post['foto']) ?>"
                 alt="Foto post"
                 style="width:180px;height:110px;object-fit:cover;border-radius:12px;
                        border:2px solid var(--pk-mid);display:block;"/>
            <label style="display:flex;align-items:center;gap:8px;margin-top:10px;
                          font-size:13px;color:#e53935;cursor:pointer;">
              <input type="checkbox" name="hapus_foto" value="1"
                     style="accent-color:#e53935;width:15px;height:15px;"/>
              Hapus foto ini
            </label>
            <div style="font-size:11px;color:var(--txt-light);margin-top:4px;">
              Upload baru hanya jika ingin mengganti.
            </div>
          </div>
        <?php endif; ?>

        <img id="fotoPreview" class="img-preview" alt="Preview"
             style="width:180px;height:110px;object-fit:cover;"/>
      </div>

      <!-- Isi -->
      <div class="form-group">
        <label>Isi Post <span class="req">*</span></label>
        <textarea name="isi" style="min-height:300px;"
                  placeholder="Tulis isi berita di sini..." required
        ><?= htmlspecialchars($post['isi'] ?? '') ?></textarea>
        <span class="form-hint">
          💡 Bisa pakai tag HTML: &lt;b&gt; tebal, &lt;i&gt; miring, &lt;br&gt; baris baru,
          &lt;a href="..."&gt; link
        </span>
      </div>

      <?php if ($isEdit): ?>
      <div style="background:#fce4ec;border-radius:10px;padding:12px 16px;
                  font-size:13px;color:#7b3f6e;">
        📌 Ditulis oleh <strong><?= htmlspecialchars($post['nama_penulis'] ?? '—') ?></strong>
        &nbsp;·&nbsp; 🕐 <?= date('d M Y, H:i', strtotime($post['tanggal_terbit'])) ?>
      </div>
      <?php endif; ?>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?= $isEdit ? '💾 Simpan Perubahan' : '🚀 Publikasikan' ?>
        </button>
        <a href="index.php?act=admin-post" class="btn btn-secondary">Batal</a>
      </div>

    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>