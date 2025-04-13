  <div class="container mt-3">
  <h3>Laporan Masuk</h3>
  <form action="<?= base_url('home/lapbm') ?>" method="post">
    <div class="row">
    <div class="col">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col">
      <label for="akhir" class="form-label">Tanggal Akhir:</label>
    </div>
     <div class="col d-flex align-items-end" class="form-control">
       </div>

  <div class="row">
    <div class="col">
      <input type="date" class="form-control" id="awal" placeholder="Tanggal Awal" name="awal" value="<?= $anjas->tanggal_masuk ?>">
    </div>
    <div class="col">
      <input type="date" class="form-control" id="akhir" placeholder="Tanggal Akhir" name="akhir" value="<?= $anjas->tanggal_masuk ?>">
    </div>
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('home/lapbm/'.$value->id_user)?>"><button type="print" class="btn btn-primary" style = "width: 100px;" ?>
  <i class="fas fa-print"></i>
            Cetak
           </button></a> 
       </div>
</form>
  
    
  <form action="<?= base_url('home/dompdf') ?>" method="post" target="_blank">
    <div class="row">
    <div class="col">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col">
      <label for="akhir" class="form-label" >Tanggal Akhir:</label>
    </div>
     <div class="col d-flex align-items-end" class="form-control">
       </div>

  <div class="row">
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Awal" name="awal" id="awal">
    </div>
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Akhir" name="akhir" id="akhir">
    </div>
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('home/dompdf/'.$value->id_user)?>"><button type="print" class="btn btn-danger" style = "width: 100px;"?>
   <i class="fas fa-file-pdf"></i>
            Cetak
           </button></a> 
       </div>

</form>

<form action="<?= base_url('home/lapbmm') ?>" method="post" target="_blank">
    <div class="row">
    <div class="col">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col">
      <label for="akhir" class="form-label" >Tanggal Akhir:</label>
    </div>
     <div class="col d-flex align-items-end" class="form-control">
       </div>

  <div class="row">
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Awal" name="awal" id="awal">
    </div>
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Akhir" name="akhir" id="akhir">
    </div>
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('home/lapbmm/'.$value->id_user)?>"><button type="print" class="btn btn-success" style = "width: 100px;"?>
  <i class="fas fa-file-excel"></i>
            Cetak
           </button></a> 
       </div>

</form>

 <form action="<?= base_url('home/tcpdf') ?>" method="post" target="_blank">
    <div class="row">
    <div class="col">
      <label for="awal" class="form-label">Tanggal Awal:</label>
    </div>
    <div class="col">
      <label for="akhir" class="form-label" >Tanggal Akhir:</label>
    </div>
     <div class="col d-flex align-items-end" class="form-control">
       </div>

  <div class="row">
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Awal" name="awal" id="awal">
    </div>
    <div class="col">
      <input type="date" class="form-control" placeholder="Tanggal Akhir" name="akhir" id="akhir">
    </div>
     <div class="col d-flex align-items-end" class="form-control">
  <a href="<?= base_url('home/tcpdf/'.$value->id_user)?>"><button type="print" class="btn btn-danger" style = "width: 100px;"?>
   <i class="fas fa-file-pdf"></i>
            Cetak
           </button></a> 
       </div>

</form>