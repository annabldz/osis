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
              <h3 class="card-title">Input Data Guru</h5>

    <form action="/absen/saveiguru" method="POST" enctype="multipart/form-data">
        <div class="input-group input-group-static mb-4">
          <label>Foto:</label>
          <input type="file" class="form-control" name="file" accept="img/" required>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama Guru:</label>
          <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Guru:" name="nama" value="<?= $anjas->nama_guru ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama User:</label>
          <input type="text" class="form-control" id="namauser" placeholder="Masukkan Nama User:" name="namauser" value="<?= $anjas->nama_user ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>NIK:</label>
          <input type="text" class="form-control" id="nik" placeholder="Masukkan NIK:" name="nik" value="<?= $anjas->nik ?>">
        </div>

        <div class="input-group input-group-static mb-4">
          <label>Username:</label>
          <input type="text" class="form-control" id="username" placeholder="Masukkan Username:" name="username" value="<?= $anjas->username ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Masukkan Password:" name="password" value="<?= $anjas->password ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Level:</label>
          <input type="text" class="form-control" id="level" placeholder="Masukkan Level:" name="level" value="2">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Status:</label>
          <input type="text" class="form-control" id="status" placeholder="Masukkan Level:" name="status" value="Guru">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Alamat:</label>
          <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat:" name="alamat" value="<?= $anjas->alamat ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nomor HP:</label>
          <input type="text" class="form-control" id="nomor" placeholder="Masukkan Nomor HP:" name="nomor" value="<?= $anjas->no_hp ?>">
        </div>

        <tr>
          
          <td>
            <input type="hidden" value="<?= $anjas->id_guru ?>" name="id">
             <input type="hidden" value="<?= $user->id_user ?>" name="user">
            <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
            
          </td>
        </tr>

    </form>
    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    