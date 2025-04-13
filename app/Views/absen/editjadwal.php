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
              <h3 class="card-title">Edit Data Jadwal</h5>

    <form action="<?= base_url('absen/savejadwal')?>" method="POST" enctype="multipart/form-data" id="form">
        <div class="input-group input-group-static mb-4">
      <label>Nama Mapel:</label>
      <select class="form-control" name="mapel">
            <option>Pilih Mapel</option>
              <?php
                foreach ($mapel2 as $key => $value) {
              ?>
           <option value="<?= $value->id_mapel ?>" <?= $jadwal->id_mapel == $value->id_mapel ? 'selected' : null ?>> 
              <?= $value->nama_mapel ?>
            </option>
              <?php
                }
              ?>
    </select>
      </div>
        <div class="input-group input-group-static mb-4">
      <label>Nama Kelas:</label>
      <select class="form-control" name="kelas">
            <option>Pilih Kelas</option>
              <?php
                foreach ($kelas2 as $key => $value) {
              ?>
            <option value="<?= $value->id_kelas ?>" <?= $jadwal->id_kelas == $value->id_kelas ? 'selected' : null ?>>
              <?= $value->nama_kelas ?>
              </option>
              <?php
                }
              ?>
    </select>
      </div>
        <div class="input-group input-group-static mb-4">
      <label>Nama Guru:</label>
      <select class="form-control" name="guru">
            <option>Pilih Guru</option>
              <?php
                foreach ($guru2 as $key => $value) {
              ?>
            <option value="<?= $value->id_guru ?>" <?= $jadwal->id_guru == $value->id_guru ? 'selected' : null ?>>
              <?= $value->nama_guru ?>
              </option>
              <?php
                }
              ?>
    </select>
      </div>
        <div class="input-group input-group-static mb-4">
       <label>Hari:</label>
          <select class="form-control" name="hari">
            <option>Pilih Kelas</option>
            <option>Senin</option>
            <option>Selasa</option>
            <option>Rabu</option>
            <option>Kamis</option>
            <option>Jumat</option>
          </select>
      </div>
        <div class="input-group input-group-static mb-4">
      <label>Jam Mulai:</label>
      <input type="time" class="form-control" id="mulai" name="mulai" value="<?= $jadwal->jam_mulai ?>">
      </div>
        <div class="input-group input-group-static mb-4">
      <label>Jam Selesai:</label>
      <input type="time" class="form-control" id="selesai" name="selesai" value="<?= $jadwal->jam_selesai ?>">
      </div>

        <tr>
          <td>
            <input type="hidden" value="<?= $jadwal->id_jadwal ?>" name="id">
            <input type="hidden" value="<?= $kelas->id_kelas ?>" name="idkelas">
            <input type="hidden" value="<?= $mapel->id_mapel ?>" name="idmapel">
            <input type="hidden" value="<?= $guru->id_guru ?>" name="idguru">
            
            <button type="submit" class="btn btn-dark">Simpan</button>
          </td>
        </tr>

    </form>
    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    