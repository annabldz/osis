<main id="main" class="main">
<h3> Jadwal</h3>
<form action="<?= base_url('home/saveijadwal') ?>" method="post">
  <div class="mb-3 mt-3">
    <label for="rombel" class="form-label">Nama Rombel:</label>
    <select class="form-control" name="rombel">
      <option>Pilih Rombel</option>
      <?php
      foreach ($rombel as $key => $value) {
        ?>
        <option value="<?= $value->id_rombel ?>"><?= $value->nama_rombel ?></option>
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
    <label for="guru" class="form-label">Nama Guru:</label>
    <select class="form-control" name="guru">
      <option>Pilih Guru</option>
      <?php
      foreach ($guru as $key => $value) {
        ?>
        <option value="<?= $value->id_guru?>"><?= $value->nama_guru?></option>
        <?php
      }
        ?>
    </select>
  </div>
  <div class="mb-3 mt-3">
    <label for="blok" class="form-label">Blok:</label>
    <select class="form-control" name="blok">
      <option>Pilih Blok</option>
      <?php
      foreach ($blok as $key => $value) {
        ?>
        <option value="<?= $value->id_blok?>"><?= $value->kode_blok?></option>
        <?php
      }
        ?>
        </select>
  </div>
        <div class="mb-3 mt-3">
    <label for="semester" class="form-label">Semester:</label>
    <select class="form-control" name="semester">
      <option>Pilih Semester</option>
      <?php
      foreach ($semester as $key => $value) {
        ?>
        <option value="<?= $value->id_semester?>"><?= $value->kode_semester?></option>
        <?php
      }
        ?>
        </select>
  </div>  
  <div class="mb-3 mt-3">
    <label for="tahun" class="form-label">Tahun Ajaran:</label>
    <select class="form-control" name="tahun">
      <option>Pilih Tahun</option>
      <?php
      foreach ($tahun as $key => $value) {
        ?>
        <option value="<?= $value->id_tahunajaran?>"><?= $value->nama_tahun?></option>
        <?php
      }
        ?>
        </select>
    </select>
  </div>
  <div class="mb-3">
    <label for="sesi" class="form-label">Sesi:</label>
        <input type="text" class="form-control" name="sesi">
  </div>
  <div class="mb-3">
    <label for="jam" class="form-label">Jam:</label>
        <input type="text" class="form-control" name="jam">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- <div class="mb-3">
    <label for="keterampilan" class="form-label">Nilai Keterampilan:</label>
    <input type="text" class="form-control" id="keterampilan" placeholder="Nilai Keterampilan" name="keterampilan" value="<?= $anjas->nilai_keterampilan ?>">
  </div> -->