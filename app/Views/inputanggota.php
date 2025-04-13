<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?=base_url ('assets/img/favicon.png')?>">
  <title>
Manajemen OSIS  </title>
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
              <h3 class="card-title">Input Data Anggota</h5>

              <form action="/home/saveianggota" method="POST" enctype="multipart/form-data" onsubmit="return validatePassword()">
        <div class="input-group input-group-static mb-4">
          <label>Foto:</label>
          <input type="file" class="form-control" name="file" accept="img/" required>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama Anggota:</label>
          <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Anggota:" name="nama" value="<?= $anjas->nama_anggota ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama User:</label>
          <input type="text" class="form-control" id="namauser" placeholder="Masukkan Nama User:" name="namauser" value="<?= $anjas->nama_user ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Jabatan:</label>
          <select class="form-control" name="jabatan">
            <option>Pilih Jabatan</option>
            <option>Pembina OSIS</option>
            <option>Ketua OSIS</option>
            <option>Wakil Ketua OSIS</option>
            <option>Sekretaris</option>
            <option>Bendahara</option>
            <option>Anggota TIK</option>
            <option>Anggota Mading</option>
            <option>Anggota Keagamaan</option>
    </select>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Menjabat pada tahun ajaran:</label>
          <select class="form-control" name="tahun_ajaran">
            <option>Pilih Tahun</option>
            <option>2023/2024</option>
            <option>2024/2025</option>
        </select>
        </div>

        <div class="input-group input-group-static mb-4">
          <label>Username:</label>
          <input type="text" class="form-control" id="username" placeholder="Masukkan Username:" name="username" value="<?= $anjas->username ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Email:</label>
          <input type="email" class="form-control" id="email" placeholder="Masukkan Email:" name="email" value="<?= $anjas->email ?>">
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Password:</label>
          <input type="password" class="form-control" id="password" name="password" value="<?= $anjas->password ?>" required>
          <small class="text-muted">* Minimal 8 karakter, 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol</small>
</div>
        <div class="input-group input-group-static mb-4">
          <label>Level:</label>
          <input type="text" class="form-control" id="level" placeholder="Masukkan Level:" name="level" value="<?= $anjas->level ?>">
        </div>
        

        <tr>
          
          <td>
            <input type="hidden" value="<?= $anjas->id_guru ?>" name="id">
             <input type="hidden" value="<?= $user->id_user ?>" name="user">
             <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
             <input type="hidden" name="created_by" value="<?= session()->get('id') ?>">

            <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
            
          </td>
        </tr>

    </form>
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

    