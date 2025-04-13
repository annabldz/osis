<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?=base_url ('assets/img/favicon.png')?>">
  <title>
    Absensi Sekolah
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
              <h3 class="card-title">Edit Data Guru</h5>

    <form action="<?= base_url('absen/saveguru')?>" method="POST" enctype="multipart/form-data" id="form">
        <div class="input-group input-group-static mb-4">
      <label>Nama Guru:</label>
      <input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_guru ?>">
    </div>
        <div class="input-group input-group-static mb-4">
      <label>NIK:</label>
      <input type="text" class="form-control" id="nik"name="nik" value="<?= $anjas->nik ?>">
    </div>

        <tr>
          <td>
            <label></label>
            <input type="hidden" value="<?= $anjas->id_guru ?>" name="id">
            <label></label>
             <input type="hidden" value="<?= $anjas->id_user ?>" name="user">
             <input type="hidden" value="<?= $anjas->id_kelas ?>" name="kelas">

            <button type="submit" class="btn btn-dark"
            onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
          </td>
        </tr>

    </form>
    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    