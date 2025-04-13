<main id="main" class="main">
<h3> Jadwal</h3>
<form action="<?= base_url('home/savetn') ?>" method="post">
  <div class="mb-3 mt-3">
    <label for="siswa" class="form-label">Nama Siswa:</label>
    <select class="form-control" name="siswa">
      <option>Pilih Siswa</option>
      <?php
      foreach ($siswa as $key => $value) {
        ?>
        <option value="<?= $value->id_siswa ?>"><?= $value->nama_siswa ?> - <?= $value->id_rombel ?></option>
        <?php
      }
        ?>
    </select>
  </div>
  <div class="mb-3 mt-3">
    <label for="mapel" class="form-label">Nama Mapel:</label>
    <select class="form-control" name="mapel">
      <option>Pilih Mapel</option>
      <?php
      foreach ($mapel as $key => $value) {
        ?>
        <option value="<?= $value->id_mapel?>"><?= $value->nama_mapel?></option>
        <?php
      }
        ?>
    </select>
  </div>
  <div class="mb-3 mt-3">
    <label for="jadwal" class="form-label">Jadwal:</label>
    <select class="form-control" name="jadwal">
      <option>Pilih Jadwal</option>
      <?php
      foreach ($love as $key => $value) {
        ?>
        <option value="<?= $value->id_jadwal?>"><?= $value->sesi?></option>
        <?php
      }
        ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="pengetahuan" class="form-label">Nilai Pengetahuan:</label>
        <input type="text" class="form-control" name="pengetahuan">
  </div>
  <div class="mb-3">
    <label for="keterampilan" class="form-label">Nilai Keterampilan:</label>
        <input type="text" class="form-control" name="keterampilan">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>