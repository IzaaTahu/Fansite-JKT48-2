<?php
// app/view/admin/jadwal/form.php
$isEdit     = isset($jadwal);
$pageTitle  = $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal';
$formAction = $isEdit
    ? "index.php?act=admin-jadwal-update&id={$jadwal['id_jadwal']}"
    : "index.php?act=admin-jadwal-store";

$tglVal = '';
if (!empty($jadwal['tanggal_jadwal'])) {
    $tglVal = (new DateTime($jadwal['tanggal_jadwal']))->format('Y-m-d\TH:i');
}

$TIPES = ['Theater Show', 'Off Air', 'On Air', 'Event', 'Meet & Greet', 'Lainnya'];

include __DIR__ . '/../layout.php';
?>

<div class="sc">
  <div class="sc-head">
    <h2><?= $isEdit ? '✏️ Edit Jadwal' : '➕ Tambah Jadwal Baru' ?></h2>
    <a href="index.php?act=admin-jadwal" class="btn btn-sm btn-secondary">← Kembali</a>
  </div>

  <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data">
    <div class="form-wrap">

      <!-- Nama Acara -->
      <div class="form-group">
        <label>Nama Acara <span class="req">*</span></label>
        <input type="text" name="nama_acara"
               value="<?= htmlspecialchars($jadwal['nama_acara'] ?? '') ?>"
               placeholder="Contoh: Cara Meminum Ramune, Off Air Surabaya, dll."
               required/>
      </div>

      <!-- Tipe & Lokasi -->
      <div class="form-grid-2">
        <div class="form-group">
          <label>Tipe Acara <span class="req">*</span></label>
          <select name="tipe" required>
            <?php foreach ($TIPES as $t): ?>
            <option value="<?= $t ?>"
              <?= (isset($jadwal['tipe']) && $jadwal['tipe'] === $t) ? 'selected' : '' ?>>
              <?= $t ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Lokasi <span class="req">*</span></label>
          <input type="text" name="lokasi"
                 value="<?= htmlspecialchars($jadwal['lokasi'] ?? '') ?>"
                 placeholder="JKT48 Theater / Online / Nama Venue"
                 required/>
        </div>
      </div>

      <!-- Tanggal & Waktu -->
      <div class="form-grid-2">
        <div class="form-group">
          <label>Tanggal &amp; Waktu <span class="req">*</span></label>
          <input type="datetime-local" name="tanggal_jadwal"
                 value="<?= $tglVal ?>" required/>
        </div>
        <div class="form-group">
          <label>Waktu Selesai (opsional)</label>
          <input type="time" name="waktu_jadwal"
                 value="<?= htmlspecialchars($jadwal['waktu_jadwal'] ?? '') ?>"/>
          <span class="form-hint">Waktu berakhir acara, misal 21:00.</span>
        </div>
      </div>

      <!-- Foto Poster -->
      <div class="form-group">
        <label>
          🖼️ Foto / Poster Acara
          <span style="font-size:11px;font-weight:400;color:var(--txt-light);">— opsional</span>
        </label>
        <input type="file" name="foto" accept="image/*" onchange="previewImg(this)"/>
        <span class="form-hint">JPG/PNG/WEBP, maks 3MB.</span>

        <?php if (!empty($jadwal['foto'])): ?>
          <div style="margin-top:8px;font-size:12px;color:var(--txt-light);">Poster saat ini:</div>
          <img src="<?= htmlspecialchars($jadwal['foto']) ?>"
               style="width:140px;height:90px;object-fit:cover;border-radius:10px;
                      border:2px solid var(--pk-mid);margin-top:4px;display:block;"/>
          <label style="display:flex;align-items:center;gap:8px;margin-top:8px;
                        font-size:13px;color:#e53935;cursor:pointer;">
            <input type="checkbox" name="hapus_foto" value="1"
                   style="accent-color:#e53935;width:15px;height:15px;"/>
            Hapus foto ini
          </label>
        <?php endif; ?>

        <img id="fotoPreview" class="img-preview"
             style="width:140px;height:90px;object-fit:cover;" alt="Preview"/>
      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label>Deskripsi <span style="font-size:11px;font-weight:400;color:var(--txt-light);">— opsional</span></label>
        <textarea name="deskripsi"
                  placeholder="Ceritakan info tambahan: setlist, siapa yang tampil, dress code, dll."
        ><?= htmlspecialchars($jadwal['deskripsi'] ?? '') ?></textarea>
        <span class="form-hint">Tampil di popup detail jadwal untuk user.</span>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?= $isEdit ? '💾 Simpan Perubahan' : '✅ Tambahkan Jadwal' ?>
        </button>
        <a href="index.php?act=admin-jadwal" class="btn btn-secondary">Batal</a>
      </div>

    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout_end.php'; ?>