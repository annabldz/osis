 <main id="main" class="main">
  <div class="container mt-3">
  <h3>Cetak Raport Blok</h3>


 <div class="card">
    <div class="card-body">
      <pre></pre>
 <form action="<?= base_url('home/lapblok') ?>" method="post" target="_blank">
    <div class="row">
    <div class="col">
      <label for="blok" class="form-label">Blok:</label>
      <select name="blok" id="blok">
               <option>Pilih Blok</option>
      <?php
      foreach ($blok as $key => $value) {
        ?>
        <option value="<?= $value->kode_blok ?>"><?= $value->kode_blok ?></option>
        <?php
      }
        ?>
            </select>
    </div>
  </div>

    <div class="row">
    <div class="col">
      <label for="tahun" class="form-label" >Tahun:</label>
      <select name="tahun" id="tahun">
                <option>Pilih Tahun Ajaran</option>
      <?php
      foreach ($tahun as $key => $value) {
        ?>
        <option value="<?= $value->nama_tahun ?>"><?= $value->nama_tahun ?></option>
        <?php
      }
        ?>
            </select>
    </div>
  </div>

  <?php
          if (session()->get('level')==1){ ?>

      <div class="row">
    <div class="col">
      <label for="rombel" class="form-label" >Rombel:</label>
      <select name="rombel" id="rombel">
                <option>Pilih Rombel</option>
      <?php
      foreach ($siswa as $key => $value) {
        ?>
        <option value="<?= $value->id_rombel ?>"><?= $value->id_rombel ?> - <?= $value->nama_siswa ?></option>
        <?php
      }
        ?>
            </select>
    </div>
  </div>
  <?php } ?>
     <!-- <div class="col d-flex align-items-end" class="form-control">
       </div> -->

   <pre></pre>
    <div class="col">
      
    <input type="hidden" value="<?=$nilai->id_nilai?>" name="id">
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('home/lapblok/'.$nilai->id_siswa)?>" ><button type="print" class="btn btn-danger" style = "width: 100px;"?>
   <i class="fas fa-file-pdf"></i>
            Cetak
           </button></a> 
       </div>


  

     
     </div>
   </div>
 </div>
</form>
