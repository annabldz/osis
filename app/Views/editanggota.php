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
              <h3 class="card-title">Edit Data Anggota</h5>

    <form action="<?= base_url('home/saveanggota')?>" method="POST" enctype="multipart/form-data" id="form">
        <div class="input-group input-group-static mb-4">
      <label>Nama Anggota:</label>
      <input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_anggota ?>">
    </div>
    <div class="input-group input-group-static mb-4">
      <label>Jabatan:</label>
      <select class="form-control" name="jabatan">
        <option value="">Pilih Jabatan</option>
        <option value="Pembina OSIS" <?= ($anjas->jabatan == 'Pembina OSIS') ? 'selected' : '' ?>>Pembina OSIS</option>
        <option value="Ketua OSIS" <?= ($anjas->jabatan == 'Ketua OSIS') ? 'selected' : '' ?>>Ketua OSIS</option>
        <option value="Wakil Ketua OSIS" <?= ($anjas->jabatan == 'Wakil Ketua OSIS') ? 'selected' : '' ?>>Wakil Ketua OSIS</option>
        <option value="Sekretaris" <?= ($anjas->jabatan == 'Sekretaris') ? 'selected' : '' ?>>Sekretaris</option>
        <option value="Bendahara" <?= ($anjas->jabatan == 'Bendahara') ? 'selected' : '' ?>>Bendahara</option>
        <option value="Anggota TIK" <?= ($anjas->jabatan == 'Anggota TIK') ? 'selected' : '' ?>>Anggota TIK</option>
        <option value="Anggota Mading" <?= ($anjas->jabatan == 'Anggota Mading') ? 'selected' : '' ?>>Anggota Mading</option>
        <option value="Anggota Keagamaan" <?= ($anjas->jabatan == 'Anggota Keagamaan') ? 'selected' : '' ?>>Anggota Keagamaan</option>
       </select>

    </div>
    <div class="input-group input-group-static mb-4">
          <label>Tahun Menjabat:</label>
          <select class="form-control" name="tahun">
        <option value="">Pilih Tahun</option>
        <option value="2023/2024" <?= ($anjas->tahun_ajaran == '2023/2024') ? 'selected' : '' ?>>2023/2024</option>
        <option value="2024/2025" <?= ($anjas->tahun_ajaran == '2024/2025') ? 'selected' : '' ?>>2024/2025</option>
       
       </select>

        </div>
        <tr>
          <td>
            <input type="hidden" value="<?= $anjas->id_anggota ?>" name="id">
             <input type="hidden" value="<?= $user->id_user ?>" name="user">
             <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
             <input type="hidden" name="updated_by" value="<?= session()->get('id') ?>">
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

    