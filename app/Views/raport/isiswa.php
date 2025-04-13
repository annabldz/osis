<main id="main" class="main">
<div class="pagetitle">
      <h1>Input Siswa</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url ('home/dashboard')?>">Home</a></li>
          <li class="breadcrumb-item">Siswa</li>
          <li class="breadcrumb-item active">Input Siswa</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Siswa</h5>

  <form action="/home/saveisiswa" method="POST" enctype="multipart/form-data">
    <table>
     <div class="mb-3 mt-3">
    <label for="file" class="form-label">Foto:</label>
    <input type="file" class="form-control" name="file" accept="img/" required>
  </div>
       <div class="mb-3">
    <label for="nama" class="form-label">Nama Siswa:</label>
    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Siswa:" name="nama" value="<?= $anjas->nama_siswa ?>">
  </div>
      <div class="mb-3">
    <label for="nis" class="form-label">NIS:</label>
    <input type="text" class="form-control" id="nis" placeholder="Masukkan NIS:" name="nis" value="<?= $anjas->nis ?>">
  </div>
      <div class="mb-3">
    <label for="username" class="form-label">Username:</label>
    <input type="text" class="form-control" id="username" placeholder="Masukkan Username:" name="username" value="<?= $anjas->username ?>">
  </div>
      <div class="mb-3">
    <label for="user" class="form-label">Nama User:</label>
    <input type="text" class="form-control" id="user" placeholder="Masukkan Nama User:" name="user" value="<?= $anjas->nama_user ?>">
  </div>
       <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="text" class="form-control" id="password" placeholder="Masukkan Password:" name="password" value="<?= $anjas->password ?>">
  </div>
  <div class="mb-3">
    <label for="rombel" class="form-label">Rombel:</label>
    <input type="text" class="form-control" id="rombel" placeholder="Masukkan Rombel:" name="rombel" value="<?= $anjas->id_rombel ?>">
  </div>
       <div class="mb-3">
    <label for="level" class="form-label">Level:</label>
    <input type="text" class="form-control" id="level" placeholder="Masukkan Level:" name="level" value="<?= $anjas->level ?>">
  </div>
        
        <td>
      <button type="submit" class="btn btn-primary" name="hasil">Simpan</button>
        </td>
      </tr>
    </table>
  </form>