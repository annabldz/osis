 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Reset Password</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reset Password</h5>

    <form action="<?= base_url('home/saveuser')?>" method="POST">
      <table>
        
        <tr>
          <td>Username</td>
          <td><input type="text" class="form-control" id="username"name="username" value="<?= $anjas->username ?>"></td>
        </tr>
        <tr>
          <td>Nama User</td>
          <td><input type="text" class="form-control" id="nama" name="nama"  value="<?=$anjas->nama_user?>"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="text" class="form-control" id="password" name="password"  value="<?=$anjas->password?>"></td>
        </tr>
        <tr>
          <td>Level</td>
          <td><input type="text" class="form-control" id="level" name="level"  value="<?=$anjas->level?>"></td>
        </tr>
        
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?=$anjas->id_user?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>