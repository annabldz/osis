<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
  <div class="card shadow rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h3 class="mb-0">Laporan Pertanggungjawaban (LPJ)</h3>
    </div>
    <div class="card-body">
      <h5><strong>Judul Kegiatan:</strong> <?= esc($lpj['judul_kegiatan']); ?></h5>
      <hr>
      <p style="white-space: pre-line;"><?= esc($lpj['lpj']); ?></p>
    </div>
    <div class="card-footer text-end">
      <a href="<?= base_url('kegiatan') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
      </a>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
