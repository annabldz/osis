 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Kelas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Kelas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Kelas</h5>

    <form action="<?= base_url('home/savekelas')?>" method="POST">
      <table>
        
        <tr>
          <td>Nama Kelas:</td>
          <td><input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_kelas ?>"></td>
        </tr>
      
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?=$anjas->id_kelas?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>