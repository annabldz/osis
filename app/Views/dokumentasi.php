<div class="container my-4">
    <!-- Header dengan padding kiri-kanan -->
    <div class="d-flex justify-content-between align-items-center mb-3 px-7 ps-4">
        <h2 class="mb-0"><?= $title ?></h2>
        <a href="<?= base_url('home/inputdokumentasi') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Dokumentasi
        </a>
    </div>
    <!-- Wrapper untuk scroll horizontal -->
    <div class="d-flex flex-row overflow-auto gap-3 px-2">
        <!-- Card Mading -->
        <?php
                    if (session()->get('level')==5 || session()->get('level')==1 || session()->get('level')==7 || session()->get('level')==8 || session()->get('level')==9){ ?>
        <div class="card shadow-sm" style="min-width: 300px;">
            <div class="card-header bg-primary text-white">
                Dokumentasi Mading
            </div>
            <div class="card-body">
                <?php if (!empty($mading)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($mading as $item): ?>
                            <li class="list-group-item">
                                <strong><?= $item->judul_dokumentasi ?></strong><br>
                                <a href="<?= $item->link_drive ?>" target="_blank">Lihat Dokumentasi</a><br>
                                <small><?= $item->bulan ?>/<?= $item->tahun ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Belum ada dokumentasi.</p>
                <?php endif; ?>
            </div>
        </div>
                  <?php } ?>
                  <?php
                    if (session()->get('level')==4 || session()->get('level')==1 || session()->get('level')==7 || session()->get('level')==8 || session()->get('level')==9){ ?>
        <!-- Card Acara Sekolah -->
        <div class="card shadow-sm" style="min-width: 300px;">
            <div class="card-header bg-success text-white">
                Dokumentasi Acara Sekolah
            </div>
            <div class="card-body">
                <?php if (!empty($acara)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($acara as $item): ?>
                            <li class="list-group-item">
                                <strong><?= $item->judul_dokumentasi ?></strong><br>
                                <a href="<?= $item->link_drive ?>" target="_blank">Lihat Dokumentasi</a><br>
                                <small><?= $item->bulan ?>/<?= $item->tahun ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Belum ada dokumentasi.</p>
                <?php endif; ?>
            </div>
        </div>
                  <?php } ?>
        <!-- Card Keagamaan -->
        <?php
                    if (session()->get('level')==6 || session()->get('level')==1 || session()->get('level')==7 || session()->get('level')==8 || session()->get('level')==9){ ?>
        <div class="card shadow-sm" style="min-width: 300px;">
            <div class="card-header bg-warning text-dark">
                Dokumentasi Keagamaan
            </div>
            <div class="card-body">
                <?php if (!empty($keagamaan)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($keagamaan as $item): ?>
                            <li class="list-group-item">
                                <strong><?= $item->judul_dokumentasi ?></strong><br>
                                <a href="<?= $item->link_drive ?>" target="_blank">Lihat Dokumentasi</a><br>
                                <small><?= $item->bulan ?>/<?= $item->tahun ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Belum ada dokumentasi.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="modalDokumentasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('home/savedokumentasi') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload Dokumentasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="input-group input-group-static mb-4">
          <label>Judul Dokumentasi</label>
            <input type="text" name="judul_dokumentasi" id="judul_dokumentasi" class="form-control"  
            placeholder="Masukkan Judul Dokumentasi:" value="<?= $anjas->judul_dokumentasi ?>" required>
          </div>
          <div class="input-group input-group-static mb-4">
          <label>Link Google Drive</label>
            <input type="url" name="link_drive" class="form-control" 
            placeholder="Masukkan Link Drive:" value="<?= $anjas->link_drive ?>"required>
          </div>
          <div class="input-group input-group-static mb-4">
          <label>Kategori</label>
            <select name="kategori" class="form-control" required>
              <option value="Dokumentasi Kegiatan">Pilih Kategori</option>
              <option value="Keagamaan">Keagamaan</option>
              <option value="Mading">Mading</option>
              <option value="Editor">Acara Sekolah</option>
            </select>
          </div>
          <div class="input-group input-group-static mb-4">
          <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" value="<?= date('F') ?>" required>
          </div>
          <div class="input-group input-group-static mb-4">
          <label>Tahun</label>
            <input type="text" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
          </div>
        </div>
        <div class="modal-footer">
        <input type="hidden" value="<?= $anjas->id_dokumentasi ?>" name="id">
             <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
             <input type="hidden" name="created_by" value="<?= session()->get('id') ?>">
          <button type="submit" class="btn btn-primary">Simpan</button>

        </div>
      </div>
    </form>
  </div>
</div>


<script>
  document.querySelectorAll('.selesai-btn').forEach(button => {
    button.addEventListener('click', function () {
      const idKegiatan = this.dataset.id;
      const judul = this.dataset.judul;
      const idProker = this.dataset.idproker;

      document.getElementById('id_kegiatan').value = idKegiatan;
      document.getElementById('id_proker').value = idProker;
      document.getElementById('judul_dokumentasi').value = judul;
    });
  });
</script>