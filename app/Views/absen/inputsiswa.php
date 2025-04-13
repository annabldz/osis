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
              <h3 class="card-title">Input Data Siswa</h5>
              <form action="/absen/saveisiswa" method="POST" enctype="multipart/form-data" onsubmit="return validatePassword()">
  <div class="input-group input-group-static mb-4">
    <label>Foto:</label>
    <input type="file" class="form-control" name="file" accept="image/*" required>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Nama Siswa:</label>
    <input type="text" class="form-control" name="nama" value="<?= $anjas->nama_siswa ?>">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Nama User:</label>
    <input type="text" class="form-control" name="namauser" value="<?= $anjas->nama_user ?>">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>NIS:</label>
    <input type="text" class="form-control" name="nis" value="<?= $anjas->nis ?>">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Kelas:</label>
    <select class="form-control" name="kelas" required>
      <option value="">Pilih Kelas</option>
      <?php foreach ($kelas as $value): ?>
        <option value="<?= $value->id_kelas ?>"><?= $value->id_kelas ?> - <?= $value->nama_kelas ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Username:</label>
    <input type="text" class="form-control" name="username" value="<?= $anjas->username ?>">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Password:</label>
    <input type="password" class="form-control" id="password" name="password" value="<?= $anjas->password ?>" required>
    <small class="text-muted">* Minimal 8 karakter, 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol</small>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Level:</label>
    <input type="text" class="form-control" name="level" value="3" readonly>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Status:</label>
    <input type="text" class="form-control" name="status" value="Siswa" readonly>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Alamat:</label>
    <input type="text" class="form-control" name="alamat" value="<?= $anjas->alamat ?>">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Nomor HP:</label>
    <input type="text" class="form-control" name="nomor" value="<?= $anjas->no_hp ?>">
  </div>

  <input type="hidden" value="<?= $anjas->id_siswa ?>" name="id">
  <input type="hidden" value="<?= $user->id_user ?>" name="user">

  <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">
    Simpan
  </button>
</form>

<!-- 🔐 JavaScript Validasi Password -->
<script>
  function validatePassword() {
    const password = document.getElementById("password").value;
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!regex.test(password)) {
      alert("⚠️ Password harus mengandung minimal:\n- 1 huruf besar\n- 1 huruf kecil\n- 1 angka\n- 1 simbol\n- Minimal 8 karakter");
      return false;
    }
    return true;
  }
</script>

    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    