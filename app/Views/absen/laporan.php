
<div class="container mt-2">
  <h3>Laporan Absensi</h3>

  <div class="row g-3">
        <div class="col-12">
          <div class="card my-2">
            <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"> -->
            <div class="card-body px-3 pb-2">
            <?php
          if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')==4 ){ ?>
    <form action="<?= base_url('absen/laporansiswa') ?>" method="post" target="_blank"> 
       <p><strong>ABSENSI SISWA</strong></p>
    <div class="row">
    <div class="col-md-3">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col-md-3">
      <label for="akhir" class="form-label">Tanggal Akhir:</label>
    </div>
    <div class="col-md-3"> 
      <label for="kelas" class="form-label">Kelas:</label>
    </div>
    <div class="col-md-6 d-flex justify-content-center">
    </div>
</div>
<?php } ?>

  <div class="row">
    <div class="col-md-3">
    <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal" name="awal" value="<?= $absensiswa->tanggal ?>">
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir" name="akhir" value="<?= $absensiswa->tanggal ?>">
    </div>
    <div class="col-md-3">
    <select name="kelas" id="kelas" class="form-select">
               <option> Pilih Kelas</option>
      <?php
      foreach ($kelas as $key => $value) {
        ?>
        <option value="<?= $value->id_kelas ?>"><?= $value->nama_kelas ?></option>
        <?php
      }
        ?>
            </select>
</div>
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('absen/laporansiswa/'.$value->id_absensiswa)?>" 
  onclick="return confirm('Apakah Anda yakin ingin mencetak laporan ini?')">
  <button type="print" class="btn btn-primary" style = "width: 100px;" ?>
  <i class="material-symbols-rounded opacity-100">docs</i>
            PDF
           </button></a> 
       </div>
    </div>
</form>

<form action="<?= base_url('absen/excelsiswa') ?>" method="post" target="_blank">  
    <div class="row">
    <div class="col-md-3">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col-md-3">
      <label for="akhir" class="form-label">Tanggal Akhir:</label>
    </div>
    <div class="col-md-3">
      <label for="kelas" class="form-label">Kelas:</label>
    </div>
    <div class="col-md-6 d-flex justify-content-center">
       </div>
    </div>

  <div class="row">
    <div class="col">
    <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal" name="awal" value="<?= $absensiswa->tanggal ?>">
    </div>
    <div class="col">
      <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir" name="akhir" value="<?= $absensiswa->tanggal ?>">
    </div>
    <div class="col-md-3">
    <select name="kelas" id="kelas" class="form-select">
               <option>Pilih Kelas</option>
      <?php
      foreach ($kelas as $key => $value) {
        ?>
        <option value="<?= $value->id_kelas ?>"><?= $value->nama_kelas ?></option>
        <?php
      }
        ?>
            </select>
</div>
     <div class="col d-flex align-items-end" class="form-control">
     <button type="submit" class="btn btn-success" style="width: 100px;" 
     onclick="return confirm('Apakah Anda yakin ingin mencetak laporan ini?')">
        <i class="material-symbols-rounded opacity-100">table_view</i> EXCEL
    </button>
       </div>
</form>
  </div>
    </div>
      </div>
        </div>


<!-- LAPORAN GURU -->
<?php
          if (session()->get('level')==1 || session()->get('level')==4){ ?>
<div class="row g-2">
        <div class="col-13">
          <div class="card my-1">
            <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"> -->
            <div class="card-body px-3 pb-2">
              
    <form action="<?= base_url('absen/laporanguru') ?>" method="post" target="_blank">  <p><strong>ABSENSI GURU</strong></p>
    <div class="row">
    <div class="col-md-3">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col-md-3">
      <label for="akhir" class="form-label">Tanggal Akhir:</label>
    </div>
    <div class="col-md-3">
      <label for="kelas" class="form-label">Nama Guru:</label>
    </div>
    <div class="col-md-6 d-flex justify-content-center">
       </div>
    </div>

  <div class="row">
  <div class="col-md-3">
    <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal" 
    name="awal" value="<?= $absenguru->tanggal ?>">
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir" 
      name="akhir" value="<?= $absenguru->tanggal ?>">
    </div>
    <div class="col-md-3">
    <select name="namaguru" id="namaguru" class="form-select">
               <option>Pilih Nama Guru</option>
      <?php
      foreach ($guru as $key => $value) {
        ?>
        <option value="<?= $value->nama_guru ?>"><?= $value->nama_guru ?></option>
        <?php
      }
        ?>
            </select>
</div>

<div class="col d-flex align-items-end" class="form-control">
<a href="<?= base_url('absen/laporanguru/'.$value->id_absenguru)?>"
nclick="return confirm('Apakah Anda yakin ingin mencetak laporan ini?')">
  <button type="print" class="btn btn-primary" style = "width: 100px;" ?>
  <i class="material-symbols-rounded opacity-100">docs</i>
            PDF
           </button></a> 
       </div>
    </div>
</form>

<form action="<?= base_url('absen/excelguru') ?>" method="post" target="_blank">  
    <div class="row">
    <div class="col-md-3">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col-md-3">
      <label for="akhir" class="form-label">Tanggal Akhir:</label>
    </div>
    <div class="col-md-3"> 
      <label for="kelas" class="form-label">Nama Guru:</label>
    </div>
    <div class="col-md-6 d-flex justify-content-center">
       </div>
    </div>

  <div class="row">
    <div class="col">
    <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal" 
    name="awal" value="<?= $absenguru->tanggal ?>">
    </div>
    <div class="col">
      <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir" 
      name="akhir" value="<?= $absenguru->tanggal ?>">
    </div>
    <div class="col">
    <select name="namaguru" id="namaguru" class="form-select">
               <option>Pilih Nama Guru</option>
      <?php
      foreach ($guru as $key => $value) {
        ?>
        <option value="<?= $value->nama_guru ?>"><?= $value->nama_guru ?></option>
        <?php
      }
        ?>
            </select>
</div>
<div class="col d-flex align-items-end" class="form-control">
<button type="submit" class="btn btn-success" style="width: 100px;"
onclick="return confirm('Apakah Anda yakin ingin mencetak laporan ini?')">
        <i class="material-symbols-rounded opacity-100">table_view</i> EXCEL
    </button>
       </div>
    
</form>
<?php } ?>  
</div>
    </div>
      </div>
        </div>
        </div>
        </div>