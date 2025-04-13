<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?=base_url ('assets/img/favicon.png')?>">
  <title>
    Manajemen OSIS 
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url ('assets/css/nucleo-icons.css')?>" rel="stylesheet" />
  <link href="<?=base_url ('assets/css/nucleo-svg.css')?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
</head>

 <main id="main" class="main">

    <section class="section">
      <div class="row">
       

          <div class="card">
            <div class="card-body">
              <div class="col-lg-500 col-md-11 col-8 mx-auto">
              <h3 class="card-title">Input Kegiatan OSIS </h5>

              <form action="/home/saveikegiatan" method="POST" enctype="multipart/form-data">
        
        <div class="input-group input-group-static mb-4">
          <label>Bagian Proker:</label>
          <select class="form-control" name="proker" required>
            <option value="">Pilih Proker</option>
            <?php foreach ($proker as $value): ?>
                <option value="<?= $value->id_proker ?>"><?= $value->judul_proker ?></option>
            <?php endforeach; ?>
           </select>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama Kegiatan:</label>
          <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Kegiatan:" name="nama" value="<?= $anjas->judul_kegiatan ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Tanggal Kegiatan:</label>
          <input type="date" class="form-control" id="tanggal" placeholder="Masukkan Tanggal Kegiatan:" name="tanggal" value="<?= $anjas->tanggal_kegiatan ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Waktu Pelaksanaan:</label>
          <input type="time" class="form-control" id="waktu" placeholder="Masukkan Waktu Pelaksanaan:" name="waktu" value="<?= $anjas->waktu ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Lokasi Pelaksanaan:</label>
          <input type="text" class="form-control" id="lokasi" placeholder="Masukkan Lokasi Pelaksanaan:" name="lokasi" value="<?= $anjas->lokasi ?>">
        </div>
        <div class="input-group input-group-static mb-4">
            <label for="proposal_file">Upload Proposal (PDF)</label>
            <input type="file" name="proposal_file" id="proposal_file" class="form-control" value="<?= $anjas->proposal_file ?>" accept=".pdf" required>
        </div>
        <!-- <div class="input-group input-group-static mb-4">
          <label>Status:</label>
          <select class="form-control" name="status">
            <option>Pilih Status</option>
            <option>Menunggu Persetujuan</option>
            <option>Berjalan</option>
            <option>Selesai</option>
            <option>Ditolak</option>
    </select>
        </div> -->

        <tr>
          
          <td>
            <input type="hidden" value="<?= $anjas->id_kegiatan ?>" name="id">
             <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
             <input type="hidden" name="created_by" value="<?= session()->get('id') ?>">
                
            <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
            
          </td>
        </tr>

    </form>
    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    