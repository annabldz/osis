<main id="main" class="main">
<div class="pagetitle">
      <h1>Input User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url ('home/dashboard')?>">Home</a></li>
          <li class="breadcrumb-item">User</li>
          <li class="breadcrumb-item active">Input User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User</h5>

  <form action="/home/saveiuser" method="POST" enctype="multipart/form-data">
    <table>
      <tr>
        <td>Foto</td>
        <td><input type="file" class="form-control" name="file" accept="img/" required></td>
      </tr>
       <tr>
        <td>Username</td>
        <td><input type="text" class="form-control" name="username"></td>
      </tr>
      <tr>
        <td>Nama User</td>
        <td><input type="text" class="form-control" name="nama"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="text" class="form-control" name="password"></td>
      </tr>
       <tr>
        <td>Level</td>
        <td><input type="text" class="form-control" name="level"></td>
      </tr>
      <tr>
        
        <td>
      <button type="submit" class="btn btn-primary" name="hasil">Simpan</button>
        </td>
      </tr>
    </table>
  </form>