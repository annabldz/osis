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
              <h3 class="card-title">Input Dokumentasi</h5>

              <form action="/home/savedokumentasi" method="POST" enctype="multipart/form-data">
        <div class="input-group input-group-static mb-4">
          <label>Judul Dokumentasi:</label>
          <input type="text" class="form-control" id="nama" placeholder="Masukkan Judul Dokumentasi:" name="nama" value="<?= $anjas->judul_dokumentasi ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Link Drive:</label>
          <input type="url" class="form-control" id="drive" placeholder="Masukkan Link Drive:" name="drive" value="<?= $anjas->link_drive ?>">
        </div>

        <div class="input-group input-group-static mb-4">
          <label>Kategori:</label>
          <select class="form-control" name="kategori">
            <option>Pilih Kategori</option>
            <option>Mading</option>
            <option>Acara Sekolah</option>
            <option>Keagamaan</option>
          </select>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Bulan:</label>
          <input type="text" name="bulan" class="form-control" value="<?= date('F') ?>" required>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Tahun:</label>
          <input type="text" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
          </div>
        <tr>
          
          <td>
            <input type="hidden" value="<?= $anjas->id_dokumentasi ?>" name="id">
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

  