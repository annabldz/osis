<h3> Barang Masuk</h3>
<form action="<?= base_url('home/savebmm') ?>" method="post">
  <div class="mb-3 mt-3">
    <label for="idb" class="form-label">Nama Barang Masuk:</label>
    <select class="form-control" name="id_brg">
      <option>Pilih Barang</option>
      <?php
      foreach ($anjas as $key => $value) {
        ?>
        <option value="<?= $value->id_barang?>"><?= $value->kode_barang?> - <?= $value->nama_barang?></option>
        <?php
      }
        ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="jumlah" class="form-label">Jumlah Barang Masuk:</label>
    <input type="text" class="form-control" id="jumlah" placeholder="Jumlah" name="jumlah" value="<?= $anjas->jumlah ?>">
  </div>
  <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal Barang Masuk:</label>
    <input type="date" class="form-control" id="tanggal" placeholder="Tanggal Masuk" name="tanggal" value="<?= $anjas->tanggal_masuk ?>">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>