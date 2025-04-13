<div class="row g-3">
          <!-- <div class="card my-5"> -->
            <!-- mx buat ke kanan, mt-n buat kebawah -->
            <div class="col-md-100">
            <div class="card-header p-0 position-relative mt-n80 mx-3 z-index-1 ">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">DATA KELAS</h6>
              </div>
            </div>
</div>
</div>
            <div class="row g-3">
        <div class="col-md-200">
          <div class="card my-4 mx-3">
            <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"> -->
            <div class="card-body px-40 pb-2 ">
           
              

            <button class="btn btn-success mb-3"><a href="/absen/inputkelas" class="text-white"
            onclick="return confirm('Apakah Anda yakin ingin menambah data kelas?')">
                  <i class="material-symbols-rounded opacity-100">add_2</i>
                Tambah Kelas
                  </a></button>
<form method="GET" action="<?= base_url('absen/hasilkelas') ?>">
    <label for="kelas">Pilih Kelas:</label>
    <select name="kelass" class="form-control">
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($kelas as $k) { ?>
            <option value="<?= $k->id_kelas ?>"><?= $k->nama_kelas ?></option>
        <?php } ?>
    </select>
    <button type="submit" class="btn btn-primary mt-2"
    onclick="return confirm('Apakah Anda yakin ingin melihat data siswa kelas ini?')">Filter</button>
</form>